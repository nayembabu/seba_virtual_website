<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recharge;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $data['users'] = User::count();
        $data['total_balance'] = User::sum('balance');
        $data['total_recharge'] = Transaction::where('type', '+')->where('description', 'like', '%Recharge%')->sum('amount');
        $data['total_withdraw'] = Transaction::where('type', '-')->sum('amount');
        $data['today_recharge_count'] = Recharge::whereDate('created_at', today())->where('status', 1)->count();
        $data['today_recharge_amount'] = Recharge::whereDate('created_at', today())->where('status', 1)->sum('amount');
        $data['recent_users'] = User::orderBy('created_at', 'desc')->limit(10)->get();
        return view('admin.dashboard', $data);
    }

    public function moderators()
    {
        $data['moderators'] = \App\Models\Admin::all();
        return view('admin.moderators', $data);
    }

    public function add_moderator()
    {
        return view('admin.add-moderator');
    }

    public function add_moderator_p(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
        ]);

        $admin = new \App\Models\Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Moderator added successfully');
    }

    public function edit_moderator($id)
    {
        $data['mod'] = \App\Models\Admin::findOrFail($id);
        return view('admin.edit-moderator', $data);
    }

    public function edit_moderator_p(Request $request, $id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return back()->with('success', 'Moderator updated successfully');
    }

    public function delete_moderator($id)
    {
        \App\Models\Admin::findOrFail($id)->delete();
        return back()->with('success', 'Moderator deleted successfully');
    }

    public function moderator_reports($id)
    {
        $data['mod'] = \App\Models\Admin::findOrFail($id);
        $data['applications'] = \App\Models\Application::where('vendor_id', $id)->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.moderator-reports', $data);
    }

    public function recharges(Request $request)
    {
        $query = Recharge::with('user')
            ->whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket']);

        if ($request->q) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('sender_number', 'LIKE', "%$q%")
                    ->orWhere('txid', 'LIKE', "%$q%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('email', 'LIKE', "%$q%")
                          ->orWhere('phone', 'LIKE', "%$q%");
                    });
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $data['recharges'] = $query->orderBy('id', 'desc')->paginate(20);
        $data['request'] = $request;

        $data['pending_count'] = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 0)->count();
        $data['approved_count'] = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 1)->count();
        $data['rejected_count'] = Recharge::whereIn('gateway_id', ['bKash', 'Nagad', 'Rocket'])->where('status', 2)->count();

        return view('admin.recharges', $data);
    }

    public function approve_recharge($id)
    {
        $recharge = Recharge::findOrFail($id);

        if ($recharge->status != 0) {
            return back()->with('error', 'This request is already processed');
        }

        $user = User::findOrFail($recharge->user_id);
        $user->balance += $recharge->amount;
        $user->save();

        $recharge->status = 1;
        $recharge->save();

        $this->createTransaction($recharge->amount, '+', 'Manual Recharge via ' . $recharge->gateway_id, $user->id);

        $this->sendTelegram(
            '<b>Recharge Approved</b>' . "\n"
            . 'User ID: ' . $user->id . "\n"
            . 'Amount: ' . $recharge->amount . ' BDT' . "\n"
            . 'Time: ' . now()->format('Y-m-d H:i:s')
        );

        return back()->with('success', 'Recharge approved successfully');
    }

    public function reject_recharge(Request $request, $id)
    {
        $recharge = Recharge::findOrFail($id);

        if ($recharge->status != 0) {
            return back()->with('error', 'This request is already processed');
        }

        $recharge->status = 2;
        $recharge->note = $request->reason ?? '';
        $recharge->save();

        $user = $recharge->user;

        $this->sendTelegram(
            '<b>Recharge Cancelled</b>' . "\n"
            . 'Email: ' . $user->email . "\n"
            . 'Reason: ' . ($request->reason ?? 'N/A') . "\n"
            . 'Time: ' . now()->format('Y-m-d H:i:s')
        );

        return back()->with('success', 'Recharge rejected');
    }

    private function sendTelegram($message)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');
            if (empty($botToken) || empty($chatId)) return;

            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
            $data = ['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'HTML'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {}
    }

    private function createTransaction($amount, $type, $description, $user_id)
    {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->description = $description;
        $transaction->save();
    }

    public function gateways()
    {
        $data['gateways'] = Gateway::orderBy('id', 'desc')->paginate(20);
        return view('admin.gateways', $data);
    }

    public function add_gateway()
    {
        return view('admin.add-gateway');
    }

    public function store_gateway(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $gateway = new Gateway();
        $gateway->name = $request->name;
        $gateway->account = $request->account;
        $gateway->details = $request->details ?? '';
        $gateway->status = $request->status;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $logo->storeAs('uploads', $filename, 'public');
            $gateway->logo = $filename;
        }

        $gateway->save();

        return redirect()->route('admin.gateways')->with('success', 'Gateway added successfully');
    }

    public function edit_gateway($id)
    {
        $data['gateway'] = Gateway::findOrFail($id);
        return view('admin.edit-gateway', $data);
    }

    public function update_gateway(Request $request, $id)
    {
        $gateway = Gateway::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $gateway->name = $request->name;
        $gateway->account = $request->account;
        $gateway->details = $request->details ?? '';
        $gateway->status = $request->status;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $logo->storeAs('uploads', $filename, 'public');
            $gateway->logo = $filename;
        }

        $gateway->save();

        return redirect()->route('admin.gateways')->with('success', 'Gateway updated successfully');
    }

    public function delete_gateway($id)
    {
        Gateway::findOrFail($id)->delete();
        return back()->with('success', 'Gateway deleted successfully');
    }

    public function toggle_gateway($id)
    {
        $gateway = Gateway::findOrFail($id);
        $gateway->status = !$gateway->status;
        $gateway->save();

        $statusText = $gateway->status ? 'activated' : 'deactivated';
        return back()->with('success', "Gateway {$gateway->name} {$statusText} successfully");
    }
}
