<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class InactiveAccountController extends Controller
{
    public function showInactiveMessage()
    {
        $whatsapp = Setting::where('name', 'whatsapp_number')->first();
        $whatsappNumber = $whatsapp ? $whatsapp->value : '+919635038840';
        return view('user.inactive_account', compact('whatsappNumber'));
    }
}