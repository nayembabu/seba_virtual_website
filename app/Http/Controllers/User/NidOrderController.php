<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NidOrder;
use App\Models\NidType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NidOrderController extends Controller
{
    public function index()
    {
        $orders = NidOrder::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Get all NID types with their costs
        $nidTypes = NidType::all()->keyBy('id');
        
        return view('user.id-card-order.index', compact('orders', 'nidTypes'));
    }

    public function store(Request $request)
    {
        // Start transaction
        DB::beginTransaction();

        try {
            // Validate common fields
            $validator = Validator::make($request->all(), [
                'form_type' => 'required|integer|between:1,4',
                'email' => 'nullable|email|max:255',
            ]);

            // Add specific validation rules based on form type
            switch ($request->form_type) {
                case NidOrder::TYPE_NID_10_12_17:
                case NidOrder::TYPE_NID_FORM_REG:
                    $validator->addRules([
                        'name' => 'required|string|max:255',
                        'nid' => 'required|string|max:255',
                    ]);
                    break;

                case NidOrder::TYPE_USER_ID_PASS:
                    $validator->addRules([
                        'nid' => 'required|string|max:255',
                        'dob' => 'required|date',
                    ]);
                    break;

                case NidOrder::TYPE_LOST_FORM:
                    $validator->addRules([
                        'email' => 'required|string|max:255',
                        'password' => 'required|string|max:255',
                    ]);
                    break;
            }

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Get service cost from nid_types table
            $nidType = NidType::where('id', $request->form_type)
                            ->where('is_active', 1)
                            ->first();
                            
            if (!$nidType) {
                return back()->with('error', 'এই সার্ভিসটি এখন উপলব্ধ নয়!');
            }

            // Check if user has enough balance
            $user = Auth::user();
            if ($user->balance < $nidType->cost) {
                return back()->with('error', 'আপনার ব্যালেন্স পর্যাপ্ত নয়! প্রয়োজনীয় ব্যালেন্স: ' . $nidType->cost . ' টাকা');
            }

            // Form type mapping to Bangla names
            $formTypeNames = [
                NidOrder::TYPE_NID_10_12_17 => '১০/১২/১৭ দিয়ে এনআইডি',
                NidOrder::TYPE_NID_FORM_REG => 'ফরম/নিবন্ধন নম্বর/১৩ ডিজিট দিয়ে এনআইডি',
                NidOrder::TYPE_USER_ID_PASS => 'ইউজার আইডি পাস সেট',
                NidOrder::TYPE_LOST_FORM => 'হারানো ফরম উত্তোলন',
            ];
            
            $formTypeName = $formTypeNames[$request->form_type] ?? 'Unknown';

            // Deduct balance from user using direct query for atomicity
            DB::table('users')
                ->where('id', $user->id)
                ->decrement('balance', $nidType->cost);

            // Create NID order
            $nidOrder = NidOrder::create([
                'user_id' => Auth::id(),
                'form_type' => $request->form_type,
                'form_type_name' => $formTypeName,
                'name' => $request->name,
                'nid' => $request->nid,
                'dob' => $request->dob,
                'email' => $request->email,
                'password' => $request->password,
                'cost' => $nidType->cost,
                'status' => NidOrder::STATUS_PENDING,
            ]);

            // Commit transaction
            DB::commit();

            return back()->with('success', 'অর্ডার সফলভাবে জমা হয়েছে।');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'দুঃখিত! কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।')
                ->withInput();
        }
    }

    public function list()
    {
        $orders = NidOrder::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->paginate(20);
        return view('user.id-card-order.list', compact('orders'));
    }

    public function show(NidOrder $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.id-card-order.show', compact('order'));
    }
}