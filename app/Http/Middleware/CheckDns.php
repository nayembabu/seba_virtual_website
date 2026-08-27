<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDns
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedDns = 'all.ddnskey.com';
        $host = $request->getHost();

        if ($host !== $allowedDns) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
