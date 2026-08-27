<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckIpBan
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Check if IP is banned
        if (Cache::has('banned_ips:' . $ip)) {
            return response()->json(['error' => 'Your IP is banned due to multiple failed login attempts.'], 403);
        }

        return $next($request);
    }
}
