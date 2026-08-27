<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Str;

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
use App\Models\Land;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;


class LandController extends Controller
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
        $data['objects'] = Land::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->get();
        $data['title'] = 'Land Certificates';
        return view('user.land.index', $data);
    }

    public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create Land Certificate';
        return view('user.land.create', $data);
    }
    
  public function store(Request $request)
{
    $this->validate($request, [
        //'malik_name' => 'required',
    ]);

    $fee = \App\Models\ServiceCharge::getCharge('land');

    if ($this->user->balance < $fee) {
        return back()->withErrors(['msg' => 'Insufficient balance']);
    }

    $this->user->balance = $this->user->balance - $fee;
    $this->user->save();
    create_transaction($fee, '-', 'Created Land certificate', $this->user->id);

    $user = $this->user;
    $land = new Land();
    $land->user_id = $user->id;
    $land->office_name = $request->office_name;
    $land->muja_no = $request->muja_no;
    $land->upazila_name = $request->upazila_name;
    $land->zila_name = $request->zila_name;
    //$land->malik_name = $request->malik_name;
    $land->holding_no = $request->holding_no;
    $land->khotiyan_no = $request->khotiyan_no;
    $land->publish_date = $request->publish_date;

    $din = $request->din;
    $mas = $request->mas;
    $bochor = $request->bochor;
    $land->bn_date = "$din $mas, $bochor";

    $land->porishud = $request->porishud;
    $land->tin_bokaya = $request->tin_bokaya;
    $land->goto_bokaya = $request->goto_bokaya;
    $land->bokayar_khoti = $request->bokayar_khoti;
    $land->hall_dabi = $request->hall_dabi;
    $land->mot_dabi = $request->mot_dabi;
    $land->mot_aday = $request->mot_aday;
    $land->mot_bokaya = $request->mot_bokaya;
    $land->montobo = $request->montobo;
    $land->sl_no = $request->sl_no;
    $land->chalan_no = $request->chalan_no;

    $maliks = array();
    $malik_info = !blank($request->m_name) ? $request->m_name : array();
    $i = -1;
    foreach ($malik_info as $key => $malik) {
        $i++;
        $maliks[$i]['name'] = $request->m_name[$key];
        $maliks[$i]['total'] = $request->m_total[$key];
    }
    $land->malik_name = json_encode($maliks);

    $jdata = array();
    $jomi_info = !blank($request->dag_no) ? $request->dag_no : array();
    $i = -1;
    foreach ($jomi_info as $key => $jomi_data) {
        $i++;
        $jdata[$i]['dag_no'] = $request->dag_no[$key];
        $jdata[$i]['jomi_type'] = $request->jomi_type[$key];
        $jdata[$i]['jomi_poriman'] = $request->jomi_poriman[$key];
    }
    $land->jomi_info = json_encode($jdata);

    // Generate a UID using Str::random and concatenate 'T09' or 'z09'
    $land->uid = Str::random(29) . (rand(0, 1) ? 'T09' : 'z09');

    $land->save();
    return back()->with('success', 'Land Certificate Created');
}


    public function edit($uid)
    {
        $data['land'] = Land::where('uid', $uid)->where('user_id', $this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit Land';
        return view('user.land.update', $data);
    }
    
    public function update($uid, Request $request)
    {
        $land = Land::where('uid', $uid)->where('user_id', $this->user->id)->firstOrFail();
        $this->validate($request, [
            //'malik_name' => 'required',
        ]);

        $user = $this->user;

        $land->office_name = $request->office_name;
        $land->muja_no = $request->muja_no;
        $land->upazila_name = $request->upazila_name;
        $land->zila_name = $request->zila_name;
        //$land->malik_name = $request->malik_name;
        $land->holding_no = $request->holding_no;
        $land->khotiyan_no = $request->khotiyan_no;
        $land->publish_date = $request->publish_date;

        $din = $request->din;
        $mas = $request->mas;
        $bochor = $request->bochor;
        $land->bn_date = "$din $mas, $bochor";

        $land->porishud = $request->porishud;
        $land->tin_bokaya = $request->tin_bokaya;
        $land->goto_bokaya = $request->goto_bokaya;
        $land->bokayar_khoti = $request->bokayar_khoti;
        $land->hall_dabi = $request->hall_dabi;
        $land->mot_dabi = $request->mot_dabi;
        $land->mot_aday = $request->mot_aday;
        $land->mot_bokaya = $request->mot_bokaya;
        $land->montobo = $request->montobo;
        $land->sl_no = $request->sl_no;
        $land->chalan_no = $request->chalan_no;

        $maliks = array();
        $malik_info = !blank($request->m_name) ? $request->m_name : array();
        $i = -1;
        foreach ($malik_info as $key => $malik) {
            $i++;
            $maliks[$i]['name'] = $request->m_name[$key];
            $maliks[$i]['total'] = $request->m_total[$key];
        }
        $land->malik_name = json_encode($maliks);

        $jdata = array();
        $jomi_info = !blank($request->dag_no) ? $request->dag_no : array();
        $i = -1;
        foreach ($jomi_info as $key => $jomi_data) {
            $i++;
            $jdata[$i]['dag_no'] = $request->dag_no[$key];
            $jdata[$i]['jomi_type'] = $request->jomi_type[$key];
            $jdata[$i]['jomi_poriman'] = $request->jomi_poriman[$key];
        }
        $land->jomi_info = json_encode($jdata);
        $land->save();
        return back()->with('success', 'Land Certificate Updated');
    }
    
    public function delete($uid)
    {
        $land = Land::where('uid', $uid)->where('user_id', $this->user->id)->firstOrFail();
        $land->delete();
        return back()->with('success', 'Land Certificate Deleted Successfully');
    }
    
    public function print($uid)
    {
        $data['data'] = Land::where('uid', $uid)->where('user_id', $this->user->id)->firstOrFail()->toArray();
        return view('user.land.print', $data);
    }
    
    public function verify($uid)
    {
        $data['data'] = Land::where('uid', $uid)->first();
        if (!blank($data['data'])) {
            $data['data'] = $data['data']->toArray();
            return view('user.land.print', $data);
        }
        return 'invalid';
    }
}
