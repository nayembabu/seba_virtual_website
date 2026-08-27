<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VisaSearchHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VisaSearchController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $histories = collect();
        if ($user) {
            $histories = VisaSearchHistory::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }
        return view('user.visa_search', compact('histories'));
    }

    public function searchVisa(Request $request)
    {
        $isAjax = $request->ajax() || $request->has('ajax');

        $request->validate(['passport' => 'required|string']);

        $user = auth()->user();
        if (!$user) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'You must be logged in']);
            return redirect()->route('login')->withErrors(['msg' => 'You must be logged in.']);
        }

        $passportNo = strtoupper(trim($request->passport));
        $chargeAmount = 100;

        if ($user->balance < $chargeAmount) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'অপর্যাপ্ত ব্যালেন্স! নূন্যতম ' . $chargeAmount . ' টাকা প্রয়োজন।']);
            return back()->withInput()->withErrors(['msg' => 'Insufficient balance']);
        }

        $api_url = "https://union-seba.site/passport_api.php?pass=admin420@gmail.com&passport=" . urlencode($passportNo);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if (!empty($curlError)) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'cURL Error: ' . $curlError]);
            return back()->withErrors(['msg' => 'cURL Error: ' . $curlError]);
        }

        if (empty($response)) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'সার্ভার থেকে কোনো রেসপন্স পাওয়া যায়নি।']);
            return back()->withErrors(['msg' => 'No response from API']);
        }

        $response = preg_replace('/^[\xEF\xBB\xBF\x1A]+/i', '', $response);
        $data = json_decode($response, true);

        if (!$data || !isset($data['passportNumber'])) {
            $data = [];
            $fields = ['jobSeekerCountry', 'passportNumber', 'bmetNo', 'clearanceDate', 'employerName', 'visaNo', 'dateOfIssue', 'dateOfExpiry', 'photo', 'name', 'DateofBirth'];
            foreach ($fields as $field) {
                if (preg_match('/\"' . $field . '\"\s*:\s*\"(.*?)\"/is', $response, $m)) {
                    $data[$field] = trim($m[1]);
                }
            }
        }

        if ($data && (isset($data['passportNumber']) || isset($data['name']))) {
            $user->balance -= $chargeAmount;
            $user->save();

            $tx_id = uniqid('txn_', true);
            $this->create_transaction($chargeAmount, 'Debit', 'Charged for visa info search', $user->id, $tx_id);

            VisaSearchHistory::create([
                'user_id' => $user->id,
                'passport_no' => $passportNo,
                'visa_no' => $data['visaNo'] ?? 'N/A',
                'applicant_name' => $data['name'] ?? '',
                'country' => $data['jobSeekerCountry'] ?? '',
                'charged_amount' => $chargeAmount,
                'api_response' => json_encode($data),
                'created_at' => now(),
            ]);

            $histories = VisaSearchHistory::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'histories' => $histories,
                    'new_balance' => $user->balance,
                ]);
            }
            return view('user.visa_search_result', compact('data'));
        } else {
            $msg = 'দুঃখিত, এই পাসপোর্ট নম্বরের কোনো তথ্য পাওয়া যায়নি!';
            if ($isAjax) return response()->json(['success' => false, 'message' => $msg]);
            return back()->withInput()->withErrors(['msg' => $msg]);
        }
    }

    protected function create_transaction($amount, $type, $details, $user_id, $tx_id = null)
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