<?php

namespace App\Http\Middleware;

use Closure;

class TokenAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check for token in headers or query parameters
        $token = $request->header('Authorization');

        // Validate the token (replace with your token validation logic)
        if ($token !== 'your_secret_token') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
