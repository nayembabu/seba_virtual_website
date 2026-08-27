@extends('user.layouts.app')

@section('title')
    মৃত্যু সনদপত্র - তৈরি করুন
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    .form-group {
        margin-bottom: 1rem;
    }
    .card-body {
        padding: 1rem;
    }
    .form-control {
        padding: 0.4rem 0.75rem;
        height: calc(1.5em + 0.75rem + 2px);
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        padding: 0.65rem 1rem;
        height: calc(1.5em + 1.3rem + 2px);
        font-size: 1rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus {
        border-color: #3699ff;
        box-shadow: 0 0 0 0.2rem rgba(54, 153, 255, 0.25);
    }
    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f7f8fa;
        opacity: 1;
    }
    .card {
        border: none;
        box-shadow: 0 0 20px 0 rgba(76, 87, 125, 0.02);
        margin-bottom: 2rem;
    }
    .card-header {
        background-color: #f7f8fa;
        border-bottom: 1px solid #ebedf2;
        padding: 1rem 1.25rem;
    }
    .section-title {
        color: #181C32;
        font-size: 1.275rem;
        font-weight: 600;
    }
    .required-label::after {
        content: " *";
        color: #f64e60;
    }
    .form-text {
        color: #7E8299;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }
    .btn-lg {
        padding: 0.825rem 1.42rem;
        font-size: 1.08rem;
        line-height: 1.5;
        border-radius: 0.42rem;
    }
    .alert {
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.42rem;
    }
    .border-left {
        border-left: 0.25rem solid !important;
    }
</style>

@php
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'death_certificate')->first();
@endphp

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-file-medical fa-fw"></i> মৃত্যু সনদপত্র - তৈরি
                    </h3>
                    <a href="{{ route('user.death_certificate.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
                    </a>
                </div>
                <hr class="border-primary opacity-75 mt-3">
            </div>
        </div>

        @if($serviceCharge)
            <div class="alert alert-info border-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x mr-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">সার্ভিস চার্জ</h4> 
                        <p class="mb-0">প্রতিটি সনদপত্র তৈরির জন্য <span class="font-weight-bold" style="color:red;">{{ number_format($serviceCharge->amount, 1) }}</span> টাকা কাটা হবে।</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-left border-danger border-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">ত্রুটি সংশোধন করুন!</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-times-circle mr-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('user.death_certificate.store') }}" method="POST" enctype="multipart/form-data" id="deathCertificateForm" class="needs-validation" novalidate>
            @csrf
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Office Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-building mr-2"></i> অফিস তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-university text-primary"></i> নিবন্ধন নম্বর<span class="text-danger">*</span></label>
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

                            <div class="form-group mb-3">
                                <label><i class="fa fa-building text-primary"></i> অফিসের নাম<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control @error('office_name') is-invalid @enderror" id="office_name" name="office_name" value="{{ old('office_name') }}" required>
                                    @error('office_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-map-marker text-primary"></i> অফিসের ঠিকানা<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea class="form-control @error('office_address') is-invalid @enderror" id="office_address" name="office_address" rows="2" required>{{ old('office_address') }}</textarea>
                                    @error('office_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deceased Personal Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-danger text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user mr-2"></i> মৃত ব্যক্তির তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-translate"></i></span>
                                    <input type="text" class="form-control @error('name_bengali') is-invalid @enderror" id="name_bengali" name="name_bengali" value="{{ old('name_bengali') }}" required>
                                    @error('name_bengali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> নাম (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-fonts"></i></span>
                                    <input type="text" class="form-control @error('name_english') is-invalid @enderror" id="name_english" name="name_english" value="{{ old('name_english') }}">
                                    @error('name_english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-venus-mars text-primary"></i> লিঙ্গ<span class="text-danger">*</span></label>
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

                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> মৃত্যুর তারিখ<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" class="form-control @error('date_of_death') is-invalid @enderror" id="date_of_death" name="date_of_death" value="{{ old('date_of_death') }}" required>
                                    @error('date_of_death')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-envelope text-primary"></i> ইমেইল</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
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
                    <!-- Family Information -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-users mr-2"></i> পারিবারিক তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-male text-primary"></i> পিতার নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('father_name_bengali') is-invalid @enderror" id="father_name_bengali" name="father_name_bengali" value="{{ old('father_name_bengali') }}" required>
                                    @error('father_name_bengali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-male text-primary"></i> পিতার নাম (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('father_name_english') is-invalid @enderror" id="father_name_english" name="father_name_english" value="{{ old('father_name_english') }}">
                                    @error('father_name_english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-female text-primary"></i> মাতার নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('mother_name_bengali') is-invalid @enderror" id="mother_name_bengali" name="mother_name_bengali" value="{{ old('mother_name_bengali') }}" required>
                                    @error('mother_name_bengali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-female text-primary"></i> মাতার নাম (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('mother_name_english') is-invalid @enderror" id="mother_name_english" name="mother_name_english" value="{{ old('mother_name_english') }}">
                                    @error('mother_name_english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marked-alt mr-2"></i> ঠিকানা সংক্রান্ত
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-hospital text-primary"></i> মৃত্যুর স্থান (বাংলায়)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                    <input type="text" class="form-control @error('place_of_death_bengali') is-invalid @enderror" id="place_of_death_bengali" name="place_of_death_bengali" value="{{ old('place_of_death_bengali') }}" required>
                                    @error('place_of_death_bengali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-hospital text-primary"></i> মৃত্যুর স্থান (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                    <input type="text" class="form-control @error('place_of_death_english') is-invalid @enderror" id="place_of_death_english" name="place_of_death_english" value="{{ old('place_of_death_english') }}">
                                    @error('place_of_death_english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (বাংলায়)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                    <textarea class="form-control @error('permanent_address_bengali') is-invalid @enderror" id="permanent_address_bengali" name="permanent_address_bengali" rows="2" required>{{ old('permanent_address_bengali') }}</textarea>
                                    @error('permanent_address_bengali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <textarea class="form-control @error('permanent_address_english') is-invalid @enderror" id="permanent_address_english" name="permanent_address_english" rows="2">{{ old('permanent_address_english') }}</textarea>
                                    @error('permanent_address_english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Information -->
                    
                </div>
                </div>
               
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-certificate mr-2"></i> সনদপত্র তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> নিবন্ধন তারিখ<span class="text-danger">*</span></label>
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

                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> ইস্যু তারিখ<span class="text-danger">*</span></label>
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
            </div>

            <!-- Submit Buttons -->
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="fa fa-save"></i> জমা দিন
                    </button>
                    <a href="{{ route('user.death_certificate.index') }}" class="btn btn-danger btn-lg ml-3">
                        <i class="fa fa-times"></i> বাতিল
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<style>
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .card-header {
        border-bottom: 0;
        padding: 1rem 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Flatpickr for date fields
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_of_death", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });
        
        flatpickr("#registration_date", {
            dateFormat: "Y-m-d"
        });
        
        flatpickr("#issue_date", {
            dateFormat: "Y-m-d"
        });
    });

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush