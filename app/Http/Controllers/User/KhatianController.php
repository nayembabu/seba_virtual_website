<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Session;

class KhatianController extends Controller
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

    public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'নাম জারি খতিয়ান';
        return view('user.khatian.create', $data);
    }

    public function store(Request $request)
    {
        $fee = \App\Models\ServiceCharge::getCharge('khatian');

        if ($this->user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $this->user->balance -= $fee;
        $this->user->save();
        create_transaction($fee, '-', 'Created Nam Jari Khatian', $this->user->id);

        $khatian = new \App\Models\Khatian();
        $khatian->user_id = $this->user->id;
        $khatian->khatian_no = $request->khatian_no;
        $khatian->district = $request->district;
        $khatian->upazila = $request->upazila;
        $khatian->mouza = $request->mouza;
        $khatian->jl_no = $request->jl_no;
        $khatian->app_no = $request->app_no;
        $khatian->app_date = $request->app_date;
        $khatian->mutation_case_no = $request->mutation_case_no;
        $khatian->dcr_no = $request->dcr_no;
        $khatian->khatian_pid = $request->khatian_pid;
        $khatian->ac_name = $request->ac_name;
        $khatian->seal = $request->seal_select;
        $khatian->total_land_val = $request->total_land_val;
        $khatian->amount_in_words = $request->amount_in_words;
        $khatian->owners_json = $request->owners_json;
        $khatian->lands_json = $request->lands_json;

        if ($request->hasFile('seal_upload')) {
            $khatian->seal = $this->uploadImage($request->seal_upload, config('location.khatian.path'), config('location.khatian.size'));
        }

        $khatian->unique_code = \Illuminate\Support\Str::random(32);
        $khatian->save();

        return redirect()->route('user.khatian.view', $khatian->id)->with('success', 'Khatian created successfully');
    }

    
    public function logs()
    {
        $data['user'] = $this->user;
        $data['khatians'] = \App\Models\Khatian::where('user_id', $this->user->id)->orderBy('id', 'desc')->paginate(20);
        $data['title'] = 'খতিয়ান লগস';
        return view('user.khatian.logs', $data);
    }
    public function view($id)
    {
        $data['user'] = $this->user;
        $data['khatian'] = \App\Models\Khatian::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
        $data['title'] = 'খতিয়ান ভিইউ';
        return view('user.khatian.view', $data);
    }
}
