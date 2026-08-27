<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'email' => 'required|email|unique:admins',
                'password' => 'required|min:6|confirmed',
            ]);

            // Create admin directly using query builder for debugging
            $admin = \DB::table('admins')->insert([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if (!$admin) {
                return back()
                    ->withInput()
                    ->with('error', 'Failed to create admin account. Please try again.');
            }

            if (!$admin) {
                return back()->with('error', 'Failed to create admin account.');
            }

            return redirect()->route('admin.login')
                ->with('success', 'Registration successful! Please login.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

        return redirect()->route('admin.login')
            ->with('success', 'Registration successful! Please login.');
    }
}