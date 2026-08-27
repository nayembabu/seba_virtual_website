<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NagorikSonod;
use App\Models\ServiceCharge;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NagorikSonodController extends Controller
{
    public function index()
    {
        $sonods = NagorikSonod::where('user_id', Auth::id())->latest()->get();
        return view('user.nagorik-sonod.index', compact('sonods'));
    }

    public function create()
    {
        $serviceCharge = ServiceCharge::where('service_name', 'nagorik_sonod')->first();
        $chargeAmount = $serviceCharge ? $serviceCharge->amount : 0;
        return view('user.nagorik-sonod.create', compact('chargeAmount'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                \Log::error('User not authenticated');
                return back()->with('error', 'User authentication failed');
            }

            $serviceCharge = ServiceCharge::where('service_name', 'nagorik_sonod')->first();
            if (!$serviceCharge) {
                \Log::error('Nagorik Sonod service charge not found');
                return back()->with('error', 'Service charge configuration not found');
            }

            if ($user->balance < $serviceCharge->amount) {
                return back()->with(NotificationHelper::insufficientBalance($serviceCharge->amount, $user->balance));
            }
            
            $request->validate([
            'union_name' => 'required|string|max:255',
            'union_address' => 'required|string|max:255',
            'certificate_number' => 'required|integer',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'husband_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'ward_no' => 'required|string|max:50',
            'nid_number' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'issue_date' => 'required|date',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/nagorik-sonod'), $photoName);
        }

        // Create nagorik sonod
        NagorikSonod::create([
            'user_id' => Auth::id(),
            'union_name' => $request->union_name,
            'union_address' => $request->union_address,
            'certificate_number' => $request->certificate_number,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'husband_name' => $request->husband_name,
            'address' => $request->address,
            'ward_no' => $request->ward_no,
            'nid_number' => $request->nid_number,
            'birth_date' => $request->birth_date,
            'issue_date' => $request->issue_date,
            'photo' => $photoName ?? null
        ]);

        // Deduct the service charge from user's balance
        $user->balance -= $serviceCharge->amount;
        $user->save();

        // Create transaction record
        $user->transactions()->create([
            'amount' => -$serviceCharge->amount,
            'details' => 'নাগরিক সনদ সার্ভিস চার্জ',
        ]);

        return redirect()->route('user.nagorik-sonod.index')
            ->with(NotificationHelper::success('নাগরিক সনদ সফলভাবে তৈরি করা হয়েছে।'));
        } catch (\Exception $e) {
            \Log::error('Nagorik Sonod Store Error: ' . $e->getMessage());
            return back()->with('error', 'নাগরিক সনদ তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function show(NagorikSonod $nagorikSonod)
    {
        abort_if($nagorikSonod->user_id !== Auth::id(), 403);
        
        // Generate QR code for verification
        $qr_code = \QrCode::format('svg')
            ->size(100)
            ->errorCorrection('H')
            ->generate(route('verify.certificate', $nagorikSonod->certificate_number));
            
        $nagorik = $nagorikSonod; // Assign to $nagorik for view compatibility
        
        return view('user.nagorik-sonod.show', compact('nagorik', 'qr_code'));
    }

    public function destroy(NagorikSonod $nagorikSonod)
    {
        abort_if($nagorikSonod->user_id !== Auth::id(), 403);
        
        // Delete the photo if exists
        if ($nagorikSonod->photo) {
            $photoPath = public_path('uploads/nagorik-sonod/' . $nagorikSonod->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $nagorikSonod->delete();

        return redirect()->route('user.nagorik-sonod.index')
            ->with('success', 'নাগরিক সনদ সফলভাবে মুছে ফেলা হয়েছে।');
    }
}