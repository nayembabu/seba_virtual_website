<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Application;
use App\Models\Recharge;
use App\Models\Gateway;
use App\Models\Configure;
use Session;

class BkashController extends Controller
{
    use Upload, Notify;
    
  
    public function __construct()
    {
        if ( get_settings()->register_option == '0' ){
             abort(403);
        }
        $this->middleware('guest');
        
    }
    
    public function index(){
        
        if ( blank(_reg_data()) ){
            abort(403);
        }
        $data["user"] = (object) _reg_data();
        
        $amount = Session::get("remaining_amount");
        if (blank($amount)) {
            $amount = \App\Models\ServiceCharge::getCharge("register");
            $amount = $amount > 0 ? $amount : 499;
        }
        $data["amount"] = $amount;

        return view("auth.bkash",$data);
        
    }
    
    public function pay(){
       if ( blank(_reg_data()) ){
            abort(403);
        }
       $amount = Session::get("remaining_amount");
       if (blank($amount)) {
            $amount = \App\Models\ServiceCharge::getCharge("register");
            $amount = $amount > 0 ? $amount : 499;
        }
       
       $url = $this->create_payment($amount);
       return redirect($url);
    }
    
    private function config(){
        $c = Configure::FirstOrNew();
        return array(
            'mode' => $c->bkash_mode,
            'callback' => route('register.bkash-callback'),
            'app_key' => $c->bkash_app_key,
            'app_secret' => $c->bkash_app_secret,
            'username' => $c->bkash_username,
            'password' => $c->bkash_password,
            );
    }

    private function get_base_url(){
        if($this->config()['mode'] == 'sandbox'){
            $base = "https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/";
        }
        else {
            $base = "https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/";
        }
        return $base;
    }

    public function create_payment($amount){
        $token = $this->getToken();
        $requestbody = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $this->config()['callback'],
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv".date('YmdH').rand(1000, 10000)
        );
        $requestbodyJson = json_encode($requestbody);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' .$token,
            'X-APP-Key:'.$this->config()['app_key']
        );

        $url = curl_init($this->get_base_url().'checkout/create');
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata)->bkashURL;
    }

    public function getToken(){
        Session::forget('token');
        $request_data = array('app_key'=> $this->config()['app_key'], 'app_secret'=> $this->config()['app_secret']);
        $request_data_json=json_encode($request_data);

        $header = array(
                'Content-Type:application/json',
                'username:'.$this->config()['username'],
                'password:'.$this->config()['password']
                );
       
        $url = curl_init($this->get_base_url().'checkout/token/grant');
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultdata = curl_exec($url);
        curl_close($url);

        $token = json_decode($resultdata)->id_token;
        Session::put('token',$token);
        return $token;
    }
    
  public function callback(Request $request)
{
    $data = [
        'success' => false,
        'msg' => 'Payment Failed',
    ];

    $allRequest = $request->all();

    if (isset($allRequest['status']) && $allRequest['status'] == 'failure') {
        $data['msg'] = 'Payment Failed';
    } elseif (isset($allRequest['status']) && $allRequest['status'] == 'cancel') {
        $data['msg'] = 'Payment Cancelled';
    } else {
        $resultdata = $this->execute($allRequest['paymentID']);
        $result_data_array = json_decode($resultdata, true);

        if (isset($result_data_array["statusCode"]) && $result_data_array["statusCode"] != '0000') {
            $data['msg'] = $result_data_array['statusMessage'];
            return redirect(route('register'))->withErrors(['msg' => $data['msg']]);
        } elseif (isset($result_data_array["statusMessage"])) {
            sleep(1);
            $resultdata = $this->query($allRequest['paymentID']);
            $resultdata = json_decode($resultdata, true);

            if (isset($resultdata['transactionStatus']) && $resultdata['transactionStatus'] == 'Initiated') {
                $data['msg'] = 'Initiated';
                return redirect(route('register'))->withErrors(['msg' => $data['msg']]);
            }
        }

        $data['success'] = true;
        $data['msg'] = 'Payment Successful';
    }

    if ($data['success'] == true) {
        // Process successful payment
        $reg_data = (object) _reg_data();
        $user = User::create([
            'name' => $reg_data->name,
            'email' => $reg_data->email,
            'phone' => $reg_data->phone,
            'gender' => $reg_data->gender,
            'dob' => $reg_data->dob,
            'nid' => $reg_data->nid,
            'status' => 1,
            'password' => $reg_data->password,
        ]);

        // Additional processing such as logging in the user, saving registration data, etc.

        // Flash message and redirect
        session()->flash('success', 'Registration Successful');
        return redirect(route('user.dashboard'));
    } else {
        // Handle failed payment
        return redirect(route('register'))->withErrors(['msg' => $data['msg']]);
    }
}


    public function execute($paymentID) {
        $auth = Session::get('token');
        
        $requestbody = array(
            'paymentID' => $paymentID
        );
        $requestbodyJson = json_encode($requestbody);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            'X-APP-Key:'.$this->config()['app_key']
        );

        $url = curl_init($this->get_base_url().'checkout/execute');
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        
        return $resultdata;
    }

    public function query($paymentID){
        
        $auth = Session::get('token');
        
        $requestbody = array(
            'paymentID' => $paymentID
        );
        $requestbodyJson = json_encode($requestbody);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            'X-APP-Key:'.$this->config()['app_key']
        );

        $url = curl_init($this->get_base_url().'checkout/payment/status');
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        
        return $resultdata;
    }
}