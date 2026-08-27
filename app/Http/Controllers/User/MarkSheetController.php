<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MarkSheet;
use App\Models\ServiceCharge;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MarkSheetController extends Controller
{
    public function index()
    {
        try {
            $objects = MarkSheet::where('user_id', auth()->id())
                ->orderBy('id', 'desc')
                ->get();
            return view('user.mark_sheet.index', compact('objects'));
        } catch (\Exception $e) {
            Log::error('MarkSheet index error: ' . $e->getMessage());
            return back()->with('error', 'মার্কশিট তালিকা লোড করতে সমস্যা হয়েছে।');
        }
    }

    public function create()
    {
        $data['charge'] = \App\Models\ServiceCharge::getCharge('mark_sheet');
        return view('user.mark_sheet.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $serviceCharge = ServiceCharge::where('service_name', 'mark_sheet')->first();

            if ($serviceCharge && $user->balance < $serviceCharge->amount) {
                return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে রিচার্জ করুন।');
            }

            $messages = [
                'student_name.required' => 'শিক্ষার্থীর নাম প্রয়োজন',
                'father_name.required' => 'পিতার নাম প্রয়োজন',
                'mother_name.required' => 'মাতার নাম প্রয়োজন',
                'roll_no.required' => 'রোল নম্বর প্রয়োজন',
                'exam_name.required' => 'পরীক্ষার নাম প্রয়োজন',
                'board.required' => 'বোর্ড নির্বাচন করুন',
                'year.required' => 'সাল প্রয়োজন',
                'institute_name.required' => 'প্রতিষ্ঠানের নাম প্রয়োজন',
                'gpa.required' => 'জিপিএ প্রয়োজন',
                'result.required' => 'ফলাফল নির্বাচন করুন',
            ];

            $validated = $request->validate([
                'student_name'   => 'required|string|max:255',
                'father_name'    => 'required|string|max:255',
                'mother_name'    => 'required|string|max:255',
                'date_of_birth'  => 'nullable|date',
                'roll_no'        => 'required|string|max:50',
                'registration_no'=> 'nullable|string|max:50',
                'exam_name'      => 'required|string|max:100',
                'board'          => 'required|string|max:100',
                'year'           => 'required|string|max:10',
                'group_name'     => 'nullable|string|max:100',
                'student_type'   => 'required|string|in:REGULAR,IRREGULAR',
                'institute_name' => 'required|string|max:255',
                'gpa'            => 'required|string|max:10',
                'grade'          => 'nullable|string|max:10',
                'result'         => 'required|string|max:20',
                'subjects'       => 'required|json',
                'details'        => 'nullable|string',
            ], $messages);

            \DB::beginTransaction();
            try {
                $validated['user_id'] = auth()->id();
                MarkSheet::create($validated);

                if ($serviceCharge) {
                    $user->balance -= $serviceCharge->amount;
                    $user->save();
                    Transaction::create([
                        'user_id' => $user->id,
                        'amount'  => -$serviceCharge->amount,
                        'details' => 'মার্কশিট সার্ভিস চার্জ',
                        'trx'     => uniqid('TRX'),
                    ]);
                }

                \DB::commit();
                return redirect()->route('user.mark_sheet.index')
                    ->with('success', 'মার্কশিট সফলভাবে তৈরি করা হয়েছে।');
            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('MarkSheet store error: ' . $e->getMessage());
            return back()->with('error', 'একটি ত্রুটি ঘটেছে।')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $markSheet = MarkSheet::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('user.mark_sheet.show', compact('markSheet'));
        } catch (\Exception $e) {
            Log::error('MarkSheet show error: ' . $e->getMessage());
            return back()->with('error', 'মার্কশিট দেখাতে সমস্যা হয়েছে।');
        }
    }

    public function edit($id)
    {
        try {
            $markSheet = MarkSheet::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('user.mark_sheet.edit', compact('markSheet'));
        } catch (\Exception $e) {
            Log::error('MarkSheet edit error: ' . $e->getMessage());
            return back()->with('error', 'ফর্ম লোড করতে সমস্যা হয়েছে।');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $markSheet = MarkSheet::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $messages = [
                'student_name.required' => 'শিক্ষার্থীর নাম প্রয়োজন',
                'father_name.required' => 'পিতার নাম প্রয়োজন',
                'mother_name.required' => 'মাতার নাম প্রয়োজন',
                'roll_no.required' => 'রোল নম্বর প্রয়োজন',
                'exam_name.required' => 'পরীক্ষার নাম প্রয়োজন',
                'board.required' => 'বোর্ড নির্বাচন করুন',
                'year.required' => 'সাল প্রয়োজন',
                'institute_name.required' => 'প্রতিষ্ঠানের নাম প্রয়োজন',
                'gpa.required' => 'জিপিএ প্রয়োজন',
                'result.required' => 'ফলাফল নির্বাচন করুন',
            ];

            $validated = $request->validate([
                'student_name'   => 'required|string|max:255',
                'father_name'    => 'required|string|max:255',
                'mother_name'    => 'required|string|max:255',
                'date_of_birth'  => 'nullable|date',
                'roll_no'        => 'required|string|max:50',
                'registration_no'=> 'nullable|string|max:50',
                'exam_name'      => 'required|string|max:100',
                'board'          => 'required|string|max:100',
                'year'           => 'required|string|max:10',
                'group_name'     => 'nullable|string|max:100',
                'student_type'   => 'required|string|in:REGULAR,IRREGULAR',
                'institute_name' => 'required|string|max:255',
                'gpa'            => 'required|string|max:10',
                'grade'          => 'nullable|string|max:10',
                'result'         => 'required|string|max:20',
                'subjects'       => 'required|json',
                'details'        => 'nullable|string',
            ], $messages);

            $markSheet->update($validated);

            return redirect()->route('user.mark_sheet.index')
                ->with('success', 'মার্কশিট সফলভাবে আপডেট করা হয়েছে।');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('MarkSheet update error: ' . $e->getMessage());
            return back()->with('error', 'আপডেট করতে সমস্যা হয়েছে।');
        }
    }

    public function destroy($id)
    {
        try {
            $markSheet = MarkSheet::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $markSheet->delete();
            return redirect()->route('user.mark_sheet.index')
                ->with('success', 'মার্কশিট সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            Log::error('MarkSheet destroy error: ' . $e->getMessage());
            return redirect()->route('user.mark_sheet.index')
                ->with('error', 'মুছে ফেলতে সমস্যা হয়েছে।');
        }
    }

    public function getCost()
    {
        try {
            $serviceCharge = ServiceCharge::where('service_name', 'mark_sheet')->first();
            $balance = Auth::user()->balance;
            return response()->json([
                'status'  => true,
                'cost'    => $serviceCharge ? (float) $serviceCharge->amount : 0,
                'balance' => (float) $balance,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
