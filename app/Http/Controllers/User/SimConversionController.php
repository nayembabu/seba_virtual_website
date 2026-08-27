<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SimConversion;
use App\Models\SimConversionType;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SimConversionController extends Controller
{
    /**
     * Get form type name by type ID
     */
    private function getFormTypeName($type)
    {
        $formTypes = [
            1 => 'জিপি',
            2 => 'রবি/এয়ারটেল',
            3 => 'বাংলালিংক',
            4 => 'টেলিটক',
            5 => 'ব্রিরিলিয়ান্ট'
        ];

        return $formTypes[$type] ?? 'অন্যান্য';
    }

    public function index()
    {
        $pageTitle = 'মোবাইল নাম্বার কনভার্সন';
        $orders = SimConversion::where('user_id', auth()->id())
            ->latest()
            ->paginate(getPaginate());
        
        // Get all SIM conversion types with their costs
        $simTypes = SimConversionType::all()->keyBy('id');
        
        return view('user.Seam_Biometric_order.index', compact('pageTitle', 'orders', 'simTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|integer|between:1,5',
            'number' => 'required|string'
        ]);

        // Get price from sim_conversions_type table
        $simType = SimConversionType::find($request->type);
        $price = $simType ? $simType->cost : 100;

        // Get user balance
        $user = auth()->user();
        
        // Check if user has sufficient balance
        if ($user->balance < $price) {
            return redirect()
                ->back()
                ->with('error', 'পর্যাপ্ত টাকা নেই। প্রয়োজনীয় টাকা: ' . $price . ' টাকা, বর্তমান ব্যালেন্স: ' . $user->balance . ' টাকা');
        }

        $order = new SimConversion();
        $order->user_id = auth()->id();
        $order->type = $request->type;
        $order->form_type_name = $this->getFormTypeName($request->type);
        $order->form_data = [
            'number' => $request->number
        ];
        $order->status = 0; // Pending
        $order->cost = $price;
        $order->save();
        
        // Deduct balance from user
        $user->decrement('balance', $price);
        
        // Create transaction record
        $txId = 'TX-' . $order->id . '-' . time();
        Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $price,
            'details' => 'সিম কনভার্সন অর্ডার - ' . $this->getFormTypeName($request->type),
            'type' => '-',
            'tx_id' => $txId,
            'description' => 'SIM Conversion Order #' . $order->id
        ]);

        session()->flash('success', 'আপনার অর্ডারটি সফলভাবে জমা হয়েছে। ' . $price . ' টাকা আপনার ব্যালেন্স থেকে কাটা হয়েছে।');
        return back();
    }

    public function view($id)
    {
        $pageTitle = 'অর্ডার বিস্তারিত';
        $order = SimConversion::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('user.Seam_Biometric_order.view', compact('pageTitle', 'order'));
    }

    public function downloadPdf($id)
    {
        $order = SimConversion::where('user_id', auth()->id())
            ->findOrFail($id);

        // Check if admin_note exists and file exists
        if (!$order->admin_note || !file_exists(public_path($order->admin_note))) {
            return back()->with('error', 'PDF ফাইল পাওয়া যাচ্ছে না।');
        }

        // Download the file
        return response()->download(
            public_path($order->admin_note),
            'SIM-Conversion-' . $order->id . '.pdf'
        );
    }
}