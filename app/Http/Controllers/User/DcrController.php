<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\Dcr;
use Barryvdh\DomPDF\Facade\Pdf;

class DcrController extends Controller
{
    use Upload;

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
        $data['title'] = 'অনলাইন ডিসিআর মেক';
        return view('user.dcr.create', $data);
    }

    public function store(Request $request)
    {
        $fee = \App\Models\ServiceCharge::getCharge('dcr');

        if ($this->user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $this->user->balance -= $fee;
        $this->user->save();
        create_transaction($fee, '-', 'Created Online DCR', $this->user->id);

        $dcr = new Dcr();
        $dcr->user_id = $this->user->id;
        $dcr->office_address = $request->office_address;
        $dcr->dcr_no = $request->dcr_no;
        $dcr->deposit_date = $request->deposit_date;
        $dcr->commissioner_name = $request->commissioner_name;
        $dcr->applicant_name = $request->applicant_name;
        $dcr->application_no = $request->application_no;
        $dcr->applicant_address = $request->applicant_address;
        $dcr->mutation_case_no = $request->mutation_case_no;
        $dcr->mutation_khatian_no = $request->mutation_khatian_no;
        $dcr->mutation_order_date = $request->mutation_order_date;
        $dcr->mutation_holding_no = $request->mutation_holding_no;
        $dcr->mouza = $request->mouza;
        $dcr->jl_no = $request->jl_no;
        $dcr->prev_khatian_type = $request->prev_khatian_type;
        $dcr->prev_khatian_no = $request->prev_khatian_no;
        $dcr->dag_no = $request->dag_no;
        $dcr->land_amount = $request->land_amount;
        $dcr->total_land_amount = $request->total_land_amount;
        $dcr->dcr_fee = $request->dcr_fee;
        $dcr->grand_total = $request->grand_total;
        $dcr->unique_code = $request->unique_code;

        if ($request->hasFile('office_logo')) {
            $dcr->office_logo = $this->uploadImage($request->office_logo, config('location.dcr.path'), config('location.dcr.size'));
        }
        if ($request->hasFile('signature_img')) {
            $dcr->signature_img = $this->uploadImage($request->signature_img, config('location.dcr.path'), config('location.dcr.size'));
        }

        $dcr->save();

        return redirect()->route('user.dcr.view', $dcr->id)->with('success', 'DCR created successfully');
    }

    public function view($id)
    {
        $data['user'] = $this->user;
        $data['dcr'] = Dcr::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
        $data['title'] = 'ডিসিআর ভিউ';
        return view('user.dcr.view', $data);
    }

    public function logs()
    {
        $data['user'] = $this->user;
        $data['dcrs'] = Dcr::where('user_id', $this->user->id)->orderBy('id', 'desc')->paginate(20);
        $data['title'] = 'ডিসিআর লগস';
        return view('user.dcr.logs', $data);
    }

    public function downloadPdf($id)
    {
        $dcr = Dcr::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
        $pdf = Pdf::loadView('user.dcr.pdf', ['dcr' => $dcr, 'title' => 'DCR PDF']);
        return $pdf->download('DCR_'.$dcr->dcr_no.'.pdf');
    }
}
