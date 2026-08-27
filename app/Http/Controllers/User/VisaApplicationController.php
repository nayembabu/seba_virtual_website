<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\VisaApplication;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisaApplicationController extends Controller
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

    public function index()
    {
        $visaApplications = VisaApplication::where('user_id', Auth::id())->latest()->get();
        return view('user.visa_applications.index', compact('visaApplications'));
    }
    
    public function create()
    {
        return view('user.visa_applications.create');
    }
    
    public function store(Request $request)
    {
        $user = $this->user;
        $fee = \App\Models\ServiceCharge::getCharge('visa-applications');

        if (!$user || $user->balance < $fee) {
            return back()->withErrors(['msg' => 'Insufficient balance']);
        }

        $request->validate([
            'visa_number' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'citizenship' => 'required|string|max:100',
            'passport_number' => 'required|string|max:50',
            'travel_document_type' => 'required|string|max:50',
            'passport_issue_date' => 'required|date',
            'passport_expiry_date' => 'required|date',
            'visa_type' => 'required|string|max:100',
            'visa_validity' => 'required|string|max:100',
            'number_of_entries' => 'required|string|max:50',
            'period_of_stay' => 'required|integer',
            'invitation' => 'nullable|string|max:255',
            'visa_issue_date' => 'required|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        try {
            // Deduct balance
            $this->user->balance = $this->user->balance - $fee;
            $this->user->save();

            // Create transaction record
            create_transaction($fee, '-', 'Created Visa Application', $this->user->id);

            $data = $request->except('_token', 'profile_photo');
            $data['user_id'] = Auth::id();
            $data['created_at'] = now();
            
            if ($request->hasFile('profile_photo')) {
                $path = storage_path('uploads/visa');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $filename = uniqid() . time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
                $request->file('profile_photo')->move($path, $filename);
                $data['profile_photo'] = $filename;
            }
            
            VisaApplication::create($data);
            
            return redirect()->route('user.visa-applications.index')->with('success', 'Visa application submitted successfully');
        } catch (\Exception $e) {
            // If an error occurs, you might want to revert the balance deduction
            // However, for simplicity, we'll just log and return an error.
            // In a real application, consider using database transactions.
            \Log::error('Error in VisaApplication store', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while submitting the visa application: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $visaApplication = VisaApplication::where('user_id', Auth::id())->findOrFail($id);
        return view('user.visa_applications.show', compact('visaApplication'));
    }
    
    /**
     * Verify a visa application
     */
    public function verify($visaNumber)
    {
        $visaApplication = VisaApplication::where('visa_number', $visaNumber)->firstOrFail();
        return view('user.visa_applications.verify', compact('visaApplication'));
    }

    public function edit($id)
    {
        $visaApplication = VisaApplication::where('user_id', Auth::id())->findOrFail($id);
        return view('user.visa_applications.edit', compact('visaApplication'));
    }

    public function update(Request $request, $id)
    {
        $visaApplication = VisaApplication::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'visa_number' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'citizenship' => 'required|string|max:100',
            'passport_number' => 'required|string|max:50',
            'travel_document_type' => 'required|string|max:50',
            'passport_issue_date' => 'required|date',
            'passport_expiry_date' => 'required|date',
            'visa_type' => 'required|string|max:100',
            'visa_validity' => 'required|string|max:100',
            'number_of_entries' => 'required|string|max:50',
            'period_of_stay' => 'required|integer',
            'invitation' => 'nullable|string|max:255',
            'visa_issue_date' => 'required|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('_token', 'profile_photo');

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($visaApplication->profile_photo) {
                $oldPhotoPath = storage_path('uploads/visa/' . $visaApplication->profile_photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Store new photo
            $path = storage_path('uploads/visa');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $filename = uniqid() . time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $request->file('profile_photo')->move($path, $filename);
            $data['profile_photo'] = $filename;
        }

        $visaApplication->update($data);

        return redirect()->route('user.visa-applications.index')->with('success', 'Visa application updated successfully!');
    }

    public function destroy($id)
    {
        $visaApplication = VisaApplication::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete associated photo if it exists
        if ($visaApplication->profile_photo) {
            $photoPath = storage_path('uploads/visa/' . $visaApplication->profile_photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $visaApplication->delete();

        return redirect()->route('user.visa-applications.index')->with('success', 'Visa application deleted successfully!');
    }
}
