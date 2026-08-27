<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Application;
use App\Models\Recharge;
use App\Models\Gateway;
use App\Models\Configure;

class BkashController extends Controller
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
        return view('user.bkash',$data);
        
    }
    
    public function pay(Request $request)
    {

        $this->validate($request,[
        'amount' => 'required|numeric|min:'.get_settings()->min_d,
		]);
        
       $url = $this->create_payment($request->amount);
       return redirect($url);
    }
    
    private function config(){
        $c = Configure::FirstOrNew();
        return array(
            'mode' => $c->bkash_mode,
            'callback' => route('user.bkash-callback'),
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
        try {
            $token = $this->getToken();
        } catch (\Exception $e) {
            return redirect(route('user.bkash'))->withErrors(['msg' => $e->getMessage()]);
        }
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

        $result = json_decode($resultdata);
        if (!$result || !isset($result->id_token)) {
            $errorMsg = $result->statusMessage ?? 'Failed to get bKash token. Check API credentials.';
            throw new \Exception($errorMsg);
        }
        $token = $result->id_token;
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
            return redirect(route('user.bkash'))->withErrors(['msg' => $data['msg']]);
        } elseif (isset($result_data_array["statusMessage"])) {
            sleep(1);
            $resultdata = $this->query($allRequest['paymentID']);
            $resultdata = json_decode($resultdata, true);

            if (isset($resultdata['transactionStatus']) && $resultdata['transactionStatus'] == 'Initiated') {
                $data['msg'] = 'Initiated';
                return redirect(route('user.bkash'))->withErrors(['msg' => $data['msg']]);
            }
        }

        $data['success'] = true;
        $data['msg'] = 'Payment Successful';
    }

    if ($data['success'] == true) {
        $amount = isset($result_data_array['amount']) ? $result_data_array['amount'] : 0; // Ensure 'amount' index is defined
        $r = new Recharge();
        $r->amount = $amount;
        $r->status = 1;
        $r->user_id = $this->user->id;
        $r->from = 'bKash Auto Payment, ID: ' . $result_data_array['paymentID'];
        $r->gateway_id = '';
        $r->txid = $result_data_array['trxID'] ?? null;
        $r->save();

        $u = $this->user;
        $u->balance += $amount;
        $u->save();

        create_transaction($amount, '+', 'Auto recharge via bKash', $u->id, $result_data_array['trxID'] ?? null);

        if ($amount >= 1500) {
            $bonus = 0.1 * $amount;
            $u->balance += $bonus;
            $u->save();
            create_transaction($bonus, '+', 'bKash recharge bonus', $u->id, 'BN-' . ($result_data_array['trxID'] ?? null));
        }

        session()->flash('success', 'Recharge successful, Amount: ' . $amount);
        return redirect(route('user.bkash'));
    } else {
        return redirect(route('user.bkash'))->withErrors(['msg' => $data['msg']]);
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
