<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function markSupportSolved($id)
    {
        // Find the support ticket by ID
        $support = Support::findOrFail($id);
        
        // Update the status of the support ticket to 'solved'
        $support->status = 1; // Assuming '1' represents 'solved'
        $support->save();

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', __('Support ticket marked as solved successfully'));
    }
    public function replyToSupport(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $support = Support::findOrFail($id);
        $support->reply = $request->reply;
        $support->save();

        return redirect()->back()->with('success', __('Support ticket replied successfully'));
    }
}
