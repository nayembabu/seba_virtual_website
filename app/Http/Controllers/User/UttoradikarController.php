<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\Uttoradikar; // Ensure model name is correct
use Illuminate\Support\Facades\Validator;

class UttoradikarController extends Controller
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

    public function index()
    {
        $data['user'] = $this->user;
        $data['objects'] = Uttoradikar::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->paginate(20);
        $data['title'] = 'Uttoradikar  Certificates';
        return view('user.uttoradikar.index', $data);
    }

    public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create Uttoradikar Certificates';
        return view('user.uttoradikar.create', $data);
    }
public function store( Request $request ){
        $this->validate($request,[
        'death_certificates_id' => 'required',
		]);
		
		
        
		
		$fee = \App\Models\ServiceCharge::getCharge('uttoradikar');
        
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        
        
        $this->user->balance = $this->user->balance - $fee;
		$this->user->save();
		create_transaction($fee,'-','Created uttoradikar certificate',$this->user->id);
		
        $user = $this->user;
        $uttoradikar = new uttoradikar();
        
    $uttoradikar->user_id = $this->user->id;
    $uttoradikar->gender = $request->gender;
    $uttoradikar->life = $request->life;
    $uttoradikar->death_certificates_id = $request->death_certificates_id;
    $uttoradikar->dod = $request->dod;
    $uttoradikar->person_bn = $request->person_bn;
    $uttoradikar->guardian_bn = $request->guardian_bn;
    $uttoradikar->person_en = $request->person_en;
    $uttoradikar->guardian_en = $request->guardian_en;
    $uttoradikar->village = $request->village;
    $uttoradikar->upazila = $request->upazila;
    $uttoradikar->district = $request->district;
    $uttoradikar->name_bn = $request->name_bn;
    $uttoradikar->name_en = $request->name_en;
    $uttoradikar->Relatives = $request->Relatives;

        
        
        $uttoradikar->save();
        return back()->with('success', 'uttoradikar  Created');
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
        'death_certificates_id' => 'required',
		]);
		
		if (!preg_match("/^[a-zA-Z-' ]*$/", $request->death_certificates_id)) {
           return back()->withErrors(['msg' => 'Only letters and white space allowed!']);
        }
        
       

        if (!isDate($request->ex_date)) {
             return back()->withErrors(['msg' => 'expair date is invalid format! ex: YYYY/MM/DD']);
        }
        $user = $this->user;
        
        
    
    $uttoradikar->user_id = $this->user->id;
    $uttoradikar->gender = $request->gender;
    $uttoradikar->life = $request->life;
    $uttoradikar->death_certificates_id = $request->death_certificates_id;
    $uttoradikar->dod = $request->dod;
    $uttoradikar->person_bn = $request->person_bn;
    $uttoradikar->guardian_bn = $request->guardian_bn;
    $uttoradikar->person_en = $request->person_en;
    $uttoradikar->guardian_en = $request->guardian_en;
    $uttoradikar->village = $request->village;
    $uttoradikar->upazila = $request->upazila;
    $uttoradikar->district = $request->district;
    $uttoradikar->name_bn = $request->name_bn;
    $uttoradikar->name_en = $request->name_en;
    $uttoradikar->Relatives = $request->Relatives;
        
        if ( !blank($request->file('photo')) ){
		    $hash = md5($request->name.'-'.time());
		    $photo =  $hash.'-trade.'.$request->file('photo')->extension();
            $request->file('photo')->move('storage/uploads',$photo);
            $uttoradikar->photo = $photo;
        }
        
        $uttoradikar->save();
        return back()->with('success', 'trade Certificate Updated');
    }
    
 
     

    public function delete($id)
    {
        $uttoradikar = Uttoradikar::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
        $uttoradikar->delete();
        return back()->with('success', 'Uttoradikar Clearance Certificate Deleted Successfully');
    }

    public function print($id)
    {
        $data['data'] = Uttoradikar::where('id', $id)->where('user_id', $this->user->id)->firstOrFail()->toArray();
        return view('user.uttoradikar.print', $data);
    }

    public function verify($id)
    {
        $data['data'] = Uttoradikar::where('id', $id)->first();
        if (!blank($data['data'])) {
            $data['data'] = $data['data']->toArray();
            return view('user.uttoradikar.verify', $data);
        }
        return 'invalid';
    }
}
