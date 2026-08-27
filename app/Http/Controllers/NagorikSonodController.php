<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Certificate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class NagorikSonodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['verify']);
    }

    private function englishToBengaliNumber($number)
    {
        $bengali = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $english = range(0, 9);
        return str_replace($english, $bengali, $number);
    }

    private function formatDateToBengali($date)
    {
        $formatted_date = date('d/m/Y', strtotime($date));
        return $this->englishToBengaliNumber($formatted_date);
    }

    private function generateQRCode($text) {
        try {
            // Generate a unique filename
            $filename = 'qr_' . time() . '_' . uniqid() . '.svg';
            $path = storage_path('uploads/' . $filename);

            // Ensure directory exists
            if (!file_exists(storage_path('uploads'))) {
                mkdir(storage_path('uploads'), 0755, true);
            }

            // Replace the domain in verification URL
            $text = str_replace(url('/'), 'http://clearance.amarnothi.com', $text);

            // Generate QR code using goqr.me API with green color
            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                'size' => '90x90',
                'data' => $text,
                'color' => '000', // black color
                'format' => 'svg'
            ]);

            // Fetch QR code from API
            $qrCode = file_get_contents($qrApiUrl);

            \Log::info('QR Code Content Generated', [
                'qr_content_length' => strlen($qrCode),
                'api_url' => $qrApiUrl
            ]);

            // Save SVG file
            $bytesWritten = file_put_contents($path, $qrCode);
            
            \Log::info('QR Code File Write Attempt', [
                'bytes_written' => $bytesWritten,
                'file_exists' => file_exists($path),
                'file_size' => file_exists($path) ? filesize($path) : 0,
                'file_permissions' => file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A'
            ]);

            // Return the storage URL
            return url('storage/uploads/' . $filename);

        } catch (\Exception $e) {
            \Log::error('QR Code Generation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
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
            
            \Log::info('Certificate number components', [
                'year' => $year,
                'random' => $random,
                'year_length' => strlen($year),
                'random_length' => strlen($random),
                'total_length' => strlen($year . $random)
            ]);

            // Convert both year and random number to Bengali separately
            $bengaliYear = $this->englishToBengaliNumber($year);
            $bengaliRandom = $this->englishToBengaliNumber($random);
            
            $fullNumber = $bengaliYear . $bengaliRandom;
            
            \Log::info('Final certificate number', [
                'bengali_year' => $bengaliYear,
                'bengali_random' => $bengaliRandom,
                'full_number' => $fullNumber,
                'full_length' => strlen($fullNumber)
            ]);
            
            return $fullNumber;
        } catch (\Exception $e) {
            \Log::error('Certificate number generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function create()
    {
        $currentYear = date('Y');
        return view('user.nagorik-sonod.create', compact('currentYear'));
    }

  public function generate(Request $request)
{
    try {
        $user = auth()->user();
        $fee = \App\Models\ServiceCharge::getCharge('nagorik-sonod');

        if ($user->balance < $fee) {
            throw new \Exception('Insufficient balance. Required balance: ' . $fee);
        }

        // Validate request data
        $validated = $request->validate([
            'union_name' => 'required',
            'union_address' => 'required',
            'certificate_number' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'husband_name' => 'nullable',
            'address' => 'required',
            'ward_no' => 'required',
            'nid_number' => 'required',
            'birth_date' => 'required|date',
            'issue_date' => 'required|date',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

   

        // Deduct balance
        $user->balance -= $fee;
        $user->save();

        // Create transaction
        $this->createTransaction($fee, 'Debit', 'Create Nagorik Sonod', $user->id);

        

            $data = $request->only([
                'union_name', 'union_address', 'name',
                'father_name', 'mother_name', 'husband_name', 'address',
                'ward_no', 'nid_number', 'birth_date', 'issue_date'
            ]);

            // Generate full certificate number
            $data['certificate_number'] = $this->generateFullCertificateNumber($request->certificate_number);

            \Log::info('Data collected', ['data' => $data]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                try {
                    $photo = $request->file('photo');
                    $filename = time() . '_' . $photo->getClientOriginalName();
                    
                    // Ensure directory exists
                    if (!file_exists(storage_path('uploads'))) {
                        mkdir(storage_path('uploads'), 0755, true);
                    }
                    
                    // Store the file in the uploads directory
                    $photoPath = 'uploads/' . $filename;
                    $fullPath = storage_path($photoPath);
                    
                    if ($photo->move(storage_path('uploads'), $filename)) {
                        \Log::info('Photo upload successful', [
                            'original_name' => $photo->getClientOriginalName(),
                            'stored_path' => $photoPath,
                            'file_size' => file_exists($fullPath) ? filesize($fullPath) : 'unknown',
                            'file_permissions' => file_exists($fullPath) ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A'
                        ]);
                    } else {
                        throw new \Exception('Failed to move uploaded photo');
                    }
                } catch (\Exception $e) {
                    \Log::error('Photo upload failed', [
                        'error' => $e->getMessage(),
                        'file' => $photo->getClientOriginalName()
                    ]);
                    throw new \Exception('Failed to process photo upload: ' . $e->getMessage());
                }
            }

            try {
                // Convert dates to Bengali format
                $data['birth_date'] = $this->formatDateToBengali($data['birth_date']);
                $data['issue_date'] = $this->formatDateToBengali($data['issue_date']);
                $data['ward_no'] = $this->englishToBengaliNumber($data['ward_no']);
                $data['nid_number'] = $this->englishToBengaliNumber($data['nid_number']);

                \Log::info('Data conversion completed', ['converted_data' => $data]);
            } catch (\Exception $e) {
                \Log::error('Error in date/number conversion', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // Store certificate data in the database
                $certificate = Certificate::create([
                    'certificate_number' => $data['certificate_number'],
                    'name' => $data['name'],
                    'father_name' => $data['father_name'],
                    'mother_name' => $data['mother_name'],
                    'husband_name' => $data['husband_name'],
                    'address' => $data['address'],
                    'ward_no' => $data['ward_no'],
                    'nid_number' => $data['nid_number'],
                    'birth_date' => $request->birth_date, // Store original date format
                    'issue_date' => $request->issue_date, // Store original date format
                    'union_name' => $data['union_name'],
                    'union_address' => $data['union_address'],
                    'photo_path' => $photoPath ?? null
                ]);

                \Log::info('Certificate stored in database', ['certificate_id' => $certificate->id]);
            } catch (\Exception $e) {
                \Log::error('Database error', ['error' => $e->getMessage()]);
                throw $e;
            }

            $data['photo_path'] = $certificate->photo_path ? asset('storage/' . $certificate->photo_path) : null;

            try {
                // Generate QR code using Google Charts
                $verification_url = route('verify.certificate', $certificate->certificate_number);
                $data['qr_code'] = $this->generateQRCode($verification_url);

                \Log::info('QR code generated');
            } catch (\Exception $e) {
                \Log::error('QR code generation error', ['error' => $e->getMessage()]);
                throw $e;
            }

            // Check if view exists
            if (!view()->exists('user.nagorik-sonod.certificate-template')) {
                \Log::error('View template not found');
                throw new \Exception('Certificate template view not found');
            }

            \Log::info('Returning view with data');
            return view('user.nagorik-sonod.certificate-template', $data);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()
                ->route('nagorik-sonod.create')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Certificate generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->route('nagorik-sonod.create')
                ->with('error', 'Error generating certificate: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function verify($certificate_number)
    {
        $certificate = Certificate::where('certificate_number', $certificate_number)->firstOrFail();
        return view('user.nagorik-sonod.verify', compact('certificate'));
    }
 private function createTransaction($amount, $type, $details, $userId)
{
    Transaction::create([
        'tx_id' => uniqid('NAGORIK-'), // Generate a unique transaction ID
        'user_id' => $userId,
        'amount' => $amount,
        'type' => $type,
        'details' => $details
    ]);
}
}