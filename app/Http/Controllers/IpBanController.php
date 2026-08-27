<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IpBanController extends Controller
{
    public function index()
    {
        // Retrieve all banned IPs from cache
        $bannedIps = Cache::get('banned_ips', []);

        return view('ipban.index', compact('bannedIps'));
    }

    public function ban(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
            'duration' => 'required|integer|min:1', // Duration in minutes
        ]);

        $ip = $request->input('ip');
        $duration = $request->input('duration');

        // Store the banned IP in cache for the specified duration
        Cache::put('banned_ips:' . $ip, true, now()->addMinutes($duration));

        return redirect()->back()->with('message', 'IP ' . $ip . ' has been banned for ' . $duration . ' minutes.');
    }

    public function unban(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
        ]);

        $ip = $request->input('ip');

        // Remove the banned IP from cache
        if (Cache::has('banned_ips:' . $ip)) {
            Cache::forget('banned_ips:' . $ip);
            return redirect()->back()->with('message', 'IP ' . $ip . ' has been unbanned.');
        }

        return redirect()->back()->with('error', 'IP not found in the banned list.');
    }
}
