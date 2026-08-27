<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReturnMake;
use App\Models\TinCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReturnMakeController extends Controller
{
    public function create()
    {
        return view('user.return.make');
    }

    public function checkTin(Request $request)
    {
        $request->validate([
            'tin_number' => 'required|digits:12'
        ]);

        try {
            $tinData = TinCertificate::where('tin_number', $request->tin_number)->first();

            if (!$tinData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'TIN number not found in our database. Please check and try again.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'tin_number' => $tinData->tin_number,
                    'name' => $tinData->name,
                    'father_name' => $tinData->father_name ?? '',
                    'mother_name' => $tinData->mother_name ?? '',
                    'circle' => $tinData->circle ?? '',
                    'zone' => $tinData->zone ?? '',
                    'current_address' => $tinData->current_address ?? '',
                    'permanent_address' => $tinData->permanent_address ?? '',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching data.'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $fee = \App\Models\ServiceCharge::getCharge('return');
        if ($fee > $user->balance) {
            return back()->with('error', 'Insufficient balance')->withInput();
        }

        $user->balance -= $fee;
        $user->save();

        $validator = Validator::make($request->all(), [
            'tin' => 'required|string|max:12',
            'name' => 'required|string|max:255',
            'father' => 'nullable|string|max:255',
            'mother' => 'nullable|string|max:255',
            'circle' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255',
            'curr' => 'nullable|string',
            'perm' => 'nullable|string',
            'ay' => 'required|string|max:20',
            'nid' => 'required|string|max:20',
            'income' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'serial' => 'required|string|max:100',
            'date' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $returnMake = ReturnMake::create([
                'tin' => $request->tin,
                'name' => $request->name,
                'father_name' => $request->father,
                'mother_name' => $request->mother,
                'circle' => $request->circle,
                'zone' => $request->zone,
                'current_address' => $request->curr,
                'permanent_address' => $request->perm,
                'assessment_year' => $request->ay,
                'nid' => $request->nid,
                'total_income' => $request->income,
                'paid_tax' => $request->tax,
                'return_serial_no' => $request->serial,
                'submission_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d'),
                'user_id' => Auth::id(),
                'service_fee' => 50.00,
                'status' => 1,
            ]);

            create_transaction($fee, '-', 'Make Return certificate', $user->id);

            DB::commit();

            // Redirect to view page or show success message
            return redirect()->route('user.return.view', $returnMake->id)
                ->with('success', 'Return certificate generated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Return Make Store Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to save return data. Please try again.')
                ->withInput();
        }
    }

    public function view($id)
    {
        $returnData = ReturnMake::findOrFail($id);
        $tinData = TinCertificate::where('tin_number', $returnData->tin)->first();

        // Check if user has permission to view
//        if ($returnData->user_id !== Auth::id()) {
//            abort(403, 'Unauthorized access.');
//        }

        return view('user.return.show', compact('returnData', 'tinData'));
    }
}
