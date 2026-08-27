<?php

namespace App\Http\Controllers;

use App\Models\NidData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class NIDController extends Controller
{
     public function show($nid_no)
    {
        // Fetch the latest NID data for the given NID number
        $data = NidData::where('nid_no', $nid_no)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$data) {
            return redirect()->back()->with('error', 'NID data not found');
        }

        // Format the date of birth
        $data->dob = date('d-m-Y', strtotime($data->dob));

        // Add any missing fields with default values
        $data->spouse = $data->spouse ?? 'N/A';
        $data->nidFather = $data->nidFather ?? 'N/A';
        $data->nidMother = $data->nidMother ?? 'N/A';
        $data->occupation = $data->occupation ?? 'N/A';
        $data->district = $data->district ?? 'N/A';
        
        // Convert gender display
        $data->gender_display = $data->gender == 'male' ? 'পুরুষ' : 'মহিলা';

        return view('nid.server-copy-old', compact('data'));
    }
}