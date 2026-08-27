<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Cache;

class TrackFailedLogin
{
    public function handle(Failed $event)
    {
        $ip = request()->ip();
        $attemptsKey = 'login_attempts:' . $ip;

        // Increment failed login attempts
        $attempts = Cache::get($attemptsKey, 0) + 1;
        Cache::put($attemptsKey, $attempts, now()->addMinutes(15));

        // If failed attempts exceed 3, ban the IP
        if ($attempts >= 3) {
            Cache::put('banned_ips:' . $ip, true, now()->addHours(1)); // Ban for 1 hour
        }
    }
}  
