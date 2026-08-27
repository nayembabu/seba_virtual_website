<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BirthRegistration;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NibondonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registrations = BirthRegistration::where('user_id', auth()->id())->latest()->get();
        return view('user.nibondon.index', compact('registrations'));
    }

    public function create()
    {
        return view('user.nibondon.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $serviceCharge = ServiceCharge::where('service_name', 'nibondon')->first();

       
        if ($user->balance < $serviceCharge->amount) {
            return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে রিচার্জ করুন।');
        }

        $validated = $request->validate([
            'office_name_bn' => 'required|string|max:255',
            'district_info_bn' => 'required|string|max:255',
            'pdf_qr_link' => 'nullable|string',
            'qr_letter' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'registration_no' => 'required|string|max:100',
            'issue_date' => 'required|date',
            'registration_date' => 'required|date',
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'mother_name_en' => 'required|string|max:255',
            'mother_name_bn' => 'required|string|max:255',
            'father_name_en' => 'required|string|max:255',
            'father_name_bn' => 'required|string|max:255',
            'birth_place_bn' => 'required|string|max:255',
            'birth_place_en' => 'required|string|max:255',
            'permanent_address_bn' => 'required|string',
            'permanent_address_en' => 'required|string',
            'father_nationality_bn' => 'required|string|max:100',
            'father_nationality_en' => 'required|string|max:100',
            'mother_nationality_bn' => 'required|string|max:100',
            'mother_nationality_en' => 'required|string|max:100',
        ]);

        $validated['user_id'] = $user->id;
        
        // Create the birth registration entry
        $birthRegistration = BirthRegistration::create($validated);

        // Deduct the service charge from user's balance
        $user->balance -= $serviceCharge->amount;
        $user->save();

        // Create transaction record
        $user->transactions()->create([
            'amount' => -$serviceCharge->amount,
            'details' => 'জন্ম নিবন্ধন সার্ভিস চার্জ',
        ]);

        return redirect()->route('user.nibondon.index')
            ->with('success', 'নিবন্ধন সফলভাবে সংরক্ষণ করা হয়েছে।');
    }

    public function show(BirthRegistration $nibondon)
    {
      
        return view('user.nibondon.show', compact('nibondon'));
    }

    public function edit(BirthRegistration $nibondon)
    {
       
        return view('user.nibondon.edit', compact('nibondon'));
    }

    public function update(Request $request, BirthRegistration $nibondon)
    {
       
        
        $validated = $request->validate([
            'office_name_bn' => 'required|string|max:255',
            'district_info_bn' => 'required|string|max:255',
            'pdf_qr_link' => 'nullable|string',
            'qr_letter' => 'nullable|string|max:100',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'registration_no' => 'required|string|max:100',
            'issue_date' => 'required|date',
            'registration_date' => 'required|date',
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'mother_name_en' => 'required|string|max:255',
            'mother_name_bn' => 'required|string|max:255',
            'father_name_en' => 'required|string|max:255',
            'father_name_bn' => 'required|string|max:255',
            'birth_place_bn' => 'required|string|max:255',
            'birth_place_en' => 'required|string|max:255',
            'permanent_address_bn' => 'required|string',
            'permanent_address_en' => 'required|string',
            'father_nationality_bn' => 'required|string|max:100',
            'father_nationality_en' => 'required|string|max:100',
            'mother_nationality_bn' => 'required|string|max:100',
            'mother_nationality_en' => 'required|string|max:100',
        ]);

        $nibondon->update($validated);

        return redirect()->route('user.nibondon.index')
            ->with('success', 'নিবন্ধন সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(BirthRegistration $nibondon)
    {
       
        
        $nibondon->delete();

        return redirect()->route('user.nibondon.index')
            ->with('success', 'নিবন্ধন সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
