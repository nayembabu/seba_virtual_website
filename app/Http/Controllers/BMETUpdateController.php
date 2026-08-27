<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BMETupdate; // Import your BMET model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; // Change this line
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Add this at the top with other imports
use Illuminate\Support\Str;

class BMETUpdateController extends Controller
{
    // Show the form
    protected $user;
 public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }
   public function index()
{
    // Fetch only the BMET records of the authenticated user
    $bmetCards = BMETupdate::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
    
    return view('user.bmet-update.index', compact('bmetCards'));
}


    public function create()
    {
        return view('user.bmet-update.create', ['title' => 'Create BMET Smart Card']);
    }

    // Handle form submission
public function store(Request $request)
{
    $user = $this->user;
    $fee = \App\Models\ServiceCharge::getCharge('bmet-update');

    if (!$user || $user->balance < $fee) {
        return back()->withErrors(['msg' => 'Insufficient balance']);
    }

    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'name' => 'required|string|max:255',
        'clearance_id' => 'required|string|max:255',
        'clearance_date' => 'required|date',
        'father_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'bra_id' => 'required|string|max:255',
        'employer' => 'required|string|max:255',
        'job' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'bmet_no' => 'required|string|max:255',
        'passport_no' => 'required|string|max:255',
        'p_issue_date' => 'required|date',
        'p_expiry_date' => 'required|date|after:p_issue_date',
        'dob' => 'required|date|before:' . now()->subYears(18)->toDateString(),
        'visa_no' => 'required|string|max:255',
    ]);

   try {
            $this->user->balance = $this->user->balance - $fee;
            $this->user->save();

            create_transaction($fee, '-', 'Created BMET Smart Card', $this->user->id);
        // Ensure the uploads directory exists
        if (!Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->makeDirectory('uploads', 0777, true);
        }

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $photoPath = $file->storeAs('uploads', $fileName, 'public');

            // Log file path
            Log::info("Photo stored at: " . $photoPath);
        }

        // Generate unique token
        $token = Str::random(32);

        // Create BMETupdate record instead of BMET
        $bmet = BMETupdate::create([
            'user_id' => $user->id,
             'photo' => isset($photoPath) ? '/app/public/' . str_replace('\\', '/', $photoPath) : null,
            'token' => $token,
            'name' => $request->name,
            'clearance_id' => $request->clearance_id,
            'clearance_date' => $request->clearance_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'bra_id' => $request->bra_id,
            'employer' => $request->employer,
            'job' => $request->job, // Fixed issue here
            'country' => $request->country,
            'bmet_no' => $request->bmet_no,
            'passport_no' => $request->passport_no,
            'p_issue_date' => $request->p_issue_date,
            'p_expiry_date' => $request->p_expiry_date,
            'dob' => $request->dob,
            'visa_no' => $request->visa_no,
        ]);

        


        
            // Generate HTML content with all the submitted data
            $htmlContent = view('user.bmet-update.qr', [
                'name' => $request->name,
                'clearance_id' => $request->clearance_id,
                'visa_no' => $request->visa_no,
                'employer' => $request->employer,
               	'job' => $request->job,
                'country' => $request->country,
                'bmet_no' => $request->bmet_no,
                'passport_no' => $request->passport_no,
                'p_issue_date' => date('d M Y', strtotime($request->p_issue_date)),
                'p_expiry_date' => date('d M Y', strtotime($request->p_expiry_date)),
                'dob' => date('Y-m-d', strtotime($request->dob)),
                'photoUrl' => isset($photoPath) ? url('/storage/app/public/' . $photoPath) : null,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'bra_id' => $request->bra_id,
                'clearance_date' => $request->clearance_date,
                // Add missing variables with default values
                'certificate_no' => '7301677', // Default value
                'ttc' => 'Sylhet mohila technical training center', // Default value
                'issue_date' => date('Y-m-d') // Current date as default
            ])->render();

            // Generate HTML filename and path
            $filename = 'bmet_' . $bmet->id . '_' . time() . '.html';
            $storagePath = 'uploads/' . $filename; // Remove 'storage/' prefix
            $absolutePath = storage_path('uploads/' . $filename); // Changed from app/public/uploads
            
            // Create uploads directory if it doesn't exist
            $uploadsPath = storage_path('uploads'); // Changed from app/public/uploads
            if (!file_exists($uploadsPath)) {
                mkdir($uploadsPath, 0777, true);
            }

            // Save HTML file
            file_put_contents($absolutePath, $htmlContent);

            try {
                // Log QR code generation attempt
                Log::info('Starting QR Code Generation', [
                    'bmet_id' => $bmet->id,
                    'verify_url' => url(route('bmet.verify', $bmet->id, false))
                ]);

                // Generate QR Code with SVG format
                $qrFileName = 'qr_' . $bmet->id . '_' . time() . '.svg';
                $qrStoragePath = 'uploads/' . $qrFileName; // Remove 'storage/' prefix
                $qrAbsolutePath = storage_path('uploads/' . $qrFileName);
                
                Log::info('QR Code Paths Created', [
                    'filename' => $qrFileName,
                    'storage_path' => $qrStoragePath,
                    'absolute_path' => $qrAbsolutePath
                ]);

                try {
                    // Generate QR code using goqr.me API with green color
                    $customHost = "https://clearance.amiprobhasi.com"; 
                    $customUrl = $customHost . "/bmet-clearance/" . $request->clearance_id;

                    // Log the custom URL that will be accessed via QR
                    Log::info('QR Code URL generation', [
                        'custom_url' => $customUrl,
                        'clearance_id' => $request->clearance_id
                    ]);

                    // Try to verify if the HTML file exists and is accessible
                    $htmlFilePath = storage_path('uploads/' . $filename);
                    if (file_exists($htmlFilePath)) {
                        Log::info('HTML file created successfully', [
                            'path' => $htmlFilePath,
                            'size' => filesize($htmlFilePath),
                            'permissions' => substr(sprintf('%o', fileperms($htmlFilePath)), -4)
                        ]);
                    } else {
                        Log::error('HTML file creation failed', [
                            'path' => $htmlFilePath,
                            'directory_exists' => file_exists(dirname($htmlFilePath)),
                            'directory_writable' => is_writable(dirname($htmlFilePath))
                        ]);
                    }

                    // Try to verify if the URL is accessible
                    try {
                        $ch = curl_init($customUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_NOBODY, true);
                        curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        Log::info('QR code URL accessibility check', [
                            'url' => $customUrl,
                            'http_code' => $httpCode
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to check QR code URL accessibility', [
                            'url' => $customUrl,
                            'error' => $e->getMessage()
                        ]);
                    }

                    $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                        'size' => '300x300',
                        'data' => $customUrl,
                        'color' => '000', // Green color
                        'format' => 'svg'
                    ]);


                    // Fetch QR code from API
                    $qrCode = file_get_contents($qrApiUrl);

                    Log::info('QR Code Content Generated', [
                        'qr_content_length' => strlen($qrCode),
                        'api_url' => $qrApiUrl
                    ]);

                    // Save SVG file
                    $bytesWritten = file_put_contents($qrAbsolutePath, $qrCode);
                    
                    Log::info('QR Code File Write Attempt', [
                        'bytes_written' => $bytesWritten,
                        'file_exists' => file_exists($qrAbsolutePath),
                        'file_size' => file_exists($qrAbsolutePath) ? filesize($qrAbsolutePath) : 0,
                        'file_permissions' => file_exists($qrAbsolutePath) ? substr(sprintf('%o', fileperms($qrAbsolutePath)), -4) : 'N/A'
                    ]);

                } catch (\Exception $qrGenException) {
                    Log::error('QR Code Generation Failed', [
                        'error' => $qrGenException->getMessage(),
                        'trace' => $qrGenException->getTraceAsString()
                    ]);
                    throw $qrGenException;
                }

                // Verify file creation and update BMET record
                if (file_exists($qrAbsolutePath)) {
                    // Update BMET record with paths
                    $bmet->update([
                        'pdf_path' => $storagePath,
                        'qr_path' =>  $qrStoragePath // Add only one 'storage/' prefix
                    ]);

                    Log::info('Files created successfully', [
                        'pdf_path' => $storagePath,
                        'qr_path' => 'storage/' . $qrStoragePath
                    ]);
                } else {
                    Log::error('QR Code File Not Created', [
                        'absolute_path' => $qrAbsolutePath,
                        'directory_exists' => file_exists(dirname($qrAbsolutePath)),
                        'directory_writable' => is_writable(dirname($qrAbsolutePath))
                    ]);
                    throw new \Exception('QR code file creation failed');
                }

            } catch (\Exception $qrException) {
                Log::error('QR Code Generation Error', [
                    'error' => $qrException->getMessage(),
                    'trace' => $qrException->getTraceAsString(),
                    'file' => $qrException->getFile(),
                    'line' => $qrException->getLine()
                ]);
                throw $qrException;
            }
            return redirect()->route('bmet-update.index')->with('success', 'BMET record created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in BMET store', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while saving the data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $bmet = BMETupdate::findOrFail($id);
        $photoUrl = $bmet->photo ? url('storage/app/public/' . $bmet->photo) : null;
        $qrUrl = $bmet->qr_path ? url('storage/app/public' . $bmet->qr_path) : null;
        \Log::info('BMET pdf_path: ' . $bmet->pdf_path); // Debug log
        return view('user.bmet-update.show', compact('bmet', 'photoUrl', 'qrUrl'));
    }

    public function edit($id)
    {
        $bmet = BMETupdate::findOrFail($id);
        return view('user.bmet-update.edit', compact('bmet'));
    }

    public function update(Request $request, $id)
    {
        $bmet = BMETupdate::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'clearance_id' => 'required|string',
            'clearance_date' => 'required|date',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'bra_id' => 'required|string',
            'employer' => 'required|string',
            'job' => 'required|string',
            'country' => 'required|string',
            'bmet_no' => 'required|string',
            'passport_no' => 'required|string',
            'p_issue_date' => 'required|date',
            'p_expiry_date' => 'required|date',
            'dob' => 'required|date',
            'visa_no' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($bmet->photo && Storage::disk('public')->exists(str_replace('storage/app/public/', '', $bmet->photo))) {
                Storage::disk('public')->delete(str_replace('storage/app/public/', '', $bmet->photo));
            }

            // Store new photo correctly in `storage/uploads/`
            $photoPath = $request->file('photo')->storeAs('uploads', time() . '_' . $request->file('photo')->getClientOriginalName(), 'public');

            // Fix the stored path (avoid "storage/storage/uploads/")
            $bmet->photo = str_replace('public/', 'storage/', $photoPath);
        }

        // Update BMET record
        $bmet->update($request->except(['_token', 'photo']) + [
            'photo' => '/app/public/' . $bmet->photo
        ]);
$certificateNo = mt_rand(1000000, 9999999); // 7-digit random number

        // Regenerate HTML content
        $htmlContent = view('user.bmet-update.qr', [
            'name' => $bmet->name,
            'clearance_id' => $bmet->clearance_id,
            'visa_no' => $bmet->visa_no,
            'employer' => $bmet->employer,
            'job' => $bmet->job,
            'country' => $bmet->country,
            'bmet_no' => $bmet->bmet_no,
            'passport_no' => $bmet->passport_no,
            'p_issue_date' => date('d M Y', strtotime($bmet->p_issue_date)),
            'p_expiry_date' => date('d M Y', strtotime($bmet->p_expiry_date)),
            'dob' => date('Y-m-d', strtotime($bmet->dob)),
            'photoUrl' => $bmet->photo ? url('/storage/' . $bmet->photo) : null,
            'father_name' => $bmet->father_name,
            'mother_name' => $bmet->mother_name,
            'bra_id' => $bmet->bra_id,
            'clearance_date' => $bmet->clearance_date,
            'certificate_no' => $certificateNo,
            'ttc' => 'Sylhet mohila technical training center',
            'issue_date' => date('Y-m-d')
        ])->render();

        // Update the existing HTML file
        $filename = basename($bmet->pdf_path);
        $absolutePath = storage_path('uploads/' . $filename);
        
        file_put_contents($absolutePath, $htmlContent);

        return redirect()->route('bmet.index')->with('success', 'BMET Smart Card updated successfully!');
    }


    public function destroy($id)
    {
        $bmet = BMETupdate::findOrFail($id);
        $bmet->delete();

        return redirect()->route('bmet.index')->with('success', 'BMET Smart Card deleted successfully!');
    }

    // Test method to verify storage
    public function checkStorage($id)
    {
        try {
            $bmet = BMETupdate::findOrFail($id);
            
            $storageInfo = [
                'photo_path' => $bmet->photo,
                'exists' => Storage::disk('direct')->exists($bmet->photo),
                'full_path' => Storage::disk('direct')->path($bmet->photo),
                'file_size' => Storage::disk('direct')->exists($bmet->photo) ? Storage::disk('direct')->size($bmet->photo) : null,
                'disk_name' => 'direct',
                'disk_root' => config('filesystems.disks.direct.root')
            ];
            
            Log::info('Storage check', $storageInfo);
            
            return response()->json($storageInfo);

        } catch (\Exception $e) {
            Log::error('Error checking storage', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Verify the BMET record from QR code scan
     */
    public function verify($id)
    {
        $bmet = BMETupdate::findOrFail($id);
        return view('user.bmet-update.verify', compact('bmet'));
    }
    public function serveFile($id)
    {
        $bmet = BMETupdate::findOrFail($id);
        $filePath = $bmet->pdf_path; // Assuming 'pdf_path' is the column storing the file path

        if (Storage::disk('direct')->exists($filePath)) {
            return response()->file(Storage::disk('direct')->path($filePath));
        }

        return abort(404, 'File not found');
    }

    // Add new method to serve file by token
    public function serveFileByToken($token)
    {
        $bmet = BMETupdate::where('token', $token)->firstOrFail();
        $filePath = str_replace('storage/', '', $bmet->pdf_path);
        $absolutePath = storage_path('uploads/' . basename($filePath));

        if (file_exists($absolutePath)) {
            return response()->file($absolutePath);
        }

        return abort(404, 'File not found');
    }

    // Add this new method to handle the new URL format
    public function showByClearanceId($clearanceId)
    {
        $bmet = BMETupdate::where('clearance_id', $clearanceId)->firstOrFail();
        
        // Try multiple possible paths
        $possiblePaths = [
            storage_path('uploads/' . basename($bmet->pdf_path)),
            storage_path('app/public/' . str_replace('storage/', '', $bmet->pdf_path)),
            public_path('storage/' . str_replace('storage/', '', $bmet->pdf_path)),
            public_path($bmet->pdf_path)
        ];

        Log::info('Attempting to find file', [
            'clearance_id' => $clearanceId,
            'pdf_path' => $bmet->pdf_path,
            'possible_paths' => $possiblePaths
        ]);

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                Log::info('File found at: ' . $path);
                return response()->file($path);
            }
        }

        Log::error('File not found in any location', [
            'clearance_id' => $clearanceId,
            'pdf_path' => $bmet->pdf_path,
            'attempted_paths' => $possiblePaths
        ]);

        return abort(404, 'File not found');
    }

    private function createTransaction($amount, $type, $description, $userId)
    {
        Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'details' => $details
        ]);
    }
}