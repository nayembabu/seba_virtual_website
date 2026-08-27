<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TinCertificate;
use Illuminate\Http\Request;

class TinCertificateController extends Controller
{
    public function create()
    {
        return view('user.tin.make');
    }

    public function store(Request $request)
    {
        $fee = \App\Models\ServiceCharge::getCharge('tin');
        $user = auth()->user();
        if ($fee > $user->balance) {
            return back()->with('error', 'Insufficient balance')->withInput();
        }

        $user->balance -= $fee;
        $user->save();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'fatherName'     => 'required|string|max:255',
            'motherName'     => 'required|string|max:255',
            'dob'            => 'required|date',
            'certDate'       => 'nullable|date',
            'curr_line1'     => 'required|string|max:255',
            'curr_line2'     => 'nullable|string|max:255',
            'currDistrict'   => 'required|string',
            'currThana'      => 'required|string',
            'curr_post'      => 'nullable|string|max:20',
            'perm_line1'     => 'required|string|max:255',
            'perm_line2'     => 'nullable|string|max:255',
            'permDistrict'   => 'required|string',
            'permThana'      => 'required|string',
            'perm_post'      => 'nullable|string|max:20',
            'taxesCircle'    => 'required|string|max:255',
            'taxesZone'      => 'required|string|max:255',
            'officeAddress'  => 'required|string|max:255',
            'officePhone'    => 'required|string|max:50',
            'tin_number'        => 'required|integer|unique:tin_certificates,tin_number',
//            'generate_tin'   => 'nullable|in:1',
        ]);

        // If you want to auto-generate a unique TIN when not provided
        // if (empty($validated['tin_num'])) {
        //     $validated['tin_num'] = $this->generateUniqueTin();
        // }

        $tinCertificate = Tincertificate::create($validated);
        create_transaction($fee, '-', 'Make Tin certificate', $user->id);

        return redirect()->route('user.tin.success', $tinCertificate->id)
            ->with('success', 'TIN generated successfully!');
    }

    public function success($id)
    {
        $tin = TinCertificate::find($id);
        return view('user.tin.show', compact('tin'));
    }

}
