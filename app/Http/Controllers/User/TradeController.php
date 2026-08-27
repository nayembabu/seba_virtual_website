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
use App\Models\trade;
use App\Models\ServiceCharge;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class TradeController extends Controller
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
    }

    public function index()
    {
        $data['user'] = $this->user;
        $data['objects'] = trade::where('user_id',$this->user->id)->orderBy('created_at','desc')->get();
        $data['title'] = 'trade Certificates';
        return view('user.trade.index', $data);
    }

     public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create trade';
        return view('user.trade.create', $data);
    }
    
     public function store( Request $request ){
        try {
            $user = Auth::user();
            if (!$user) {
                \Log::error('User not authenticated');
                return back()->with('error', 'User authentication failed');
            }

            $serviceCharge = ServiceCharge::where('service_name', 'trade')->first();
            if (!$serviceCharge) {
                \Log::error('Trade service charge not found');
                return back()->with('error', 'Service charge configuration not found');
            }

            if ($user->balance < $serviceCharge->amount) {
                return back()->with(NotificationHelper::insufficientBalance($serviceCharge->amount, $user->balance));
            }

            $this->validate($request,[
                'malik_name' => 'required',
            ]);

            $user = $this->user;
        $trade = new trade();
        $trade->user_id = $user->id;
        $trade->trade_no = $request->trade_no;
        $trade->income_amount = $request->income_amount;
        $trade->malik_name = $request->malik_name;
        $trade->b_name = $request->b_name;
        $trade->father_name = $request->father_name;
        $trade->mother_name = $request->mother_name;
        $trade->nid_no = $request->nid_no;
        $trade->wife_name = $request->wife_name;
        $trade->malik_type = $request->malik_type;
        $trade->b_type = $request->b_type;
        $trade->bu_name = $request->bu_name;
        $trade->account_year = $request->account_year;
        $trade->address = $request->address;
        $trade->fee = $request->fee;
        $trade->ex_date = $request->ex_date;
        $trade->total_amount = $request->total_amount;
        $trade->qrCodeContainer = $request->qrCodeContainer;
        $trade->others_amount = $request->others_amount;
        $trade->charge_amount = $request->charge_amount;
        $trade->due_amount = $request->due_amount;
        $trade->permit_amount = $request->permit_amount;
        $trade->sine_amount = $request->sine_amount;
        $trade->fund_amount = $request->fund_amount;
        $trade->tax_amount = $request->tax_amount;
        $trade->cr_amount = $request->cr_amount;
        $trade->vat_amount = $request->vat_amount;
        $trade->p_address = $request->p_address;
        $trade->union_name = $request->union_name;
        $trade->union_address = $request->union_address;

        
        
        $trade->save();

            // Deduct the service charge from user's balance
            $user->balance -= $serviceCharge->amount;
            $user->save();

            // Create transaction record
            $user->transactions()->create([
                'amount' => -$serviceCharge->amount,
                'details' => 'Trade license service charge',
            ]);

            return redirect()->route('user.trade.index')->with(NotificationHelper::success('ট্রেড লাইসেন্স সফলভাবে তৈরি করা হয়েছে।'));
        } catch (\Exception $e) {
            \Log::error('Trade License Store Error: ' . $e->getMessage());
            return back()->with('error', 'ট্রেড লাইসেন্স তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }
    
     public function edit($id)
    {
        $data['trade'] = trade::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit trade';
        return view('user.trade.update', $data);
    }
    
    public function update($id, Request $request ){
        $trade = trade::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $this->validate($request,[
        'malik_name' => 'required',
		]);
		
		if (!preg_match("/^[a-zA-Z-' ]*$/", $request->malik_name)) {
           return back()->withErrors(['msg' => 'Only letters and white space allowed!']);
        }
        
       

        if (!isDate($request->ex_date)) {
             return back()->withErrors(['msg' => 'expair date is invalid format! ex: YYYY/MM/DD']);
        }
        $user = $this->user;
        
        
        $trade->trade_no = $request->trade_no;
        $trade->malik_name = $request->malik_name;
        $trade->b_name = $request->b_name;
        $trade->father_name = $request->father_name;
        $trade->mother_name = $request->mother_name;
        $trade->nid_no = $request->nid_no;
        $trade->wife_name = $request->wife_name;
        $trade->malik_type = $request->malik_type;
        $trade->b_type = $request->b_type;
        $trade->bu_name = $request->bu_name;
        $trade->account_year = $request->account_year;
        $trade->address = $request->address;
        $trade->fee = $request->fee;
        $trade->ex_date = $request->ex_date;
        $trade->total_amount = $request->total_amount;
        $trade->qrCodeContainer = $request->qrCodeContainer;
        $trade->others_amount = $request->others_amount;
        $trade->charge_amount = $request->charge_amount;
        $trade->due_amount = $request->due_amount;
        $trade->permit_amount = $request->permit_amount;
        $trade->sine_amount = $request->sine_amount;
        $trade->fund_amount = $request->fund_amount;
        $trade->tax_amount = $request->tax_amount;
        $trade->cr_amount = $request->cr_amount;
        $trade->vat_amount = $request->vat_amount;
        $trade->p_address = $request->p_address;
        $trade->union_name = $request->union_name;
        $trade->union_address = $request->union_address;
        
        if ( !blank($request->file('photo')) ){
		    $hash = md5($request->name.'-'.time());
		    $photo =  $hash.'-trade.'.$request->file('photo')->extension();
            $request->file('photo')->move('storage/uploads',$photo);
            $trade->photo = $photo;
        }
        
        $trade->save();
        return redirect()->route('user.trade.index')->with(NotificationHelper::success('ট্রেড লাইসেন্স সফলভাবে আপডেট করা হয়েছে।'));
    }
    
    public function delete($id){
        $trade = trade::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $trade->delete();
        return back()->with('success', 'trade Certificate Deleted Successfully');
    }
    
     public function print($id){
        $data['data'] = trade::where('id',$id)->where('user_id',$this->user->id)->firstOrFail()->toArray();
        return view('user.trade.print', $data);
    }
    
    public function verify($id){
        $data['data'] = trade::where('id',$id)->first();
        if ( !blank($data['data']) ){
            $data['data'] = $data['data']->toArray();
            return view('user.trade.verify', $data);
        }
        return 'invalid';
    }
    
    
 
}
