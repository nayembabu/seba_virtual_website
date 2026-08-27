<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;

class ServiceChargeController extends Controller
{
    /**
     * Display a listing of service charges.
     */
    public function index(Request $request)
    {
        $query = ServiceCharge::query();

        // Search by service_name
        if ($request->filled('search')) {
            $query->where('service_name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $services     = $query->orderBy('id')->get();
        $totalServices  = ServiceCharge::count();
        $totalActive    = ServiceCharge::where('status', 1)->count();
        $totalInactive  = ServiceCharge::where('status', 0)->count();
        $totalAmount    = ServiceCharge::where('status', 1)->sum('amount');

        return view('admin.service-charge.index', compact(
            'services',
            'totalServices',
            'totalActive',
            'totalInactive',
            'totalAmount'
        ));
    }

    /**
     * Store a newly created service charge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => [
                'required',
                'string',
                'max:255',
                'unique:service_charges,service_name',
                'regex:/^[a-z0-9_\-]+$/',   // only lowercase, numbers, dash, underscore
            ],
            'amount' => ['required', 'numeric', 'min:0'],
        ], [
            'service_name.unique'  => 'এই সার্ভিস নামটি ইতোমধ্যে বিদ্যমান।',
            'service_name.regex'   => 'সার্ভিস নামে শুধু ছোট হাতের অক্ষর, সংখ্যা, ড্যাশ ও আন্ডারস্কোর ব্যবহার করুন।',
            'amount.required'      => 'চার্জের পরিমাণ প্রয়োজন।',
            'amount.numeric'       => 'চার্জ একটি বৈধ সংখ্যা হতে হবে।',
            'amount.min'           => 'চার্জ ০ বা তার বেশি হতে হবে।',
        ]);

        ServiceCharge::create([
            'service_name' => strtolower(trim($request->service_name)),
            'amount'       => $request->amount,
            'status'       => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.service-charges.index')
            ->with('success', 'নতুন সার্ভিস চার্জ সফলভাবে যোগ করা হয়েছে।');
    }

    /**
     * Update the specified service charge (amount & status only).
     */
    public function update(Request $request, ServiceCharge $serviceCharge)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
        ], [
            'amount.required' => 'চার্জের পরিমাণ প্রয়োজন।',
            'amount.numeric'  => 'চার্জ একটি বৈধ সংখ্যা হতে হবে।',
            'amount.min'      => 'চার্জ ০ বা তার বেশি হতে হবে।',
        ]);

        // service_name is intentionally NOT updated
        $serviceCharge->update([
            'amount' => $request->amount,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.service-charges.index')
            ->with('success', '"' . $serviceCharge->service_name . '" সার্ভিস চার্জ সফলভাবে আপডেট হয়েছে।');
    }
}