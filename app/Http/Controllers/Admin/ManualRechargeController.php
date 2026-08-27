<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recharge;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManualRechargeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('created_at', '>=', now()->subHours(24));

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('from', 'LIKE', "%{$search}%")
                  ->orWhere('txid', 'LIKE', "%{$search}%");
            });
        }

        $recharges = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();

        $stats = [
            'pending' => Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 'pending')->count(),
            'approved' => Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 'approved')->count(),
            'cancelled' => Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 'cancelled')->count(),
            'today' => Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->whereDate('created_at', today())->where('status', 'approved')->sum('amount'),
        ];

        return view('admin.manual-recharges', compact('recharges', 'stats'));
    }

    public function approve($id)
    {
        $recharge = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->findOrFail($id);

        if ($recharge->status != 'pending') {
            return back()->withErrors(['msg' => 'This request is not pending.']);
        }

        $recharge->status = 'approved';
        $recharge->note = 'Approved by admin';
        $recharge->save();

        $user = User::find($recharge->user_id);
        if ($user) {
            $user->balance += $recharge->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $recharge->amount;
            $transaction->type = '+';
            $transaction->description = "Manual recharge approved via {$recharge->gateway_id} (Trx: {$recharge->txid})";
            $transaction->save();
        }

        return back()->with('success', "Approved! {$recharge->amount} BDT added to user balance.");
    }

    public function cancel(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $recharge = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->findOrFail($id);

        if ($recharge->status != 'pending') {
            return back()->withErrors(['msg' => 'This request is not pending.']);
        }

        $recharge->status = 'cancelled';
        $recharge->note = $request->reason;
        $recharge->save();

        return back()->with('success', "Cancelled! Reason: {$request->reason}");
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
            'sender' => 'required|string|max:50',
            'trx' => 'required|string|max:100',
        ]);

        $method = ucfirst($request->method);

        $user = User::where('email', $request->email)
            ->orWhere('name', $request->name)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name ?? 'Test User',
                'email' => $request->email ?? ('test' . time() . '@example.com'),
                'password' => Hash::make('password'),
                'balance' => 0,
                'status' => 1,
            ]);
        }

        $recharge = new Recharge();
        $recharge->user_id = $user->id;
        $recharge->amount = $request->amount;
        $recharge->gateway_id = $method;
        $recharge->from = $request->sender;
        $recharge->txid = $request->trx;
        $recharge->status = 'pending';
        $recharge->save();

        return back()->with('success', "New request #{$recharge->id} added for {$user->name} via {$method}.");
    }
}
