<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SmartCard;
use App\Models\Setting;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SmartCardController extends Controller
{
    private function transliterateToBangla($text) {
        // Basic Bangla to English transliteration map
        $translitMap = [
            'বরগুনা' => 'Barguna',
    'বরিশাল' => 'Barishal',
    'ভোলা' => 'Bhola',
    'ঝালকাঠি' => 'Jhalokathi',
    'পটুয়াখালী' => 'Patuakhali',
    'পিরোজপুর' => 'Pirojpur',

    'বান্দরবান' => 'Bandarban',
    'ব্রাহ্মণবাড়িয়া' => 'Brahmanbaria',
    'চাঁদপুর' => 'Chandpur',
    'চট্টগ্রাম' => 'Chattogram',
    'কুমিল্লা' => 'Cumilla',
    'কক্সবাজার' => 'Cox’s Bazar',
    'ফেনী' => 'Feni',
    'খাগড়াছড়ি' => 'Khagrachhari',
    'লক্ষ্মীপুর' => 'Lakshmipur',
    'নোয়াখালী' => 'Noakhali',
    'রাঙ্গামাটি' => 'Rangamati',

    'ঢাকা' => 'Dhaka',
    'ফরিদপুর' => 'Faridpur',
    'গাজীপুর' => 'Gazipur',
    'গোপালগঞ্জ' => 'Gopalganj',
    'কিশোরগঞ্জ' => 'Kishoreganj',
    'মাদারীপুর' => 'Madaripur',
    'মানিকগঞ্জ' => 'Manikganj',
    'মুন্সীগঞ্জ' => 'Munshiganj',
    'নারায়ণগঞ্জ' => 'Narayanganj',
    'নরসিংদী' => 'Narsingdi',
    'রাজবাড়ী' => 'Rajbari',
    'শরীয়তপুর' => 'Shariatpur',
    'টাঙ্গাইল' => 'Tangail',

    'বাগেরহাট' => 'Bagerhat',
    'চুয়াডাঙ্গা' => 'Chuadanga',
    'যশোর' => 'Jashore',
    'ঝিনাইদহ' => 'Jhenaidah',
    'খুলনা' => 'Khulna',
    'কুষ্টিয়া' => 'Kushtia',
    'মাগুরা' => 'Magura',
    'মেহেরপুর' => 'Meherpur',
    'নড়াইল' => 'Narail',
    'সাতক্ষীরা' => 'Satkhira',

    'জামালপুর' => 'Jamalpur',
    'ময়মনসিংহ' => 'Mymensingh',
    'নেত্রকোণা' => 'Netrokona',
    'শেরপুর' => 'Sherpur',

    'বগুড়া' => 'Bogura',
    'জয়পুরহাট' => 'Joypurhat',
    'নওগাঁ' => 'Naogaon',
    'নাটোর' => 'Natore',
    'চাঁপাইনবাবগঞ্জ' => 'Chapai Nawabganj',
    'পাবনা' => 'Pabna',
    'রাজশাহী' => 'Rajshahi',
    'সিরাজগঞ্জ' => 'Sirajganj',

    'দিনাজপুর' => 'Dinajpur',
    'গাইবান্ধা' => 'Gaibandha',
    'কুড়িগ্রাম' => 'Kurigram',
    'লালমনিরহাট' => 'Lalmonirhat',
    'নিলফামারী' => 'Nilphamari',
    'পঞ্চগড়' => 'Panchagarh',
    'রংপুর' => 'Rangpur',
    'ঠাকুরগাঁও' => 'Thakurgaon',

    'হবিগঞ্জ' => 'Habiganj',
    'মৌলভীবাজার' => 'Moulvibazar',
    'সুনামগঞ্জ' => 'Sunamganj',
    'সিলেট' => 'Sylhet',
        ];
        
        // Check if exact match exists
        if (isset($translitMap[$text])) {
            return $translitMap[$text];
        }
        
        // If no match found, return original text capitalized
        return ucwords($text);
    }

    public function index()
    {
        // Get service charge amount
        $serviceCharge = ServiceCharge::where('service_name', 'smartcard')->first();
        $chargeAmount = $serviceCharge ? $serviceCharge->amount : 10;

        // Convert service charge to Bangla numerals
        $banglaMake = strtr((string) $chargeAmount, ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);
        $banglaUpload = $banglaMake; // Same charge for upload and make
        $banglaTotal = strtr((string) ($chargeAmount * 2), ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);

        // Set notification to empty since UserNotification is not available
        $notification = '';

        $smartcards = SmartCard::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.smartcard.index', compact('smartcards', 'banglaUpload', 'banglaMake', 'banglaTotal', 'notification'));
    }

    public function create()
    {
        $serviceCharge = ServiceCharge::where('service_name', 'smartcard')->first();
        $chargeAmount = $serviceCharge ? $serviceCharge->amount : 0;
        return view('user.smartcard.create', compact('chargeAmount'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $serviceCharge = ServiceCharge::where('service_name', 'smartcard')->first();
        $chargeAmount = $serviceCharge ? $serviceCharge->amount : 0;
        
        // Convert service charge to Bangla numerals
        $banglaMake = strtr((string) $chargeAmount, ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);
        $banglaUpload = $banglaMake; // Same charge for upload and make
        $banglaTotal = strtr((string) ($chargeAmount * 2), ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);

        if (!$serviceCharge) {
            Log::warning('Service charge not configured for Smart Card', [
                'user_id' => auth()->id()
            ]);
            return back()->with('error', 'সার্ভিস চার্জ কনফিগার করা হয়নি।');
        }

        if ($user->balance < $serviceCharge->amount) {
            Log::info('Insufficient balance for Smart Card creation', [
                'user_id' => auth()->id(),
                'balance' => $user->balance,
                'required_amount' => $serviceCharge->amount
            ]);
            return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে আপনার ব্যালেন্স রিচার্জ করুন।');
        }

        $request->validate([
            'nid_no' => 'required|max:20',
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'birth_place_en' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:10',
            'blood_group' => 'nullable|string|max:10',
            'issue_date' => 'required|date',
            'formatted_dob' => 'nullable|string|max:30',
            'formatted_nid' => 'nullable|string|max:30',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nid_no.required' => 'The NID field is required.',
            'place_of_birth.required' => 'The birth place field is required.'
        ]);

        try {
            // Create uploads directory if it doesn't exist
            $uploadsPath = public_path('uploads/smartcards');
            if (!file_exists($uploadsPath)) {
                if (!mkdir($uploadsPath, 0777, true)) {
                    Log::error('Failed to create upload directory', ['path' => $uploadsPath]);
                    throw new \Exception('ফাইল আপলোড ডিরেক্টরি তৈরি করা যায়নি।');
                }
            }

            try {
                // Store photo
                $photo = $request->file('photo');
                $photoFileName = time() . '_photo_' . auth()->id() . '.' . $photo->getClientOriginalExtension();
                $photoPath = 'uploads/smartcards/' . $photoFileName;
                if (!$photo->move(public_path('uploads/smartcards'), $photoFileName)) {
                    throw new \Exception('ছবি আপলোড করা যায়নি।');
                }

                // Store signature
                $signature = $request->file('signature');
                $signatureFileName = time() . '_signature_' . auth()->id() . '.' . $signature->getClientOriginalExtension();
                $signaturePath = 'uploads/smartcards/' . $signatureFileName;
                if (!$signature->move(public_path('uploads/smartcards'), $signatureFileName)) {
                    // Clean up photo if signature upload fails
                    unlink(public_path($photoPath));
                    throw new \Exception('স্বাক্ষর আপলোড করা যায়নি।');
                }
            } catch (\Exception $e) {
                Log::error('ফাইল আপলোড ব্যর্থ হয়েছে', [
                    'ইউজার_আইডি' => auth()->id(),
                    'সমস্যা' => $e->getMessage(),
                    'তারিখ' => now()->format('Y-m-d H:i:s')
                ]);
                throw new \Exception('ফাইল আপলোড ব্যর্থ হয়েছে: ' . $e->getMessage());
            }

            \DB::beginTransaction();
            try {
                $smartcard = SmartCard::create([
                    'user_id' => auth()->id(),
                    'name_bn' => $request->name_bn,
                    'name_en' => $request->name_en,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'photo' => $photoPath,
                    'signature' => $signaturePath,
                    'date_of_birth' => $request->date_of_birth,
                    'nid_no' => $request->nid_no,
                    'blood_group' => $request->blood_group,
                    'address' => $request->address,
                    'place_of_birth' => $request->place_of_birth,
                    'birth_place_en' => $request->birth_place_en,
                    'issue_date' => $request->issue_date,
                    'gender' => $request->gender,
                    'postal_code' => $request->postal_code,
                    'formatted_dob' => $request->formatted_dob,
                    'formatted_nid' => $request->formatted_nid,
                    'service_charge' => $serviceCharge->amount,
                    'status' => 'pending'
                ]);

                // Deduct balance
                $user->decrement('balance', $serviceCharge->amount);

                \DB::commit();

                Log::info('SmartCard created successfully', [
                    'user_id' => auth()->id(),
                    'smartcard_id' => $smartcard->id,
                    'service_charge' => $serviceCharge->amount
                ]);

                return redirect()->route('user.smartcard.index')
                    ->with('success', 'স্মার্ট কার্ড সফলভাবে তৈরি করা হয়েছে।');

            } catch (\Exception $e) {
                \DB::rollBack();
                // Clean up uploaded files
                Storage::delete(['public/' . $photoPath, 'public/' . $signaturePath]);
                
                Log::error('ডাটাবেজ অপারেশন ব্যর্থ হয়েছে', [
                    'ইউজার_আইডি' => auth()->id(),
                    'সমস্যা' => $e->getMessage(),
                    'ট্রেস' => $e->getTraceAsString(),
                    'তারিখ' => now()->format('Y-m-d H:i:s')
                ]);
                throw new \Exception('ডাটাবেস অপারেশন ব্যর্থ হয়েছে।');
            }

        } catch (\Exception $e) {
            Log::error('স্মার্ট কার্ড তৈরি ব্যর্থ হয়েছে', [
                'ইউজার_আইডি' => auth()->id(),
                'সমস্যা' => $e->getMessage(),
                'ফাইল' => $e->getFile(),
                'লাইন' => $e->getLine(),
                'ট্রেস' => $e->getTraceAsString(),
                'তারিখ' => now()->format('Y-m-d H:i:s')
            ]);

            return redirect()->back()
                ->with('error', $e->getMessage() ?: 'স্মার্ট কার্ড তৈরি করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।')
                ->withInput();
        }
    }

    public function show($id)
    {
        $smartcard = SmartCard::findOrFail($id);
        
        if ($smartcard->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Convert photo and signature to base64
        $photoBase64 = '';
        $signatureBase64 = '';
        
        if ($smartcard->photo && file_exists(public_path($smartcard->photo))) {
            $photoPath = public_path($smartcard->photo);
            $photoBase64 = 'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($photoPath));
        }
        
        if ($smartcard->signature && file_exists(public_path($smartcard->signature))) {
            $signaturePath = public_path($smartcard->signature);
            $signatureBase64 = 'data:image/' . pathinfo($signaturePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($signaturePath));
        }

        // Format dates
        $formattedDob = $smartcard->formatted_dob ?? $smartcard->date_of_birth->format('d M Y');
        $issueDate = $smartcard->issue_date->format('d M Y');
        
        // Format NID number with spaces
        $formattedNid = $smartcard->formatted_nid ?? substr($smartcard->nid_no, 0, 3) . ' ' . substr($smartcard->nid_no, 3, 3) . ' ' . substr($smartcard->nid_no, 6);

        // Generate secret code from name if not exists
        $secretCode = $smartcard->secret_code ?? $smartcard->name_en;
        $secretCode = str_pad($secretCode, 90, '<');
        $line1 = substr($secretCode, 0, 30);
        $line2 = substr($secretCode, 30, 30);
        $line3 = substr($secretCode, 60, 30);

        return view('user.smartcard.show', [
            'pin' => $smartcard->pin ?? mt_rand(1000, 9999),
            'banglaName' => $smartcard->name_bn,
            'englishName' => $smartcard->name_en,
            'fatherName' => $smartcard->father_name,
            'motherName' => $smartcard->mother_name,
            'dateOfBirth' => $smartcard->date_of_birth->format('d M Y'),
            'nidNumber' => $smartcard->nid_no,
            'address' => $smartcard->address,
            'bloodGroup' => $smartcard->blood_group ?? 'N/A',
            'birthPlace' => $smartcard->place_of_birth,
            'birthPlaceEn' => $smartcard->birth_place_en ?? $this->transliterateToBangla($smartcard->place_of_birth),
            'issueDate' => $issueDate,
            'photoBase64' => $photoBase64,
            'signatureBase64' => $signatureBase64,
            'formattedDob' => $formattedDob,
            'formattedNid' => $formattedNid,
            'gender' => $smartcard->gender ?? '',
            'postalCode' => $smartcard->postal_code ?? '',
            'line1' => $line1,
            'line2' => $line2,
            'line3' => $line3,
            'smartcard' => $smartcard
        ]);
    }

    public function edit($id)
    {
        $smartcard = SmartCard::findOrFail($id);
        
        if ($smartcard->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.smartcard.edit', compact('smartcard'));
    }

    public function update(Request $request, $id)
    {
        $smartcard = SmartCard::findOrFail($id);
        
        if ($smartcard->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'father_name' => 'required|string|max:255', 
            'mother_name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date_of_birth' => 'required|date',
            'nid_no' => 'required|string|max:20',
            'address' => 'required|string',
            'place_of_birth' => 'required|string|max:255',
            'birth_place_en' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'gender' => 'nullable|string|max:10',
            'blood_group' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10'
        ], [
            'nid_no.required' => 'The NID field is required.',
            'place_of_birth.required' => 'The birth place field is required.'
        ]);

        if ($validator->fails()) {
            Log::error('SmartCard validation failed', [
                'user_id' => auth()->id(),
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['photo', 'signature']);

        try {
            if ($request->hasFile('photo')) {
                if ($smartcard->photo && file_exists(public_path($smartcard->photo))) {
                    unlink(public_path($smartcard->photo));
                }
                $photo = $request->file('photo');
                $photoFileName = time() . '_photo_' . auth()->id() . '.' . $photo->getClientOriginalExtension();
                $photoPath = 'uploads/smartcards/' . $photoFileName;
                if (!$photo->move(public_path('uploads/smartcards'), $photoFileName)) {
                    throw new \Exception('ছবি আপলোড করা যায়নি।');
                }
                $data['photo'] = $photoPath;
            }

            if ($request->hasFile('signature')) {
                if ($smartcard->signature && file_exists(public_path($smartcard->signature))) {
                    unlink(public_path($smartcard->signature));
                }
                $signature = $request->file('signature');
                $signatureFileName = time() . '_signature_' . auth()->id() . '.' . $signature->getClientOriginalExtension();
                $signaturePath = 'uploads/smartcards/' . $signatureFileName;
                if (!$signature->move(public_path('uploads/smartcards'), $signatureFileName)) {
                    throw new \Exception('স্বাক্ষর আপলোড করা যায়নি।');
                }
                $data['signature'] = $signaturePath;
            }

            // Map the form fields to database fields
            $updateData = [
                'name_bn' => $request->input('name_bn'),
                'name_en' => $request->input('name_en'),
                'father_name' => $request->input('father_name'),
                'mother_name' => $request->input('mother_name'),
                'date_of_birth' => $request->input('date_of_birth'),
                'nid_no' => $request->input('nid_no'),
                'address' => $request->input('address'),
                'place_of_birth' => $request->input('place_of_birth'),
                'birth_place_en' => $request->input('birth_place_en'),
                'issue_date' => $request->input('issue_date'),
                'gender' => $request->input('gender'),
                'blood_group' => $request->input('blood_group'),
                'postal_code' => $request->input('postal_code')
            ];

            if (isset($data['photo'])) {
                $updateData['photo'] = $data['photo'];
            }
            if (isset($data['signature'])) {
                $updateData['signature'] = $data['signature'];
            }
            
            \DB::beginTransaction();
            try {
                $smartcard->update($updateData);
                \DB::commit();
                
                return redirect()->route('user.smartcard.index')
                    ->with('success', 'স্মার্ট কার্ড সফলভাবে আপডেট করা হয়েছে।');
                    
            } catch (\Exception $e) {
                \DB::rollBack();
                Log::error('স্মার্ট কার্ড আপডেট ব্যর্থ হয়েছে', [
                    'ইউজার_আইডি' => auth()->id(),
                    'সমস্যা' => $e->getMessage(),
                    'তারিখ' => now()->format('Y-m-d H:i:s')
                ]);
                return back()->with('error', 'স্মার্ট কার্ড আপডেট করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।');
            }
        } catch (\Exception $e) {
            Log::error('ফাইল আপলোড ব্যর্থ হয়েছে', [
                'ইউজার_আইডি' => auth()->id(),
                'সমস্যা' => $e->getMessage(),
                'তারিখ' => now()->format('Y-m-d H:i:s')
            ]);
            return back()->with('error', $e->getMessage() ?: 'ফাইল আপলোড ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    public function destroy($id)
    {
        $smartcard = SmartCard::findOrFail($id);
        
        if ($smartcard->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($smartcard->photo && file_exists(public_path($smartcard->photo))) {
            unlink(public_path($smartcard->photo));
        }
        if ($smartcard->signature && file_exists(public_path($smartcard->signature))) {
            unlink(public_path($smartcard->signature));
        }

        $smartcard->delete();

        return redirect()->route('user.smartcard.index')
            ->with('success', 'Smart Card deleted successfully.');
    }
}
