<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\SignToServer;
use App\Models\User;
use App\Models\ServiceCharge;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class SignToServerController extends Controller
{
    use Upload, Notify;

    protected $user;

    public function __construct()
    {
        $this->middleware(['auth', 'web'])->except(['verify']);
        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                $this->user = auth()->user();
            }
            return $next($request);
        })->except(['verify']);
    }
    public function index()
    {
        $data['user'] = $this->user;
        $data['title'] = 'All Sign To Server Entries';
        $data['objects'] = SignToServer::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('user.sign-to-server.index', $data);
    }

    public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create New Sign To Server Entry';
        return view('user.sign-to-server.create', $data);
    }

    public function store(Request $request)
    {
        $user = $this->user;
        
        try {
            // Check service charge
            $serviceCharge = ServiceCharge::where('service_name', 'sign_to_server')->first();

            if (!$serviceCharge) {
                \Log::warning('Service charge not configured for sign to server', [
                    'user_id' => $user->id
                ]);
                return back()->with('error', 'Service charge is not configured.');
            }

            if ($user->balance < $serviceCharge->amount) {
                \Log::info('Insufficient balance for sign to server creation', [
                    'user_id' => $user->id,
                    'balance' => $user->balance,
                    'required_amount' => $serviceCharge->amount
                ]);
                return back()->with('error', 'Insufficient balance. Please recharge your account.');
            }

            \DB::beginTransaction();
            // Normalize field names from the view
            if ($request->has('birth_place') && !$request->has('place_of_birth')) {
                $request->merge(['place_of_birth' => $request->input('birth_place')]);
            }

            // Normalize gender casing so validation in:male,female,other works
            if ($request->has('gender')) {
                $request->merge(['gender' => strtolower($request->input('gender'))]);
            }

            $rules = [
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'id_number' => 'required|string|max:255',
                'pin_number' => 'required|string|max:255',
                'name_bangla' => 'required|string|max:255',
                'name_english' => 'required|string|max:255',
                'date_of_birth' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'spouse_name' => 'nullable|string|max:255',
                'education' => 'nullable|string|max:255',
                'form_no' => 'nullable|string|max:255',
                'voter_no' => 'nullable|string|max:255',
                'serial_no' => 'nullable|string|max:255',
                'voter_area' => 'nullable|string|max:255',
                'father_id' => 'nullable|string|max:255',
                'mother_id' => 'nullable|string|max:255',
                'phone' => 'required|string|max:255',
                'gender' => 'required|string|in:male,female,other',
                'occupation' => 'nullable|string|max:255',
                'blood_group' => 'nullable|string|in:Unknown,A+,A-,B+,B-,O+,O-,AB+,AB-',
                'religion' => 'required|string|in:islam,hinduism,christianity,buddhism,other',
                'present_address' => 'nullable|string',
                'permanent_address' => 'nullable|string',
                'address' => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                \Log::error('SignToServer validation failed', $validator->errors()->toArray());
                return back()->withErrors($validator)->withInput();
            }
            $validated = $validator->validated();

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_photo_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create sign_to_server directory if it doesn't exist
            if (!Storage::disk('public')->exists('sign_to_server')) {
                Storage::disk('public')->makeDirectory('sign_to_server');
            }
            
            try {
                // Store the file in storage/app/public/sign_to_server
                $photoPath = $photo->storeAs('sign_to_server', $photoName, 'public');
                $validated['photo'] = $photoPath;
            } catch (\Exception $e) {
                \Log::error('Photo upload failed: ' . $e->getMessage());
                return back()->with('error', 'Photo upload failed. Please try again.');
            }
        }

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signatureName = time() . '_sign_' . uniqid() . '.' . $signature->getClientOriginalExtension();
            
            // Create sign_to_server directory if it doesn't exist
            if (!Storage::disk('public')->exists('sign_to_server')) {
                Storage::disk('public')->makeDirectory('sign_to_server');
            }
            
            try {
                // Store the file in storage/app/public/sign_to_server
                $signaturePath = $signature->storeAs('sign_to_server', $signatureName, 'public');
                $validated['signature'] = $signaturePath;
            } catch (\Exception $e) {
                \Log::error('Signature upload failed: ' . $e->getMessage());
                return back()->with('error', 'Signature upload failed. Please try again.');
            }
        }

        // Add user_id to the validated data
        $validated['user_id'] = $user->id;

        // Create the sign to server entry
        $signToServer = SignToServer::create($validated);

        // Deduct the service charge from user's balance
        $user->balance -= $serviceCharge->amount;
        $user->save();

        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'amount' => -$serviceCharge->amount,
            'details' => 'Sign To Server Service Charge',
            'trx' => uniqid('TRX'),
        ]);

        \DB::commit();

        return redirect()->route('user.sign-to-server.index')
            ->with('success', 'Entry created successfully.');
        } catch (ValidationException $e) {
            \DB::rollback();
            // Let validation exceptions bubble so Laravel can redirect back with errors
            throw $e;
        } catch (\Exception $e) {
            \DB::rollback();
            // Log full exception including validation data if available
            \Log::error('Failed to create entry: ' . $e->getMessage());
            if (method_exists($e, 'errors')) {
                \Log::error('Validation errors: ' . json_encode($e->errors()));
            }
            return back()->with('error', 'Failed to create entry. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            // Validate user is authenticated
            if (!$this->user) {
                \Log::error('Unauthenticated access attempt to sign-to-server show');
                return redirect()->route('login')->with('error', 'Please login to access this page.');
            }

            // Find the record with error handling
            $signToServer = SignToServer::where('id', $id)
                ->where('user_id', $this->user->id)
                ->first();

            if (!$signToServer) {
                \Log::warning('Sign to server entry not found. ID: ' . $id . ', User: ' . $this->user->id);
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Requested entry was not found.');
            }

            // Prepare base64 images if files exist
            $photoBase64 = null;
            $signatureBase64 = null;

            try {
                if ($signToServer->photo && Storage::disk('public')->exists($signToServer->photo)) {
                    $photoContents = Storage::disk('public')->get($signToServer->photo);
                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                }

                if ($signToServer->signature && Storage::disk('public')->exists($signToServer->signature)) {
                    $sigContents = Storage::disk('public')->get($signToServer->signature);
                    $mime = finfo_buffer(finfo_open(), $sigContents, FILEINFO_MIME_TYPE) ?: 'image/png';
                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($sigContents);
                }
            } catch (\Exception $e) {
                // don't fail the whole request if image encoding fails; log and continue
                \Log::error('Failed to prepare base64 images for sign-to-server id ' . $id . ': ' . $e->getMessage());
            }

            $data = [
                'signToServer' => $signToServer,
                'user' => $this->user,
                'title' => 'View Sign To Server Entry',
                'photoBase64' => $photoBase64,
                'signatureBase64' => $signatureBase64,
            ];

            return view('user.sign-to-server.show', $data);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in sign-to-server show: ' . $e->getMessage());
            return redirect()->route('user.sign-to-server.index')
                ->with('error', 'Database error occurred. Please try again.');
        } catch (\Exception $e) {
            \Log::error('Error in sign-to-server show: ' . $e->getMessage());
            return redirect()->route('user.sign-to-server.index')
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    public function edit($id)
    {
        $data['signToServer'] = SignToServer::where('id', $id)
            ->where('user_id', $this->user->id)
            ->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit Sign To Server Entry';
        return view('user.sign-to-server.edit', $data);
    }

    public function update($id, Request $request)
    {
        $signToServer = SignToServer::where('id', $id)
            ->where('user_id', $this->user->id)
            ->firstOrFail();

        // Normalize birth_place if sent from the view
        if ($request->has('birth_place') && !$request->has('place_of_birth')) {
            $request->merge(['place_of_birth' => $request->input('birth_place')]);
        }

        // Normalize gender casing so validation in:male,female,other works
        if ($request->has('gender')) {
            $request->merge(['gender' => strtolower($request->input('gender'))]);
        }

        $rules = [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_number' => 'required|string|max:255',
            'pin_number' => 'required|string|max:255',
            'name_bangla' => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
            'date_of_birth' => 'nullable',
            'place_of_birth' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'form_no' => 'nullable|string|max:255',
            'voter_no' => 'nullable|string|max:255',
            'voter_area' => 'nullable|string|max:255',
            'father_id' => 'nullable|string|max:255',
            'mother_id' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'occupation' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|in:Unknown,A+,A-,B+,B-,O+,O-,AB+,AB-',
            'religion' => 'required|string|in:islam,hinduism,christianity,buddhism,other',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'address' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            \Log::error('SignToServer (update) validation failed', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        // Handle file updates
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($signToServer->photo) {
                Storage::disk('public')->delete($signToServer->photo);
            }
            
            $photo = $request->file('photo');
            $photoName = time() . '_photo_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create sign_to_server directory if it doesn't exist
            if (!Storage::disk('public')->exists('sign_to_server')) {
                Storage::disk('public')->makeDirectory('sign_to_server');
            }
            
            try {
                // Store the file in storage/app/public/sign_to_server
                $photoPath = $photo->storeAs('sign_to_server', $photoName, 'public');
                $validated['photo'] = $photoPath;
            } catch (\Exception $e) {
                \Log::error('Photo upload failed during update: ' . $e->getMessage());
                return back()->with('error', 'Photo upload failed. Please try again.');
            }
        }

        if ($request->hasFile('signature')) {
            // Delete old signature if it exists
            if ($signToServer->signature) {
                Storage::disk('public')->delete($signToServer->signature);
            }
            
            $signature = $request->file('signature');
            $signatureName = time() . '_sign_' . uniqid() . '.' . $signature->getClientOriginalExtension();
            
            // Create sign_to_server directory if it doesn't exist
            if (!Storage::disk('public')->exists('sign_to_server')) {
                Storage::disk('public')->makeDirectory('sign_to_server');
            }
            
            try {
                // Store the file in storage/app/public/sign_to_server
                $signaturePath = $signature->storeAs('sign_to_server', $signatureName, 'public');
                $validated['signature'] = $signaturePath;
            } catch (\Exception $e) {
                \Log::error('Signature upload failed during update: ' . $e->getMessage());
                return back()->with('error', 'Signature upload failed. Please try again.');
            }
        }

        $signToServer->update($validated);

        return redirect()->route('user.sign-to-server.index')
            ->with('success', 'Entry updated successfully.');
    }

    public function showV1($id)
    {
        try {
            // Validate user is authenticated
            if (!$this->user) {
                \Log::error('Unauthenticated access attempt to sign-to-server showV1');
                return redirect()->route('login')->with('error', 'Please login to access this page.');
            }

            // Find the record with error handling
            $signToServer = SignToServer::where('id', $id)
                ->where('user_id', $this->user->id)
                ->first();

            if (!$signToServer) {
                \Log::warning('Sign to server entry not found for V1. ID: ' . $id . ', User: ' . $this->user->id);
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Requested entry was not found.');
            }

            // Prepare base64 images
            $photoBase64 = null;
            $signatureBase64 = null;
            try {
                if ($signToServer->photo && Storage::disk('public')->exists($signToServer->photo)) {
                    $photoContents = Storage::disk('public')->get($signToServer->photo);
                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                }
                if ($signToServer->signature && Storage::disk('public')->exists($signToServer->signature)) {
                    $sigContents = Storage::disk('public')->get($signToServer->signature);
                    $mime = finfo_buffer(finfo_open(), $sigContents, FILEINFO_MIME_TYPE) ?: 'image/png';
                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($sigContents);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to prepare base64 images for show_v1 id ' . $id . ': ' . $e->getMessage());
            }

            // Check if the view exists
            if (!view()->exists('user.sign-to-server.show_v1')) {
                \Log::error('View user.sign-to-server.show_v1 does not exist');
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Template not found. Please contact support.');
            }

            return view('user.sign-to-server.show_v1', compact('signToServer', 'photoBase64', 'signatureBase64'));

        } catch (\Exception $e) {
            \Log::error('Error in sign-to-server showV1: ' . $e->getMessage());
            return redirect()->route('user.sign-to-server.index')
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    public function showV2($id)
    {
        try {
            if (!$this->user) {
                \Log::error('Unauthenticated access attempt to sign-to-server showV2');
                return redirect()->route('login')->with('error', 'Please login to access this page.');
            }

            $signToServer = SignToServer::where('id', $id)
                ->where('user_id', $this->user->id)
                ->first();

            if (!$signToServer) {
                \Log::warning('Sign to server entry not found for V2. ID: ' . $id . ', User: ' . $this->user->id);
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Requested entry was not found.');
            }

            // Prepare base64 images
            $photoBase64 = null;
            $signatureBase64 = null;
            try {
                if ($signToServer->photo && Storage::disk('public')->exists($signToServer->photo)) {
                    $photoContents = Storage::disk('public')->get($signToServer->photo);
                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                }
                if ($signToServer->signature && Storage::disk('public')->exists($signToServer->signature)) {
                    $sigContents = Storage::disk('public')->get($signToServer->signature);
                    $mime = finfo_buffer(finfo_open(), $sigContents, FILEINFO_MIME_TYPE) ?: 'image/png';
                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($sigContents);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to prepare base64 images for show_v2 id ' . $id . ': ' . $e->getMessage());
            }

            if (!view()->exists('user.sign-to-server.show_v2')) {
                \Log::error('View user.sign-to-server.show_v2 does not exist');
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Template not found. Please contact support.');
            }

            return view('user.sign-to-server.show_v2', compact('signToServer', 'photoBase64', 'signatureBase64'));

        } catch (\Exception $e) {
            \Log::error('Error in sign-to-server showV2: ' . $e->getMessage());
            return redirect()->route('user.sign-to-server.index')
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    public function showV3($id)
    {
        try {
            if (!$this->user) {
                \Log::error('Unauthenticated access attempt to sign-to-server showV3');
                return redirect()->route('login')->with('error', 'Please login to access this page.');
            }

            $signToServer = SignToServer::where('id', $id)
                ->where('user_id', $this->user->id)
                ->first();

            if (!$signToServer) {
                \Log::warning('Sign to server entry not found for V3. ID: ' . $id . ', User: ' . $this->user->id);
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Requested entry was not found.');
            }

            // Prepare base64 images
            $photoBase64 = null;
            $signatureBase64 = null;
            try {
                if ($signToServer->photo && Storage::disk('public')->exists($signToServer->photo)) {
                    $photoContents = Storage::disk('public')->get($signToServer->photo);
                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                }
                if ($signToServer->signature && Storage::disk('public')->exists($signToServer->signature)) {
                    $sigContents = Storage::disk('public')->get($signToServer->signature);
                    $mime = finfo_buffer(finfo_open(), $sigContents, FILEINFO_MIME_TYPE) ?: 'image/png';
                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($sigContents);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to prepare base64 images for show_v3 id ' . $id . ': ' . $e->getMessage());
            }

            if (!view()->exists('user.sign-to-server.show_v3')) {
                \Log::error('View user.sign-to-server.show_v3 does not exist');
                return redirect()->route('user.sign-to-server.index')
                    ->with('error', 'Template not found. Please contact support.');
            }

            return view('user.sign-to-server.show_v3', compact('signToServer', 'photoBase64', 'signatureBase64'));

        } catch (\Exception $e) {
            \Log::error('Error in sign-to-server showV3: ' . $e->getMessage());
            return redirect()->route('user.sign-to-server.index')
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    public function delete($id)
    {
        $signToServer = SignToServer::where('id', $id)
            ->where('user_id', $this->user->id)
            ->firstOrFail();
        // Delete associated files
        if ($signToServer->photo) {
            Storage::disk('public')->delete($signToServer->photo);
        }
        if ($signToServer->signature) {
            Storage::disk('public')->delete($signToServer->signature);
        }

        $signToServer->delete();

        return back()->with('success', 'Entry Deleted Successfully');
    }

    /**
     * Destroy alias for delete — some routes/controllers expect a destroy method.
     * Keeps the same behavior as delete to avoid route changes.
     */
    public function destroy($id)
    {
        return $this->delete($id);
    }

    public function extractPdf(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');
            
            // Validate file is PDF
            if ($file->getClientMimeType() !== 'application/pdf') {
                return response()->json(['success' => false, 'message' => 'File must be a PDF'], 400);
            }

            // Get the file contents
            $fileContents = file_get_contents($file->getRealPath());

            // Create a new cURL resource
            $ch = curl_init();

            // Setup the cURL request
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://api.example.com/extract-pdf',//replace with your actual API endpoint
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'file' => new \CURLFile($file->getRealPath(), 'application/pdf', $file->getClientOriginalName())
                ]
            ]);

            // Execute the request
            $response = curl_exec($ch);
            
            // Check for errors
            if (curl_errno($ch)) {
                throw new \Exception('Curl error: ' . curl_error($ch));
            }

            // Close cURL resource
            curl_close($ch);

            // Decode the response
            $data = json_decode($response, true);

            if (!$data) {
                throw new \Exception('Failed to decode API response');
            }

            // Transform the data to match your form field names
            $transformedData = [
                'id_number' => $data['nid'] ?? null,
                'pin_number' => $data['pin'] ?? null,
                'name_bangla' => $data['nameBangla'] ?? null,
                'name_english' => $data['nameEnglish'] ?? null,
                'date_of_birth' => $data['dateOfBirth'] ?? null,
                'place_of_birth' => $data['birthPlace'] ?? null,
                'father_name' => $data['fatherName'] ?? null,
                'mother_name' => $data['motherName'] ?? null,
                'spouse_name' => $data['spouseName'] ?? null,
                'education' => $data['education'] ?? null,
                'form_no' => $data['formNo'] ?? null,
                'voter_no' => $data['voterNo'] ?? null,
                'voter_area' => $data['voterArea'] ?? null,
                'gender' => strtolower($data['gender'] ?? ''),
                'occupation' => $data['occupation'] ?? null,
                'blood_group' => $data['bloodGroup'] ?? null,
                'religion' => strtolower($data['religion'] ?? ''),
                'present_address' => $data['presentAddress'] ?? $data['address'] ?? null,
                'permanent_address' => $data['permanentAddress'] ?? $data['address'] ?? null,
            ];

            // Handle images if they exist in the response
            if (!empty($data['images'])) {
                if (isset($data['images'][0]['base64'])) {
                    $transformedData['photo'] = $data['images'][0]['base64'];
                }
                if (isset($data['images'][1]['base64'])) {
                    $transformedData['signature'] = $data['images'][1]['base64'];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $transformedData
            ]);

        } catch (\Exception $e) {
            \Log::error('PDF extraction failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to extract data from PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verify($id)
    {
        try {
            \Log::info('Verifying sign-to-server with ID: ' . $id);
            
            $data['data'] = SignToServer::where('id', $id)->first();
            
            if (!$data['data']) {
                \Log::info('Data not found for ID: ' . $id);
                return redirect()->route('home')->withErrors(['message' => 'The requested data was not found.']);
            }

            \Log::info('Data found: ' . json_encode($data['data']));
            return view('user.sign-to-server.verify', $data);

        } catch (\Exception $e) {
            \Log::error('Error in verify method: ' . $e->getMessage());
            return redirect()->route('home')->withErrors(['message' => 'An error occurred while processing your request.']);
        }
    }

    /**
     * Public store for local testing only (no auth / CSRF) - DO NOT enable in production
     */
    public function publicStore(Request $request)
    {
        // Attach a user for testing (first user)
        $this->user = User::first();
        return $this->store($request);
    }

}
