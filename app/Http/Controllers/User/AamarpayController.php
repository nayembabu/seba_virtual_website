<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\Recharge;
use App\Models\Configure;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AamarpayController extends Controller
{
    use Upload, Notify;

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
        return view('user.aamarpay', $data);
    }

   public function pay(Request $request)
{
    $this->validate($request, [
        'amount' => 'required|numeric|min:500',
    ]);

    $end_point = env('AAMAR_PAY_END_POINT');
    $user = Auth::user();
    $cus_name = $user->name;
    $cus_email = $user->email;
    $cus_phone = $user->phone;
    $now = Carbon::now();
    $tran_id = $now->format('YmdHisu');
    $success_url = route('success');
    $fail_url = route('fail');
    $cancel_url = route('cancel');

    // Calculate 5% VAT
    $amount = $request->amount;
    $vat = 0.05 * $amount; // 5% VAT
    $totalAmount = $amount + $vat;

    // Curl Request
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $end_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'store_id' => env('AAMAR_PAY_STORE_ID'),
                'tran_id' => $tran_id,
                'success_url' => $success_url,
                'fail_url' => $fail_url,
                'cancel_url' => $cancel_url,
                'amount' => $totalAmount,  // Including VAT
                'currency' => env('AAMAR_PAY_CURRENCY'),
                'signature_key' => env('AAMAR_PAY_SIGNATURE_KEY'),
                'desc' => 'Merchant Registration Payment',
                'cus_name' => $cus_name,
                'cus_email' => $cus_email,
                'cus_phone' => $cus_phone,
                'type' => 'json'
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        )
    );

    $response = curl_exec($curl);
    curl_close($curl);
    $responseObj = json_decode($response);

    if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {
        $paymentUrl = $responseObj->payment_url;
        return redirect()->away($paymentUrl);
    } else {
        echo $response;
    }
}


    public function success(Request $request)
    {   
        $request_id = $request->mer_txnid;

        $trxcheck = env('AAMAR_PAY_TRXCHECK_END_POINT');
        $store_id = env('AAMAR_PAY_STORE_ID');
        $signature_key = env('AAMAR_PAY_SIGNATURE_KEY');
        $url = $trxcheck . '?request_id=' .$request_id. '&store_id='. $store_id . '&signature_key=' . $signature_key . '&type=json';
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        if($response->pay_status == "Successful")
        {
            $amount = isset($response->amount) ? $response->amount : 0; 
            $r = new Recharge();
            $r->amount = $amount;
            $r->status = 1;
            $r->user_id = $this->user->id;
            $r->from = 'Aamar Pay Auto Payment, ID: ' . $response->bank_trxid;
            $r->gateway_id = '';
            $r->txid = $response->bank_trxid ?? null;
            $r->save();

            $u = $this->user;
            $u->balance += $amount;
            $u->save();

            create_transaction($amount, '+', ' recharge via Aamar Pay ', $u->id, $response->bank_trxid ?? null);

            if ($amount >= 500) {
                $bonus = 0.0 * $amount;
                $u->balance += $bonus;
                $u->save();
                create_transaction($bonus, '+', 'amarpay recharge bonus', $u->id, 'BN-' . ($response->bank_trxid ?? null));
            }

            session()->flash('success', 'Recharge successful, Amount: ' . $amount);
            return redirect(route('user.aamarpay'));
        }
            
        return redirect(route('user.aamarpay'))->withErrors(['msg' => 'Something Went!! TRy Again']);
    }

    

    public function fail(Request $request)
    {
        if($request->pay_status == 'Failed')
        {
            return redirect(route('user.aamarpay'))->withErrors(['msg' => 'Payment Faild!! TRy Again']);
        }
    }

    public function cancel()
    {
        return redirect(route('user.aamarpay'))->withErrors(['msg' => 'Cancle!!']);
    }
}
