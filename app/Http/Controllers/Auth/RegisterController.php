<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected $redirectTo = '/user/dashboard';

    public function __construct()
    {
        if (get_settings()->register_option == '0') {
            abort(403);
        }
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        Session::forget('reg_data');
        $data['districts'] = array();
        return view('auth.register', $data);
    }


    public function register(Request $request)
    {
        // Validate input
        $this->validate($request, [
            'name' => 'required|string|max:91',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users,phone',
            'gender' => 'required',
            'promo' => 'nullable|string|exists:promo_codes,code', // Validation for promo code
        ]);

        // Fetch promo code if provided
        $promoCode = null;
        if ($request->promo) {
            $promoCode = PromoCode::where('code', $request->promo)
                ->where('is_active', 1)
                ->first();
            \Log::info('Promo code: ' . $request->promo . ' found: ' . ($promoCode ? 'yes' : 'no'));
        }

        // Prepare registration data
        $reg_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'nid' => $request->nid,
            'status' => 0,
            'password' => Hash::make($request->password),
            'promo' => $request->promo,
        ];

        // Get registration service charge
        $registrationFee = \App\Models\ServiceCharge::getCharge('register');

        // Handle promo code logic
        if ($promoCode) {
            if ($promoCode->times_used < $promoCode->usage_limit) {
                // Increment times_used for this promo code
                $promoCode->increment('times_used');

                // Calculate actual promo amount based on type
                $actualPromoAmount = 0;
                if ($promoCode->promo_type == 'flat') {
                    $actualPromoAmount = $promoCode->promo_amount;
                } elseif ($promoCode->promo_type == 'percent') {
                    $actualPromoAmount = ($registrationFee * $promoCode->promo_amount) / 100;
                }

                // Check if promo amount covers the registration fee
                if ($actualPromoAmount >= $registrationFee) {
                    // Promo code covers the entire registration fee, skip payment
                    $user = User::create($reg_data);
                    $this->guard()->login($user);
                    session()->flash('success', 'Registration Successful with Promo Code. Payment Skipped.');
                    return redirect($this->redirectTo);
                } else {
                    // Promo code provides a discount, proceed to payment with remaining amount
                    $remainingAmount = $registrationFee - $actualPromoAmount;
                    Session::put('reg_data', $reg_data);
                    Session::put('remaining_amount', $remainingAmount);
                    session()->flash('success', 'Promo code applied. Please complete payment for the remaining amount.');
                    return redirect(route('register.pay'));
                }
            } else {
                // Promo code limit exceeded
                session()->flash('error', 'Promo code usage limit exceeded.');
            }
        } else if ($request->promo) {
            // Invalid promo code
            session()->flash('error', 'Invalid promo code.');
        }

        // No valid promo code or promo code limit exceeded, redirect to payment
        Session::put('reg_data', $reg_data);
        return redirect(route('register.pay'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function check(Request $request)
    {
        $user = User::where('email', $request->input)
                    ->orWhere('phone', $request->input)
                    ->first();
        return response()->json(!blank($user) ? 'exists' : false);
    }

    public function checkPromo(Request $request)
    {
        $promo = $request->input('promo');
        $valid = PromoCode::where('code', $promo)
                          ->where('is_active', 1)
                          ->exists();
        return response()->json($valid ? 'valid' : 'invalid');
    }
}
