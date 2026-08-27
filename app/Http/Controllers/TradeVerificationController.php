<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradeVerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Ensure the request is a POST request
        if ($request->isMethod('post')) {
            // Retrieve the trade number from the form input
            $trade_no = $request->input('track_id');

            // Query the database to find a matching record
            $trade = DB::table('trades')->where('trade_no', $trade_no)->first();

            if ($trade) {
                // If a match is found, redirect to the PDF link with the trade ID
                return redirect()->route('trade.verify', ['id' => $trade->id]);
            } else {
                // If no match is found, return an error message
                return back()->withErrors(['track_id' => 'No matching record found']);
            }
        }

        // Display the verification form
        return view('verify'); // Assuming your Blade file is named verify.blade.php
    }
}
