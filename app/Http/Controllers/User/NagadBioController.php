<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Support;
use App\Models\Transaction;
use App\Models\Notification;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;



class NagadBioController extends Controller
{
    use Upload, Notify;


   
    public function __construct()
    {
        if ( get_settings()->nagad_option == '0' ){
            abort(404);
        }
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Nagad Bio';
        return view('user.nagad-bio', $data);
    }

    
public function view_api(Request $request)
{
    \Log::info('Request started for phone: ' . $request->phone);

    // Validate phone number
    $this->validate($request, [
        'phone' => 'required|min:11|max:11',
    ]);

    \Log::info('Phone validation passed');

    // Get Nagad fee
    $fee = \App\Models\ServiceCharge::getCharge('nagad-bio');
    \Log::info('Nagad fee: ' . $fee);

    // Check if user has enough balance
    if ($this->user->balance < $fee) {
        \Log::error('Insufficient balance for user: ' . $this->user->id);
        return back()->withErrors(['msg' => 'Insufficient balance']);
    }

    // Prepare API URL
    $url = 'https://api2.bdx.today/bio.php?number=' . $request->phone;
    \Log::info('API URL: ' . $url);

    // Send request to the API
    $response = send_get_request($url);
    \Log::info('API Response: ' . $response);

    if ($response == 'failed') {
        \Log::error('API failed for URL: ' . $url);
        return back()->withInput($request->input())->withErrors(['msg' => 'API error, please try again']);
    }

    // Decode the API response
    $data = json_decode($response);
    \Log::info('Decoded API response: ', (array) $data);

    // Check if the response contains the expected data
    if (!blank($data) && isset($data->name) && !empty($data->name)) {
        
        // Deduct the balance
        $this->user->balance -= $fee;
        $this->user->save();
        \Log::info('Balance deducted for user: ' . $this->user->id);

        // Record the transaction
        create_transaction($fee, '-', 'Viewed SIM Bio', $this->user->id);
        \Log::info('Transaction created for user: ' . $this->user->id);

        // Store the retrieved data in the session
        session()->flash('nagad_bio', 'found');
        session()->flash('nagad_bio_name', $data->name);
        session()->flash('nagad_bio_nid', $data->national_id);
        session()->flash('nagad_bio_dob', $data->date_of_birth);
         // Add image URL to session
        \Log::info('Session data stored');

    } else {
        \Log::error('API response does not contain valid data for phone: ' . $request->phone);
        return back()->withInput($request->input())->withErrors(['msg' => 'Data not found or data structure changed']);
    }

    \Log::info('Request completed successfully for phone: ' . $request->phone);
    return back();
}



    
     
     public function view(){
          $token = Session::get('nagad_bio','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token);
           $data['data'] = $token;
           
           if ( isset($token->expire_time) && $token->expire_time >= time() ){
               return view('user.templates.nagad-bio',$data);
           } else {
               return 'Token expired or invalid';
           }
    }
    
 
}
