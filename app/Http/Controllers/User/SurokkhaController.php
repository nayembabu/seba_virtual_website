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
use App\Models\Surokkha;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class SurokkhaController extends Controller
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
        $data['objects'] = Surokkha::where('user_id',$this->user->id)->orderBy('created_at','desc')->get();
        $data['title'] = 'Vaccine Certificates';
        return view('user.surokkha.index', $data);
    }

     public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create Vaccine Certificate';
        return view('user.surokkha.create', $data);
    }
    
     public function store( Request $request ){
        $this->validate($request,[
		]);
		
		
		$fee = \App\Models\ServiceCharge::getCharge('surokkha');
        
        if ( $this->user->balance < $fee){
             return back()->withErrors(['msg' => 'Insufficient balance']);
        }
        
        
        $this->user->balance = $this->user->balance - $fee;
		$this->user->save();
		create_transaction($fee,'-','Created Vaccine Certificate',$this->user->id);
		
      $user = $this->user;
        
      $certi_no = $request->certi_no;
      $type = $request->type;
      if ($type == 'One') {
        $national_id = $request->national_id;
      } else {
        $national_id = $request->birth_id;
      }
      $passport_no = $request->passport_no;
      $nationality = $request->nationality;
      $name = $request->name;
      $gender = $request->gender;
      $dd = $request->date_birth;
      $date = str_replace('/', '-', $dd);
      $date_birth = date('Y-m-d', strtotime($date));
      //for dose 
      $one = $request->doseone_date;
      $dose_one = str_replace('/', '-', $one);
      $doseone_date = date('Y-m-d', strtotime($dose_one));


      $two = $request->dosetwo_date;
      $dose_two = str_replace('/', '-', $two);
      $dosetwo_date = date('Y-m-d', strtotime($dose_two));


      $three = $request->dosethree_date;
      $dose_three = str_replace('/', '-', $three);
      $dosethree_date = date('Y-m-d', strtotime($dose_three));

      $type = $request->type;
      if ($type == 'One') {
        $national_id = $request->national_id;
      } else {
        $national_id = $request->birth_id;
      }

      $v1_type = $request->doseone_name;
      if ($v1_type == 'other') {
        $doseone_name = $request->doseone_name2;
      } else {
        $doseone_name = $request->doseone_name;
      }
      $v2_type = $request->dosetwo_name;
      if ($v2_type == 'other') {
        $dosetwo_name = $request->dosetwo_name2;
      } else {
        $dosetwo_name = $request->dosetwo_name;
      }
      $v3_type = $request->dosethree_name;
      if ($v3_type == 'other') {
        $dosethree_name = $request->dosethree_name2;
      } else {
        $dosethree_name = $request->dosethree_name;
      }
      $vc_type = $request->vacc_center;
      if ($vc_type == 'other') {
        $vacc_center = $request->vacc_center2;
      } else {
        $vacc_center = $request->vacc_center;
      }
      $vacc_by = $request->vacc_by;
      $total_dose = $request->total_dose;
        
        $surokkha = new Surokkha();
        $surokkha->user_id = $user->id;
        $surokkha->certi_no = $certi_no;
        $surokkha->type = $type; 
        $surokkha->national_id = $national_id;
        $surokkha->passport_no = $passport_no;
        $surokkha->nationality = $nationality;
        $surokkha->name = $name;
        $surokkha->gender = $gender;
        $surokkha->date_birth = $date_birth;
        $surokkha->doseone_date = $doseone_date;
        $surokkha->doseone_name = $doseone_name;
        $surokkha->dosetwo_date = $dosetwo_date;
        $surokkha->dosetwo_name = $dosetwo_name;
        $surokkha->dosethree_date = $dosethree_date;
        $surokkha->dosethree_name = $dosethree_name;
        $surokkha->vacc_center = $vacc_center;
        $surokkha->vacc_by = $vacc_by;
        $surokkha->total_dose = $total_dose;
        $surokkha->save();
        return redirect()->route('user.surokkha.index')->with('success', 'Vaccine Certificate Created');
    }
    
     public function edit($id)
    {
        $data['surokkha'] = Surokkha::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit Vaccine Certificate';
        return view('user.surokkha.update', $data);
    }
    
    public function update($id, Request $request ){
        $surokkha = Surokkha::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $this->validate($request,[
		]);
	
        $user = $this->user;
        
         $certi_no = $request->certi_no;
      $type = $request->type;
      if ($type == 'One') {
        $national_id = $request->national_id;
      } else {
        $national_id = $request->birth_id;
      }
      $passport_no = $request->passport_no;
      $nationality = $request->nationality;
      $name = $request->name;
      $gender = $request->gender;
      $dd = $request->date_birth;
      $date = str_replace('/', '-', $dd);
      $date_birth = date('Y-m-d', strtotime($date));
      //for dose 
      $one = $request->doseone_date;
      $dose_one = str_replace('/', '-', $one);
      $doseone_date = date('Y-m-d', strtotime($dose_one));


      $two = $request->dosetwo_date;
      $dose_two = str_replace('/', '-', $two);
      $dosetwo_date = date('Y-m-d', strtotime($dose_two));


      $three = $request->dosethree_date;
      $dose_three = str_replace('/', '-', $three);
      $dosethree_date = date('Y-m-d', strtotime($dose_three));

      $type = $request->type;
      if ($type == 'One') {
        $national_id = $request->national_id;
      } else {
        $national_id = $request->birth_id;
      }

      $v1_type = $request->doseone_name;
      if ($v1_type == 'other') {
        $doseone_name = $request->doseone_name2;
      } else {
        $doseone_name = $request->doseone_name;
      }
      $v2_type = $request->dosetwo_name;
      if ($v2_type == 'other') {
        $dosetwo_name = $request->dosetwo_name2;
      } else {
        $dosetwo_name = $request->dosetwo_name;
      }
      $v3_type = $request->dosethree_name;
      if ($v3_type == 'other') {
        $dosethree_name = $request->dosethree_name2;
      } else {
        $dosethree_name = $request->dosethree_name;
      }
      $vc_type = $request->vacc_center;
      if ($vc_type == 'other') {
        $vacc_center = $request->vacc_center2;
      } else {
        $vacc_center = $request->vacc_center;
      }
      $vacc_by = $request->vacc_by;
      $total_dose = $request->total_dose;
        
        $surokkha->certi_no = $certi_no;
        $surokkha->type = $type; 
        $surokkha->national_id = $national_id;
        $surokkha->passport_no = $passport_no;
        $surokkha->nationality = $nationality;
        $surokkha->name = $name;
        $surokkha->gender = $gender;
        $surokkha->date_birth = $date_birth;
        $surokkha->doseone_date = $doseone_date;
        $surokkha->doseone_name = $doseone_name;
        $surokkha->dosetwo_date = $dosetwo_date;
        $surokkha->dosetwo_name = $dosetwo_name;
        $surokkha->dosethree_date = $dosethree_date;
        $surokkha->dosethree_name = $dosethree_name;
        $surokkha->vacc_center = $vacc_center;
        $surokkha->vacc_by = $vacc_by;
        $surokkha->total_dose = $total_dose;
        $surokkha->save();
        
        return redirect()->route('user.surokkha.index')->with('success', 'Vaccine Certificate Updated');
    }
    
    public function destroy($id){
        $surokkha = Surokkha::where('id',$id)->where('user_id',$this->user->id)->firstOrFail();
        $surokkha->delete();
        return back()->with('success', 'Vaccine Certificate Deleted Successfully');
    }
    
     public function print($id){
        $data['data'] = Surokkha::where('id',$id)->where('user_id',$this->user->id)->firstOrFail()->toArray();
        return view('user.surokkha.print', $data);
    }
    
 public function verify($id)
{
    \Log::info('Verifying surokkha with ID: ' . $id); // Log the ID being processed
    
    $data['data'] = Surokkha::where('id', $id)->first();
    
    if (!blank($data['data'])) {
        \Log::info('Data found: ' . json_encode($data['data'])); // Log the data if found
        return view('user.surokkha.verify', $data);
    }

    \Log::info('Data not found'); // Log when data is not found
    return response()->json(['message' => 'Data not found'], 404);
}



 
}
