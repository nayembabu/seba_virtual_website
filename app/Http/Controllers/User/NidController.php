<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Nid;
use App\Models\ServiceCharge;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class NidController extends Controller
{
    public function extractNidData(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json([
                    'error' => 'কোন ফাইল পাওয়া যায়নি'
                ], 400);
            }

            $file = $request->file('file');
            
            if (!$file->isValid()) {
                return response()->json([
                    'error' => 'ফাইল আপলোডে সমস্যা হয়েছে'
                ], 400);
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->attach(
                    'file',
                    $file->get(),
                    $file->getClientOriginalName()
                )
                ->post('example.com.api/nid/extract');

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'API কল ব্যর্থ হয়েছে',
                    'message' => $response->body()
                ], $response->status());
            }

            $data = $response->json();
            
            $transformedData = [
                'nameBangla' => $data['data']['nameBangla'] ?? null,
                'nameEnglish' => $data['data']['nameEnglish'] ?? null,
                'fatherName' => $data['data']['fatherName'] ?? null,
                'motherName' => $data['data']['motherName'] ?? null,
                'dateOfBirth' => $data['data']['dateOfBirth'] ?? null,
                'birthPlace' => $data['data']['birthPlace'] ?? null,
                'nid' => $data['data']['nid'] ?? null,
                'bloodGroup' => $data['data']['bloodGroup'] ?? null,
                'permanentAddress' => $data['data']['presentAddress'] ?? null,
                'gender' => $data['data']['gender'] === 'female' ? 'মহিলা' : 'পুরুষ',
                'religion' => $data['data']['religion'] ?? null,
                'spouseName' => $data['data']['spouseName'] ?? null,
                'occupation' => $data['data']['occupation'] ?? null,
                'address' => $data['data']['address'] ?? null,
                'sl_no' => $data['data']['sl_no'] ?? null,
                'pin' => $data['data']['pin'] ?? null,
                'voterNo' => $data['data']['voterNo'] ?? null,
                'images' => $data['images'] ?? []
            ];
            
            return response()->json([
                'success' => true,
                'data' => $transformedData
            ]);

        } catch (\Exception $e) {
            \Log::error('NID Extraction Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'এনআইডি প্রক্রিয়াকরণে সমস্যা হয়েছে',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $nids = Nid::where('user_id', auth()->id())->latest()->paginate(10);
        return view('user.nid.index', compact('nids'));
    }

    public function create()
    {
        $serviceCharge = ServiceCharge::where('service_name', 'nid')->first();
        $chargeAmount = $serviceCharge ? $serviceCharge->amount : 0;
        return view('user.nid.create', compact('chargeAmount'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                \Log::error('User not authenticated');
                return back()->with('error', 'User authentication failed');
            }

            $serviceCharge = ServiceCharge::where('service_name', 'nid')->first();
            if (!$serviceCharge) {
                \Log::error('NID service charge not found');
                return back()->with('error', 'Service charge configuration not found');
            }

        if ($user->balance < $serviceCharge->amount) {
            return back()->with(NotificationHelper::insufficientBalance($serviceCharge->amount, $user->balance));
        }

        $validated = $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nid_number' => 'required|string|max:20',
            'pin_number' => 'required|string|max:20',
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'issue_date' => 'required|date',
            'address' => 'required|string',
        ]);

        // Handle signature upload
        $signaturePath = $request->file('signature')->store('signatures', 'public');
        // Handle photo upload
        $photoPath = $request->file('photo')->store('photos', 'public');

        // Create NID record
        Nid::create([
            'user_id' => auth()->id(),
            'signature' => $signaturePath,
            'photo' => $photoPath,
            'nid_number' => $request->nid_number,
            'pin_number' => $request->pin_number,
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'date_of_birth' => $request->date_of_birth,
            'birth_place' => $request->birth_place,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'issue_date' => $request->issue_date,
            'address' => $request->address,
        ]);

        // Deduct the service charge from user's balance
        $user->balance -= $serviceCharge->amount;
        $user->save();

        // Create transaction record
        $user->transactions()->create([
            'amount' => -$serviceCharge->amount,
            'details' => 'NID service charge',
        ]);

        return redirect()->route('user.nid.index')->with(NotificationHelper::success('এনআইডি তথ্য সফলভাবে তৈরি করা হয়েছে।'));
        } catch (\Exception $e) {
            \Log::error('NID Store Error: ' . $e->getMessage());
            return back()->with('error', 'এনআইডি তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function show(Nid $nid)
    {
        if ($nid->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Convert photo and signature to base64
        $photoBase64 = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('public')->get($nid->photo));
        $signatureBase64 = 'data:image/jpeg;base64,' . base64_encode(Storage::disk('public')->get($nid->signature));
        
        // Format issue date in Bangla
        $issueDateBangla = \App\Helpers\BanglaDateFormatter::formatDate($nid->issue_date);
        
        return view('user.nid.show', compact('nid', 'photoBase64', 'signatureBase64', 'issueDateBangla'));
    }

    public function edit(Nid $nid)
    {
        if ($nid->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('user.nid.edit', compact('nid'));
    }

    public function update(Request $request, Nid $nid)
    {
        if ($nid->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nid_number' => 'required|string|max:20',
            'pin_number' => 'required|string|max:20',
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'issue_date' => 'required|date',
            'address' => 'required|string',
        ]);

        $data = $request->except(['signature', 'photo']);

        if ($request->hasFile('signature')) {
            Storage::disk('public')->delete($nid->signature);
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $data['signature'] = $signaturePath;
        }

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($nid->photo);
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $nid->update($data);

        return redirect()->route('user.nid.index')->with(NotificationHelper::success('এনআইডি তথ্য সফলভাবে আপডেট করা হয়েছে।'));
    }

    public function destroy(Nid $nid)
    {
        if ($nid->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete associated files
        Storage::disk('public')->delete($nid->signature);
        Storage::disk('public')->delete($nid->photo);

        $nid->delete();
        
        return redirect()->route('user.nid.index')->with(NotificationHelper::success('এনআইডি তথ্য সফলভাবে মুছে ফেলা হয়েছে।'));
    }
}
