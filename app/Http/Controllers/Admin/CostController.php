<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCharge;
use App\Models\SignCopyOrderType;
use App\Models\NidType;
use App\Models\PassportOrderType;
use App\Models\SimConversionType;
use App\Models\SimNetworkOrderType;
use App\Models\TinOrderType;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of all order types with name_bn and cost
     */
    public function index()
    {
        // Get all six types separately
        $signCopyCosts = SignCopyOrderType::all();
        $nidCosts = NidType::all();
        $passportCosts = PassportOrderType::all();
        $simConversionCosts = SimConversionType::all();
        $simNetworkCosts = SimNetworkOrderType::all();
        $tinCosts = TinOrderType::all();
        
        // Calculate total costs
        $totalCosts = $signCopyCosts->count() + $nidCosts->count() + $passportCosts->count() + 
                      $simConversionCosts->count() + $simNetworkCosts->count() + $tinCosts->count();
        
        $totalActive = $signCopyCosts->where('is_active', true)->count() + 
                       $nidCosts->where('is_active', true)->count() + 
                       $passportCosts->where('is_active', true)->count() +
                       $simConversionCosts->where('is_active', true)->count() +
                       $simNetworkCosts->where('is_active', true)->count() +
                       $tinCosts->where('is_active', true)->count();
        
        $totalInactive = $signCopyCosts->where('is_active', false)->count() + 
                         $nidCosts->where('is_active', false)->count() + 
                         $passportCosts->where('is_active', false)->count() +
                         $simConversionCosts->where('is_active', false)->count() +
                         $simNetworkCosts->where('is_active', false)->count() +
                         $tinCosts->where('is_active', false)->count();
        
        $totalAmount = $signCopyCosts->sum('cost') + 
                       $nidCosts->sum('cost') + 
                       $passportCosts->sum('cost') +
                       $simConversionCosts->sum('cost') +
                       $simNetworkCosts->sum('cost') +
                       $tinCosts->sum('cost');
        
        return view('admin.cost.index', compact(
            'signCopyCosts', 'nidCosts', 'passportCosts', 
            'simConversionCosts', 'simNetworkCosts', 'tinCosts',
            'totalCosts', 'totalActive', 'totalInactive', 'totalAmount'
        ));
    }

    /**
     * Store a newly created cost in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'table_type' => 'required|in:sign_copy,nid,passport,sim_conversion,sim_network,tin'
        ]);

        // Set is_active to true (1) if not provided
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $tableType = $validated['table_type'];
        unset($validated['table_type']);

        // Determine which model to use
        switch ($tableType) {
            case 'sign_copy':
                if (SignCopyOrderType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে সাইন কপি টেবিলে বিদ্যমান রয়েছে']);
                }
                SignCopyOrderType::create($validated);
                break;
            case 'nid':
                if (NidType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে এনআইডি টেবিলে বিদ্যমান রয়েছে']);
                }
                NidType::create($validated);
                break;
            case 'passport':
                if (PassportOrderType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে পাসপোর্ট টেবিলে বিদ্যমান রয়েছে']);
                }
                PassportOrderType::create($validated);
                break;
            case 'sim_conversion':
                if (SimConversionType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে সিম কনভার্সন টেবিলে বিদ্যমান রয়েছে']);
                }
                SimConversionType::create($validated);
                break;
            case 'sim_network':
                if (SimNetworkOrderType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে সিম নেটওয়ার্ক টেবিলে বিদ্যমান রয়েছে']);
                }
                SimNetworkOrderType::create($validated);
                break;
            case 'tin':
                if (TinOrderType::where('code', $validated['code'])->exists()) {
                    return back()->withErrors(['code' => 'এই কোডটি ইতিমধ্যে টিআইএন টেবিলে বিদ্যমান রয়েছে']);
                }
                TinOrderType::create($validated);
                break;
        }
        
        return back()->with('success', 'খরচ সফলভাবে যোগ করা হয়েছে');
    }

    /**
     * Update the specified cost in storage
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'table_type' => 'required|in:sign_copy,nid,passport,sim_conversion,sim_network,tin'
        ]);

        // Set is_active to true (1) if not provided
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $tableType = $validated['table_type'];
        unset($validated['table_type']);

        // Determine which model to use and get the cost
        switch ($tableType) {
            case 'sign_copy':
                $cost = SignCopyOrderType::findOrFail($id);
                break;
            case 'nid':
                $cost = NidType::findOrFail($id);
                break;
            case 'passport':
                $cost = PassportOrderType::findOrFail($id);
                break;
            case 'sim_conversion':
                $cost = SimConversionType::findOrFail($id);
                break;
            case 'sim_network':
                $cost = SimNetworkOrderType::findOrFail($id);
                break;
            case 'tin':
                $cost = TinOrderType::findOrFail($id);
                break;
        }

        // Get old name_bn before update
        $oldNameBn = $cost->name_bn;
        $newCost = $validated['cost'];

        // Update the current cost
        $cost->update($validated);
        
        // Update all other rows with the same name_bn in the same table
        switch ($tableType) {
            case 'sign_copy':
                SignCopyOrderType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
            case 'nid':
                NidType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
            case 'passport':
                PassportOrderType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
            case 'sim_conversion':
                SimConversionType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
            case 'sim_network':
                SimNetworkOrderType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
            case 'tin':
                TinOrderType::where('name_bn', $oldNameBn)->where('id', '!=', $id)->update(['cost' => $newCost]);
                break;
        }
        
        return back()->with('success', 'খরচ সফলভাবে আপডেট করা হয়েছে এবং সকল সম্পর্কিত খরচও আপডেট হয়েছে');
    }

    /**
     * Delete the specified cost from storage
     */
    public function destroy(Request $request, $id)
    {
        $tableType = $request->input('table_type');

        switch ($tableType) {
            case 'sign_copy':
                $cost = SignCopyOrderType::findOrFail($id);
                break;
            case 'nid':
                $cost = NidType::findOrFail($id);
                break;
            case 'passport':
                $cost = PassportOrderType::findOrFail($id);
                break;
            case 'sim_conversion':
                $cost = SimConversionType::findOrFail($id);
                break;
            case 'sim_network':
                $cost = SimNetworkOrderType::findOrFail($id);
                break;
            case 'tin':
                $cost = TinOrderType::findOrFail($id);
                break;
            default:
                return back()->withErrors(['error' => 'Invalid table type']);
        }
        
        $cost->delete();
        
        return back()->with('success', 'খরচ সফলভাবে মুছে ফেলা হয়েছে');
    }


    public function serviceCharge()
    {
        $serviceCharges = ServiceCharge::all();
        return view('admin.cost.service_charge', compact('serviceCharges'));
    }
}
