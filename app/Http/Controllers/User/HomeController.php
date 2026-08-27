<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Support;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Application;
use App\Models\Recharge;
use App\Models\Gateway;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Upload, Notify;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        //$this->theme = template();
    }

    public function index()
    {
        $data['user'] = $this->user;
        $data['supports'] = Support::where('user_id',$this->user->id)->count();
        return view('user.dashboard', $data);
    }
    
    public function support_tickets()
    {
       
        $data['user'] = $this->user;
        $data['supports'] = Support::where('user_id',$this->user->id)->orderBy('created_at','desc')->paginate(20);
        return view('user.supports', $data);
    }
    
     public function create_support_ticket()
    {
        $data['user'] = $this->user;
        return view('user.create-support', $data);
    }
     public function store_ticket( Request $request ){
        $this->validate($request,[
        'msg' => 'required',
		]);
        $user = $this->user;
        $s = new Support();
        $s->user_id = $user->id;
        $s->msg = $request->msg;
        $s->status = "pending";
        $s->save();
        return back()->with('success', 'Support Ticket Submitted');
    }
    
     public function notifications()
    {
        $data['user'] = $this->user;
        $notifications = Notification::orderBy('created_at', 'desc');
        $notifications->where(function($query) {
             return $query
                    ->where('user_id',$this->user->id )
                    ->orWhere('user_id','')
                    ->orWhereNull('user_id');
            });
        $data['notifications'] = $notifications->paginate(20);
        return view('user.notifications', $data);
    }
    
    
   
    
     public function recharge()
    {
        $data['user'] = $this->user;
        $data['recharges'] = Recharge::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(20);
        $data['gateways'] = Gateway::orderBy('created_at','desc')->get();
        return view('user.recharge', $data);
    }

    public function manualRecharge()
    {
        $data['user'] = $this->user;
        $data['gateways'] = Gateway::where('status', 1)->get();
        $data['min_d'] = \App\Models\Setting::where('name', 'min_d')->value('value') ?? 100;
        $activeNames = $data['gateways']->pluck('name')->toArray();
        $data['recharges'] = Recharge::where('user_id', auth()->user()->id)->whereIn('gateway_id', $activeNames)->where('created_at', '>=', now()->subHours(24))->orderBy('created_at','desc')->paginate(5);
        return view('user.manual-recharge', $data);
    }

    public function manualRechargeProcess(Request $request)
    {
        $activeMethods = Gateway::where('status', 1)->pluck('name')->implode(',');
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required|in:' . $activeMethods,
        ]);

        session(['recharge_amount' => $request->amount]);

        return redirect()->route('user.manual-recharge.pay', $request->method);
    }

    public function manualRechargePay($method)
    {
        if (!Gateway::where('name', $method)->where('status', 1)->exists()) {
            return redirect()->route('user.manual-recharge')->withErrors(['msg' => 'Invalid payment method']);
        }

        $amount = session('recharge_amount');
        if (!$amount || $amount < 100) {
            return redirect()->route('user.manual-recharge')->withErrors(['msg' => 'Session expired. Please try again.']);
        }

        $gatewayNumber = $this->getGatewayNumber($method);

        return view('user.manual-recharge-pay', [
            'method' => $method,
            'amount' => $amount,
            'gatewayNumber' => $gatewayNumber,
        ]);
    }

    public function manualRechargeSubmit(Request $request, $method)
    {
        if (!Gateway::where('name', $method)->where('status', 1)->exists()) {
            return redirect()->route('user.manual-recharge')->withErrors(['msg' => 'Invalid payment method']);
        }

        $amount = session('recharge_amount');
        if (!$amount || $amount < 100) {
            $amount = $request->amount;
        }

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'sender' => 'required|string|max:50',
            'trxid' => 'required|string|max:100',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $user = auth()->user();

        // Upload screenshot
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $fileName = time() . '_' . rand(1111, 9999) . '.' . $file->extension();
            $file->move(public_path('storage/screenshots/manual-recharge'), $fileName);
            $screenshotPath = 'screenshots/manual-recharge/' . $fileName;
        }

        // Create recharge record
        $recharge = new Recharge();
        $recharge->user_id = $user->id;
        $recharge->amount = $amount;
        $recharge->gateway_id = $method;
        $recharge->from = $request->sender;
        $recharge->txid = $request->trxid;
        $recharge->sender_number = $request->sender;
        $recharge->screenshot = $screenshotPath;
        $recharge->status = "pending";
        $recharge->save();

        // Telegram notification
        $this->sendTelegramNotification($user, $method, $amount, $request->sender, $request->trxid, $screenshotPath);

        session()->forget('recharge_amount');

        return redirect()->route('user.manual-recharge')->with('success', 'αªåαª¬αª¿αª╛αª░ αª░αª┐αªÜαª╛αª░αºìαª£ αª░αª┐αªòαºïαºƒαºçαª╕αºìαªƒ αª╕αª½αª▓αª¡αª╛αª¼αºç αª£αª«αª╛ αªªαºçαªôαºƒαª╛ αª╣αºƒαºçαª¢αºçαÑñ αªàαºìαª»αª╛αªíαª«αª┐αª¿ αªàαª¿αºüαª«αºïαªªαª¿αºçαª░ αª¬αª░ αª¼αºìαª»αª╛αª▓αºçαª¿αºìαª╕ αª»αºïαªù αª╣αª¼αºçαÑñ');
    }

    private function getGatewayNumber($method)
    {
        $gateway = \App\Models\Gateway::where('name', $method)->where('status', 1)->first();
        if ($gateway && !empty($gateway->account)) {
            return $gateway->account;
        }
        return '01XXXXXXXXX';
    }

    private function sendTelegramNotification($user, $method, $amount, $sender, $trxid, $screenshotPath)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN', '');
            $chatId = env('TELEGRAM_CHAT_ID', '');

            if (empty($botToken) || empty($chatId)) {
                return;
            }

            $count = Recharge::where('user_id', $user->id)->count();
            $message = "
≡ƒÜÇ <b>NEW {$method} RECHARGE</b>
Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼

≡ƒæñ <b>User ID:</b> {$user->id}
≡ƒô⌐ <b>Email:</b> {$user->email}
≡ƒÆ│ <b>Payment No:</b> #{$count}
≡ƒô▒ <b>Sender Number:</b> {$sender}
≡ƒåö <b>Transaction ID:</b> {$trxid}
≡ƒÆ░ <b>Method:</b> {$method}
Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼

Γ₧ò <b>Recharge Amount:</b> {$amount} αº│
Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼Γû¼

≡ƒòÆ " . now()->format('d M Y h:i A') . "
";

            $url = "https://api.telegram.org/bot{$botToken}/sendPhoto";

            if ($screenshotPath && file_exists(public_path("storage/{$screenshotPath}"))) {
                $filePath = public_path("storage/{$screenshotPath}");
                $postFields = [
                    'chat_id' => $chatId,
                    'caption' => $message,
                    'parse_mode' => 'HTML',
                    'photo' => new \CURLFile($filePath)
                ];
            } else {
                $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
                $postFields = [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            // Silently fail - notification is optional
        }
    }

     public function recharge_form($id){
        $gateway = Gateway::findOrFail($id);
        $data['user'] = $this->user;
        $data['gateway'] = $gateway;
        return view('user.recharge-form', $data);
    }
    
    public function recharge_form_p($id,Request $request){
        $gateway = Gateway::findOrFail($id);
        
        $user = $this->user;
        $this->validate($request,[
        'amount' => 'required|numeric|min:'.get_settings()->min_d,
        'from' => 'required',
        'txid' => 'required',
		]);   
		
		$r = new Recharge();
		$r->amount = $request->amount;
		$r->from = $request->from;
		$r->txid = $request->txid;
		$r->gateway_id = $id;
		$r->user_id = auth()->user()->id;
		$r->save();
		return back()->with('success', 'Recharge Request Submitted');
    }
    
     public function transactions(){
        $data['user'] = $this->user;
        $data['transactions'] = Transaction::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(20);
        return view('user.transactions', $data);
    }
    
    public function convert_17_digit(){
        $data['user'] = $this->user;
        return view('user.convert-17-digit', $data);
    }
    public function convert_17_digit_post(Request $request){
         $this->validate($request,[
        'nid' => 'required',
        'dob' => 'required'
		]);
		
		$url = get_main_api_domain().'/17nid.php?nid='.$request->nid.'&dob='.date('Y-m-d',strtotime($request->dob));
		$response = send_get_request($url);
		$data = json_decode($response);
		
		if ( isset($data->data->smartId) && !blank($data->data->smartId)){
            
            session()->flash('17nid', 'found');
            session()->flash('17nid_name', $data->data->nameEn);
            session()->flash('17nid_nid', $data->data->smartId );
            
        } else {
          	return back()->withErrors(['msg' => 'Data not found or data structure changed']);
        }
        
        return back();
    }
    
    public function nid_auto_make(){
        $data['user'] = $this->user;
        return view('user.nid-auto', $data);
    }
    public function nid_auto_make_post(Request $request){
         $this->validate($request,[
        'nid' => 'required',
        'dob' => 'required'
		]);
		
		if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('nid-auto') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		$url = get_main_api_domain().'/auto-nid/api.php?nid='.$request->nid.'&dob='.date('Y-m-d',strtotime($request->dob));
		$response = send_get_request($url);
		
     	if( $response == 'failed' ) {
		    return $this->captcha($request,route('user.nid-auto-make'));
        }
		
		$data = json_decode($response);
		if ( !blank($data) && isset($data->success) && $data->success == true) {
		   $fee = \App\Models\ServiceCharge::getCharge('nid-auto');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Print auto nid',$this->user->id);
           $encrypted = json_decode($response,true);
           $encrypted['expire_time'] = strtotime("+5 min"); 
           $token = encrypt(json_encode($encrypted));
           Session::put('nid_token',$token);
           return redirect( route('user.nid-print') );
        } 
         else {
          	return back()->withInput($request->input())->withErrors(['msg' => 'αªñαªÑαºìαª» αªôαºƒαª╛ αª»αª╛αªÜαºìαª¢ αª¿']);
        }
        
        return back();
    }
    
   public function nid_17_make()
    {
        $data['user'] = $this->user;  // Passing user information to the view
        return view('user.17nid', $data); // Adjusted to point to the correct view
    }

    // Handle the form submission for 17-digit NID conversion
    public function nid_17_make_post(Request $request)
    {
        // Validate the input for NID
        $request->validate([
            'nid' => 'required|digits:17', // Ensure the NID is 17 digits
            // You may include 'dob' validation if needed
            // 'dob' => 'required|date'
        ]);

        if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('nid-auto') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		$url = get_main_api_domain().'/auto-nid/17nid.php?nid='.$request->nid.'&dob='.date('Y-m-d',strtotime($request->dob));
		$response = send_get_request($url);
		
     	if( $response == 'failed' ) {
		    return $this->captcha($request,route('user.nid-auto-make'));
        }
		
		$data = json_decode($response);
		if ( !blank($data) && isset($data->success) && $data->success == true) {
		   $fee = \App\Models\ServiceCharge::getCharge('nid-auto');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Print 17 Digit Without Sign',$this->user->id);
           $encrypted = json_decode($response,true);
           $encrypted['expire_time'] = strtotime("+5 min"); 
           $token = encrypt(json_encode($encrypted));
           Session::put('nid_token',$token);
           return redirect( route('user.nid-print') );
        } 
         else {
          	return back()->withInput($request->input())->withErrors(['msg' => 'Data not found or data structure changed']);
        }
        
        return back();
    }
    
    
     public function nid_manual(){
        $data['title'] = 'Nid Manual';
        $data['user'] = $this->user;
        return view('user.nid.create', $data);
    }
    public function nid_manual_post(Request $request){
        
        $messages = [
          'district.required' => 'The birthplace field is required',
          'voter_area.required'    => 'The pin number field is required',
          'present_addr.required'    => 'The full address field is required',
        ];

         $this->validate($request,[
        'photo'  => 'required',
        //'sign'  => 'required',
        'name_bn'  => 'required',
        'name_en'  => 'required',
        'nid_no' => 'required',
        'voter_area' => 'required',
        'fathers_name'  => 'required',
        'mothers_name'  => 'required',
        'district' => 'required',
        'dob' => 'required',
        'present_addr'  => 'required',
		], $messages);
		
		if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('nid-manual') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		
		
		
		   $fee = \App\Models\ServiceCharge::getCharge('nid-manual');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Print manual nid',$this->user->id);
           $encrypted = $request->except(['_token']);
           $encrypted['expire_time'] = strtotime("+5 min"); 
           $token = encrypt(json_encode($encrypted));
           Session::put('nid_token',$token);
           return redirect( route('user.nid-print') );
            
    }
    
    public function nid_print(Request $request){
           $token = Session::get('nid_token','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token);
           $data['data'] = $token;
           
           if ( isset($token->expire_time) && $token->expire_time >= time() ){
               return view('user.templates.nid-print',$data);
           } else {
               return 'Token expired or invalid';
           }
    }

    public function server_copy(){
        $data['user'] = $this->user;
        $data['history'] = \App\Models\NidData::where('user_id', $this->user->id)->orderBy('id', 'desc')->paginate(5);
        return view('user.server-copy', $data);
    }
    public function server_copy_post(Request $request){
         $this->validate($request,[
        'nid' => 'required',
        'dob' => 'required'
		]);
		
		if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('server-copy') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		
		$maxAttempts = 2;
		$response = 'failed';
		$apiKey = 'YDPSXyY3mqyxmMOFPDn1rgM1if5aQFf7Q5j7eZrhpi67Ya4u4vRMz7lNWoVFqhp0';
		for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
		    $url = 'https://api.e-serviceportal.com/api/v1/sign-to-server?key='.$apiKey.'&nid='.$request->nid.'&dob='.date('Y-m-d',strtotime($request->dob));
		    $response = send_get_request($url);
		    if ($response != 'failed') {
		        break;
		    }
		    if ($attempt < $maxAttempts) {
		        usleep(500000);
		    }
		}

		if( $response == 'failed' ) {
		    return $this->captcha($request,route('user.server-copy'));
		}


		$result = json_decode($response);
		if ( !blank($result) && isset($result->status) && $result->status == 'success' && isset($result->data)) {
		   $data = $result->data;
		   $fee = \App\Models\ServiceCharge::getCharge('server-copy');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Created server copy',$this->user->id);
		
		 		 // Use voter_no from API response
		 $voterNo = $data->voter_no ?? "";
$pin = $data->pin ?? "";

$encrypted = [
		     'nid_no' => $data->nid ?? $request->nid,
		     'name_bn' => $data->name_bn,
		     'name_en' => $data->name_en,
		     'fathers_name' => $data->father,
		     'mothers_name' => $data->mother,
		     'gender' => $data->gender,
		     'religion' => $data->religion,
		     'dob' => $data->dob,
		     'voter_area' => $data->voter_area,
             'voter_no' => $voterNo,
             'pin' => $pin,
		     'permanent_addr' => $data->permanent_address,
		     'present_addr' => $data->present_address,
		     'photo' => $data->photo,
             'district' => $data->birth_place,
		     'type' => $request->type,
		     'expire_time' => strtotime('+5 min')
		 ];
		 $token = encrypt(json_encode($encrypted));
		 // Store the data in the database first
		 $nidData = new \App\Models\NidData();
                $nidData->user_id = $this->user->id;
                $nidData->nid_no = $data->nid ?? $request->nid;
                $nidData->dob = $data->dob;
                $nidData->name_bn = $data->name_bn;
                $nidData->name_en = $data->name_en;
                $nidData->voter_area = $data->voter_area;
                $nidData->voter_no = $voterNo;
                $nidData->pin = $pin;
                $nidData->fathers_name = $data->father;
                $nidData->mothers_name = $data->mother;
                $nidData->gender = $data->gender;
                $nidData->religion = $data->religion;
                $nidData->permanent_addr = $data->permanent_address;
                $nidData->present_addr = $data->present_address;
                $nidData->photo = $data->photo;
                $nidData->district = $data->birth_place;
                $nidData->expire_time = strtotime('+5 min');
                $nidData->save();
                // Include ID in token for download link construction
                $encrypted['id'] = $nidData->id;
                $token = encrypt(json_encode($encrypted));
                Session::put('server_copy_token',$token);
		 return redirect( route('user.server-copy') );
		    
		    
		    
		    
		} else {
          	return back()->withInput($request->input())->withErrors(['msg' => 'Data not found or data structure changed']);
        }
        
        return back();

	
    }
    
    public function server_copy_view(Request $request){
           $templateType = $request->type ?? 'default';
           
           $renderView = function($dataObj) use ($templateType) {
               if ($templateType == 'default') {
                   $data['data'] = $dataObj;
                   return view('user.templates.server-copy', $data);
               }
               $photoUrl = $dataObj->photo ?? '';
               // Convert base64 photo to temporary file for v1/v2/v3 templates
               if ($photoUrl && strpos($photoUrl, 'data:') === 0) {
                   try {
                       $ext = 'jpg';
                       if (preg_match('/^data:image\/(\w+);base64,/', $photoUrl, $m)) {
                           $ext = $m[1] == 'jpeg' ? 'jpg' : $m[1];
                       }
                       $base64Data = substr($photoUrl, strpos($photoUrl, ',') + 1);
                       $base64Data = str_replace(' ', '+', $base64Data);
                       $imgData = base64_decode($base64Data);
                       if ($imgData !== false) {
                           $fileName = 'temp_' . uniqid() . '.' . $ext;
                           $filePath = public_path('storage/photos/' . $fileName);
                           file_put_contents($filePath, $imgData);
                           // Schedule cleanup after response
                           $GLOBALS['_temp_photos'][] = $filePath;
                           $photoUrl = 'storage/photos/' . $fileName;
                       }
                   } catch (Exception $e) {
                       // Fall through to original photoUrl if conversion fails
                   }
               }
               $viewData = [
                   'nidNumber' => $dataObj->nid_no ?? ($dataObj->nid ?? ''),
                   'banglaName' => $dataObj->name_bn ?? '',
                   'englishName' => $dataObj->name_en ?? '',
                   'fatherName' => $dataObj->fathers_name ?? '',
                   'motherName' => $dataObj->mothers_name ?? '',
                   'spouse_name' => $dataObj->spouse ?? '',
                   'dateOfBirth' => $dataObj->dob ?? '',
                   'nid' => $dataObj,
                   'religion' => $dataObj->religion ?? '',
                   'bloodGroup' => $dataObj->blood_grp ?? '',
                   'birthPlace' => $dataObj->district ?? ($dataObj->birth_place ?? ''),
                   'education' => 'αªñαªÑαºìαª» αª¿αª╛αªç',
                   'occupation' => $dataObj->occupation ?? '',
                   'vote_center' => $dataObj->voter_area ?? '',
                   'voter_no' => $dataObj->voter_no ?? '',
                   'form_no' => 'NIDFN' . mt_rand(100000000, 999999999),
                   'pin' => $dataObj->pin ?? $dataObj->nid_no ?? ($dataObj->nid ?? ''),
                   'present_address' => $dataObj->present_addr ?? ($dataObj->present_address ?? ''),
                   'address' => $dataObj->permanent_addr ?? ($dataObj->permanent_address ?? ''),
                   'photo' => $photoUrl,
               ];
               $viewHtml = view('user.nidcard.' . $templateType, $viewData)->render();
               if ($templateType != 'default' && request()->has('download')) {
                   $response = response($viewHtml);
                   $response->header('Content-Type', 'text/html; charset=utf-8');
                   $response->header('Content-Disposition', 'attachment; filename="nid-card-' . $templateType . '.html"');
                   return $response;
               }
               return response($viewHtml);

           };
           
           if ($request->has('id')) {
               $nidData = \App\Models\NidData::find($request->id);
               if (!$nidData) {
                   return 'Data not found';
               }
               return $renderView($nidData);
           }
           $token = Session::get('server_copy_token','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token);
           $data['data'] = $token;
           
           if ( isset($token->expire_time) && $token->expire_time >= time() ){
               if ( $token->type == 'old' ){
                  return view('user.templates.server-copy-old',$data);
               }
               return $renderView($token);
           } else {
               return 'Token expired or invalid';
           }
    }
    
    private function captcha($request,$rurl){
        $url = get_main_api_domain().'/nid-new/get_captcha.php';
		$response = send_get_request($url);
		$data = json_decode($response);
		if ( isset($data->captcha) && !blank($data->captcha) ){
		  Session::put('_robot_cp',$data->captcha);
		  Session::put('_robot_cp_redirect',$rurl);
		  return redirect( route('user.verify-robot') );
		}
        return back()->withInput($request->input())->withErrors(['msg' => 'Api error please try again']);
    }
    
    public function verify_robot(){
        $cp = Session::get('_robot_cp','');
        $url = Session::get('_robot_cp_redirect','');
        if ( blank($cp) || blank($url) ){
            abort(403);
        }
        $data['user'] = $this->user;
        $data['cp'] = $cp;
        return view('user.captcha', $data);
    }
    public function verify_robot_post(Request $request){
        $cp = Session::get('_robot_cp','');
        $r_url = Session::get('_robot_cp_redirect','');
        if ( blank($cp) || blank($r_url) ){
            abort(403);
        }
        
         $this->validate($request,[
        'captcha' => 'required',
		]);
		
		$url = get_main_api_domain().'/nid-new/captcha_api.php?cp='.$request->captcha;
		$response = send_get_request($url);
		$data = json_decode($response);
		if ( isset($data->Code) && $data->Code == '200' && isset($data->Message) && $data->Message == 'OK' ){
		    Session::forget('_robot_cp');
            Session::forget('_robot_cp_redirect');
		    return redirect($r_url);
		}
		
		return back()->withInput($request->input())->withErrors(['msg' => 'Invalid Captcha']);
    }
    
     public function verify_robot_refresh(Request $request){
        $cp = Session::get('_robot_cp','');
        $r_url = Session::get('_robot_cp_redirect','');
        if ( blank($cp) || blank($r_url) ){
            abort(403);
        }
        $url = get_main_api_domain().'/nid-new/get_captcha.php';
		$response = send_get_request($url);
		$data = json_decode($response);
		if ( isset($data->captcha) && !blank($data->captcha) ){
		  Session::put('_robot_cp',$data->captcha);
		  return $data->captcha;
		}
        return 'failed';
     }
     
    public function old_birth(){
        $data['user'] = $this->user;
        $data['charge'] = \App\Models\ServiceCharge::getCharge('old-birth');
        $editSession = \Illuminate\Support\Facades\Session::get('old-birth-edit');
        if ($editSession) {
            try {
                $decrypted = decrypt($editSession);
                $editData = json_decode($decrypted, true);
                if (isset($editData['expire_time'])) unset($editData['expire_time']);
                request()->session()->flashInput($editData);
            } catch (\Exception $e) {}
        }
        return view('user.old-birth', $data);
    }
    public function old_birth_bn_post(Request $request){
         $this->validate($request,[
        'name' => 'required',
        'fatherName' => 'required',
        'motherName' => 'required',
        'brNo' => 'required'
		]);
		
		if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('old-birth') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		
		 $fee = \App\Models\ServiceCharge::getCharge('old-birth');
		 $this->user->balance = $this->user->balance - $fee;
		 $this->user->save();
		 create_transaction($fee,'-','Created old birth ( Bangla ) ',$this->user->id);
		 $encrypted = $request->except(['_token']);
         $encrypted['expire_time'] = strtotime("+5 min"); 
         $token = encrypt(json_encode($encrypted));
         Session::put('old-birth-bn',$token);
         Session::put('old-birth-edit', $encrypted);
         return redirect( route('user.old-birth-view-bn') );
    }
    public function old_birth_view_bn(){
        $token = Session::get('old-birth-bn','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token,true);
           $data['data'] = $token;
           
           if ( isset($token['expire_time']) && $token['expire_time'] >= time() ){
              return view('user.templates.old-birth-bn', $data);
           } else {
               return 'Token expired or invalid';
           }
    }
    public function old_birth_en_post(Request $request){
        $this->validate($request,[
        'name' => 'required',
        'fatherName' => 'required',
        'motherName' => 'required',
        'brNo' => 'required'
		]);
		
		if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('old-birth') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		 
		 $fee = \App\Models\ServiceCharge::getCharge('old-birth');
		 $this->user->balance = $this->user->balance - $fee;
		 $this->user->save();
		 create_transaction($fee,'-','Created old birth ( English ) ',$this->user->id);
		 $encrypted = $request->except(['_token']);
         $encrypted['expire_time'] = strtotime("+5 min"); 
         $token = encrypt(json_encode($encrypted));
         Session::put('old-birth-en',$token);
         Session::put('old-birth-edit', $encrypted);
         return redirect( route('user.old-birth-view-en') );
    }
    public function old_birth_view_en(){
           $token = Session::get('old-birth-en','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token,true);
           $data['data'] = $token;
           
           if ( isset($token['expire_time']) && $token['expire_time'] >= time() ){
              return view('user.templates.old-birth-en', $data);
           } else {
               return 'Token expired or invalid';
           }
    }

    public function new_birth(){
        $data['user'] = $this->user;
        return view('user.new-birth', $data);
    }
    public function new_birth_post(Request $request){
         $this->validate($request,[
        'brn' => 'required',
        'name_bangla' => 'required',
        'name_english' => 'required',
		]);
        if ( $this->user->balance < \App\Models\ServiceCharge::getCharge('new-birth') ){
		    return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
		}
		 
		 $fee = \App\Models\ServiceCharge::getCharge('new-birth');
		 $this->user->balance = $this->user->balance - $fee;
		 $this->user->save();
		 create_transaction($fee,'-','Created Death Certificate ',$this->user->id);
		 $encrypted = $request->except(['_token']);
         $encrypted['expire_time'] = strtotime("+5 min"); 
         $token = encrypt(json_encode($encrypted));
         Session::put('new-birth',$token);
         return redirect( route('user.new-birth-view') );
    }
    public function new_birth_api(Request $request){
        
         $this->validate($request,[
        'ubrn' => 'required',
        'dob' => 'required'
		]);
    	$url = get_main_api_domain().'/birth.php?ubrn='.$request->ubrn.'&dob='.date('Y-m-d',strtotime($request->dob));
		$response = send_get_request($url);
		if( $response == 'failed' ) {
		   $data['success'] = false;
           $data['msg'] = 'Api error please try again';
           return $data;
        }
        $data = json_decode($response);
        return response()->json($data);
    }
    public function new_birth_view(){
          $token = Session::get('new-birth','');
           try {
               $token = decrypt($token);
           } catch(DecryptException $e){
               return $e->getMessage();
           }
           $token = json_decode($token,true);
           $data['data'] = $token;
           
           if ( isset($token['expire_time']) && $token['expire_time'] >= time() ){
              return view('user.templates.new-birth', $data);
           } else {
               return 'Token expired or invalid';
           }
    }
    
public function tin()
    {
        $data['user'] = $this->user;
        return view('user.tin', $data);
    }

    // Handle TIN form submission
    public function tin_post(Request $request)
    {
        $this->validate($request, [
            'tin' => 'required',
        ]);

        $tinFee = \App\Models\ServiceCharge::getCharge('tin');

        // Fetch HTML content from the API
        $url = 'https://server.hostmdn.biz/tin.php?tin=' . urlencode($request->tin);
        $htmlContent = $this->send_get_request($url);

        if (empty($htmlContent)) {
            return back()->withErrors(['msg' => 'No HTML content returned from API']);
        }

        // Check for specific error messages in HTML content
        if (strpos($htmlContent, 'An unexpected error has occurred.') !== false ||
            strpos($htmlContent, 'Please Login again or contact the system administrator.') !== false ||
            strpos($htmlContent, 'Exception: Non-static method requires a target.') !== false) {
            return back()->withErrors(['msg' => 'The TIN application could not be processed. Please try again or contact support.']);
        }

        // Check if user balance is sufficient
        if ($this->user->balance < $tinFee) {
            return back()->withInput($request->input())->withErrors(['msg' => 'Insufficient balance']);
        }

        // Check if user has already been charged
        if (!session()->has('tinCertificate')) {
            // Deduct the fee from user's balance and create a transaction
            $this->user->balance -= $tinFee;
            $this->user->save();
            create_transaction($tinFee, '-', 'Print TIN Certificate', $this->user->id);

            // Save HTML content, expiration time, and a flag to session
            $sessionData = [
                'htmlContent' => $htmlContent,
                'expire_time' => strtotime("+5 minutes"), // Set expiration time for 5 minutes from now
                'charged' => true // Flag indicating that the user has been charged
            ];
            session(['tinCertificate' => $sessionData]);
        }

        return view('user.tin_view', ['htmlContent' => $htmlContent]);
    }

    // Download TIN certificate as HTML
    public function download_html()
    {
        $sessionData = session('tinCertificate');

        if (empty($sessionData) || $sessionData['expire_time'] < time()) {
            return redirect()->route('tin')->withErrors(['msg' => 'No HTML content available to download']);
        }

        $filename = 'TIN_Certificate.html';

        return response($sessionData['htmlContent'])
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // View TIN certificate
    public function tin_view()
    {
        $sessionData = session('tinCertificate');

        // Redirect if session data is missing or expired
        if (empty($sessionData) || $sessionData['expire_time'] < time()) {
            return redirect()->route('tin')->withErrors(['msg' => 'Session expired or no HTML content available to view']);
        }

        return view('user.tin_view', ['htmlContent' => $sessionData['htmlContent']]);
    }
protected function send_get_request($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'failed';
    }

    curl_close($ch);
    return $response;
} 
    
    public function profile()
    {
        $data['user'] = $this->user;
        return view('user.profile', $data);
    }
    
    public function updateProfile(Request $request)
{
        $user = $this->user;

        $this->validate($request, [
            'name' => 'required|string|max:91',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'gender' => 'required|in:Male,Female,Other',
            'nid' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'telegram_id' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->nid = $request->nid;
        $user->dob = $request->dob;
        $user->telegram_id = $request->telegram_id;
        $user->save();

        session()->flash('success', 'Profile Updated Successfully');
        return back();
}

    
     public function updatePassword()
    {
        $data['user'] = $this->user;
        return view('user.password_edit', $data);
    }
    
     public function updatePassword_p(Request $request){
        $user = $this->user;
        $this->validate($request,[
        'current_password' => 'required',
        'new_password' => 'required|string|min:6',
        'new_password_confirm' => 'required|same:new_password',
		]);
		
		if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['msg' => 'Old Password Did Not Match']);
        }
		
		
        $user->password = Hash::make($request->new_password);
        $user->save();
        session()->flash('success', 'Password Changed');
        return back();
    }
    
 public function applications()
    {
        $data['user'] = $this->user;

        
        $data['application_count'] = Application::where('user_id', $this->user->id)->count();
 $data['sign_fee'] = \App\Models\ServiceCharge::getCharge('sign'); 
    $data['bio_fee'] = \App\Models\ServiceCharge::getCharge('bio');  
        $data['applications'] = Application::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.applications', $data);
    }

   
public function new_application(Request $request)
    {
        $data['user'] = $this->user;
        $data['fee'] = \App\Models\ServiceCharge::getCharge('sign'); 
        return view('user.new-application', $data);
    }

    public function new_application_p(Request $request)
    { 
        $currentDateTime = Carbon::now('Asia/Dhaka'); 
        $currentDay = $currentDateTime->dayOfWeek;
        $currentHour = $currentDateTime->hour;

        
        if ($currentDay == Carbon::FRIDAY || ($currentHour < 9 || $currentHour >= 21)) {
            return back()->withErrors(['msg' => 'αªåαºçαªªαª¿ αªÅαªûαª¿ αª¼αºìαªº αª¢αºç, αª╢αºüαªòαºìαª¼αª╛αª░ αª¢αºüαªƒαª┐αª░ αªªαª¿ αªàαªÑαª¼αª╛ αªòαª╛αª£αºç αª╕αª«αºƒ αª╕αª╛αª▓ αº»αªƒαª╛ αªÑαºçαªòαºç αª╛αªñ αº»αª╛αª░ αª«αªºαºìαª» αª¿αºƒ αªàαª¿αºüαªùαºìαª░αª╣ αªòαª░ αª¬αª░αºç αªåαª¼αª╛αª░ αºçαºìαªƒαª╛ αªòαª░αºüαª¿αÑñ']);
        }
        
        $this->validate($request, [
            'nid' => 'required',
            'name' => 'required',
            'type' => 'required',
        ]);

        $user = $this->user;
        $sign_fee = \App\Models\ServiceCharge::getCharge('sign'); // Fetching the sign application fee from settings

        if ($user->balance < $sign_fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        // Create the application
        $app = new Application();
        $app->user_id = $user->id;
        $app->nid = $request->nid;
        $app->name = $request->name;
        $app->type = $request->type;
        $app->save();

        $fee = \App\Models\ServiceCharge::getCharge('sign');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Order Sign Copy',$this->user->id);
        return back()->with('success', 'Application Submitted');
    }

    public function new_application_advanced(Request $request)
    {
        $data['user'] = $this->user;
        return view('user.new-application-advanced', $data);
    }

    public function new_application_advanced_p(Request $request)
    {
        // Check if today is Friday or if the current time is outside the allowed hours (9 AM to 9 PM)
        $currentDateTime = Carbon::now('Asia/Dhaka'); // Set timezone to Bangladesh
        $currentDay = $currentDateTime->dayOfWeek;
        $currentHour = $currentDateTime->hour;

        // If it's Friday (full-day holiday) or not within allowed hours on other days
        if ($currentDay == Carbon::FRIDAY || ($currentHour < 9 || $currentHour >= 21)) {
            return back()->withErrors(['msg' => 'αªåαª¼αºçαªªαª¿ αªûαª¿ αª¼αª¿αºìαªº αªåαª¢αºç, αª╢αºüαªòαºìαª░αª¼αª╛αª░ αª¢αºüαª┐αª░ αªªαª┐αª¿ αªàαªÑαª¼αª╛ αªòαª╛αª£αºçαª░ αª╕αª«αºƒ αª╕αª╛αª▓ αº»αªƒαª╛ αªÑαºçαªòαºç αª╛ αº»αªƒαª╛αª░ αª«αªºαºìαºç αª¿αÑñ αªàαª¿αºüαªùαºìαª╣ αªòαª░ αª¬αª░αºç αªåαª¼αª╛αª░ αªÜαºçαª╖αºìαªƒαª╛ αªòαª░αºüαª¿αÑñ']);
        }

        // Validation for the required inputs only
        $this->validate($request, [
            'nid' => 'required|string',
            'name' => 'required|string|max:15',
        ]);

        $user = $this->user;
        $bio_fee = \App\Models\ServiceCharge::getCharge('bio'); // Fetching the biometric application fee from settings

        if ($user->balance < $bio_fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        // Handle file upload
        $extra = $request->except(['_token', 'photo']);
        $file_data = $request->file('photo');

        if (!blank($file_data)) {
            $hash = md5(time());
            $file_name = $hash . '-photo.' . $file_data->extension();
            $file_data->move('storage/photos', $file_name);
            $extra['photo'] = $file_name;
        }

        // Create the application
        $app = new Application();
        $app->user_id = $user->id;
        $app->type = 'Biometric';
        $app->nid = $request->nid;
        $app->name = $request->name;
        $app->save();

        
        $fee = \App\Models\ServiceCharge::getCharge('bio');
		   $this->user->balance = $this->user->balance - $fee;
		   $this->user->save();
		   create_transaction($fee,'-','Order Biometric',$this->user->id);
        

        return back()->with('success', 'Biometric Successfully Ordered');
    }
    
    public function deleteApplication($id)
{
    // Find the application by ID, fail if not found
    $application = Application::findOrFail($id);

    // Check if the application belongs to the user and is eligible for deletion (status == '0')
    if ($application->user_id == $this->user->id && $application->status == '0') {
        // Get the user associated with the application
        $user = $application->user;

        // Refund the appropriate fee based on the application type
        if ($application->type == 'Biometric') {
            $bio_fee = \App\Models\ServiceCharge::getCharge('bio'); // Fetch biometric fee from settings
            $user->balance += $bio_fee; // Refund the biometric fee
            $user->save(); // Save updated user balance
            // Create a transaction for deleting the biometric application
            $this->create_transaction($bio_fee, '+', 'Order Deleted by User: Biometric Application', $user->id);
        } else {
            $sign_fee = \App\Models\ServiceCharge::getCharge('sign'); // Fetch sign fee from settings
            $user->balance += $sign_fee; // Refund the sign fee
            $user->save(); // Save updated user balance
            // Create a transaction for deleting the sign application
            $this->create_transaction($sign_fee, '+', 'Order Deleted by User: Sign Application', $user->id);
        }

        // Delete the application
        $application->delete();

        // Redirect with success message
        return redirect()->route('user.applications')->with('success', 'Application Deleted Successfully');
    }

    // If the application doesn't belong to the user or cannot be deleted, return with error
    return redirect()->route('user.applications')->withErrors(['msg' => 'Unable to delete the application']);
}

private function create_transaction($amount, $type, $description, $user_id)
{
    $transaction = new Transaction();
    $transaction->user_id = $user_id;
    $transaction->amount = $amount;
    $transaction->type = $type;
    $transaction->description = $description;
    $transaction->save();
}

 


    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
    
     protected function guard()
    {
        return \Illuminate\Support\Facades\Auth::guard();
    }
    
}
