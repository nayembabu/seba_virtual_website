<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BmetSearchHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BmetSearchController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $histories = collect();
        if ($user) {
            $histories = BmetSearchHistory::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }
        return view('user.bmet_search', compact('histories'));
    }

    public function searchBmet(Request $request)
    {
        $isAjax = $request->ajax() || $request->has('ajax');

        $request->validate(['passport' => 'required|string']);

        $user = auth()->user();
        if (!$user) {
            if ($isAjax) return response()->json(['success' => false, 'message' => 'You must be logged in']);
            return redirect()->route('login')->withErrors(['msg' => 'You must be logged in.']);
        }

        $passportNo = strtoupper(trim($request->passport));
        $chargeAmount = 200;

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
            $fields = [
                'name', 'fullName', 'fathersName', 'mothersName', 'dateofBirth', 'age', 'genderId', 'gender', 'mobile', 'nid', 'religionId', 'religionName', 'maritalStatusId', 'spouseName', 'nationality', 'photo',
                'preDivisionId', 'preDivision', 'preDistrictId', 'preDistrict', 'preThanaId', 'preThana', 'preRoad', 'preHouse', 'prePostOfficeId', 'prePostOffice', 'prePostCode', 'preMauza', 'preWard', 'preVillage', 'preAddressDetails', 'preAddress', 'combinePreAddress',
                'perDivisionId', 'perDivision', 'perDistrictId', 'perDistrict', 'perThanaId', 'perThana', 'perHouse', 'perRoad', 'perPostOfficeId', 'perPostOffice', 'perPostCode', 'perMauza', 'perWard', 'perVillage', 'perAddressDetails', 'perAddress', 'combinePerAddress',
                'jobSeekerCountryId', 'jobSeekerCountry', 'jobCategoryId', 'jobCategory', 'visaType', 'passportNumber', 'clearanceTypeId', 'bmetNo', 'clearanceDate', 'dataSourceCategory', 'employerName', 'visaNo', 'dateOfIssue', 'dateOfExpiry', 'travels', 'manualApplicationYn'
            ];
            foreach ($fields as $field) {
                if (preg_match('/"' . $field . '"\s*:\s*"(.*?)"/is', $response, $m)) {
                    $data[$field] = trim($m[1]);
                } else {
                    $data[$field] = null;
                }
            }
        }

        if ($data && (isset($data['passportNumber']) || isset($data['fullName']) || isset($data['name']))) {
            $user->balance -= $chargeAmount;
            $user->save();

            $tx_id = uniqid('txn_', true);
            $tx = new Transaction();
            $tx->user_id = $user->id;
            $tx->amount = $chargeAmount;
            $tx->type = 'Debit';
            $tx->details = 'Charged for BMET info search';
            $tx->tx_id = $tx_id;
            $tx->created_at = now();
            $tx->save();

            $bmetNo = $data['bmetNo'] ?? ($data['visaNo'] ?? 'N/A');

            BmetSearchHistory::create([
                'user_id' => $user->id,
                'passport_no' => $passportNo,
                'bmet_no' => $bmetNo,
                'applicant_name' => $data['fullName'] ?? ($data['name'] ?? ''),
                'country' => $data['jobSeekerCountry'] ?? '',
                'charged_amount' => $chargeAmount,
                'api_response' => json_encode($data),
                'created_at' => now(),
            ]);

            $histories = BmetSearchHistory::where('user_id', $user->id)
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
            return view('user.bmet_search', compact('data'));
        } else {
            $msg = 'দুঃখিত, এই পাসপোর্ট নম্বরের কোনো তথ্য পাওয়া যায়নি!';
            if ($isAjax) return response()->json(['success' => false, 'message' => $msg]);
            return back()->withInput()->withErrors(['msg' => $msg]);
        }
    }
}
