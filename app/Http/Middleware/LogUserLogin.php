<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginLog;

class LogUserLogin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            LoginLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip()
            ]);
        }

        return $next($request);
    }
}
