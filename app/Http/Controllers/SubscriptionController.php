<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        return response()->json(['message' => 'Subscribe endpoint placeholder']);
    }
}
