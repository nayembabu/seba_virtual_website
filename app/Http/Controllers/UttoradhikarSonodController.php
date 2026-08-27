<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UttoradhikarSonod;
use Illuminate\Http\Request;

class UttoradhikarSonodController extends Controller
{
    private const CERTIFICATE_FEE = 100; // 100 Taka fee

    public function __construct()
    {
        $this->middleware('auth')->except(['verify']);
    }

    private function englishToBengaliNumber($number)
    {
        $bengali = ['', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $english = range(0, 9);
        return str_replace($english, $bengali, $number);
    }

    private function formatDateToBengali($date)
    {
        $formatted_date = date('d/m/Y', strtotime($date));
        return $this->englishToBengaliNumber($formatted_date);
    }

    public function create()
    {
        $currentYear = date('Y');
        $union_name = '৯নং রায়হনপুর ইউনিয়ন';
        $union_address = 'উপজেলা: কলাাড়া, জেলা: পটুয়াখালী';
        return view('user.uttoradhikarsonod.create', compact('currentYear', 'union_name', 'union_address'));
    }

    private function generateVillageId($request) {
        // Combine location details to create a unique identifier
        return md5(
            $request->word_no . 
            $request->village_name . 
            $request->post_office . 
            $request->thana . 
            $request->upozila . 
            $request->zila
        );
    }

    public function store(Request $request)
    {
        try {
            // Check user balance first
            $user = auth()->user();
            if ($user->balance < self::CERTIFICATE_FEE) {
                return back()->with('error', 'পনার ব্যালেন্স পর্যাপ্ নয়। সার্টফিকেট ফি: '. self::CERTIFICATE_FEE . ' টাকা');
            }

            // Custom error messages in Bengali
            $messages = [
                'gender.required' => 'লিঙ্গ নর্বাচন করুন',
                'gender.in' => 'অনুগ্রহ করে সঠিক লিঙ্গ নির্বাচন করুন',
                'he_she_is.required' => 'জীবি/মৃত অবস্থা নির্বাচন করন',
                'he_she_is.in' => 'অনুগ্র করে জীবিত অবা মৃত নির্াচন করুন',
                'certificate_number.required' => 'সার্টিফিকেট নম্বর প্রয়োজন',
                'death_certificates_id.required_if' => 'মৃত্যু সনদ নম্বর প্রয়োজন',
                'dod.required_if' => 'মৃত্যুর তািখ প্রয়োজ',
                'person_bn.required' => 'ব্যক্তির নাম (বাংলয়) প্রয়োজ',
                'guardian_bn.required' => 'অভিভাকের নাম (বাংলায়) প্রয়োজন'
            ];

            // Initial data validation
            $this->validate($request, [
                'gender' => 'required|in:male,female,other',
                'he_she_is' => 'required|in:death,live',
            ], $messages);

            // Add messages to validation
            $request->validate([
                'certificate_number' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
                'union_name' => 'required|string|max:255',
                'union_address' => 'required|string|max:255',
                'word_no' => 'required|string',
                'village_name' => 'required|string',
                'post_office' => 'required|string',
                'thana' => 'required|string',
                'upozila' => 'required|string',
                'zila' => 'required|string',
                'death_certificates_id' => 'required_if:he_she_is,death|nullable|string|max:17',
                'dod' => 'required_if:he_she_is,death|nullable|date',
                'person_bn' => 'required|string|max:150',
                'guardian_bn' => 'required|string|max:150',
                'name_bn.*' => 'required|string|max:150',
                'Relatives.*' => 'required|string|in:পিতা,মাা,স্বামী,স্্রী,ভাই,সৎ ভই,বোন,পুত্র,কন্যা,নাতি,ভাতিজা,ভাতিজ,দাদী',
            ], $messages);

            // Generate village_id from location details
            $village_id = $this->generateVillageId($request);

            // Format relatives data
            $relatives = array_map(function($name_bn, $relation) {
                return [
                    'name_bn' => $name_bn,
                    'relation' => $relation
                ];
            }, $request->name_bn, $request->Relatives);

            // Create certificate with all form data
            $certificate = UttoradhikarSonod::create([
                'user_id' => auth()->id(), // Add this line
                'certificate_number' => $this->generateFullCertificateNumber($request->certificate_number),
                'union_name' => $request->union_name,
                'union_address' => $request->union_address,
                // Location details
                'village_id' => $village_id,
                'word_no' => $request->word_no,
                'village_name' => $request->village_name,
                'post_office' => $request->post_office,
                'thana' => $request->thana,
                'upozila' => $request->upozila,
                'zila' => $request->zila,
                // Person details
                'gender' => $request->gender,
                'he_she_is' => $request->he_she_is,
                'death_certificates_id' => $request->death_certificates_id,
                'dod' => $request->dod,
                'person_bn' => $request->person_bn,
                'guardian_bn' => $request->guardian_bn,
                'relatives' => $relatives,
            ]);

            // Deduct balance and create transaction
            $user->decrement('balance', self::CERTIFICATE_FEE);
            $this->createTransaction(
                self::CERTIFICATE_FEE,
                'debit',
                'উত্তরাধিকা সনদ ফি - ' . $certificate->certificate_number,
                $user->id
            );

            \Log::info('Certificate created successfully', [
                'certificate_id' => $certificate->id,
                'data' => $certificate->toArray()
            ]);

            return redirect()->route('user.uttoradhikarsonod.show', $certificate->id)
                ->with('success', 'ত্তরাধিকার সনদ সফলভাবে তৈরি করা হয়েছে।');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed in store method', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            
            $errorMessage = 'অনুগ্রহ করে প্রয়োজনয় তথ্যগুল সঠিকভাবে পরণ করুন: ';
            if (isset($e->errors()['gender'])) {
                $errorMessage .= ' লিঙ্গ,';
            }
            if (isset($e->errors()['he_she_is'])) {
                $errorMessage .= ' জীবিত/মৃত অবস্থা,';
            }
            
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', rtrim($errorMessage, ','));
        } catch (\Exception $e) {
            \Log::error('Unexpected error in store method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'একি অপ্রত্যািত ত্রুটি ঘেছে। অনুগ্রহ করে আবার চষ্টা করুন।');
        }
    }

    private function generateQRCode($text) {
        try {
            $filename = 'qr_' . time() . '_' . uniqid() . '.svg';
            $path = storage_path('uploads/' . $filename);

            if (!file_exists(storage_path('uploads'))) {
                mkdir(storage_path('uploads'), 0755, true);
            }

            $text = str_replace(url('/'), 'http://clearance.amarnothi.com', $text);

            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                'size' => '90x90',
                'data' => $text,
                'color' => '000',
                'format' => 'svg'
            ]);

            $qrCode = file_get_contents($qrApiUrl);

            \Log::info('QR Code Content Generated', [
                'qr_content_length' => strlen($qrCode),
                'api_url' => $qrApiUrl
            ]);

            $bytesWritten = file_put_contents($path, $qrCode);
            
            \Log::info('QR Code File Write Attempt', [
                'bytes_written' => $bytesWritten,
                'file_exists' => file_exists($path),
                'file_size' => file_exists($path) ? filesize($path) : 0,
                'file_permissions' => file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A'
            ]);

            return url('storage/uploads/' . $filename);

        } catch (\Exception $e) {
            \Log::error('QR Code Generation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $certificate = UttoradhikarSonod::findOrFail($id);
            
            $union_name = $certificate->union_name ?? '৯ন রায়হানপু ইউনিয়ন';
            $union_address = $certificate->union_address ?? 'উপেলা: কলাপাডা, জেলা: পটুয়াখালী';
            $certificate_number = $certificate->certificate_number;
            $chairman_name = "চে়ারম্যান";

            // Generate QR code for verification
            $verification_url = route('verify.uttoradhikar', $certificate->certificate_number);
            $qr_code = $this->generateQRCode($verification_url);
            
            return view('user.uttoradhikarsonod.certificate-template', 
                compact('certificate', 'union_name', 'union_address', 'certificate_number', 'chairman_name', 'qr_code'));

        } catch (\Exception $e) {
            \Log::error('Error in show method', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Certificate not found');
        }
    }

    public function verify($certificate_number)
    {
        try {
            $certificate = UttoradhikarSonod::where('certificate_number', $certificate_number)->firstOrFail();
            return view('user.uttoradhikarsonod.verify', compact('certificate'));
        } catch (\Exception $e) {
            \Log::error('Certificate verification failed', [
                'certificate_number' => $certificate_number,
                'error' => $e->getMessage()
            ]);
            abort(404, 'Certificate not found');
        }
    }

    private function generateFullCertificateNumber($year) {
        try {
            // Validate year is numeric and 4 digits
            if (!is_numeric($year) || strlen($year) !== 4) {
                \Log::error('Invalid year format', ['year' => $year]);
                throw new \InvalidArgumentException('Invalid year provided for certificate number');
            }
            
            // Generate 12 random digits for the serial number to make total 16 digits
            $random = str_pad(random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);
            
            // Convert both year and random number to Bengali separately
            $bengaliYear = $this->englishToBengaliNumber($year);
            $bengaliRandom = $this->englishToBengaliNumber($random);
            
            return $bengaliYear . $bengaliRandom;
        } catch (\Exception $e) {
            \Log::error('Certificate number generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function index()
    {
        $certificates = UttoradhikarSonod::where('user_id', auth()->id())
                                       ->orderBy('created_at', 'desc')
                                       ->paginate(10);
        
        return view('user.uttoradhikarsonod.index', compact('certificates'));
    }

    public function edit($id)
    {
        try {
            $certificate = UttoradhikarSonod::findOrFail($id);
            $currentYear = date('Y');
            $union_name = $certificate->union_name ?? 'নং রায়হানুর ইউনিয়ন';
            $union_address = $certificate->union_address ?? 'পজেলা: কলাপড়া, জেলা: পটুয়াখালী';

            // Unpack relatives array for form fields
            $name_bn = [];
            $relatives = [];
            
            if (is_array($certificate->relatives)) {
                foreach ($certificate->relatives as $relative) {
                    $name_bn[] = $relative['name_bn'];
                    $relatives[] = $relative['relation'];
                }
            }

            // Merge the unpacked data with the certificate
            $certificate->name_bn = $name_bn;
            $certificate->Relatives = $relatives;

            return view('user.uttoradhikarsonod.edit', compact(
                'certificate',
                'currentYear',
                'union_name',
                'union_address'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in edit method', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'সার্টিফিকেট ুঁজে পাওয় যায়নি।');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $certificate = UttoradhikarSonod::findOrFail($id);
            
            // Validate the request data (same validation as store method)
            $messages = [
                'gender.required' => 'লিঙ্গ নির্বাচন করুন',
                'gender.in' => 'অনুগ্র করে সঠিক লিঙ্গ নির্বাচ করুন',
                'he_she_is.required' => 'জবিত/মৃত অবসথা নির্বাচ করুন',
                'he_she_is.in' => 'অনু্রহ করে জীবত অথবা মৃত নর্বাচন করু',
                'certificate_number.required' => 'সার্টিফিকেট নমবর প্রয়োজ',
                'death_certificates_id.required_if' => 'মৃত্যু সনদ নম্বর প্রয়োজ',
                'dod.required_if' => 'মৃত্যু তারিখ প্রযোজন',
                'person_bn.required' => 'ব্যক্তির নাম (বংলায়) প্রযোজন',
                'guardian_bn.required' => 'অভভাবকের নাম (বাংলায়) প্রয়োজন'
            ];

            $validated = $request->validate([
                'gender' => 'required|in:male,female,other',
                'he_she_is' => 'required|in:death,live',
                'certificate_number' => 'required',
                'union_name' => 'required|string|max:255',
                'union_address' => 'required|string|max:255',
                'word_no' => 'required|string',
                'village_name' => 'required|string',
                'post_office' => 'required|string',
                'thana' => 'required|string',
                'upozila' => 'required|string',
                'zila' => 'required|string',
                'death_certificates_id' => 'required_if:he_she_is,death|nullable|string|max:17',
                'dod' => 'required_if:he_she_is,death|nullable|date',
                'person_bn' => 'required|string|max:150',
                'guardian_bn' => 'required|string|max:150',
                'name_bn.*' => 'required|string|max:150',
                'Relatives.*' => 'required|string|in:পিত,মাতা,স্বাম,স্ত্রী,ভাই,সৎ ভাই,বোন,পত্র,কন্যা,নতি,ভাতিজা,ভতিজী,দাদী',
            ], $messages);

            // Format relatives data
            $relatives = array_map(function($name_bn, $relation) {
                return [
                    'name_bn' => $name_bn,
                    'relation' => $relation
                ];
            }, $request->name_bn, $request->Relatives);

            // Update certificate
            $certificate->update([
                'certificate_number' => $request->certificate_number,
                'union_name' => $request->union_name,
                'union_address' => $request->union_address,
                'word_no' => $request->word_no,
                'village_name' => $request->village_name,
                'post_office' => $request->post_office,
                'thana' => $request->thana,
                'upozila' => $request->upozila,
                'zila' => $request->zila,
                'gender' => $request->gender,
                'he_she_is' => $request->he_she_is,
                'death_certificates_id' => $request->death_certificates_id,
                'dod' => $request->dod,
                'person_bn' => $request->person_bn,
                'guardian_bn' => $request->guardian_bn,
                'relatives' => $relatives,
            ]);

            return redirect()->route('user.uttoradhikarsonod.show', $certificate->id)
                ->with('success', 'সা্টিফিকেট সলভাবে আপডেট করা হয়েছে।');
        } catch (\Exception $e) {
            \Log::error('Error updating certificate', [
                'error' => $e->getMessage(),
                'certificate_id' => $id
            ]);
            return back()->with('error', 'সার্িফিকেট আপডট করতে সমস্া হয়েছে। অুগ্রহ করে আার চেষ্টা কুন।')->withInput();
        }
    }
    private function createTransaction($amount, $type, $description, $userId)
    {
        Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'details' => $description
        ]);
    }
}

