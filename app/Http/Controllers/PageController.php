<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aboutUs()
    {
        return view('about_us');
    }

    public function termsAndConditions()
    {
        return view('terms_and_conditions');
    }

    public function privacyPolicy()
    {
        return view('privacy_policy');
    }
}
