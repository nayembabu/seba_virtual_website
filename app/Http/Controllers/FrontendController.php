<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;

class FrontendController extends Controller
{
    public function __construct()
    {
        $this->middleware(StartSession::class);
    }
    public function index(Request $request)
    {
        // Generate two random numbers for captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $sum = $num1 + $num2;
        

        

        
        return view('auth.login', [
            'num1' => $num1,
            'num2' => $num2
        ]);
    }

    public function api()
    {
        //
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Attempt to log in with either email or username
        $credentials = [
            'password' => $request->password
        ];
        $userAnswer = (int) $request->input('captcha');
        $num1 = (int) $request->input('num1');
        $num2 = (int) $request->input('num2');
        $correctAnswer = $num1 + $num2;

        if ($userAnswer !== $correctAnswer) {
            return back()->withErrors(['captcha' => 'Captcha verification failed. Please try again.']);
        }

        // Check if input is email or username
        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials[$field] = $request->username;

        if (auth()->attempt($credentials)) {
            // Successful login
            return redirect()->route('user.dashboard');
        }

        // Failed login
        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Invalid credentials']);
    }
}
