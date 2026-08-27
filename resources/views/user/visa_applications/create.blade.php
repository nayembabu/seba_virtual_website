@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Visa Application</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.visa-applications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @php
                            $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'visa_applications')->first();
                        @endphp

                        @if($serviceCharge)
                            <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1 font-weight-bold">Service Charge</h6>
                                        <p class="mb-0 small text-muted">A fee of <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> will be deducted for each Visa Application.</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="visa_number" class="form-label">Visa Number</label>
                                <input type="text" class="form-control @error('visa_number') is-invalid @enderror" id="visa_number" name="visa_number" value="{{ old('visa_number') }}" required>
                                @error('visa_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="citizenship" class="form-label">Citizenship</label>
                                <input type="text" class="form-control @error('citizenship') is-invalid @enderror" id="citizenship" name="citizenship" value="{{ old('citizenship') }}" required>
                                @error('citizenship')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="passport_number" class="form-label">Passport Number</label>
                                <input type="text" class="form-control @error('passport_number') is-invalid @enderror" id="passport_number" name="passport_number" value="{{ old('passport_number') }}" required>
                                @error('passport_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="travel_document_type" class="form-label">Travel Document Type</label>
                                <input type="text" class="form-control @error('travel_document_type') is-invalid @enderror" id="travel_document_type" name="travel_document_type" value="{{ old('travel_document_type') }}" required>
                                @error('travel_document_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="passport_issue_date" class="form-label">Passport Issue Date</label>
                                <input type="date" class="form-control @error('passport_issue_date') is-invalid @enderror" id="passport_issue_date" name="passport_issue_date" value="{{ old('passport_issue_date') }}" required>
                                @error('passport_issue_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                                <input type="date" class="form-control @error('passport_expiry_date') is-invalid @enderror" id="passport_expiry_date" name="passport_expiry_date" value="{{ old('passport_expiry_date') }}" required>
                                @error('passport_expiry_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="visa_type" class="form-label">Visa Type</label>
                                <select class="form-control @error('visa_type') is-invalid @enderror" id="visa_type" name="visa_type" required>
                                    <option value="">Select Visa Type</option>
                                    <option value="Tourist">Tourist</option>
                                    <option value="Business">Business</option>
                                    <option value="Student">Student</option>
                                    <option value="Work">Work</option>
                                    <option value="Family">Family</option>
                                </select>
                                @error('visa_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="visa_validity" class="form-label">Visa Validity</label>
                                <select class="form-control @error('visa_validity') is-invalid @enderror" id="visa_validity" name="visa_validity" required>
                                    <option value="">Select Validity</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option value="1 year">1 year</option>
                                    <option value="2 years">2 years</option>
                                    <option value="5 years">5 years</option>
                                </select>
                                @error('visa_validity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="number_of_entries" class="form-label">Number of Entries</label>
                                <select class="form-control @error('number_of_entries') is-invalid @enderror" id="number_of_entries" name="number_of_entries" required>
                                    <option value="">Select Number of Entries</option>
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                    <option value="Multiple">Multiple</option>
                                </select>
                                @error('number_of_entries')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="period_of_stay" class="form-label">Period of Stay (days)</label>
                                <input type="number" class="form-control @error('period_of_stay') is-invalid @enderror" id="period_of_stay" name="period_of_stay" value="{{ old('period_of_stay') }}" required>
                                @error('period_of_stay')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="invitation" class="form-label">Invitation (Optional)</label>
                                <input type="text" class="form-control @error('invitation') is-invalid @enderror" id="invitation" name="invitation" value="{{ old('invitation') }}">
                                @error('invitation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="visa_issue_date" class="form-label">Visa Issue Date</label>
                                <input type="datetime-local" class="form-control @error('visa_issue_date') is-invalid @enderror" id="visa_issue_date" name="visa_issue_date" value="{{ old('visa_issue_date') }}" required>
                                @error('visa_issue_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo">
                                @error('profile_photo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit Application</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection