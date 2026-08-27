<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NidData;

class HomeController extends Controller
{
    // Show form for entering NID data
    public function server_copy()
    {
        return view('nid.server_copy');  // View for form
    }

    // Store NID data
    public function server_copy_post(Request $request)
    {
        $request->validate([
            'nid_no' => 'required|unique:nid_data,nid_no',
            'name_en' => 'required',
            'name_bn' => 'required',
            'dob' => 'required|date',
            'fathers_name' => 'required',
            'mothers_name' => 'required',
            'gender' => 'required|in:male,female,other',
            // Additional fields can be validated here
        ]);

        NidData::create($request->all());

        return redirect()->route('server-copy-view')->with('success', 'NID data stored successfully');
    }

    // Display all stored NID data
    public function server_copy_view()
    {
        $data = NidData::all();  // Retrieve all NID records
        return view('nid.server_copy_view', compact('data'));  // Pass data to view
    }

    // Display specific NID data based on token
    public function user_server_copy_view($token)
    {
        $data = NidData::where('token', $token)->firstOrFail();  // Find record by token
        return view('nid.user_server_copy_view', compact('data'));  // Pass data to view
    }
}
