<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function usageHistory(Request $request)
    {
        $now = Carbon::now();
        
        // Fetch transaction types and counts for the last 24 hours
        $last24Hours = Transaction::where('created_at', '>=', $now->subHours(24))
            ->select('details as transaction_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('transaction_type')
            ->get();

        // Fetch transaction types and counts for the last week
        $now = Carbon::now(); // Resetting time
        $lastWeek = Transaction::where('created_at', '>=', $now->subDays(7))
            ->select('details as transaction_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('transaction_type')
            ->get();

        // Fetch transaction types and counts for the last month
        $now = Carbon::now(); // Resetting time
        $lastMonth = Transaction::where('created_at', '>=', $now->subMonth())
            ->select('details as transaction_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('transaction_type')
            ->get();

        return view('admin.use', compact('last24Hours', 'lastWeek', 'lastMonth'));
    }
}
