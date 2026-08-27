<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Upload;

class VisaApplicationController extends Controller
{
    use Upload;
    
    public function index()
    {
        $visaApplications = VisaApplication::where('user_id', Auth::id())->latest()->paginate(15);
        return view('visa_applications.index', compact('visaApplications'));
    }
    
    public function create()
    {
        return view('visa_applications.create');
    }
    
    public function store(Request $request)
    {
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
        $data['user_id'] = Auth::id();
        
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $this->uploadImage($request->file('profile_photo'), config('location.visa.path'));
        }
        
        VisaApplication::create($data);
        
        return redirect()->route('visa-applications.index')->with('success', 'Visa application submitted successfully');
    }
    
    public function show($id)
    {
        $visaApplication = VisaApplication::findOrFail($id);
        return view('visa_applications.show', compact('visaApplication'));
    }
}