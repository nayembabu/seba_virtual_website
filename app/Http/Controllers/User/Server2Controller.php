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
use App\Models\server2;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class server2Controller extends Controller
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
        $data['objects'] = server2::where('user_id',$this->user->id)->orderBy('created_at','desc')->paginate(20);
        $data['title'] = 'server2 Certificates';
        return view('user.server2.index', $data);
    }

     public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create server2';
        return view('user.server2.create', $data);
    }
    
     public function store( Request $request ){
        $this->validate($request,[
        'name_bangla' => 'required',
		]);
		
		
        
		
		$fee = \App\Models\ServiceCharge::getCharge('new-birth');
        
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        
        
        $this->user->balance = $this->user->balance - $fee;
		$this->user->save();
		create_transaction($fee,'-','New version Birth Certificate',$this->user->id);
		
        $user = $this->user;
        $server2 = new server2();
        $server2->user_id = $user->id;
       $server2->address1 = $request->address1;
        $server2->address2 = $request->address2;
        $server2->brn = $request->brn;
        $server2->father_bangla = $request->father_bangla;
        $server2->father_english = $request->father_english;
        $server2->dor = $request->dor;
        $server2->doi = $request->doi;
        $server2->dob = $request->dob;
        $server2->sex = $request->sex;
        $server2->name_bangla = $request->name_bangla;
        $server2->name_english = $request->name_english;
        $server2->mother_bangla = $request->mother_bangla;
        $server2->mother_english = $request->mother_english;
        $server2->pob_bangla = $request->pob_bangla;
        $server2->pob_english = $request->pob_english;
        $server2->permanent_bangla = $request->permanent_bangla;
        $server2->permanent_english = $request->permanent_english;
        $server2->father_n_bangla = $request->father_n_bangla;
        $server2->father_n_english = $request->father_n_english;
        $server2->mother_n_bangla = $request->mother_n_bangla;
        $server2->mother_n_english = $request->mother_n_english;

        
        
        $server2->save();
        return back()->with('success', 'Trde lisecence Created');
    }
    
     public function edit($id)
    {
        $data['server2'] = server2::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit server2';
        return view('user.server2.update', $data);
    }
    
    public function update($id, Request $request ){
        $server2 = server2::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $this->validate($request,[
        'brn' => 'required',
		]);
		
	
        $user = $this->user;
        
        
        $server2->address1 = $request->address1;
        $server2->address2 = $request->address2;
        $server2->brn = $request->brn;
        $server2->father_bangla = $request->father_bangla;
        $server2->father_english = $request->father_english;
        $server2->dor = $request->dor;
        $server2->doi = $request->doi;
        $server2->dob = $request->dob;
        $server2->sex = $request->sex;
        $server2->name_bangla = $request->name_bangla;
        $server2->name_english = $request->name_english;
        $server2->mother_bangla = $request->mother_bangla;
        $server2->mother_english = $request->mother_english;
        $server2->pob_bangla = $request->pob_bangla;
        $server2->pob_english = $request->pob_english;
        $server2->permanent_bangla = $request->permanent_bangla;
        $server2->permanent_english = $request->permanent_english;
        $server2->father_n_bangla = $request->father_n_bangla;
        $server2->father_n_english = $request->father_n_english;
        $server2->mother_n_bangla = $request->mother_n_bangla;
        $server2->mother_n_english = $request->mother_n_english;
        
        
        if ( !blank($request->file('photo')) ){
		    $hash = md5($request->name.'-'.time());
		    $photo =  $hash.'-server2.'.$request->file('photo')->extension();
            $request->file('photo')->move('storage/uploads',$photo);
            $server2->photo = $photo;
        }
        
        $server2->save();
        return back()->with('success', 'server2 Certificate Updated');
    }
    
    public function delete($id){
        $server2 = server2::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $server2->delete();
        return back()->with('success', 'server2 Certificate Deleted Successfully');
    }
    
     public function print($id){
        $data['data'] = server2::where('id',$id)->where('user_id',$this->user->id)->firstOrFail()->toArray();
        return view('user.server2.print', $data);
    }
    
    public function verify($id){
        $data['data'] = server2::where('id',$id)->first();
        if ( !blank($data['data']) ){
            $data['data'] = $data['data']->toArray();
            return view('user.server2.verify', $data);
        }
        return 'invalid';
    }
    
    
 
}
