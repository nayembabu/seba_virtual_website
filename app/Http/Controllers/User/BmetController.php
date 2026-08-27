<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bmet;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BmetController extends Controller
{
    public function index()
    {
        $bmets = Bmet::get();
        return view('user.bmets.index', compact('bmets'));
    }

    public function create()
    {
        return view('user.bmets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'clearance_id' => 'required|string|max:255|unique:bmets',
            'clearance_date' => 'required|date',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'bra_id' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bmet_no' => 'required|string|max:255|unique:bmets',
            'passport_no' => 'required|string|max:255|unique:bmets',
            'p_issue_date' => 'required|date',
            'p_expiry_date' => 'required|date',
            'dob' => 'required|date',
            'visa_no' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads', 'public');
        }

        Bmet::create([
            'name' => $request->name,
            'clearance_id' => $request->clearance_id,
            'clearance_date' => $request->clearance_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'bra_id' => $request->bra_id,
            'employer' => $request->employer,
            'country' => $request->country,
            'bmet_no' => $request->bmet_no,
            'passport_no' => $request->passport_no,
            'p_issue_date' => $request->p_issue_date,
            'p_expiry_date' => $request->p_expiry_date,
            'dob' => $request->dob,
            'visa_no' => $request->visa_no,
            'photo' => $photoPath,
        ]);

        return redirect()->route('bmet.index')->with('success', 'BMET record created successfully!');
    }
}
