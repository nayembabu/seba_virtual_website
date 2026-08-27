@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.mongolia-visa.update', $mongoliaVisa->id) }}" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <!-- Visa Information -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visa Permit Number</label>
                                            <input type="text" name="visa_permit_number" class="form-control" required value="{{ old('visa_permit_number', $mongoliaVisa->visa_permit_number) }}">
                                            @error('visa_permit_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Personal Information -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" class="form-control" required value="{{ old('first_name', $mongoliaVisa->first_name) }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $mongoliaVisa->middle_name) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" class="form-control" required value="{{ old('last_name', $mongoliaVisa->last_name) }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="">Select Gender</option>
                                                <option value="MALE" {{ old('gender', $mongoliaVisa->gender) == 'MALE' ? 'selected' : '' }}>Male</option>
                                                <option value="FEMALE" {{ old('gender', $mongoliaVisa->gender) == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                                <option value="OTHER" {{ old('gender', $mongoliaVisa->gender) == 'OTHER' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control" required value="{{ old('date_of_birth', $mongoliaVisa->date_of_birth) }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <input type="text" name="nationality" class="form-control" required value="{{ old('nationality', $mongoliaVisa->nationality) }}">
                                            @error('nationality')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Passport Information -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Passport Number</label>
                                            <input type="text" name="passport_number" class="form-control" required value="{{ old('passport_number', $mongoliaVisa->passport_number) }}">
                                            @error('passport_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Passport Issue Date</label>
                                            <input type="date" name="passport_issue_date" class="form-control" required value="{{ old('passport_issue_date', $mongoliaVisa->passport_issue_date) }}">
                                            @error('passport_issue_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Passport Expiry Date</label>
                                            <input type="date" name="passport_expiry_date" class="form-control" required value="{{ old('passport_expiry_date', $mongoliaVisa->passport_expiry_date) }}">
                                            @error('passport_expiry_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Visa Details -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Inviting Company</label>
                                            <input type="text" name="inviting_company" class="form-control" required value="{{ old('inviting_company', $mongoliaVisa->inviting_company) }}">
                                            @error('inviting_company')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visa Class</label>
                                            <input type="text" name="visa_class" class="form-control" required value="{{ old('visa_class', $mongoliaVisa->visa_class) }}">
                                            @error('visa_class')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Type of Visa</label>
                                            <input type="text" name="type_of_visa" class="form-control" required value="{{ old('type_of_visa', $mongoliaVisa->type_of_visa) }}">
                                            @error('type_of_visa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Entry Type</label>
                                            <input type="text" name="entry_type" class="form-control" required value="{{ old('entry_type', $mongoliaVisa->entry_type) }}">
                                            @error('entry_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visa Issue Date</label>
                                            <input type="date" name="visa_issue_date" class="form-control" required value="{{ old('visa_issue_date', $mongoliaVisa->visa_issue_date) }}">
                                            @error('visa_issue_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visa Effective Date</label>
                                            <input type="date" name="visa_effective_date" class="form-control" required value="{{ old('visa_effective_date', $mongoliaVisa->visa_effective_date) }}">
                                            @error('visa_effective_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visa Validity (Days)</label>
                                            <input type="number" name="visa_validity_days" class="form-control" required value="{{ old('visa_validity_days', $mongoliaVisa->visa_validity_days) }}">
                                            @error('visa_validity_days')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Application Date</label>
                                            <input type="date" name="application_date" class="form-control" required value="{{ old('application_date', $mongoliaVisa->application_date) }}">
                                            @error('application_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Remaining Stay Days</label>
                                            <input type="number" name="remaining_stay_days" class="form-control" required value="{{ old('remaining_stay_days', $mongoliaVisa->remaining_stay_days) }}">
                                            @error('remaining_stay_days')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Port of Entry</label>
                                            <input type="text" name="port_of_entry" class="form-control" required value="{{ old('port_of_entry', $mongoliaVisa->port_of_entry) }}">
                                            @error('port_of_entry')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" required value="{{ old('contact_number', $mongoliaVisa->contact_number) }}">
                                            @error('contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Notice Section Date</label>
                                            <input type="date" name="notice_section_date" class="form-control" required value="{{ old('notice_section_date', $mongoliaVisa->notice_section_date) }}">
                                            @error('notice_section_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button class="btn btn-primary">Update</button>
                                    <a href="{{ route('user.mongolia-visa.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
