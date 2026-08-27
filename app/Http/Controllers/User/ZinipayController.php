<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Configure;
use App\Models\Recharge;

class ZinipayController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        $data['user'] = $this->user;
        return view('user.zinipay', $data);
    }

    public function pay(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:' . get_settings()->min_d,
        ]);

        $amount = $request->amount;
        $config = Configure::FirstOrNew();
        $apiKey = $config->zini_api_key;

        if (blank($apiKey)) {
            return back()->withErrors(['msg' => 'ZiniPay API key not configured']);
        }

        $postData = [
            'cus_name' => $this->user->name ?? 'User',
            'cus_email' => $this->user->email ?? 'customer@' . request()->getHost(),
            'amount' => (float)$amount,
            'metadata' => [
                'user_id' => $this->user->id,
            ],
            'redirect_url' => route('user.zinipay-callback'),
            'cancel_url' => route('user.zinipay'),
            'webhook_url' => route('user.zinipay-webhook'),
        ];

        $response = $this->apiRequest('/v1/payment/create', $postData, $apiKey);

        if (!$response || !isset($response->status) || $response->status !== true) {
            $msg = $response->message ?? 'Failed to create payment invoice';
            return back()->withErrors(['msg' => $msg]);
        }

        $invoiceId = $response->invoice_id ?? $response->invoiceId ?? '';

        $r = new Recharge();
        $r->amount = $amount;
        $r->status = 0;
        $r->user_id = $this->user->id;
        $r->from = 'ZiniPay';
        $r->gateway_id = '';
        $r->txid = $invoiceId;
        $r->save();

        Session::put('zinipay_recharge_id', $r->id);

        return redirect($response->payment_url);
    }

    public function callback(Request $request)
    {
        $invoiceId = $request->invoice_id;

        if (blank($invoiceId)) {
            return redirect(route('user.recharge'))->withErrors(['msg' => 'No invoice ID received']);
        }

        $config = Configure::FirstOrNew();
        $apiKey = $config->zini_api_key;

        $response = $this->apiRequest('/v1/payment/verify', [
            'invoice_id' => $invoiceId,
        ], $apiKey);

        if (!$response || !isset($response->status)) {
            return redirect(route('user.recharge'))->withErrors(['msg' => 'Payment verification failed']);
        }

        if ($response->status === 'COMPLETED') {
            $recharge = Recharge::where('txid', $invoiceId)->where('user_id', auth()->id())->where('status', 0)->first();

            if (!$recharge) {
                return redirect(route('user.recharge'))->withErrors(['msg' => 'Invalid recharge request']);
            }

            if ((float)$response->amount != (float)$recharge->amount) {
                return redirect(route('user.recharge'))->withErrors(['msg' => 'Amount mismatch']);
            }

            $recharge->status = 1;
            $recharge->txid = $response->transaction_id ?? $invoiceId;
            $recharge->save();

            $u = $this->user;
            $u->balance += $recharge->amount;
            $u->save();

            create_transaction($recharge->amount, '+', 'Auto recharge via ZiniPay', $u->id, $response->transaction_id ?? null);

            Session::forget('zinipay_recharge_id');

            session()->flash('success', 'Recharge successful, Amount: ' . $recharge->amount);
            return redirect(route('user.recharge'));
        }

        return redirect(route('user.recharge'))->withErrors(['msg' => 'Payment ' . strtolower($response->status ?? 'failed')]);
    }

    public function webhook(Request $request)
    {
        $invoiceId = $request->invoice_id;
        $status = $request->status;

        if (blank($invoiceId) || $status != 'true') {
            return response('ignored', 200);
        }

        $config = Configure::FirstOrNew();
        $apiKey = $config->zini_api_key;

        $result = $this->apiRequest('/v1/payment/verify', [
            'invoice_id' => $invoiceId,
        ], $apiKey);

        if (!$result || $result->status !== 'COMPLETED') {
            return response('verification failed', 200);
        }

        $recharge = Recharge::where('txid', $invoiceId)->where('status', 0)->first();
        if (!$recharge) {
            return response('not found or already processed', 200);
        }

        $recharge->status = 1;
        $recharge->txid = $result->transaction_id ?? $invoiceId;
        $recharge->save();

        $user = \App\Models\User::find($recharge->user_id);
        if ($user) {
            $user->balance += $recharge->amount;
            $user->save();
            create_transaction($recharge->amount, '+', 'Auto recharge via ZiniPay (webhook)', $user->id, $result->transaction_id ?? null);
        }

        return response('ok', 200);
    }

    private function apiRequest($endpoint, $data, $apiKey)
    {
        $url = 'https://api.zinipay.com' . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'zini-api-key: ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!in_array($httpCode, [200,201]) || blank($result)) {
            return null;
        }

        return json_decode($result);
    }
}
