<?php

namespace App\Http\Controllers;

use App\Models\EVisa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EVisaController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Attempting to load e-visas index page.');
            $visas = EVisa::latest()->get();
            return view('user.evisas.index', compact('visas'));
        } catch (\Exception $e) {
            Log::error('Error loading e-visas index page: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withError('Error loading e-visas page. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Log::info('Attempting to load e-visas create page.');
            return view('user.evisas.create');
        } catch (\Exception $e) {
            Log::error('Error loading e-visas create page: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withError('Error loading e-visas create page. Please try again later.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */    public function store(Request $request)
    {
        try {
            $user = $this->user;
            $fee = \App\Models\ServiceCharge::getCharge('evisas');

            if (!$user || $user->balance < $fee) {
                return back()->withInput()->withErrors(['balance' => 'Insufficient balance. Required balance: ' . $fee]);
            }

            $validated = $request->validate([
                'visa_id' => 'required|unique:e_visas',
                'evisa_number' => 'required|unique:e_visas',
                'ref_number' => 'required',
                'issue_date' => 'required|date',
                'expire_date' => 'required|date|after:issue_date',
                'place_of_issue' => 'required',
                'remarks' => 'nullable',
                'visa_fee' => 'required|numeric',
                'gender' => 'required|in:Male,Female,Other',
                'full_name' => 'required',
                'date_of_birth' => 'required|date|before:today',
                'nationality' => 'required',
                'travel_document' => 'required',
                'travel_doc_no' => 'required',
                'travel_doc_issue' => 'required|date',
                'travel_doc_expiry' => 'required|date|after:travel_doc_issue',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Deduct balance
            $user->balance -= $fee;
            $user->save();

            // Create transaction
            $this->createEVisaTransaction($fee, 'Debit', 'Fee for E-Visa: ' . $validated['evisa_number'], $user->id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move('D:/oopjhjh/storage/uploads', $imageName);
                $validated['image'] = 'storage/uploads/' . $imageName;
            }

            // Add the user_id to the validated data
            $validated['user_id'] = $user->id;

            EVisa::create($validated);

            return redirect()->route('user.evisas.index')
                ->with('success', 'E-Visa created successfully. Fee deducted: ' . $fee);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error during E-Visa creation: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $evisa = EVisa::findOrFail($id);
            Log::info('Attempting to load e-visas show page for EVisa ID: ' . $evisa->id);
            return view('user.evisas.show', compact('evisa'));
        } catch (ModelNotFoundException $e) {
            Log::warning('EVisa with ID ' . $id . ' not found.', ['exception' => $e]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Error loading e-visas show page for EVisa ID: ' . $id . ' - ' . $e->getMessage(), ['exception' => $e]);
            return back()->withError('Error loading e-visas details page. Please try again later.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EVisa $evisa)
    {
        try {
            Log::info('Attempting to load e-visas edit page for EVisa ID: ' . $evisa->id);
            return view('user.evisas.edit', compact('evisa'));
        } catch (\Exception $e) {
            Log::error('Error loading e-visas edit page for EVisa ID: ' . $evisa->id . ' - ' . $e->getMessage(), ['exception' => $e]);
            return back()->withError('Error loading e-visas edit page. Please try again later.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EVisa $evisa)
    {
        $validated = $request->validate([
            'visa_id' => 'required|unique:e_visas,visa_id,' . $evisa->id,
            'evisa_number' => 'required|unique:e_visas,evisa_number,' . $evisa->id,
            'ref_number' => 'required',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date|after:issue_date',
            'place_of_issue' => 'required',
            'remarks' => 'nullable',
            'visa_fee' => 'required|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'full_name' => 'required',
            'date_of_birth' => 'required|date|before:today',
            'nationality' => 'required',
            'travel_document' => 'required',
            'travel_doc_no' => 'required',
            'travel_doc_issue' => 'required|date',
            'travel_doc_expiry' => 'required|date|after:travel_doc_issue',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($evisa->image && file_exists('D:/oopjhjh/' . $evisa->image)) {
                unlink('D:/oopjhjh/' . $evisa->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move('D:/oopjhjh/storage/uploads', $imageName);
            $validated['image'] = 'storage/uploads/' . $imageName;
        }

        $evisa->update($validated);

        return redirect()->route('user.evisas.index')
            ->with('success', 'E-Visa updated successfully.');
    }

    /**
     * Create a transaction record for E-Visa.
     */
    private function createEVisaTransaction($amount, $type, $details, $userId)
    {
        Transaction::create([
            'tx_id' => uniqid('EVISA-'), // Unique transaction ID with prefix
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'details' => $details
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */    public function destroy(EVisa $evisa)
    {
        // Delete associated image if exists
        if ($evisa->image && file_exists('D:/oopjhjh/' . $evisa->image)) {
            unlink('D:/oopjhjh/' . $evisa->image);
        }

        $evisa->delete();

        return redirect()->route('user.evisas.index')
            ->with('success', 'E-Visa deleted successfully.');
    }
}
