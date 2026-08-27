<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->status == 0) {
            Auth::guard('web')->logout(); // Log out the user to prevent dashboard access
            return redirect()->route('inactive.account');
        }

        return $next($request);

    }

}
