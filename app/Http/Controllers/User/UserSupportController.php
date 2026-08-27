<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSupportController extends Controller
{
    public function index()
    {
        $supports = Support::where('user_id', Auth::id())->get();
        return view('user.support-tickets.index', compact('supports'));
    }

    public function show($id)
    {
        $support = Support::findOrFail($id);
        return view('user.support-tickets.show', compact('support'));
    }

    public function create()
    {
        return view('user.support-tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $support = new Support();
        $support->user_id = Auth::id();
        $support->subject = $request->input('subject');
        $support->msg = $request->input('message');
        $support->priority = $request->input('priority');
        $support->status = '0'; // Default to pending

        if ($request->hasFile('photo')) {
            $support->photo = $request->file('photo')->store('ticket_photos', 'public');
        }

        $support->save();

        return redirect()->route('user.support-tickets')->with('success', 'Support ticket created successfully.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $support = Support::findOrFail($id);

        if ($support->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Store the reply
        $support->replies()->create([
            'user_id' => Auth::id(),
            'reply' => $request->input('reply'),
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('reply_photos', 'public') : null,
        ]);

        return redirect()->route('user.support-tickets.show', $id)->with('success', 'Reply sent successfully.');
    }
}
