<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NidToTinController extends Controller
{
    public function index()
    {
        return view('user.nid_to_tin');
    }

    public function nidToTinPost(Request $request)
{
    // Validate the incoming request. All fields are optional.
    $this->validate($request, [
        'nid' => 'nullable',
        'contact_telephone' => 'nullable',
        'dob_day' => 'nullable',
        'dob_month' => 'nullable',
        'dob_year' => 'nullable',
        'passport_number' => 'nullable',
        'asses_name' => 'nullable',
        'contact_email' => 'nullable',
        'reg_type_no' => 'nullable',
        'is_old_tin' => 'nullable',
        'fath_name' => 'nullable',
        'zone_no' => 'nullable',
        'circle_no' => 'nullable',
        'dt_app_from_day' => 'nullable',
        'dt_app_from_month' => 'nullable',
        'dt_app_from_year' => 'nullable',
    ]);

    // Collect all input parameters
    $params = $request->only([
        'nid', 'contact_telephone', 'dob_day', 'dob_month', 'dob_year', 
        'passport_number', 'asses_name', 'contact_email', 'reg_type_no', 
        'is_old_tin', 'fath_name', 'zone_no', 'circle_no', 'dt_app_from_day', 
        'dt_app_from_month', 'dt_app_from_year'
    ]);

    // Build the query string dynamically based on provided parameters
    $queryParams = [];
    foreach ($params as $key => $value) {
        if (!empty($value)) {
            $queryParams[$key] = $value;
        }
    }

    // Build the API URL with the dynamic query parameters
    $url = 'https://api2.bdx.today/TIN/nid2tin.php?' . http_build_query($queryParams);

    // Send the GET request to the API
    $response = $this->send_get_request($url);

    // Check if response is empty or failed
    if (empty($response)) {
        return back()->withErrors(['msg' => 'No data returned from API']);
    }

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if data is valid
    if (isset($data['data'][0]) && count($data['data'][0]) >= 3) {
        // Extract name and TIN
        $name = $data['data'][0][1];
        $tin = $data['data'][0][2];
    } else {
        $name = 'N/A';
        $tin = 'N/A';
    }

    // Return the result view with the extracted data
    return view('user.nid_to_tin_result', compact('name', 'tin'));
}

    protected function send_get_request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return null; // or handle error appropriately
        }

        curl_close($ch);
        return $response;
    }
}
