<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LdTaxController extends Controller
{
    // Method to display the search form
    public function index()
    {
        return view('ldt-search');  // Return the form view
    }

    // Method to handle the form submission and search
public function search(Request $request)
{
    // Validate the incoming form data
    $request->validate([
        'division' => 'required',
        'district' => 'required',
        'upazila' => 'required',
        'moza' => 'required',
        'option_select' => 'required',
        'input_value' => 'required|string',
    ]);

    // Prepare data for API request
    $data = [
        'division_id' => $request->division,
        'district_id' => $request->district,
        'upazila_id' => $request->upazila,
        'mouja_id' => $request->moza,
    ];

    // Add the dynamic field to the data object
    if ($request->option_select === 'holding_number') {
        $data['holding_no'] = $request->input_value;
    } elseif ($request->option_select === 'khotian_no') {
        $data['khotian_no'] = $request->input_value;
    }

    // Call API to fetch data
    $client = new Client();
    $response = $client->get('https://api.bdx.today/paytax/hid.php', [
        'query' => $data
    ]);

    // Decode the API response
    $result = json_decode($response->getBody()->getContents(), true);

    // Check if result is found
    if (isset($result[0]) && isset($result[0]['id'])) {
        $applicationId = $result[0]['id'];
        return view('ldt-result', compact('applicationId'));  // Show result
    } else {
        return back()->withErrors(['msg' => 'No data found for the given criteria.']);  // Error message
    }
}


    // Method to fetch dynamic data for districts based on division
    public function getDistricts(Request $request)
    {
        $divisionId = $request->division_id;
        $client = new Client();
        $response = $client->get("https://api.bdx.today/paytax/getzila.php?id={$divisionId}");
        $districts = json_decode($response->getBody()->getContents(), true)['data'];

        return response()->json($districts);
    }

    // Method to fetch dynamic data for upazilas based on district
    public function getUpazilas(Request $request)
    {
        $districtId = $request->district_id;
        $client = new Client();
        $response = $client->get("https://api.bdx.today/paytax/getupzila.php?id={$districtId}");
        $upazilas = json_decode($response->getBody()->getContents(), true)['data'];

        return response()->json($upazilas);
    }

    // Method to fetch dynamic data for mozas based on upazila
    public function getMozas(Request $request)
    {
        $upazilaId = $request->upazila_id;
        $client = new Client();
        $response = $client->get("https://api.bdx.today/paytax/getmoza.php?id={$upazilaId}");
        $mozas = json_decode($response->getBody()->getContents(), true)['data'];

        return response()->json($mozas);
    }
}
