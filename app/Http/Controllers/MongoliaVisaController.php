<?php

namespace App\Http\Controllers;

use App\Models\MongoliaVisa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MongoliaVisaController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        $mongoliaVisas = MongoliaVisa::where('user_id', Auth::id())->get();
        $title = "Mongolia Visa List";
        return view('user.mongolia-visa.index', compact('mongoliaVisas', 'title'));
    }

    public function create()
    {
        $title = "Create Mongolia Visa";
        return view('user.mongolia-visa.create', compact('title'));
    }

    public function store(Request $request)
    {
        $user = $this->user;
        $fee = \App\Models\ServiceCharge::getCharge('mongolia-visa');

        if (!$user || $user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $request->validate([
            'visa_permit_number' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:50',
            'passport_number' => 'required|string|max:20',
            'passport_issue_date' => 'required|date',
            'passport_expiry_date' => 'required|date',
            'inviting_company' => 'required|string|max:255',
            'visa_class' => 'required|string|max:10',
            'type_of_visa' => 'required|string|max:20',
            'entry_type' => 'required|string|max:20',
            'visa_issue_date' => 'required|date',
            'visa_effective_date' => 'required|date',
            'visa_validity_days' => 'required|integer',
            'application_date' => 'required|date',
            'remaining_stay_days' => 'required|integer',
            'port_of_entry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'notice_section_date' => 'required|date'
        ]);

        try {
            $this->user->balance = $this->user->balance - $fee;
            $this->user->save();

            $this->createTransaction($fee, '-', 'Created Mongolia Visa', $this->user->id);

            $mongoliaVisa = new MongoliaVisa($request->all());
            $mongoliaVisa->user_id = Auth::id();
            $mongoliaVisa->save();

            return redirect()->route('user.mongolia-visa.index')->with('success', 'Mongolia Visa created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while saving the data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $mongoliaVisa = MongoliaVisa::findOrFail($id);
        $title = "View Mongolia Visa";
        return view('user.mongolia-visa.show', compact('mongoliaVisa', 'title'));
    }

    public function edit($id)
    {
        $mongoliaVisa = MongoliaVisa::findOrFail($id);
        $title = "Edit Mongolia Visa";
        return view('user.mongolia-visa.edit', compact('mongoliaVisa', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visa_permit_number' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:50',
            'passport_number' => 'required|string|max:20',
            'passport_issue_date' => 'required|date',
            'passport_expiry_date' => 'required|date',
            'inviting_company' => 'required|string|max:255',
            'visa_class' => 'required|string|max:10',
            'type_of_visa' => 'required|string|max:20',
            'entry_type' => 'required|string|max:20',
            'visa_issue_date' => 'required|date',
            'visa_effective_date' => 'required|date',
            'visa_validity_days' => 'required|integer',
            'application_date' => 'required|date',
            'remaining_stay_days' => 'required|integer',
            'port_of_entry' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'notice_section_date' => 'required|date'
        ]);

        $mongoliaVisa = MongoliaVisa::findOrFail($id);
        $mongoliaVisa->fill($request->all());
        $mongoliaVisa->save();

        return redirect()->route('user.mongolia-visa.index')->with('success', 'Mongolia Visa updated successfully.');
    }

    public function destroy($id)
    {
        $mongoliaVisa = MongoliaVisa::findOrFail($id);
        $mongoliaVisa->delete();

        return redirect()->route('user.mongolia-visa.index')->with('success', 'Mongolia Visa deleted successfully.');
    }

    public function print($id)
    {
        $mongoliaVisa = MongoliaVisa::findOrFail($id);
        $title = "Print Mongolia Visa";
        return view('user.mongolia-visa.print', compact('mongoliaVisa', 'title'));
    }

    public function verify($visa_permit_number)
    {
        $mongoliaVisa = MongoliaVisa::where('visa_permit_number', $visa_permit_number)->firstOrFail();
        $title = "Verify Mongolia Visa";
        return view('user.mongolia-visa.verify', compact('mongoliaVisa', 'title'));
    }

    private function createTransaction($amount, $type, $details, $userId)
    {
        Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'details' => $details
        ]);
    }
}
