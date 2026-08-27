<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminModController extends Controller
{
    public function dashboard()
    {
        return view('mod.dashboard');
    }
}