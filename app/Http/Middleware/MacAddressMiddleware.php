<?php

namespace App\Http\Middleware;

use Closure;

class MacAddressMiddleware
{
    public function handle($request, Closure $next, ...$allowedMacAddresses)
    {
        $macAddress = $request->server('HTTP_X_FORWARDED_FOR'); // Replace with actual method to get MAC address

        if (!in_array($macAddress, $allowedMacAddresses)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
