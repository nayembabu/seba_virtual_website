<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SmartCard;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SmartCardController extends Controller
{
    protected $user;

  
  public function print($id)
  {
      $smartCard = SmartCard::where('id', $id)
          ->where('user_id', $this->user->id)
          ->firstOrFail();

      return view('user.smartcard.print', compact('smartCard'));
  }

  public function verify($id)
  {
      $smartCard = SmartCard::findOrFail($id);
      
      // This route doesn't require authentication since it's using withoutMiddleware
      // It's likely a public route to verify the authenticity of a smart card
      
      return view('user.smartcard.verify', compact('smartCard'));
  }
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
        $smartCards = SmartCard::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.smartcard.index', compact('smartCards'));
    }

    public function create()
    {
        $data['title'] = 'Create Smart Card';
        return view('user.smartcard.create', ['title' => 'Create Smart Card']);
    }

    public function parsePdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $pdf = $request->file('pdf');

            $client = new \GuzzleHttp\Client(['timeout' => 120]);
            $response = $client->post('https://apix.cloudseba.xyz/SIGN-2-SMART/sign/signto-smart.php', [
                'multipart' => [
                    [
                        'name' => 'key',
                        'contents' => 'FixedFast1976036*#$',
                    ],
                    [
                        'name' => 'pdf',
                        'contents' => fopen($pdf->getRealPath(), 'r'),
                        'filename' => $pdf->getClientOriginalName(),
                    ],
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (!$result || !isset($result['success']) || !$result['success']) {
                $errorMsg = $result['error'] ?? 'PDF processing failed';
                return response()->json([
                    'success' => false,
                    'error' => $errorMsg,
                ], 422);
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'API request failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function downloadAndSaveImage($url, $type, $baseStoragePath, $basePublicUrl)
    {
        try {
            $imageContents = file_get_contents($url);
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = uniqid() . '.' . $extension;
            $savePath = "$baseStoragePath/$type";

            if (!is_dir($savePath)) {
                mkdir($savePath, 0775, true);
            }

            file_put_contents("$savePath/$filename", $imageContents);

            return "$basePublicUrl/$type/$filename";
        } catch (\Exception $e) {
            Log::error('Image download failed: ' . $e->getMessage());
            return null;
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $fee = \App\Models\ServiceCharge::getCharge('smartcard');

        if ($user->balance < $fee) {
            return back()->with('error', 'You do not have enough balance to create a Smart Card. Required: ৳50');
        }

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nid_no' => 'required|string|max:50',
            'pin' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'place_of_birth' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_url' => 'nullable|url',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature_url' => 'nullable|url',
        ]);

        $user->balance -= $fee;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $fee,
            'type' => 'debit',
            'details' => 'Smart Card Creation Fee',
            'tx_id' => strtoupper('SC' . uniqid()),
        ]);

        $smartCard = new SmartCard();
        $smartCard->user_id = $user->id;
        $smartCard->fill($validated);

        // Set your custom storage path and public URL
        $baseStoragePath = public_path('smartcards');
        $basePublicUrl = '/smartcards';

        // Handle photo
        if ($request->hasFile('photo')) {
            $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move("$baseStoragePath/photos", $filename);
            $smartCard->photo = "$basePublicUrl/photos/$filename";
        } elseif ($request->filled('photo_url')) {
            $photoUrl = $this->downloadAndSaveImage($request->photo_url, 'photos', $baseStoragePath, $basePublicUrl);
            if ($photoUrl) {
                $smartCard->photo = $photoUrl;
            }
        }

        // Handle signature
        if ($request->hasFile('signature')) {
            $filename = uniqid() . '.' . $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move("$baseStoragePath/signatures", $filename);
            $smartCard->signature = "$basePublicUrl/signatures/$filename";
        } elseif ($request->filled('signature_url')) {
            $signatureUrl = $this->downloadAndSaveImage($request->signature_url, 'signatures', $baseStoragePath, $basePublicUrl);
            if ($signatureUrl) {
                $smartCard->signature = $signatureUrl;
            }
        }


        $smartCard->save();

        return redirect()->route('user.smartcard.index')->with('success', 'Smart Card created successfully. ৳50 has been deducted.');
    }

    public function show($id)
    {
        $smartCard = SmartCard::where('id', $id)
            ->where('user_id', $this->user->id)
            ->firstOrFail();

        $banglaName = $smartCard->name_bn;
        $englishName = $smartCard->name_en;
        $fatherName = $smartCard->father_name;
        $motherName = $smartCard->mother_name;
        $dateOfBirth = $smartCard->date_of_birth;
        $formattedDob = $smartCard->date_of_birth
            ? \Carbon\Carbon::parse($smartCard->date_of_birth)->format('d M Y')
            : '';
        $nidNumber = $smartCard->nid_no;
        $formattedNid = $smartCard->nid_no;
        $bloodGroup = $smartCard->blood_group ?? 'N/A';
        $address = $smartCard->address;
        $birthPlaceEn = $smartCard->place_of_birth ?? 'N/A';
        $issueDate = $smartCard->issue_date
            ? \Carbon\Carbon::parse($smartCard->issue_date)->format('d M Y')
            : 'N/A';
        $photoBase64 = $smartCard->photo;
        $signatureBase64 = $smartCard->signature;
        $pin = $smartCard->pin ?? '';

        return view('user.smartcard.show', compact(
            'smartCard',
            'banglaName',
            'englishName',
            'fatherName',
            'motherName',
            'dateOfBirth',
            'formattedDob',
            'nidNumber',
            'formattedNid',
            'bloodGroup',
            'address',
            'birthPlaceEn',
            'issueDate',
            'photoBase64',
            'signatureBase64',
            'pin'
        ));
    }

  public function edit($id)
{
    try {
        // Use direct output to debug instead of relying on logs
        // This will show up in your browser when debugging is enabled
        // Make sure APP_DEBUG is set to true in your .env file
        
        // Create a custom log file to ensure it's writable
        $debugLogPath = storage_path('app/smartcard_debug.log');
        $debugMsg = date('Y-m-d H:i:s') . " - SmartCardController@edit called with ID: $id\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Try both auth methods to see which one works
        $authUserId = auth()->check() ? auth()->id() : 'Not authenticated';
        $thisUserId = isset($this->user) ? $this->user->id : 'User not set in middleware';
        
        $debugMsg = date('Y-m-d H:i:s') . " - Auth User ID: $authUserId, Controller User ID: $thisUserId\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Debug the query that will be executed
        $query = SmartCard::where('id', $id);
        if (isset($this->user)) {
            $query->where('user_id', $this->user->id);
        }
        
        // Get the query SQL for debugging
        $querySql = $query->toSql();
        $debugMsg = date('Y-m-d H:i:s') . " - Query SQL: $querySql\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Execute the query with debug info
        $smartCard = $query->first();
        
        // Debug: Check if we found the card
        if (!$smartCard) {
            $debugMsg = date('Y-m-d H:i:s') . " - SmartCard not found with ID: $id\n";
            file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            
            // Try to find the card without user_id restriction to check if it exists at all
            $anyCard = SmartCard::find($id);
            if ($anyCard) {
                $debugMsg = date('Y-m-d H:i:s') . " - Card exists but belongs to user_id: {$anyCard->user_id}\n";
                file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            } else {
                $debugMsg = date('Y-m-d H:i:s') . " - No card with ID: $id exists in database\n";
                file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            }
            
            // Dump all cards for this user to check if any exist
            $userCards = SmartCard::where('user_id', $this->user->id)->get();
            $debugMsg = date('Y-m-d H:i:s') . " - User has " . count($userCards) . " cards. IDs: " . 
                        implode(', ', $userCards->pluck('id')->toArray()) . "\n";
            file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            
            return redirect()->route('user.smartcard.index')
                ->with('error', 'Smart Card not found or you don\'t have permission to edit it.');
        }
        
        $debugMsg = date('Y-m-d H:i:s') . " - SmartCard found: ID={$smartCard->id}, User={$smartCard->user_id}, Name={$smartCard->name_en}\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Check if the view exists before rendering
        $viewPath = 'user.smartcard.edit';
        if (!view()->exists($viewPath)) {
            $debugMsg = date('Y-m-d H:i:s') . " - View not found: $viewPath\n";
            file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            
            // List available views that might be related
            $viewFinder = app('view.finder');
            $hints = $viewFinder->getHints();
            $possibleViews = [];
            
            try {
                $viewPaths = $viewFinder->getPaths();
                foreach ($viewPaths as $path) {
                    if (is_dir($path . '/user/smartcard')) {
                        $files = scandir($path . '/user/smartcard');
                        $possibleViews = array_merge($possibleViews, $files);
                    }
                }
                $debugMsg = date('Y-m-d H:i:s') . " - Related views: " . implode(', ', $possibleViews) . "\n";
                file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            } catch (\Exception $e) {
                $debugMsg = date('Y-m-d H:i:s') . " - Error scanning views: " . $e->getMessage() . "\n";
                file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
            }
            
            return redirect()->route('user.smartcard.index')
                ->with('error', 'The edit page template could not be found. Please contact support.');
        }
        
        $debugMsg = date('Y-m-d H:i:s') . " - View exists, rendering edit page\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Pass the smart card to the view
        return view($viewPath, [
            'smartcard' => $smartCard,
            'title' => 'Edit Smart Card: ' . $smartCard->name_en
        ]);
        
    } catch (\Exception $e) {
        // Write exception to custom debug file
        $debugLogPath = storage_path('app/smartcard_debug.log');
        $debugMsg = date('Y-m-d H:i:s') . " - EXCEPTION: " . $e->getMessage() . "\n";
        $debugMsg .= "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
        $debugMsg .= "Trace: " . $e->getTraceAsString() . "\n";
        file_put_contents($debugLogPath, $debugMsg, FILE_APPEND);
        
        // Also try to write to PHP error log directly
        error_log('SmartCardController Exception: ' . $e->getMessage());
        
        return redirect()->route('user.smartcard.index')
            ->with('error', 'An error occurred while attempting to edit the Smart Card: ' . $e->getMessage());
    }
}
  public function update(Request $request, $id)
{
    // Find the smart card record
    $card = SmartCard::findOrFail($id);

    // Validate inputs
    $validated = $request->validate([
        'name_en' => 'required|string|max:255',
        'name_bn' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'nid_no' => 'required|string|max:100',
//        'pin' => 'required|string|max:255',
        'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'place_of_birth' => 'required|string|max:255',
        'issue_date' => 'required|date',
        'address' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photo_url' => 'nullable|url',
        'signature_url' => 'nullable|url',
    ]);

    // Update fields
    $card->name_en = $validated['name_en'];
    $card->name_bn = $validated['name_bn'];
    $card->father_name = $validated['father_name'];
    $card->mother_name = $validated['mother_name'];
    $card->date_of_birth = $validated['date_of_birth'];
    $card->nid_no = $validated['nid_no'];
     $card->pin = $validated['pin'] ?? $card->pin;
    $card->blood_group = $validated['blood_group'];
    $card->place_of_birth = $validated['place_of_birth'];
    $card->issue_date = $validated['issue_date'];
    $card->address = $validated['address'];

    // Handle photo upload or existing photo URL
    if ($request->hasFile('photo')) {
        // Delete old photo if exists and stored locally
        if ($card->photo && \Storage::disk('public')->exists($card->photo)) {
            \Storage::disk('public')->delete($card->photo);
        }
        // Store new photo
        $photoPath = $request->file('photo')->store('app/public/smartcards/photos', 'public');
        $card->photo = $photoPath;
    } elseif ($request->photo_url) {
        // If photo_url is provided (from extraction), save URL as is
        $card->photo = $request->photo_url;
    }
    // Else keep existing photo as is

    // Handle signature upload or existing signature URL
    if ($request->hasFile('signature')) {
        // Delete old signature if exists and stored locally
        if ($card->signature && \Storage::disk('public')->exists($card->signature)) {
            \Storage::disk('public')->delete($card->signature);
        }
        // Store new signature
        $signaturePath = $request->file('signature')->store('app/public/smartcards/signatures', 'public');
        $card->signature = $signaturePath;
    } elseif ($request->signature_url) {
        // Save signature URL from extraction
        $card->signature = $request->signature_url;
    }
    // Else keep existing signature as is

    // Save updated record
    $card->save();

    return redirect()->route('user.smartcard.index', $card->id)
        ->with('success', 'Smart Card updated successfully.');
}


    public function destroy($id)
    {
        $smartCard = SmartCard::where('id', $id)
            ->where('user_id', $this->user->id)
            ->firstOrFail();

        try {
            if ($smartCard->photo && Storage::disk('public')->exists(str_replace('storage/', '', $smartCard->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $smartCard->photo));
            }
            if ($smartCard->signature && Storage::disk('public')->exists(str_replace('storage/', '', $smartCard->signature))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $smartCard->signature));
            }

            $smartCard->delete();

            return redirect()->route('smart-cards.index')->with('success', 'Smart card deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete smart card: " . $e->getMessage());
            return back()->with('error', 'Failed to delete smart card: ' . $e->getMessage());
        }
    }
}
