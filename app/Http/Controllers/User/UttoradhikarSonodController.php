<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UttoradhikarSonod;

class UttoradhikarSonodController extends Controller
{
    // ...existing code...

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'certificate_number' => 'required|numeric|min:2000|max:' . (date('Y') + 1),
                'union_name' => 'required|string|max:255',
                'union_address' => 'required|string|max:255',
                'word_no' => 'required|numeric',
                'village_name' => 'required|string|max:255',
                'post_office' => 'required|string|max:255',
                'thana' => 'required|string|max:255',
                'upozila' => 'required|string|max:255',
                'zila' => 'required|string|max:255',
                // ...existing validation rules...
            ]);

            $fee = \App\Models\ServiceCharge::getCharge('uttoradhikarsonod');
            $user = auth()->user();

            if ($user->balance < $fee) {
                return back()->withErrors(['msg' => 'Insufficient balance']);
            }

            $user->balance -= $fee;
            $user->save();

            create_transaction($fee, '-', 'Created উত্তরাধিকার সনদ', $user->id);

            UttoradhikarSonod::create($validated);

            return redirect()->route('user.uttoradhikar-sonod.index')->with('success', 'Data saved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error saving Uttoradhikar Sonod:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    // ...existing code...
}
