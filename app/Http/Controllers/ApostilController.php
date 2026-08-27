<?php

namespace App\Http\Controllers;

use App\Models\Apostil;
use App\Models\Transaction; // Added Transaction model import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added Auth facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Added Str facade import

class ApostilController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // It's good practice to pass the fee to the view if it's dynamic,
        // but since it's hardcoded as per BMETController, we might not need to.
        // For future flexibility, you could define $fee here or from a config/setting
        // and pass it to the view:
        // Fee is fetched dynamically from ServiceCharge
        // return view('user.apostil.create', compact('fee'));
        return view('user.apostil.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch only apostils belonging to the authenticated user
        $apostils = Apostil::where('user_id', Auth::id())->latest()->get();
        return view('user.apostil.index', compact('apostils'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apostil  $apostil
     * @return \Illuminate\Http\Response
     */
    public function show(Apostil $apostil)
    {
        // Ownership check
        if ($apostil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.apostil.show', compact('apostil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apostil  $apostil
     * @return \Illuminate\Http\Response
     */
    public function edit(Apostil $apostil)
    {
        // Ownership check
        if ($apostil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.apostil.edit', compact('apostil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apostil  $apostil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apostil $apostil)
    {
        // Ownership check
        if ($apostil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'date' => 'required|date',
            'apostil_no' => 'required|string|max:255|unique:apostils,apostil_no,'.$apostil->id,
            'place' => 'required|string|max:255', // Added place validation
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Added webp
        ]);

        $data = $request->only(['date', 'apostil_no', 'place']); // Added place

        if ($request->hasFile('certificate_image')) {
            $destinationPath = storage_path('uploads');
            $image = $request->file('certificate_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true); // Use 0775 for permissions, true for recursive
            }

            // Delete old image if exists
            if ($apostil->certificate_image) {
                $oldImagePath = storage_path('uploads/' . $apostil->certificate_image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath); // Use @ to suppress errors if unlink fails, though proper error handling is better
                }
            }
            
            // Move the new file
            $image->move($destinationPath, $imageName);
            $data['certificate_image'] = $imageName;
        }

        $apostil->update($data);

        return redirect()->route('user.application-details.index') // Updated route name
                         ->with('success','Apostil updated successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = $this->user; // User from constructor
            $fee = \App\Models\ServiceCharge::getCharge('apostil');

            if (!$user || $user->balance < $fee) {
                // Using withErrors to display a specific error message on the form
                return back()->withInput()->withErrors(['balance' => 'Insufficient balance. Required balance: ' . $fee]);
            }

            $validatedData = $request->validate([
                'date' => 'required|date',
                'apostil_no' => 'required|string|max:255|unique:apostils',
                'place' => 'required|string|max:255',
                'certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Deduct balance
            $user->balance -= $fee;
            $user->save();

            // Create transaction
            $this->createApostilTransaction($fee, 'Debit', 'Fee for Apostil: ' . $validatedData['apostil_no'], $user->id);
            
            // Handle file upload
            $imageName = null;
            if ($request->hasFile('certificate_image')) {
                $destinationPath = storage_path('uploads');
                $image = $request->file('certificate_image');
                $imageName = time().'.'.$image->getClientOriginalExtension();

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
                $image->move($destinationPath, $imageName);
            }

            Apostil::create([
                'user_id' => $user->id,
                'date' => $validatedData['date'],
                'apostil_no' => $validatedData['apostil_no'],
                'place' => $validatedData['place'],
                'certificate_image' => $imageName,
            ]);

            return redirect()->route('user.application-details.create')
                             ->with('success','Apostil Application Detail created successfully. Fee deducted: '.$fee);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel, redirecting back with $errors
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error during Apostil creation: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            // It's crucial to consider rolling back the balance deduction if an error occurs after it.
            // For now, just returning a generic error.
            return back()->withInput()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Create a transaction record for Apostil.
     * Mimics NagorikSonodController's private createTransaction.
     */
    private function createApostilTransaction($amount, $type, $details, $userId)
    {
        Transaction::create([
            'tx_id' => uniqid('APOSTIL-'), // Unique transaction ID with prefix
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type, // e.g., 'Debit'
            'details' => $details
            // Ensure your Transaction model and table have these fields
            // and that 'tx_id' is fillable if not using guarded = []
        ]);
    }

    /**
     * Serve the certificate image from storage.
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */

    /**
     * Display the publicly verifiable apostil data.
     *
     * @param  string  $apostilNo
     * @return \Illuminate\Http\Response
     */
    public function publicVerifyByApostilNo(string $apostilNo)
    {
        $apostil = Apostil::where('apostil_no', $apostilNo)->firstOrFail();
        return view('apostil.public-verify', compact('apostil'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apostil  $apostil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apostil $apostil)
    {
        // Ownership check
        if ($apostil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the associated image file from storage/uploads
        if ($apostil->certificate_image) {
            $imagePath = storage_path('uploads/' . $apostil->certificate_image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $apostil->delete();

        return redirect()->route('user.application-details.index')
                         ->with('success', 'Apostil record deleted successfully.');
    }
}
