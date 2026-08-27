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
use App\Models\Police;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class PoliceController extends Controller
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
        $data['objects'] = Police::where('user_id',$this->user->id)->orderBy('created_at','desc')->get();
        $data['title'] = 'Police Clearance Certificates';
        return view('user.police.index', $data);
    }

     public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create Police Clearance';
        return view('user.police.create', $data);
    }
    
     public function store( Request $request ){
        $this->validate($request,[
        'police_reg' => 'required',
		]);
		
		
        $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'police')->first();
        
        if ( $this->user->balance < $serviceCharge->amount){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        
        $this->user->balance = $this->user->balance - $serviceCharge->amount;
		$this->user->save();
		create_transaction($serviceCharge->amount,'-','Created Police Clearance certificate',$this->user->id);
		
        $user = $this->user;
        $police = new Police();
        $police->user_id = $user->id;
        $police->police_reg = $request->police_reg;
        $police->police_date = date('d-M-Y');
        $police->designation = $request->designation;
        $police->applicant_name = $request->applicant_name;
        $police->what_of = $request->what_of;
        $police->father_name = $request->father_name;
        $police->village_area = $request->village_area;
        $police->post_office = $request->post_office;
        $police->police_station = $request->police_station;
        $police->district = $request->district;
        $police->document_type = $request->document_type;
        $police->passport_no = $request->passport_no;
        $police->certificate_date = date('d-M-Y',strtotime($request->certificate_date));
        $police->status = $request->status;
        $police->issued_location = $request->issued_location;
        $police->issued_date = $request->issued_date;
        $police->save();
        return redirect()->route('user.police.index')->with('success', 'পুলিশ ক্লিয়ারেন্স সার্টিফিকেট সফলভাবে তৈরি করা হয়েছে');
    }
    
     public function show($id)
    {
        $data['police'] = Police::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Show Police Clearance';
        return view('user.police.show', $data);
    }

    public function edit($id)
    {
        $data['police'] = Police::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit Police Clearance';
        return view('user.police.update', $data);
    }
    
    public function update($id, Request $request ){
        $police = Police::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $this->validate($request,[
        'police_reg' => 'required',
		]);
	
        $user = $this->user;
        
        $police->police_reg = $request->police_reg;
        $police->designation = $request->designation;
        $police->applicant_name = $request->applicant_name;
        $police->what_of = $request->what_of;
        $police->father_name = $request->father_name;
        $police->village_area = $request->village_area;
        $police->post_office = $request->post_office;
        $police->police_station = $request->police_station;
        $police->district = $request->district;
        $police->document_type = $request->document_type;
        $police->passport_no = $request->passport_no;
        $police->certificate_date = date('d-M-Y',strtotime($request->certificate_date));
        $police->status = $request->status;
        $police->issued_location = $request->issued_location;
        $police->issued_date = $request->issued_date;
        
        $police->save();
        return redirect()->route('user.police.index')->with('success', 'পুলিশ ক্লিয়ারেন্স সার্টিফিকেট সফলভাবে আপডেট করা হয়েছে');
    }
    
    public function delete($id){
        $police = Police::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $police->delete();
        return back()->with('success', 'Police Clearance Certificate Deleted Successfully');
    }
    
     public function print($id){
        $data['data'] = Police::where('id',$id)->where('user_id',$this->user->id)->firstOrFail()->toArray();
        return view('user.police.print', $data);
    }
    
public function verify(Request $request, $id = null)
{
    // Check if {id} is present in the route
    if ($id) {
        $data['data'] = Police::where('police_reg', $id)->first();
        if ($data['data']) {
            return view('user.police.verify', $data);
        }
        return 'Invalid Police Clearance Certificate';
    }

    // Check if 'p' query parameter exists
    $p = $request->query('p');
    $police_reg = null;

    if ($p) {
        $parts = explode('P50_TOKEN_ID:', $p);
        if (isset($parts[1])) {
            $police_reg = $parts[1];
        }
    }

    if ($police_reg) {
        $data['data'] = Police::where('police_reg', $police_reg)->first();
        if ($data['data']) {
            return view('user.police.verify', $data);
        }
    }
  if ($id) {
        $data['data'] = Police::where('id', $id)->first();
        if ($data['data']) {
            return view('user.police.verify', $data);
        }
    }

    return 'Invalid Police Clearance Certificate';
}

}