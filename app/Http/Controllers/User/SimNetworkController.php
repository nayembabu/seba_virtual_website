<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SimNetworkOrder;
use App\Models\SimNetworkOrderType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimNetworkController extends Controller
{
    /**
     * Get service name based on type
     */
    private function getServiceName($type)
    {
        $services = [
            1 => 'কল লিস্ট ৩ মাস',
            2 => 'রবি/এয়ারটেল SMS',
            3 => 'বাংলালিংক SMS',
            4 => 'নাম্বার টু লোকেশন',
            5 => 'NID টু নাম্বার',
            6 => 'IMEI টু লোকেশন',
            7 => 'IMEI টু এক্টিভ',
            8 => 'নাম্বার টু IMEI',
            9 => 'বিকাশ ইনফো',
            10 => 'নগদ ইনফো',
            11 => 'রকেট ইনফো',
        ];

        return $services[$type] ?? 'সিম নেটওয়ার্ক সার্ভিস';
    }

    /**
     * Display a listing of the orders
     */
    public function index()
    {
        $orders = SimNetworkOrder::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Get all SIM network order types with their costs
        $simNetworkTypes = SimNetworkOrderType::all()->keyBy('id');

        return view('user.sim_network_order.index', compact('orders', 'simNetworkTypes'));
    }

    /**
     * Store a newly created order in storage
     */
    public function store(Request $request)
    {
        try {
            $type = $request->input('type');
            
            // Validate based on type
            $rules = $this->getValidationRules($type);
            $request->validate($rules);

            // Get service cost from database
            $simNetworkType = SimNetworkOrderType::find($type);
            $cost = $simNetworkType ? $simNetworkType->cost : 100;

            // Check user balance
            if (Auth::user()->balance < $cost) {
                return redirect()->back()
                    ->with('error', 'পর্যাপ্ত টাকা নেই। প্রয়োজনীয় টাকা: ' . $cost . ' টাকা, বর্তমান ব্যালেন্স: ' . Auth::user()->balance . ' টাকা')
                    ->withInput();
            }

            DB::beginTransaction();

            try {
                // Prepare form data based on type
                $formData = $this->prepareFormData($request, $type);

                // Create order
                $order = SimNetworkOrder::create([
                    'user_id' => Auth::id(),
                    'type' => $type,
                    'form_type_name' => $this->getServiceName($type),
                    'form_data' => $formData,
                    'status' => 0, // Pending
                    'cost' => $cost,
                ]);

                // Deduct balance
                $user = Auth::user();
                $user->balance -= $cost;
                $user->save();

                // Create transaction record
                Transaction::create([
                    'user_id' => Auth::id(),
                    'amount' => $cost,
                    'details' => $this->getServiceName($type),
                    'type' => '-',
                    'tx_id' => 'TX-' . $order->id . '-' . time(),
                    'description' => $this->getServiceName($type) . ' - Order #' . $order->id,
                ]);

                DB::commit();

                return redirect()->route('user.sim.network.index')
                    ->with('success', 'অর্ডার সফলভাবে জমা হয়েছে! ৳' . $cost . ' আপনার ব্যালেন্স থেকে কাটা হয়েছে।');

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', 'অনুগ্রহ করে সব ফিল্ড সঠিকভাবে পূরণ করুন।')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'একটি সমস্যা হয়েছে। আবার চেষ্টা করুন। Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified order
     */
    public function view($id)
    {
        $order = SimNetworkOrder::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.sim_network_order.view', compact('order'));
    }

    /**
     * Download PDF for an order
     */
    public function downloadPdf($id)
    {
        try {
            $order = SimNetworkOrder::where('user_id', Auth::id())
                ->findOrFail($id);

            if (!$order->admin_note || !str_contains($order->admin_note, '.pdf')) {
                return response()->json([
                    'success' => false,
                    'message' => 'এই অর্ডারের জন্য কোনো PDF পাওয়া যায়নি'
                ], 404);
            }

            $filePath = public_path($order->admin_note);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF ফাইল খুঁজে পাওয়া যায়নি'
                ], 404);
            }

            return response()->download($filePath, 'order_' . $order->id . '_document.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'PDF ডাউনলোড করতে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules based on service type
     */
    private function getValidationRules($type)
    {
        switch ($type) {
            case 1: // Call List 3 Month
            case 2: // Robi SMS
            case 3: // Banglalink SMS
            case 4: // Number to Location
            case 8: // Number to IMEI
                return ['number' => 'required|regex:/^01[0-9]{9}$/'];

            case 5: // NID to All Numbers
                return [
                    'nid_10' => 'nullable|digits:10',
                    'nid_17' => 'nullable|digits:17',
                ];

            case 6: // IMEI to Location
                return [
                    'imei_1' => 'required|digits:15',
                    'imei_2' => 'nullable|digits:15',
                ];

            case 7: // IMEI to Active Number
                return [
                    'imei_1' => 'required|digits:15',
                    'imei_2' => 'nullable|digits:15',
                    'last_used_number' => 'nullable|regex:/^01[0-9]{9}$/',
                    'lost_date' => 'nullable|date',
                ];

            case 9: // Bkash Info
                return ['bkash_number' => 'required|regex:/^01[0-9]{9}$/'];

            case 10: // Nagad Info
                return ['nagad_number' => 'required|regex:/^01[0-9]{9}$/'];

            case 11: // Rocket Info
                return ['rocket_number' => 'required|regex:/^01[0-9]{9}$/'];

            default:
                return [];
        }
    }

    /**
     * Prepare form data based on service type
     */
    private function prepareFormData(Request $request, $type)
    {
        switch ($type) {
            case 1: // Call List
            case 2: // Robi SMS
            case 3: // Banglalink SMS
            case 4: // Number to Location
            case 8: // Number to IMEI
                return ['number' => $request->input('number')];

            case 5: // NID to All Numbers
                return [
                    'nid_10' => $request->input('nid_10'),
                    'nid_17' => $request->input('nid_17'),
                ];

            case 6: // IMEI to Location
                return [
                    'imei_1' => $request->input('imei_1'),
                    'imei_2' => $request->input('imei_2'),
                ];

            case 7: // IMEI to Active Number
                return [
                    'imei_1' => $request->input('imei_1'),
                    'imei_2' => $request->input('imei_2'),
                    'last_used_number' => $request->input('last_used_number'),
                    'lost_date' => $request->input('lost_date'),
                ];

            case 9: // Bkash
                return ['bkash_number' => $request->input('bkash_number')];

            case 10: // Nagad
                return ['nagad_number' => $request->input('nagad_number')];

            case 11: // Rocket
                return ['rocket_number' => $request->input('rocket_number')];

            default:
                return [];
        }
    }

    /**
     * Get service cost based on type
     */
    private function getServiceCost($type)
    {
        $costs = [
            1 => 20,  // Call List
            2 => 80,   // Robi SMS
            3 => 80,   // Banglalink SMS
            4 => 50,   // Number to Location
            5 => 150,  // NID to Numbers
            6 => 120,  // IMEI to Location
            7 => 120,  // IMEI to Active
            8 => 100,  // Number to IMEI
            9 => 200,  // Bkash
            10 => 200, // Nagad
            11 => 200, // Rocket
        ];

        return $costs[$type] ?? 0;
    }

}
