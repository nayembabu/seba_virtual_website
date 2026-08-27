<?php

namespace App\Http\Controllers;

use App\Models\BmetEc;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BmetEcController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bmetEcs = BmetEc::where('user_id', Auth::id())->get();
        $title = "BMET EC List";
        return view('user.bmet-ec.index', compact('bmetEcs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create BMET EC";
        return view('user.bmet-ec.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->user;
        $fee = \App\Models\ServiceCharge::getCharge('bmet-ec');

        if (!$user || $user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $request->validate([
            'ec_no' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'passport_no' => 'required|string|max:255',
            'passport_issue_date' => 'required|date',
            'passport_expire_date' => 'required|date',
            'visa_no' => 'required|string|max:255',
            'visa_issue_date' => 'required|date',
            'visa_expire_date' => 'required|date',
            'recruiting_agency' => 'required|string|max:255',
            'rl_id' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bmet_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $this->user->balance = $this->user->balance - $fee;
            $this->user->save();

            $this->createTransaction($fee, '-', 'Created BMET EC Card', $this->user->id);

            $bmetEc = new BmetEc($request->all());
            $bmetEc->user_id = Auth::id();

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('bmet-ec-photos', 'public');
                $bmetEc->profile_photo = $path;
            }

            $bmetEc->save();

            return redirect()->route('user.bmet-ec.create')->with('success', 'BMET EC created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while saving the data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bmetEc = BmetEc::findOrFail($id);
        $title = "View BMET EC";
        return view('user.bmet-ec.show', compact('bmetEc', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bmetEc = BmetEc::findOrFail($id);
        $title = "Edit BMET EC";
        return view('user.bmet-ec.edit', compact('bmetEc', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ec_no' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'passport_no' => 'required|string|max:255',
            'passport_issue_date' => 'required|date',
            'passport_expire_date' => 'required|date',
            'visa_no' => 'required|string|max:255',
            'visa_issue_date' => 'required|date',
            'visa_expire_date' => 'required|date',
            'recruiting_agency' => 'required|string|max:255',
            'rl_id' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bmet_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bmetEc = BmetEc::findOrFail($id);
        $bmetEc->fill($request->all());

        if ($request->hasFile('profile_photo')) {
            if ($bmetEc->profile_photo) {
                Storage::disk('public')->delete($bmetEc->profile_photo);
            }
            $path = $request->file('profile_photo')->store('bmet-ec-photos', 'public');
            $bmetEc->profile_photo = $path;
        }

        $bmetEc->save();

        return redirect()->route('user.bmet-ec.index')->with('success', 'BMET EC updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bmetEc = BmetEc::findOrFail($id);
        if ($bmetEc->profile_photo) {
            Storage::disk('public')->delete($bmetEc->profile_photo);
        }
        $bmetEc->delete();

        return redirect()->route('user.bmet-ec.index')->with('success', 'BMET EC deleted successfully.');
    }

    public function print($id)
    {
        $bmetEc = BmetEc::findOrFail($id);
        $title = "Print BMET EC";
        return view('user.bmet-ec.print', compact('bmetEc', 'title'));
    }

    public function verify($ec_no)
    {
        $bmetEc = BmetEc::where('ec_no', $ec_no)->firstOrFail();
        $title = "Verify BMET EC";
        return view('user.bmet-ec.verify', compact('bmetEc', 'title'));
    }

    private function createTransaction($amount, $type, $details, $userId)
    {
        Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'details' => $details
        ]);
    }
}
