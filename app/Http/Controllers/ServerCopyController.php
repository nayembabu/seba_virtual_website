<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NidData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Encryption\DecryptException;
use QrCode;

class ServerCopyController extends Controller
{  
    
    //rakib
    
    //rakib
    
    
    public function __construct()
    {
        $this->middleware('auth')->except(['viewServerCopy']);
    }

    public function index()
    {
        $serverCopies = NidData::where('user_id', Auth::id())->get();
        return view('user.servercopy.index', compact('serverCopies'));
    }
public function server_copy(){
        $data['user'] = $this->user;
        return view('user.server-copy', $data);
    }
    public function server_copy_post(Request $request)
    {
        try {
            $validated = $request->validate([
                'nid' => 'required',
                'dob' => 'required|date'
            ]);

            if (Auth::user()->balance < \App\Models\ServiceCharge::getCharge('server-copy')) {
                return back()->withInput()->withErrors(['msg' => 'Insufficient balance']);
            }

            $url = get_main_api_domain() . '/ddos-new/api.php';
            $response = $this->send_get_request($url, [
                'nid' => $request->nid,
                'dob' => date('Y-m-d', strtotime($request->dob))
            ]);

            if ($response === 'failed') {
                return $this->captcha($request, route('user.server-copy'));
            }

            $data = json_decode($response);
            
            if (!$data || !isset($data->success) || $data->success !== true) {
                throw new \Exception('Invalid response data');
            }

            return $this->processValidResponse($data);

        } catch (\Exception $e) {
            Log::error('Server copy creation failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['msg' => 'Data not found or data structure changed']);
        }
    }

    protected function processValidResponse($data)
    {
        try {
            $user = Auth::user();
            $fee = \App\Models\ServiceCharge::getCharge('server-copy');

            // Start transaction
            \DB::beginTransaction();

            // Update user balance
            $user->balance -= $fee;
            $user->save();

            // Create transaction record
            create_transaction($fee, '-', 'Created server copy', $user->id);

            // Create NID data record
            $nidData = new NidData([
                'user_id' => $user->id,
                'nid_no' => $data->nid_no,
                'voter_area' => $data->voter_area,
                'name_bn' => $data->name_bn,
                'name_en' => $data->name_en,
                'dob' => date('Y-m-d', strtotime($data->dob)),
                'fathers_name' => $data->fathers_name,
                'mothers_name' => $data->mothers_name,
                'gender' => $data->gender,
                'religion' => $data->religion,
                'occupation' => $data->occupation,
                'blood_grp' => $data->blood_grp,
                'permanent_addr' => $data->permanent_addr,
                'district' => $data->district,
                'present_addr' => $data->present_addr,
                'photo' => $data->photo,
                'expire_time' => now()->addMinutes(5)
            ]);
            
            $nidData->save();

            $token = encrypt($nidData->id);
            
            \DB::commit();

            return redirect()->route('user.server-copy-view', ['token' => urlencode($token)]);

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Transaction failed: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Failed to process the request']);
        }
    }

    public function view($token)
    {
        try {
            $nidDataId = decrypt($token);
            $nidData = NidData::findOrFail($nidDataId);

            if ($nidData->expire_time < now()) {
                return redirect()->route('user.server-copy')
                    ->withErrors(['msg' => 'The server copy has expired']);
            }

            return view('user.server_copy.view', compact('nidData'));

        } catch (DecryptException $e) {
            return back()->withErrors(['msg' => 'Invalid or expired token']);
        } catch (\Exception $e) {
            Log::error('View access failed: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Unable to access the requested data']);
        }
    }

    public function download($id)
    {
        try {
            $nidData = NidData::findOrFail($id);

            if ($nidData->expire_time < now()) {
                return back()->withErrors(['msg' => 'This server copy has expired']);
            }

            $filePath = storage_path("app/{$nidData->photo}");
            
            if (!file_exists($filePath)) {
                throw new \Exception('File not found');
            }

            return response()->download($filePath);

        } catch (\Exception $e) {
            Log::error('Download failed: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Unable to download the file']);
        }
    }

public function saveHtmlContent(Request $request)
{
    try {
        // Validate the incoming request data
        $validated = $request->validate([
            'html_content' => 'required',
            'url' => 'required|url',
            'nid_no' => 'required|string', // Ensure nid_no is also validated
        ]);

        // Save the validated data to the database
        $savedContent = ServerCopy::create([
            'html_content' => $validated['html_content'],
            'url' => $validated['url'],
            'nid_no' => $validated['nid_no'], // Save nid_no
            'created_at' => now(),
        ]);

        // Return the saved content as a response
        return response()->json($savedContent);

    } catch (\Exception $e) {
        // Handle any errors that might occur
        Log::error('Save HTML content failed: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to save content'], 500);
    }
}

   
   //ekhane abr dimni
   
    public function viewServerCopy($id)
    {
        try {
            $serverCopy = ServerCopy::findOrFail($id);
            return view('view', compact('serverCopy'));

        } catch (\Exception $e) {
            Log::error('View server copy failed: ' . $e->getMessage());
            return response()->view('errors.404', [], 404);
        }
    }
   

    private function send_get_request($url, $params = [])
    {
        try {
            $queryString = http_build_query($params);
            $fullUrl = $url . '?' . $queryString;
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'ignore_errors' => true
                ]
            ]);

            $response = file_get_contents($fullUrl, false, $context);
            
            if ($response === false) {
                throw new \Exception('Request failed');
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return 'failed';
        }
    }

    
}