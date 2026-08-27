<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DeathCertificate;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;

class DeathCertificateController extends Controller
{
    public function index()
    {
        $deathCertificates = DeathCertificate::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.death_certificate.index', compact('deathCertificates'));
    }

    public function create()
    {
        return view('user.death_certificate.create');
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            
            try {
                $serviceCharge = ServiceCharge::where('service_name', 'death_certificate')->firstOrFail();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return back()->with('error', 'সার্ভিস চার্জ কনফিগার করা হয়নি। অনুগ্রহ করে অ্যাডমিনের সাথে যোগাযোগ করুন।');
            }

            if ($user->balance < $serviceCharge->amount) {
                return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স।');
            }

            $validated = $request->validate([
                'registration_no' => 'required|string|max:255',
                'office_name' => 'required|string|max:255',
                'office_address' => 'required|string',
                'date_of_death' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'name_bengali' => 'required|string|max:255',
                'name_english' => 'required|string|max:255',
                'father_name_bengali' => 'required|string|max:255',
                'father_name_english' => 'required|string|max:255',
                'mother_name_bengali' => 'required|string|max:255',
                'mother_name_english' => 'required|string|max:255',
                'place_of_death_bengali' => 'required|string',
                'place_of_death_english' => 'required|string',
                'permanent_address_bengali' => 'required|string',
                'permanent_address_english' => 'required|string',
                'registration_date' => 'required|date',
                'issue_date' => 'required|date',
                'email' => 'required|email|max:255',
            ]);

            \DB::beginTransaction();
            try {
                $deathCertificate = DeathCertificate::create(array_merge($validated, [
                    'user_id' => $user->id
                ]));

                // Deduct the service charge from user's balance
                $user->balance -= $serviceCharge->amount;
                $user->save();

                // Create transaction record
                $user->transactions()->create([
                    'amount' => -$serviceCharge->amount,
                    'description' => 'Death Certificate service charge',
                ]);

                \DB::commit();

                return redirect()->route('user.death_certificate.index')
                    ->with('success', 'মৃত্যু সনদপত্র সফলভাবে তৈরি করা হয়েছে।');

            } catch (\Exception $e) {
                \DB::rollBack();
                \Log::error('Death Certificate Creation Error: ' . $e->getMessage());
                return back()->with('error', 'দুঃখিত, একটি ত্রুটি ঘটেছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
            }
        } catch (\Exception $e) {
            \Log::error('Death Certificate System Error: ' . $e->getMessage());
            return back()->with('error', 'সিস্টেমে একটি ত্রুটি ঘটেছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    public function show(DeathCertificate $deathCertificate)
    {
        $certificate = $deathCertificate;
        return view('user.death_certificate.show', compact('certificate'));
    }

    public function edit(DeathCertificate $deathCertificate)
    {
        return view('user.death_certificate.edit', compact('deathCertificate'));
    }

    public function update(Request $request, DeathCertificate $deathCertificate)
    {
        $validated = $request->validate([
            'registration_no' => 'required|string|max:255',
            'office_name' => 'required|string|max:255',
            'office_address' => 'required|string',
            'date_of_death' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'name_bengali' => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
            'father_name_bengali' => 'required|string|max:255',
            'father_name_english' => 'required|string|max:255',
            'mother_name_bengali' => 'required|string|max:255',
            'mother_name_english' => 'required|string|max:255',
            'place_of_death_bengali' => 'required|string',
            'place_of_death_english' => 'required|string',
            'permanent_address_bengali' => 'required|string',
            'permanent_address_english' => 'required|string',
            'registration_date' => 'required|date',
            'issue_date' => 'required|date',
            'email' => 'required|email|max:255',
        ]);

        $deathCertificate->update($validated);

        return redirect()->route('user.death_certificate.index')
            ->with('success', 'মৃত্যু সনদপত্র সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(DeathCertificate $deathCertificate)
    {
        $deathCertificate->delete();

        return redirect()->route('user.death_certificate.index')
            ->with('success', 'মৃত্যু সনদপত্র সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
