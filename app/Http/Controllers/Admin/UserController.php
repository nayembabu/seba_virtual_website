<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc("id")->get();
        return view("admin.users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:60",
            "email" => "nullable|email|unique:users,email",
            "phone" => "nullable|string|max:91|unique:users,phone",
            "password" => "required|min:6",
            "gender" => "nullable|string",
            "dob" => "nullable|string",
            "nid" => "nullable|string|max:100",
            "balance" => "nullable|numeric|min:0",
            "status" => "boolean",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "gender" => $request->gender,
            "dob" => $request->dob,
            "nid" => $request->nid,
            "balance" => $request->balance ?? 0.00,
            "role" => 1,
            "status" => $request->is_active ?? 0,
            "added_by" => auth()->guard("admin")->user()->id, // Assuming admin is logged in
        ]);

        return redirect()->route("admin.users.index")->with("success", "User created successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("admin.users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string|max:60",
            "email" => ["nullable", "email", Rule::unique("users", "email")->ignore($user->id)],
            "phone" => ["nullable", "string", "max:91", Rule::unique("users", "phone")->ignore($user->id)],
            "password" => "nullable|min:6",
            "gender" => "nullable|string",
            "dob" => "nullable|string",
            "nid" => "nullable|string|max:100",
            "balance" => "nullable|numeric|min:0",
            "status" => "boolean",
        ]);

        $userData = [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "dob" => $request->dob,
            "nid" => $request->nid,
            "balance" => $request->balance ?? 0.00,
            "role" => 1,
            "status" => $request->status ?? 0,
        ];

        if ($request->filled("password")) {
            $userData["password"] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route("admin.users.index")->with("success", "User updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route("admin.users.index")->with("success", "User deleted successfully.");
    }

    public function updateStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();

        return response()->json(["message" => "User status updated successfully."]);
    }

    public function updateBalance(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "amount" => "required|numeric|min:0.01",
            "type" => "required|in:add,subtract",
        ]);

        $user = User::findOrFail($request->user_id);
        $amount = $request->amount;

        if ($request->type == "add") {
            $user->balance += $amount;
            $message = "Balance added successfully.";
        } else {
            if ($user->balance < $amount) {
                return response()->json(["message" => "Insufficient balance."], 400);
            }
            $user->balance -= $amount;
            $message = "Balance subtracted successfully.";
        }

        $user->save();

        return response()->json(["message" => $message]);
    }
}
