<?php
namespace App\Http\Controllers\Auth;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/user/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the login fields
        $this->validateLogin($request);

        // Get user by username (which could be email)
        $user = User::where('email', $request->username)
                    ->orWhere('username', $request->username)
                    ->first();

        if (!$user) {
            return back()->withErrors(['username' => 'User not found.']);
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // Check if user is banned
        if ($user->status == 0) {
            return back()->withErrors(['msg' => 'Your account is inactive. Please contact administrator.']);
        }

        // Log successful attempt
        $this->logLoginAttempt($user->email, true);

        // Login user
        Auth::login($user);

        // Set success message
        session()->flash('success', 'Successfully logged in!');

        // Redirect to dashboard
        return redirect()->intended(route('user.dashboard'));
    }

    protected function logLoginAttempt($email, $status)
    {
        $user = User::where('email', $email)->first();
        $userId = $user ? $user->id : null;

        LoginAttempt::create([
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'login_time' => now(),
            'status' => $status,
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }
}
