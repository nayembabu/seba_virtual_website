<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ElectricityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ElectricityBillController extends Controller
{
    public function index()
    {
        try {
            $objects = ElectricityBill::where('user_id', auth()->id())
                ->orderBy('id', 'desc')
                ->paginate(20);
            return view('user.electricity_bill.index', compact('objects'));
        } catch (\Exception $e) {
            Log::error('ElectricityBill index error: ' . $e->getMessage());
            return back()->with('error', 'বিল তালিকা লোড করতে সমস্যা হয়েছে।');
        }
    }

    public function create()
    {
        return view('user.electricity_bill.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->except('_token', 'submit_bill');
            $data['user_id'] = auth()->id();

            ElectricityBill::create($data);

            return redirect()->route('user.electricity_bill.index')
                ->with('success', 'বিল সফলভাবে সংরক্ষণ করা হয়েছে।');
        } catch (\Exception $e) {
            Log::error('ElectricityBill store error: ' . $e->getMessage());
            return back()->with('error', 'সংরক্ষণ করতে সমস্যা হয়েছে।')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $bill = ElectricityBill::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('user.electricity_bill.show', compact('bill'));
        } catch (\Exception $e) {
            return back()->with('error', 'বিল দেখাতে সমস্যা হয়েছে।');
        }
    }

    public function edit($id)
    {
        try {
            $bill = ElectricityBill::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('user.electricity_bill.edit', compact('bill'));
        } catch (\Exception $e) {
            return back()->with('error', 'ফর্ম লোড করতে সমস্যা হয়েছে।');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $bill = ElectricityBill::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $data = $request->except('_token', '_method', 'submit_bill');
            $bill->update($data);

            return redirect()->route('user.electricity_bill.index')
                ->with('success', 'বিল সফলভাবে আপডেট করা হয়েছে।');
        } catch (\Exception $e) {
            Log::error('ElectricityBill update error: ' . $e->getMessage());
            return back()->with('error', 'আপডেট করতে সমস্যা হয়েছে।')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $bill = ElectricityBill::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $bill->delete();
            return redirect()->route('user.electricity_bill.index')
                ->with('success', 'বিল সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->route('user.electricity_bill.index')
                ->with('error', 'মুছে ফেলতে সমস্যা হয়েছে।');
        }
    }
}