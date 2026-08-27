<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PassportOrder;
use App\Models\PassportOrderType;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PassportOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userCheck');
    }
    public function index()
    {
        $pageTitle = 'পাসপোর্ট সার্ভিস';
        $emptyMessage = 'No orders found';
        $orders = PassportOrder::where('user_id', auth()->id())
                              ->latest()
                              ->paginate(getPaginate());
        
        // Get all passport order types with their costs
        $passportTypes = PassportOrderType::all()->keyBy('id');

        return view('user.Passport_order.index', compact('pageTitle', 'emptyMessage', 'orders', 'passportTypes'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'form_type' => 'required|integer|between:1,4',
            'form_data.name' => 'required|string|max:255',
            'form_data.dob' => 'required|date',
            'form_data.passport_no' => 'nullable|string|max:50',
            'form_data.nid_no' => 'nullable|string|max:50',
        ]);

        // Additional validation based on form_type
        if (in_array($request->form_type, [1, 2, 4]) && empty($request->input('form_data.passport_no'))) {
            return back()->withErrors(['form_data.passport_no' => 'Passport No. is required'])->withInput();
        }
        
        if ($request->form_type == 3 && empty($request->input('form_data.nid_no'))) {
            return back()->withErrors(['form_data.nid_no' => 'NID No. is required'])->withInput();
        }

        // Form type mapping to Bangla names
        $formTypeNames = [
            1 => 'MRP Passport to SB Copy',
            2 => 'E-Passport to Delivery Slip',
            3 => 'NID/Nibondhon to Passport Info',
            4 => 'BMET 78% Approve',
        ];
        
        $formTypeName = $formTypeNames[$request->form_type] ?? 'Unknown';

        // Get price from passport_orders_type table
        $passportType = PassportOrderType::find($request->form_type);
        $price = $passportType ? $passportType->cost : 100;

        // Get user balance
        $user = auth()->user();
        
        // Check if user has sufficient balance
        if ($user->balance < $price) {
            return redirect()
                ->back()
                ->with('error', 'পর্যাপ্ত টাকা নেই। প্রয়োজনীয় টাকা: ' . $price . ' টাকা, বর্তমান ব্যালেন্স: ' . $user->balance . ' টাকা');
        }

        // Extract only form_data from request
        $formData = $request->input('form_data', []);
        
        // Remove empty values
        $formData = array_filter($formData, function($value) {
            return !is_null($value) && $value !== '';
        });
        
        // Create the order
        $order = new PassportOrder();
        $order->user_id = auth()->id();
        $order->form_type = $request->form_type;
        $order->form_type_name = $formTypeName;
        $order->form_data = $formData;
        $order->status = 0;
        $order->cost = $price;
        $order->save();
        
        // Deduct balance from user
        $user->decrement('balance', $price);
        
        // Create transaction record
        $txId = 'TX-' . $order->id . '-' . time();
        Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $price,
            'details' => 'পাসপোর্ট অর্ডার - ' . $formTypeName,
            'type' => '-',
            'tx_id' => $txId,
            'description' => 'Passport Order #' . $order->id
        ]);

        session()->flash('success', 'আপনার অর্ডারটি সফলভাবে জমা হয়েছে। ' . $price . ' টাকা আপনার ব্যালেন্স থেকে কাটা হয়েছে।');
        return back();
    }

    public function show($id)
    {
        $order = PassportOrder::findOrFail($id);
        
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $pageTitle = 'Order Details';
        
        return view('user.Passport_order.show', compact('pageTitle', 'order'));
    }

    public function download($id)
    {
        $order = PassportOrder::findOrFail($id);
        
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Extract the PDF filename from admin_note
        // admin_note contains something like "/passport_pdfs/order_20_1763285308.pdf"
        $adminNote = $order->admin_note;
        
        if (empty($adminNote)) {
            return back()->with('error', 'কোন PDF ফাইল পাওয়া যায়নি।');
        }

        // Clean the path - remove leading slash if present
        $pdfPath = ltrim($adminNote, '/');
        
        // Build full file path
        $filePath = public_path($pdfPath);
        
        // Check if file exists
        if (!file_exists($filePath)) {
            return back()->with('error', 'ফাইলটি খুঁজে পাওয়া যায়নি।');
        }

        // Get the filename for download
        $filename = basename($filePath);
        
        // Download the file
        return response()->download($filePath, $filename);
    }
}