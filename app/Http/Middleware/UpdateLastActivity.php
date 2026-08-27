<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Update user's last activity timestamp
            Auth::user()->update(['updated_at' => Carbon::now()]);
        }

        return $next($request);
    }
}
