<?php
// app/Http/Controllers/TicketController.php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|integer|between:1,3',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('ticket_photos', 'public');
        }

        Support::create([
            'user_id' => Auth::id(),
            'subject' => $request->input('subject'),
            'msg' => $request->input('message'),
            'priority' => $request->input('priority'),
            'photo' => $photoPath,
            'status' => 0, // Initial status
        ]);

        return redirect()->route('tickets.create')->with('success', 'Ticket created successfully.');
    }
}
