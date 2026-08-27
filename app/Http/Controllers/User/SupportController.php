<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('ticket_photos', 'public');
        }

        Support::create([
            'user_id' => auth()->id(),
            'subject' => $request->input('subject'),
            'msg' => $request->input('message'),
            'photo' => $photoPath,
            'priority' => $request->input('priority'),
            'status' => 'pending',
        ]);

        return redirect()->route('user.support-tickets')->with('success', 'Ticket created successfully.');
    }
}
