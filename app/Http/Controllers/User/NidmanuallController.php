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
use App\Models\nidmanuall;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class nidmanuallController extends Controller
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
        $data['objects'] = nidmanuall::where('user_id',$this->user->id)->orderBy('created_at','desc')->paginate(20);
        $data['title'] = 'nidmanuall Certificates';
        return view('user.nidmanuall.index', $data);
    }

     public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create nidmanuall';
        return view('user.nidmanuall.create', $data);
    }
    
     public function store( Request $request ){
        
        
        
		
		$fee = \App\Models\ServiceCharge::getCharge('nid-manual');
        
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        
        
        $this->user->balance = $this->user->balance - $fee;
		$this->user->save();
		create_transaction($fee,'-','Created Uttoradikar certificate',$this->user->id);
		
        $user = $this->user;
        $nidmanuall = new nidmanuall();
        $nidmanuall->sl_no = $user->sl_no;
        $nidmanuall->office_name = $request->office_name;
        $nidmanuall->upazila_name = $request->upazila_name;
        $nidmanuall->zila_name = $request->zila_name;
        $nidmanuall->a_name = $request->a_name;
        $nidmanuall->a_fathers = $request->a_fathers;
        $nidmanuall->a_wife_husband = $request->a_wife_husband;
        $nidmanuall->a_village = $request->a_village;
        $nidmanuall->publish_date = $request->publish_date;
        $nidmanuall->name = $request->name;
        $nidmanuall->father_name = $request->father_name;
        $nidmanuall->b_d_date = $request->b_d_date;
        $nidmanuall->b_d_no = $request->b_d_no;
        $nidmanuall->relation = $request->relation;
        $nidmanuall->comment = $request->comment;
              
        
        $nidmanuall->save();
        return back()->with('success', 'Uttoradikar Certificate Created');
    }
    
     public function edit($id)
    {
        $data['nidmanuall'] = nidmanuall::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit nidmanuall';
        return view('user.nidmanuall.update', $data);
    }
    
    public function update($id, Request $request ){
        $nidmanuall = nidmanuall::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $this->validate($request,[
        'nameEnglish' => 'required',
		]);
		
		
        $user = $this->user;
        
         $nidmanuall = new nidmanuall();
         $nidmanuall->sl_no = $user->sl_no;
        $nidmanuall->office_name = $request->office_name;
        $nidmanuall->upazila_name = $request->upazila_name;
        $nidmanuall->zila_name = $request->zila_name;
        $nidmanuall->a_name = $request->a_name;
        $nidmanuall->a_fathers = $request->a_fathers;
        $nidmanuall->a_wife_husband = $request->a_wife_husband;
        $nidmanuall->a_village = $request->a_village;
        $nidmanuall->publish_date = $request->publish_date;
        $nidmanuall->name = $request->name;
        $nidmanuall->father_name = $request->father_name;
        $nidmanuall->b_d_date = $request->b_d_date;
        $nidmanuall->b_d_no = $request->b_d_no;
        $nidmanuall->relation = $request->relation;
        $nidmanuall->comment = $request->comment;
        
        $nidmanuall->save();
        return back()->with('success', 'Uttoradikar Certificate Updated');
    }
    
    public function delete($id){
        $nidmanuall = nidmanuall::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $nidmanuall->delete();
        return back()->with('success', 'Uttoradikar Certificate Deleted Successfully');
    }
    
     public function print($id){
        $data['data'] = nidmanuall::where('id',$id)->where('user_id',$this->user->id)->firstOrFail()->toArray();
        return view('user.nidmanuall.print', $data);
    }
    
    public function verify($id){
        $data['data'] = nidmanuall::where('id',$id)->first();
        if ( !blank($data['data']) ){
            $data['data'] = $data['data']->toArray();
            return view('user.nidmanuall.verify', $data);
        }
        return 'invalid';
    }
    
    
 
}
