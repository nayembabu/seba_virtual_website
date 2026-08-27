<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard("admin")->user();
        return view("admin.profile.edit", compact("admin"));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard("admin")->user();

        $request->validate([
            "email" => [
                "required",
                "email",
                Rule::unique("admins")->ignore($admin->id),
            ],
            "password" => "nullable|min:8|confirmed",
        ]);

        $admin->email = $request->input("email");

        if ($request->filled("password")) {
            $admin->password = Hash::make($request->input("password"));
        }

        $admin->save();

        return redirect()
            ->route("admin.profile.edit")
            ->with("success", "Profile updated successfully.");
    }
}
