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

    
     public function view_api( Request $request ){
        $this->validate($request,[
        'phone' => 'required|min:11|max:11',
		]);
		
		
	    $fee = \App\Models\ServiceCharge::getCharge('bio');
        
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }


		$url = 'http://103.240.4.99/~exeftyho/m.php?number='.$request->phone;
		$response = send_get_request($url);

		if( $response == 'failed' ) {
          	return back()->withInput($request->input())->withErrors(['msg' => 'Api error please try again']);
        }
		$data = json_decode($response);
		if ( !blank($data) && isset($data->নাম) && !empty($data->নাম) ) {
		    
		    $this->user->balance = $this->user->balance - $fee;
		    $this->user->save();
		    create_transaction($fee,'-','Viewed Nagad Bio',$this->user->id);
		    session()->flash('nagad_bio', 'found');
            session()->flash('nagad_bio_name', $data->নাম);
            session()->flash('nagad_bio_nid', $data->{'এনআইডি নং'} );
            session()->flash('nagad_bio_dob', $data->{'জন্ম তারিখ'} );
            session()->flash('nagad_bio_phone', $request->phone );
         
		    
        } 
         else {
          	return back()->withInput($request->input())->withErrors(['msg' => 'Data not found or data structure changed']);
        }
		
        
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
