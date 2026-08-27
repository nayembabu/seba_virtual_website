@extends('user.layouts.app')

@section('title')
    জন্ম নিবন্ধন - তৈরি করুন
@endsection

@section('content')
@php
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'nibondon')->first();
@endphp

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-plus-circle mr-2"></i> জন্ম নিবন্ধন - তৈরি করুন
                    </h5>
                    <a href="{{ route('user.nibondon.index') }}" class="btn btn-outline-dark btn-sm px-3">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body p-4">
                    @if($serviceCharge)
                        <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                <div>
                                    <h6 class="alert-heading mb-1 font-weight-bold">সার্ভিস চার্জ</h6> 
                                    <p class="mb-0 small text-muted">প্রতিটি জন্ম নিবন্ধন তৈরির জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> টাকা কাটা হবে।</p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('user.nibondon.store') }}" method="POST" enctype="multipart/form-data" id="birthRegistrationForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-6">
                                <div class="bg-light p-3 rounded mb-4">
                                    <h6 class="font-weight-bold text-primary mb-3 border-bottom pb-2">
                                        <i class="fas fa-user mr-2"></i> ব্যক্তিগত তথ্য
                                    </h6>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark">নাম (ইংরেজি) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" placeholder="Enter name in English" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark">নাম (বাংলা) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" name="name_bn" value="{{ old('name_bn') }}" placeholder="নাম বাংলায় লিখুন" required>
                                    </div>

                            <!-- Gender -->
                            <div class="form-group mb-3">
                                <label for="gender">
                                    <i class="fa fa-venus-mars text-primary"></i> লিঙ্গ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>মহিলা</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="form-group mb-3">
                                <label for="date_of_birth">
                                    <i class="fa fa-calendar text-primary"></i> জন্ম তারিখ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birth Place English -->
                            <div class="form-group mb-3">
                                <label for="birth_place_en">
                                    <i class="fa fa-map-marker text-primary"></i> জন্মস্থান (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                    <input type="text" class="form-control @error('birth_place_en') is-invalid @enderror" id="birth_place_en" name="birth_place_en" value="{{ old('birth_place_en') }}" required>
                                    @error('birth_place_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birth Place Bangla -->
                            <div class="form-group mb-3">
                                <label for="birth_place_bn">
                                    <i class="fa fa-map-marker text-primary"></i> জন্মস্থান (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                    <input type="text" class="form-control @error('birth_place_bn') is-invalid @enderror" id="birth_place_bn" name="birth_place_bn" value="{{ old('birth_place_bn') }}" required>
                                    @error('birth_place_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-users mr-2"></i> পিতা-মাতার তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Father Name English -->
                            <div class="form-group mb-3">
                                <label for="father_name_en">
                                    <i class="fa fa-user text-primary"></i> পিতার নাম (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('father_name_en') is-invalid @enderror" id="father_name_en" name="father_name_en" value="{{ old('father_name_en') }}" required>
                                    @error('father_name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Father Name Bangla -->
                            <div class="form-group mb-3">
                                <label for="father_name_bn">
                                    <i class="fa fa-user text-primary"></i> পিতার নাম (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('father_name_bn') is-invalid @enderror" id="father_name_bn" name="father_name_bn" value="{{ old('father_name_bn') }}" required>
                                    @error('father_name_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Father Nationality English -->
                            <div class="form-group mb-3">
                                <label for="father_nationality_en">
                                    <i class="fa fa-flag text-primary"></i> পিতার জাতীয়তা (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="text" class="form-control @error('father_nationality_en') is-invalid @enderror" id="father_nationality_en" name="father_nationality_en" value="{{ old('father_nationality_en', 'Bangladeshi') }}" required>
                                    @error('father_nationality_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Father Nationality Bangla -->
                            <div class="form-group mb-3">
                                <label for="father_nationality_bn">
                                    <i class="fa fa-flag text-primary"></i> পিতার জাতীয়তা (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="text" class="form-control @error('father_nationality_bn') is-invalid @enderror" id="father_nationality_bn" name="father_nationality_bn" value="{{ old('father_nationality_bn', 'বাংলাদেশী') }}" required>
                                    @error('father_nationality_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mother Name English -->
                            <div class="form-group mb-3">
                                <label for="mother_name_en">
                                    <i class="fa fa-user text-primary"></i> মাতার নাম (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('mother_name_en') is-invalid @enderror" id="mother_name_en" name="mother_name_en" value="{{ old('mother_name_en') }}" required>
                                    @error('mother_name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mother Name Bangla -->
                            <div class="form-group mb-3">
                                <label for="mother_name_bn">
                                    <i class="fa fa-user text-primary"></i> মাতার নাম (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('mother_name_bn') is-invalid @enderror" id="mother_name_bn" name="mother_name_bn" value="{{ old('mother_name_bn') }}" required>
                                    @error('mother_name_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mother Nationality English -->
                            <div class="form-group mb-3">
                                <label for="mother_nationality_en">
                                    <i class="fa fa-flag text-primary"></i> মাতার জাতীয়তা (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="text" class="form-control @error('mother_nationality_en') is-invalid @enderror" id="mother_nationality_en" name="mother_nationality_en" value="{{ old('mother_nationality_en', 'Bangladeshi') }}" required>
                                    @error('mother_nationality_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mother Nationality Bangla -->
                            <div class="form-group mb-3">
                                <label for="mother_nationality_bn">
                                    <i class="fa fa-flag text-primary"></i> মাতার জাতীয়তা (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="text" class="form-control @error('mother_nationality_bn') is-invalid @enderror" id="mother_nationality_bn" name="mother_nationality_bn" value="{{ old('mother_nationality_bn', 'বাংলাদেশী') }}" required>
                                    @error('mother_nationality_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Registration Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt mr-2"></i> নিবন্ধন তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Registration Number -->
                            <div class="form-group mb-3">
                                <label for="registration_no">
                                    <i class="fa fa-id-badge text-primary"></i> নিবন্ধন নম্বর<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control @error('registration_no') is-invalid @enderror" id="registration_no" name="registration_no" value="{{ old('registration_no') }}" required>
                                    @error('registration_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Registration Date -->
                            <div class="form-group mb-3">
                                <label for="registration_date">
                                    <i class="fa fa-calendar text-primary"></i> নিবন্ধন তারিখ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date') }}" required>
                                    @error('registration_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Issue Date -->
                            <div class="form-group mb-3">
                                <label for="issue_date">
                                    <i class="fa fa-calendar text-primary"></i> ইস্যু তারিখ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date') }}" required>
                                    @error('issue_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Office Name Bangla -->
                            <div class="form-group mb-3">
                                <label for="office_name_bn">
                                    <i class="fa fa-building text-primary"></i> অফিসের নাম (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control @error('office_name_bn') is-invalid @enderror" id="office_name_bn" name="office_name_bn" value="{{ old('office_name_bn') }}" required>
                                    @error('office_name_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- District Info Bangla -->
                            <div class="form-group mb-3">
                                <label for="district_info_bn">
                                    <i class="fa fa-map text-primary"></i> জেলার তথ্য (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                    <input type="text" class="form-control @error('district_info_bn') is-invalid @enderror" id="district_info_bn" name="district_info_bn" value="{{ old('district_info_bn') }}" required>
                                    @error('district_info_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-home mr-2"></i> ঠিকানা তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Permanent Address English -->
                            <div class="form-group mb-3">
                                <label for="permanent_address_en">
                                    <i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                    <textarea class="form-control @error('permanent_address_en') is-invalid @enderror" id="permanent_address_en" name="permanent_address_en" rows="3" required>{{ old('permanent_address_en') }}</textarea>
                                    @error('permanent_address_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Permanent Address Bangla -->
                            <div class="form-group mb-3">
                                <label for="permanent_address_bn">
                                    <i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                    <textarea class="form-control @error('permanent_address_bn') is-invalid @enderror" id="permanent_address_bn" name="permanent_address_bn" rows="3" required>{{ old('permanent_address_bn') }}</textarea>
                                    @error('permanent_address_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>

                        <!-- Submit Buttons -->
                        <div class="text-right mt-4 border-top pt-4">
                            <button type="reset" class="btn btn-light px-4 mr-2 font-weight-bold">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm font-weight-bold">
                                <i class="fas fa-save mr-1"></i> জমা দিন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card { border-radius: 10px; }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #f0f0f0; }
    .form-control { border-radius: 6px; padding: 10px 15px; height: auto; border: 1px solid #e0e0e0; font-size: 14px; }
    .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1); border-color: #80bdff; }
    label { font-size: 13px; margin-bottom: 8px; color: #555; }
    .btn { border-radius: 6px; font-weight: 600; }
    .bg-light { background-color: #f8f9fa !important; }
</style>
@endpush

@push('scripts')
<script>
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var form = document.getElementById('birthRegistrationForm');
            
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();

    // Auto-fill related fields (optional enhancement)
    document.addEventListener('DOMContentLoaded', function() {
        // Set today's date as default for issue_date if empty
        const issueDateInput = document.getElementById('issue_date');
        if (!issueDateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            issueDateInput.value = today;
        }

        // Validate registration date is not in future
        const registrationDateInput = document.getElementById('registration_date');
        registrationDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate > today) {
                alert('নিবন্ধন তারিখ ভবিষ্যতের হতে পারে না');
                this.value = '';
            }
        });

        // Validate date of birth is not in future
        const dobInput = document.getElementById('date_of_birth');
        dobInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate > today) {
                alert('জন্ম তারিখ ভবিষ্যতের হতে পারে না');
                this.value = '';
            }
        });

        // Ensure registration date is after birth date
        function validateDates() {
            const dobValue = dobInput.value;
            const regDateValue = registrationDateInput.value;
            
            if (dobValue && regDateValue) {
                const dob = new Date(dobValue);
                const regDate = new Date(regDateValue);
                
                if (regDate < dob) {
                    alert('নিবন্ধন তারিখ জন্ম তারিখের পরে হতে হবে');
                    registrationDateInput.value = '';
                }
            }
        }

        dobInput.addEventListener('change', validateDates);
        registrationDateInput.addEventListener('change', validateDates);
    });
</script>
