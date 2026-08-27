<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Support;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Recharge;
use App\Models\Gateway;
use Illuminate\Support\Facades\Log;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Application;
use App\Models\PassportSearchHistory;

class PassportSearchController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $histories = collect();
        if ($user) {
            $histories = PassportSearchHistory::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }
        return view('user.passport_search', compact('histories'));
    }

    public function searchPassport(Request $request)
    {
        $isAjax = $request->ajax() || $request->has('ajax');

        $request->validate([
            'passport' => 'required|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'You must be logged in']);
            return redirect()->route('login')->withErrors(['msg' => 'You must be logged in to perform this action.']);
        }

        $passportNo = $request->passport;
        $api_url = "https://bdservice24.online/passport_api.php?pass=ruksanarrr230@gmail.com&passport=" . urlencode($passportNo);
        Log::info('API Request URL', ['url' => $api_url]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
            Log::error('cURL Error', ['error' => $errorMsg]);
            curl_close($ch);
            if ($isAjax) return response()->json(['success' => false, 'message' => 'cURL Error: ' . $errorMsg]);
            return back()->withErrors(['msg' => 'cURL Error: ' . $errorMsg]);
        }
        curl_close($ch);

        if (empty($response)) {
            Log::error('No data returned from API');
            if ($isAjax) return response()->json(['success' => false, 'message' => 'No data returned from API']);
            return back()->withErrors(['msg' => 'No data returned from API']);
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'Error processing API response']);
            return back()->withErrors(['msg' => 'Error processing API response']);
        }

        if (isset($data['status']) && $data['status'] === true && isset($data['data']['data'])) {
            $passportInfo = $data['data']['data'];
            $chargedAmount = $data['charged_amount'] ?? 50;

            if ($user->balance < $chargedAmount) {
                if ($isAjax) return response()->json(['success' => false, 'message' => 'Insufficient balance']);
                return back()->withInput()->withErrors(['msg' => 'Insufficient balance']);
            }

            $user->balance -= $chargedAmount;
            $user->save();

            $tx_id = uniqid('txn_', true);
            $this->create_transaction($chargedAmount, 'Debit', 'Charged for passport search', $user->id, $tx_id);

            PassportSearchHistory::create([
                'user_id' => $user->id,
                'passport_no' => $passportNo,
                'applicant_name' => $passportInfo['fullName'] ?? $passportInfo['name'] ?? '',
                'passport_type' => $request->passport_type ?? 'MRP',
                'thana' => $passportInfo['preThana'] ?? $passportInfo['perThana'] ?? '',
                'charged_amount' => $chargedAmount,
                'api_response' => json_encode($passportInfo),
                'created_at' => now(),
            ]);

            $histories = PassportSearchHistory::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'data' => $passportInfo,
                    'histories' => $histories,
                ]);
            }
            return view('user.passport_search_result', compact('passportInfo'));
        } else {
            $errorMsg = $data['msg'] ?? $data['data']['message'] ?? 'Error fetching data from API';
            if ($isAjax) return response()->json(['success' => false, 'message' => $errorMsg]);
            return back()->withInput()->withErrors(['msg' => $errorMsg]);
        }
    }

    protected function formatPhoto($photo)
    {
        if (!empty($photo)) {
            return 'data:image/jpeg;base64,' . $photo;
        }
        return null;
    }

    protected function create_transaction($amount, $type, $details, $user_id, $tx_id = null, $reference = null)
    {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->details = $details;
        $transaction->tx_id = $tx_id;
        $transaction->created_at = now();
        $transaction->save();
    }
}
