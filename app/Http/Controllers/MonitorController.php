<?php
// app/Http/Controllers/MonitorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginLog;

class MonitorController extends Controller
{
    public function index()
    {
        // Get users with balance but no recharge history, paginated
        $users = User::doesntHave('recharges')
            ->where('balance', '>', 0)
            ->paginate(20);

        // Get users with the same IP address, paginated
        $loginLogs = LoginLog::select('user_id', 'ip_address')
            ->groupBy('ip_address', 'user_id')
            ->havingRaw('COUNT(*) > 1')
            ->paginate(20);

        return view('admin.monitor', compact('loginLogs', 'users'));
    }
}
