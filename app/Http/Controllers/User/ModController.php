<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Configure;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Facades\App\Services\BasicService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ModController extends Controller
{
    use Upload, Notify, AuthenticatesUsers;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            if ( $this->user->role !== '1' ){
                abort(403);
            }
            return $next($request);
        });
    }

      public function users(Request $request){
        $users = User::where('role',0)->where('added_by',$this->user->id)->orderBy('created_at','desc');
        $data['users'] = $users->paginate(20);
        $data['request'] = $request;
        return view('user.mod.users', $data);
    }
    
    public function user_add(){
        return view('user.mod.add-user');
    }
    public function user_store(Request $request){
        
		$fee = \App\Models\ServiceCharge::getCharge('mod-user-add');
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
       
         $this->validate($request,[
        'name' => 'required|string|max:91',
        'gender' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|min:6',
        'phone' => 'required|unique:users,phone'
		]);
            $u = new User();
            $u->name = $request->name;
            $u->email = $request->email;
            $u->phone = $request->phone;
            $u->gender = $request->gender;
            $u->dob = $request->dob;
            $u->nid = $request->nid;
            $u->added_by = $this->user->id;
            $u->status = 1;
            $u->password = Hash::make($request->password);
            $u->save();
            
        $this->user->balance = $this->user->balance - $fee;
		$this->user->save();
		create_transaction($fee,'-','Created a new user',$this->user->id);
        
        session()->flash('success', ' User Successfully Added');
        return back();
    }
    
}