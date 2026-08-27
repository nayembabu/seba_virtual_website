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
use App\Models\ServiceCharge;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Parser as Browser;
use App\Models\User;
use App\Models\Support;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Pdo;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;

class PdoController extends Controller
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
        $data['objects'] = Pdo::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->get();
        $data['title'] = 'Pdo Certificates';
        return view('user.pdo.index', $data);
    }

    public function create()
    {
        $data['user'] = $this->user;
        $data['title'] = 'Create Pdo';
        return view('user.pdo.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
        ]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $request->full_name)) {
            return back()->withErrors(['msg' => 'Only letters and white space allowed!']);
        }

        if (!isDate($request->course_date)) {
            return back()->withErrors(['msg' => 'Course Date is invalid format! ex: dd/mm/yyyy']);
        }

        if (!isDate($request->issue_date)) {
            return back()->withErrors(['msg' => 'Issue Date is invalid format! ex: dd/mm/yyyy']);
        }

        $fee = \App\Models\ServiceCharge::getCharge('pdo');

        if ($this->user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $this->user->balance -= $fee;
        $this->user->save();
        create_transaction($fee, '-', 'Created pdo certificate', $this->user->id);

        $pdo = new Pdo();
        $pdo->user_id = $this->user->id;
        $pdo->name_title = $request->name_title;
        $pdo->full_name = $request->full_name;
        $pdo->fathers_name = $request->fathers_name;
        $pdo->mothers_name = $request->mothers_name;
        $pdo->nid_no = $request->nid_no;
        $pdo->passport_no = $request->passport_no;
        $pdo->course_name = $request->course_name;
        $pdo->connected_by = $request->connected_by;
        $pdo->destination_country = $request->destination_country;
        $pdo->certificate_no = $request->certificate_no;
        $pdo->batch_no = $request->batch_no;
        $pdo->roll_no = $request->roll_no;
        $pdo->course_date = $request->course_date;
        $pdo->issue_date = $request->issue_date;

        if (!blank($request->file('photo'))) {
            $hash = md5($request->full_name . '-' . time());
            $photo = $hash . '-pdo.' . $request->file('photo')->extension();
            $request->file('photo')->move('storage/uploads', $photo);
            $pdo->photo = $photo;
        }

        $pdo->uid = $this->generateUid(); // Generate the unique identifier
        $pdo->save();

        return redirect()->route('user.pdo.index')->with('success', 'PDO Certificate Created');
    }

    public function edit($uid)
    {
        $data['pdo'] = Pdo::where('id', $uid)->where('user_id', $this->user->id)->firstOrFail();
        $data['user'] = $this->user;
        $data['title'] = 'Edit Pdo';
        return view('user.pdo.update', $data);
    }

    public function update($uid, Request $request)
    {
        $pdo = Pdo::where('id', $uid)->where('user_id', $this->user->id)->firstOrFail();
        $this->validate($request, [
            'full_name' => 'required',
        ]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $request->full_name)) {
            return back()->withErrors(['msg' => 'Only letters and white space allowed!']);
        }

        if (!isDate($request->course_date)) {
            return back()->withErrors(['msg' => 'Course Date is invalid format! ex: dd/mm/yyyy']);
        }

        if (!isDate($request->issue_date)) {
            return back()->withErrors(['msg' => 'Issue Date is invalid format! ex: dd/mm/yyyy']);
        }

        $pdo->name_title = $request->name_title;
        $pdo->full_name = $request->full_name;
        $pdo->fathers_name = $request->fathers_name;
        $pdo->mothers_name = $request->mothers_name;
        $pdo->nid_no = $request->nid_no;
        $pdo->passport_no = $request->passport_no;
        $pdo->course_name = $request->course_name;
        $pdo->connected_by = $request->connected_by;
        $pdo->destination_country = $request->destination_country;
        $pdo->certificate_no = $request->certificate_no;
        $pdo->batch_no = $request->batch_no;
        $pdo->roll_no = $request->roll_no;
        $pdo->course_date = $request->course_date;
        $pdo->issue_date = $request->issue_date;

        if (!blank($request->file('photo'))) {
            $hash = md5($request->full_name . '-' . time());
            $photo = $hash . '-pdo.' . $request->file('photo')->extension();
            $request->file('photo')->move('storage/uploads', $photo);
            $pdo->photo = $photo;
        }

        $pdo->save();
        return redirect()->route('user.pdo.index')->with('success', 'PDO Certificate Updated');
    }

    public function delete($id)
    {
        $pdo = Pdo::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
        $pdo->delete();
        return back()->with('success', 'PDO Certificate Deleted Successfully');
    }

    public function print($uid)
    {
        $data['data'] = Pdo::where('id', $uid)->where('user_id', $this->user->id)->firstOrFail()->toArray();
        return view('user.pdo.print', $data);
    }

    public function verify($uid)
    {
        $data['data'] = Pdo::where('id', $uid)->first();
        if (!blank($data['data'])) {
            $data['data'] = $data['data']->toArray();
            return view('user.pdo.verify', $data);
        }
        return 'invalid';
    }

    private function generateUid()
    {
        $letters = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2));
        $numbers = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate 6 digit number
        $lastLetter = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1));

        return $letters . $numbers . $lastLetter; // Combine to create UID
    }
}
