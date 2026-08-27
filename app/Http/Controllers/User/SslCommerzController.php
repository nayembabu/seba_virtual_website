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
use App\SSLCommerz;
use App\Models\Application;
use App\Models\Recharge;
use App\Models\Gateway;
use App\Models\Configure;
use \Illuminate\Support\Facades\Auth;
use Session;

class SslCommerzController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }
    
    public function test(){
       
        
    }
    
    public function index(){
        
        $data['user'] = $this->user;
        
        return view('user.ssl-commerz',$data);
        
    }
    
    public function pay(Request $request){
        
        $this->validate($request,[
        'amount' => 'required|numeric|min:'.get_settings()->min_d,
		]);
       return $this->create_payment($request->amount);
    }
    
    public function create_payment($amount){
        $value_a = encrypt($this->user->id);
        $value_b = '';
        $value_c = '';
        $value_d = '';
        $post_data = array();
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();
        $post_data['value_a'] = $value_a;
        $post_data['value_b'] = $value_b;
        $post_data['value_c'] = $value_c;
        $post_data['value_d'] = $value_d;
        $post_data['cus_name'] = $this->user->name;
        $post_data['cus_add1'] = 'Dhaka-1000';
        $post_data['cus_city'] = 'Dhaka';
        $post_data['cus_postcode'] = '1000';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $this->user->phone;
        $post_data['cus_email'] = $this->user->email;
        $post_data['success_url'] = route('user.ssl-payment-success');
        $post_data['fail_url'] = route('user.ssl-payment-failed');
        $post_data['cancel_url'] = route('user.ssl-payment-failed').'?type=cancel';
        $sslc = new SSLCommerz();
        $result = $sslc->initiate($post_data);
        return $result;
    }

    public function success(Request $request){
       $user_id = decrypt($request->value_a);
       $user = User::findOrFail($user_id);
       Auth::guard('web')->loginUsingId($user_id);
       
            $amount = $request->amount;
            $r = new Recharge();
            $r->amount = $amount;
            $r->status = 1;
            $r->user_id = $user_id;
            $r->from = 'Auto Payment : SslCommerz';
            $r->gateway_id = '';
            $r->txid = $request->tran_id;
            $r->save();
            $u = $user;
            $u->balance = $u->balance + $amount;
            $u->save();
            create_transaction($amount,'+','Auto recharge via SslCommerz',$u->id,$request->tran_id);
            
            if ( $amount >= 500){
            $bonus = 0.20 * $amount;
            $u->balance = $u->balance + $bonus;
            $u->save();
            create_transaction($bonus,'+','SslCommerz recharge bonus',$u->id,'BN-'.$request->tran_id);
            } 
       
            session()->flash('success', 'Recharge successful , Amount : '.$amount);
            return redirect(route('user.ssl-commerz'));
    }
    
    public function failed(Request $request){
       $user_id = decrypt($request->value_a);
       $user = User::findOrFail($user_id);
       Auth::guard('web')->loginUsingId($user_id);
       
        $msg = 'Payment Failed';
        if ( isset($request->type) && $request->type == 'cancel' ){
        $msg = 'Payment Cancelled';
        }
       
        return redirect(route('user.ssl-commerz'))->withErrors(['msg' => $msg]);
    }

   
}
