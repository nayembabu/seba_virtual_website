<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SignCopyOrder;
use App\Models\SignCopyOrderType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignCopyOrderController extends Controller
{
    public function index()
    {
        $orders = SignCopyOrder::where('user_id', auth()->id())
            ->latest()
            ->get();
        
        // Get all order types with their costs
        $orderTypes = SignCopyOrderType::all()->keyBy('id');

        return view('user.sign_copy_order.index', compact('orders', 'orderTypes'));
    }

   public function store(Request $request)
{
    $request->validate([
        'form_type' => 'required|integer|between:1,6',
        'form_data.photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $formData = [];
    $formType = $request->form_type;
    
    // Get price from sign_copy_orders_type table
    $orderType = SignCopyOrderType::find($formType);
    $price = $orderType ? $orderType->cost : 50;
    
    // Form type mapping to Bangla names
    $formTypeNames = [
        1 => '১০/১২/১৭ দিয়ে সাইন',
        2 => 'ফরম/নিবন্ধন নং দিয়ে সাইন',
        3 => 'অফিসিয়াল সারভার কপি',
        4 => 'NID CMS COPY',
        5 => 'নাম ঠিকানা দিয়ে সাইন',
        6 => 'ম্যাচ ফাউন্ড কপি',
    ];
    
    $formTypeName = $formTypeNames[$formType] ?? 'অজানা';

    switch($formType) {
        case 1:
        case 2:
            // Get data from form_data[] or form_info
            $formDataFromRequest = $request->input('form_data', []);
            if (is_array($formDataFromRequest)) {
                $formData = collect($formDataFromRequest)
                    ->filter(function ($value) {
                        return !is_null($value) && $value !== '';
                    })
                    ->all();
            } else {
                // Fallback to old method if form_data is not array
                $formData = [
                    'name' => $request->input('name'),
                    'nid' => $request->input('nid')
                ];
            }
            break;
            
        case 3:
        case 4:
            // Get data from form_data[] or form_info
            $formDataFromRequest = $request->input('form_data', []);
            if (is_array($formDataFromRequest)) {
                $formData = collect($formDataFromRequest)
                    ->filter(function ($value) {
                        return !is_null($value) && $value !== '';
                    })
                    ->all();
            } else {
                // Fallback to old method if form_data is not array
                $formData = [
                    'nid' => $request->input('nid'),
                    'dob' => $request->input('dob')
                ];
            }
            break;
            
        case 5:
            // Get form data and filter out null/empty values
            $formData = collect($request->input('form_data', []))
                ->filter(function ($value) {
                    return !is_null($value) && $value !== '';
                })
                ->all();
            break;
            
        case 6:
            $formData = collect($request->input('form_data', []))
                ->filter(function ($value) {
                    return !is_null($value) && $value !== '';
                })
                ->all();
            
            if($request->hasFile('form_data.photo')) {
                $photo = $request->file('form_data.photo');
                $path = $photo->store('sign-copy-photos', 'public');
                $formData['photo'] = $path;
            }
            break;
    }

    // Get user balance
    $user = auth()->user();
    
    // Check if user has sufficient balance
    if ($user->balance < $price) {
        return redirect()
            ->back()
            ->with('error', 'পর্যাপ্ত টাকা নেই। প্রয়োজনীয় টাকা: ' . $price . ' টাকা, বর্তমান ব্যালেন্স: ' . $user->balance . ' টাকা');
    }

    // Create the order
    $order = SignCopyOrder::create([
        'user_id' => auth()->id(),
        'form_type' => $formType,
        'form_type_name' => $formTypeName,
        'form_data' => $formData,
        'cost' => $price,
        'status' => 0
    ]);
    
    // Deduct balance from user
    $user->decrement('balance', $price);
    
    // Create transaction record
    $txId = 'TX-' . $order->id . '-' . time();
    Transaction::create([
        'user_id' => auth()->id(),
        'amount' => $price,
        'details' => 'সাইন কপি অর্ডার - ' . $formTypeName,
        'type' => '-',
        'tx_id' => $txId,
        'description' => 'Sign Copy Order #' . $order->id
    ]);

    return redirect()
        ->route('user.sign.copy.order.index')
        ->with('success', 'আপনার অর্ডারটি সফলভাবে জমা হয়েছে। ' . $price . ' টাকা আপনার ব্যালেন্স থেকে কাটা হয়েছে।');
}

// Add this helper method to parse the labeled data
private function parseFormData($text)
{
    $lines = explode("\n", $text);
    $parsed = [];
    
    $fieldMap = [
        'নিজ নাম' => 'name',
        'পিতার নাম' => 'father_name',
        'মাতার নাম' => 'mother_name',
        'স্বামী/স্ত্রী নাম' => 'spouse_name',
        'জন্ম সনদ' => 'birth_cert',
        'বিভাগ' => 'division',
        'জেলা' => 'district',
        'উপজেলা' => 'upazila',
        'ইউনিয়ন/পৌরসভা/সিটি করপোরেশন' => 'union',
        'ওয়ার্ড নং' => 'ward',
        'ডাকঘর' => 'post_office',
        'গ্রাম' => 'village',
        'পিতার এনআইডি নং' => 'father_nid',
        'মাতার এনআইডি নং' => 'mother_nid',
        'সাথে ভোটার হওয়া একজনের এনআইডি' => 'voter_nid',
    ];
    
    foreach ($lines as $line) {
        foreach ($fieldMap as $label => $key) {
            if (strpos($line, $label) !== false) {
                // Extract value after the colon
                $parts = explode(':', $line, 2);
                if (isset($parts[1])) {
                    $value = trim($parts[1]);
                    if (!empty($value)) {
                        $parsed[$key] = $value;
                    }
                }
                break;
            }
        }
    }
    
    return $parsed;
}

    public function show(SignCopyOrder $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.sign_copy_order.show', compact('order'));
    }

    public function downloadPDFPublic($filename)
    {
        // Full file path inside public/
        $path = public_path($filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Get only the actual filename without path
        $downloadName = basename($filename);

        return response()->download($path, $downloadName, [
            'Content-Type' => 'application/pdf',
        ]);
    }



    public function downloadPDF($filename)
    {
        // Security check - ensure filename is valid (no path traversal)
        if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
            abort(403, 'Access denied');
        }

        $filepath = public_path($filename);

        // Security check - ensure file exists
        if (!file_exists($filepath) || !is_file($filepath)) {
            abort(404, 'File not found at: ' . $filepath);
        }

        // Verify user owns this order
        $order = SignCopyOrder::where('admin_note', $filename)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            abort(403, 'Unauthorized access to this file');
        }

        // Return PDF for download
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}