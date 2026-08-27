<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SoudiSonod;

class SoudiSonodController extends Controller
{
    // Display all SoudiSonod records
    public function index()
    {
        $soudiSonods = SoudiSonod::get();
        return view('user.soudi-sonod.index', compact('soudiSonods'));
    }

    // Show create form
    public function create()
    {
        return view('user.soudi-sonod.create');
    }

    // Store form data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nationality' => 'required',
            'passport_no' => 'required|unique:soudi_sonods',
            'certificate_no' => 'required',
            'worker_no' => 'required',
            'type' => 'required',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
        ]);
        $user = auth()->user();
        $fee = \App\Models\ServiceCharge::getCharge('soudi-sonod');
        if ($fee > $user->balance) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        $user->balance = $user->balance - $fee;
        $user->save();
        create_transaction($fee, '-', 'Created BMET Smart Card', $user->id);

        SoudiSonod::create($validated);
        return redirect()->route('user.soudi-sonod.index');
    }

    // Show specific SoudiSonod
    public function show($id)
    {
        $soudi = SoudiSonod::findOrFail($id);
        return view('user.soudi-sonod.show', compact('soudi'));
    }

    // Show edit form
    public function edit($id)
    {
        $workerCertificate = SoudiSonod::findOrFail($id);
        return view('user.soudi-sonod.edit', compact('workerCertificate'));
    }

    // Update SoudiSonod
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nationality' => 'required',
            'passport_no' => 'required|unique:soudi_sonods,'.$id,
            'certificate_no' => 'required',
            'worker_no' => 'required',
            'type' => 'required',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
        ]);

        SoudiSonod::find($id)->update($validated);
        return redirect()->route('user.soudi-sonod.index');
    }

    // Delete SoudiSonod
    public function destroy($id)
    {
        SoudiSonod::destroy($id);
        return redirect()->route('user.soudi-sonod.index');
    }
}