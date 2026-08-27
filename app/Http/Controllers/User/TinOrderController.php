<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TinOrder;
use App\Models\TinOrderType;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TinOrderController extends Controller
{
    /**
     * Get form type name by type ID
     */
    private function getFormTypeName($type)
    {
        $formTypes = [
            1 => 'টিন সার্টিফিকেট অর্ডার',
            2 => 'নিউ টিন আবেদন',
            3 => 'জিরো রিটার্ন আবেদন',
            4 => 'টিন সার্টিফিকেট কারেকশন',
            5 => 'টিন আইডি পাসওয়ার্ড সেট'
        ];

        return $formTypes[$type] ?? 'টিন সার্ভিস';
    }

    public function index()
    {
        $pageTitle = 'টিন সার্ভিস';
        $orders = TinOrder::where('user_id', auth()->id())
            ->latest()
            ->paginate(getPaginate());
        
        // Get all TIN order types with their costs
        $tinTypes = TinOrderType::all()->keyBy('id');
        
        return view('user.tin_order.index', compact('pageTitle', 'orders', 'tinTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|integer|between:1,5'
        ]);

        $formData = [];

        // Based on type, get different form fields
        switch($request->type) {
            case 1: // টিন সার্টিফিকেট অর্ডার
                $request->validate([
                    'nid_tin_mobile' => 'required|string'
                ]);
                $formData = [
                    'nid_tin_mobile' => $request->nid_tin_mobile
                ];
                break;

            case 2: // নিউ টিন আবেদন
                $request->validate([
                    'nid_no' => 'required|string',
                    'mobile_no' => 'required|string',
                    'father_nid' => 'required|string',
                    'mother_nid' => 'required|string'
                ]);
                $formData = [
                    'nid_no' => $request->nid_no,
                    'mobile_no' => $request->mobile_no,
                    'father_nid' => $request->father_nid,
                    'mother_nid' => $request->mother_nid
                ];
                break;

            case 3: // জিরো রিটার্ন আবেদন
                $request->validate([
                    'nid_number' => 'required|string',
                    'tin_number' => 'required|string',
                    'mobile_number' => 'required|string'
                ]);
                $formData = [
                    'nid_number' => $request->nid_number,
                    'tin_number' => $request->tin_number,
                    'mobile_number' => $request->mobile_number
                ];
                break;

            case 4: // টিন সার্টিফিকেট কারেকশন
                $request->validate([
                    'user_id' => 'required|string',
                    'pass' => 'required|string',
                    'correction_info' => 'required|string'
                ]);
                $formData = [
                    'user_id' => $request->user_id,
                    'pass' => $request->pass,
                    'correction_info' => $request->correction_info
                ];
                break;

            case 5: // টিন আইডি পাসওয়ার্ড সেট
                $request->validate([
                    'tin_no' => 'required|string'
                ]);
                $formData = [
                    'tin_no' => $request->tin_no,
                    'id_pass' => $request->id_pass ?? null
                ];
                break;
        }

        // Get price from tin_orders_type table
        $tinType = TinOrderType::find($request->type);
        $price = $tinType ? $tinType->cost : 50;

        // Get user balance
        $user = auth()->user();
        
        // Check if user has sufficient balance
        if ($user->balance < $price) {
            return redirect()
                ->back()
                ->with('error', 'পর্যাপ্ত টাকা নেই। প্রয়োজনীয় টাকা: ' . $price . ' টাকা, বর্তমান ব্যালেন্স: ' . $user->balance . ' টাকা');
        }

        $order = new TinOrder();
        $order->user_id = auth()->id();
        $order->type = $request->type;
        $order->form_type_name = $this->getFormTypeName($request->type);
        $order->form_data = $formData;
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
            'details' => 'টিন অর্ডার - ' . $this->getFormTypeName($request->type),
            'type' => '-',
            'tx_id' => $txId,
            'description' => 'TIN Order #' . $order->id
        ]);

        session()->flash('success', 'আপনার অর্ডারটি সফলভাবে জমা হয়েছে। ' . $price . ' টাকা আপনার ব্যালেন্স থেকে কাটা হয়েছে।');
        return back();
    }

    public function view($id)
    {
        $pageTitle = 'অর্ডার বিস্তারিত';
        $order = TinOrder::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('user.tin_order.view', compact('pageTitle', 'order'));
    }

    /**
     * Download PDF for a TIN order (only for the order owner)
     */
    public function downloadPdf($id)
    {
        try {
            $order = TinOrder::where('user_id', auth()->id())
                ->findOrFail($id);

            if (!$order->admin_note || strpos($order->admin_note, '.pdf') === false) {
                abort(404, 'পিডিএফ ফাইল এই অর্ডারের জন্য পাওয়া যায়নি');
            }

            $filePath = public_path($order->admin_note);

            if (!file_exists($filePath)) {
                abort(404, 'সার্ভারে পিডিএফ ফাইল পাওয়া যায়নি');
            }

            return response()->download($filePath);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'অর্ডার পাওয়া যায়নি');
        } catch (\Exception $e) {
            abort(404, 'পিডিএফ ডাউনলোড করতে সমস্যা হয়েছে');
        }
    }
}
