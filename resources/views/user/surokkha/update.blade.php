@extends('user.layouts.app')

@section('title')
    @lang($title)
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
    .radio-group {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 1rem;
    }
    .radio-group label {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-edit fa-fw"></i>সুরক্ষা সার্টিফিকেট - সম্পাদনা করুন
                    </h3>
                    <a href="{{ route('user.surokkha.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
                    </a>
                </div>
                <hr class="border-primary opacity-75 mt-3">
            </div>
        </div>

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

        <form action="{{ route('user.surokkha.update', $surokkha->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Beneficiary Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user mr-2"></i>গ্রহীতা তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="certi_no">
                                    <i class="fa fa-certificate text-primary"></i>সার্টিফিকেট নম্বর
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                   
                                    <input type="text" class="form-control @error('certi_no') is-invalid @enderror" id="certi_no" name="certi_no" value="{{ $surokkha->certi_no }}" placeholder="Enter certificate number">
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="required-label">
                                    <i class="fa fa-id-card text-primary"></i>আইডি নির্বাচন করুন
                                </label>
                                <div class="radio-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="nid" value="One" {{ $surokkha->type == 'One' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nid">
                                            এনআইডি নম্বর
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="bn" value="Two" {{ $surokkha->type == 'Two' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bn">
                                            জন্ম নিবন্ধন নম্বর
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3" id="nid_show" style="{{ $surokkha->type == 'One' ? '' : 'display:none' }}">
                                <label for="national_id" class="required-label">
                                    <i class="fa fa-address-card text-primary"></i>জাতীয় আইডি নম্বর
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" id="national_id" name="national_id" placeholder="জাতীয় আইডি নম্বর" value="{{ old('national_id', $surokkha->national_id) }}">
                                    @error('national_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3" id="bn_show" style="{{ $surokkha->type == 'Two' ? '' : 'display:none' }}">
                                <label for="birth_id" class="required-label">
                                    <i class="fa fa-birthday-cake text-primary"></i>জন্ম নিবন্ধন নম্বর
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-heart"></i></span>
                                    <input type="text" class="form-control @error('birth_id') is-invalid @enderror" id="birth_id" name="birth_id" placeholder="জন্ম নিবন্ধন নম্বর" value="{{ old('birth_id', $surokkha->birth_id) }}">
                                    @error('birth_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="passport_no">
                                    <i class="fa fa-passport text-primary"></i>পাসপোর্ট নম্বর
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-journal"></i></span>
                                    <input type="text" class="form-control @error('passport_no') is-invalid @enderror" id="passport_no" name="passport_no" placeholder="পাসপোর্ট নম্বর" value="{{ old('passport_no', $surokkha->passport_no) }}">
                                    @error('passport_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nationality" class="required-label">
                                    <i class="fa fa-flag text-primary"></i>জাতীয়তা
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <select class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="Bangladeshi" {{ old('nationality', $surokkha->nationality) == 'Bangladeshi' ? 'selected' : '' }}>বাংলাদেশী</option>
                                        <option value="India" {{ old('nationality', $surokkha->nationality) == 'India' ? 'selected' : '' }}>ভারতীয়</option>
                                    </select>
                                    @error('nationality')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name" class="required-label">
                                    <i class="fa fa-user text-primary"></i>নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="পূর্ণ নাম" value="{{ old('name', $surokkha->name) }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="date_birth" class="required-label">
                                    <i class="fa fa-calendar text-primary"></i>জন্ম তারিখ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" class="form-control @error('date_birth') is-invalid @enderror" id="date_birth" name="date_birth" value="{{ old('date_birth', $surokkha->date_birth) }}">
                                    @error('date_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="gender" class="required-label">
                                    <i class="fa fa-venus-mars text-primary"></i>লিঙ্গ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="Male" {{ old('gender', $surokkha->gender) == 'Male' ? 'selected' : '' }}>পুরুষ</option>
                                        <option value="Female" {{ old('gender', $surokkha->gender) == 'Female' ? 'selected' : '' }}>মহিলা</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vaccination Details -->
                <div class="col-lg-6">
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-syringe mr-2"></i>টিকা প্রদানের বিবরণ
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Dose 1 -->
                            <div class="form-group mb-3">
                                <label for="dose-1">
                                    <i class="fa fa-calendar text-primary"></i>প্রথম ডোজের তারিখ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('doseone_date') is-invalid @enderror" id="dose-1" name="doseone_date" value="{{ old('doseone_date', $surokkha->doseone_date) }}">
                                    @error('doseone_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="doseone_name">
                                    <i class="fa fa-vial text-primary"></i>প্রথম ডোজের টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-droplet"></i></span>
                                    <select class="form-control @error('doseone_name') is-invalid @enderror" id="doseone_name" name="doseone_name" onchange="vc1(this);">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="1" {{ old('doseone_name', $surokkha->doseone_name) == '1' ? 'selected' : '' }}>Pfizer (Pfizer-BioNTech)</option>
                                        <option value="2" {{ old('doseone_name', $surokkha->doseone_name) == '2' ? 'selected' : '' }}>COVISHIELD (AstraZeneca)</option>
                                        <option value="3" {{ old('doseone_name', $surokkha->doseone_name) == '3' ? 'selected' : '' }}>Moderna (Moderna)</option>
                                        <option value="4" {{ old('doseone_name', $surokkha->doseone_name) == '4' ? 'selected' : '' }}>Vero Cell (Sinopharm)</option>
                                        <option value="5" {{ old('doseone_name', $surokkha->doseone_name) == '5' ? 'selected' : '' }}>Janssen (Johnson & Johnson)</option>
                                        <option value="other1" {{ old('doseone_name', $surokkha->doseone_name) == 'other1' ? 'selected' : '' }}>অন্যান্য</option>
                                    </select>
                                    @error('doseone_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3" id="ifYesv1" style="{{ old('doseone_name', $surokkha->doseone_name) == 'other1' ? '' : 'display: none;' }}">
                                <label for="doseone_name2">
                                    <i class="fa fa-edit text-primary"></i>অন্যান্য টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <input type="text" class="form-control @error('doseone_name2') is-invalid @enderror" id="doseone_name2" name="doseone_name2" placeholder="টিকার নাম লিখুন" value="{{ old('doseone_name2', $surokkha->doseone_name2) }}">
                                    @error('doseone_name2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dose 2 -->
                            <div class="form-group mb-3">
                                <label for="dose-2">
                                    <i class="fa fa-calendar text-primary"></i>দ্বিতীয় ডোজের তারিখ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('dosetwo_date') is-invalid @enderror" id="dose-2" name="dosetwo_date" value="{{ old('dosetwo_date', $surokkha->dosetwo_date) }}">
                                    @error('dosetwo_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="dosetwo_name">
                                    <i class="fa fa-vial text-primary"></i>দ্বিতীয় ডোজের টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-droplet"></i></span>
                                    <select class="form-control @error('dosetwo_name') is-invalid @enderror" id="dosetwo_name" name="dosetwo_name" onchange="vc2(this);">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="Pfizer (Pfizer-BioNTech)" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'Pfizer (Pfizer-BioNTech)' ? 'selected' : '' }}>Pfizer (Pfizer-BioNTech)</option>
                                        <option value="COVISHIELD" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'COVISHIELD' ? 'selected' : '' }}>COVISHIELD (AstraZeneca)</option>
                                        <option value="Moderna (Moderna)" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'Moderna (Moderna)' ? 'selected' : '' }}>Moderna (Moderna)</option>
                                        <option value="Vero Cell (Sinopharm)" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'Vero Cell (Sinopharm)' ? 'selected' : '' }}>Vero Cell (Sinopharm)</option>
                                        <option value="Janssen (Johnson &amp;" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'Janssen (Johnson &amp;' ? 'selected' : '' }}>Janssen (Johnson & Johnson)</option>
                                        <option value="other2" {{ old('dosetwo_name', $surokkha->dosetwo_name) == 'other2' ? 'selected' : '' }}>অন্যান্য</option>
                                    </select>
                                    @error('dosetwo_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3" id="ifYesv2" style="{{ old('dosetwo_name', $surokkha->dosetwo_name) == 'other2' ? '' : 'display: none;' }}">
                                <label for="dosetwo_name2">
                                    <i class="fa fa-edit text-primary"></i>অন্যান্য টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <input type="text" class="form-control @error('dosetwo_name2') is-invalid @enderror" id="dosetwo_name2" name="dosetwo_name2" placeholder="টিকার নাম লিখুন" value="{{ old('dosetwo_name2', $surokkha->dosetwo_name2) }}">
                                    @error('dosetwo_name2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dose 3 -->
                            <div class="form-group mb-3">
                                <label for="dose-3">
                                    <i class="fa fa-calendar text-primary"></i>তৃতীয় ডোজের তারিখ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('dosethree_date') is-invalid @enderror" id="dose-3" name="dosethree_date" value="{{ old('dosethree_date', $surokkha->dosethree_date) }}">
                                    @error('dosethree_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="dosethree_name">
                                    <i class="fa fa-vial text-primary"></i>তৃতীয় ডোজের টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-droplet"></i></span>
                                    <select class="form-control @error('dosethree_name') is-invalid @enderror" id="dosethree_name" name="dosethree_name" onchange="vc3(this);">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="1" {{ old('dosethree_name', $surokkha->dosethree_name) == '1' ? 'selected' : '' }}>Pfizer (Pfizer-BioNTech)</option>
                                        <option value="2" {{ old('dosethree_name', $surokkha->dosethree_name) == '2' ? 'selected' : '' }}>COVISHIELD (AstraZeneca)</option>
                                        <option value="3" {{ old('dosethree_name', $surokkha->dosethree_name) == '3' ? 'selected' : '' }}>Moderna (Moderna)</option>
                                        <option value="4" {{ old('dosethree_name', $surokkha->dosethree_name) == '4' ? 'selected' : '' }}>Vero Cell (Sinopharm)</option>
                                        <option value="5" {{ old('dosethree_name', $surokkha->dosethree_name) == '5' ? 'selected' : '' }}>Janssen (Johnson & Johnson)</option>
                                        <option value="other3" {{ old('dosethree_name', $surokkha->dosethree_name) == 'other3' ? 'selected' : '' }}>অন্যান্য</option>
                                    </select>
                                    @error('dosethree_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3" id="ifYesv3" style="{{ old('dosethree_name', $surokkha->dosethree_name) == 'other3' ? '' : 'display: none;' }}">
                                <label for="dosethree_name2">
                                    <i class="fa fa-edit text-primary"></i>অন্যান্য টিকার নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <input type="text" class="form-control @error('dosethree_name2') is-invalid @enderror" id="dosethree_name2" name="dosethree_name2" placeholder="টিকার নাম লিখুন" value="{{ old('dosethree_name2', $surokkha->dosethree_name2) }}">
                                    @error('dosethree_name2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Vaccination Center -->
                            <div class="form-group mb-3">
                                <label for="vacc_center" class="required-label">
                                    <i class="fa fa-hospital text-primary"></i>টিকা কেন্দ্র
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select class="form-control @error('vacc_center') is-invalid @enderror" id="vacc_center" name="vacc_center" onchange="center(this);">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="Bagerhat 250 Bed Hospital" {{ old('vacc_center', $surokkha->vacc_center) == 'Bagerhat 250 Bed Hospital' ? 'selected' : '' }}>Bagerhat 250 Bed Hospital</option>
                                        <option value="Dhaka Medical College Hospital" {{ old('vacc_center', $surokkha->vacc_center) == 'Dhaka Medical College Hospital' ? 'selected' : '' }}>Dhaka Medical College Hospital</option>
                                        <option value="Combined Military Hospital (CMH)" {{ old('vacc_center', $surokkha->vacc_center) == 'Combined Military Hospital (CMH)' ? 'selected' : '' }}>Combined Military Hospital (CMH)</option>
                                        <option value="other" {{ old('vacc_center', $surokkha->vacc_center) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                    </select>
                                    @error('vacc_center')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3" id="ifYes" style="{{ old('vacc_center', $surokkha->vacc_center) == 'other' ? '' : 'display: none;' }}">
                                <label for="vacc_center2" class="required-label">
                                    <i class="fa fa-edit text-primary"></i>অন্যান্য টিকা কেন্দ্রের নাম
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <input type="text" class="form-control @error('vacc_center2') is-invalid @enderror" id="vacc_center2" name="vacc_center2" placeholder="টিকা কেন্দ্রের নাম লিখুন" value="{{ old('vacc_center2', $surokkha->vacc_center2) }}">
                                    @error('vacc_center2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="vacc_by">
                                    <i class="fa fa-user-md text-primary"></i>টিকা প্রদানকারী
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-check"></i></span>
                                    <input type="text" class="form-control @error('vacc_by') is-invalid @enderror" id="vacc_by" name="vacc_by" value="Directorate General of Health Services (DGHS)" readonly>
                                    @error('vacc_by')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="total_dose" class="required-label">
                                    <i class="fa fa-syringe text-primary"></i>মোট ডোজ সংখ্যা
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" class="form-control @error('total_dose') is-invalid @enderror" id="total_dose" name="total_dose" placeholder="মোট ডোজ সংখ্যা" value="{{ old('total_dose', $surokkha->total_dose) }}" min="1" max="3">
                                    @error('total_dose')
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

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="fa fa-save"></i> আপডেট করুন
                    </button>
                    <a href="{{ route('user.surokkha.index') }}" class="btn btn-danger btn-lg ml-3">
                        <i class="fa fa-times"></i> বাতিল
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize radio button functionality
        let val = $('input[type=radio][name=type]').val();
        toggleIdFields(val);
        
        $('input[type=radio][name=type]').change(function() {
            toggleIdFields(this.value);
        });

        function toggleIdFields(value) {
            if (value == 'One') {
                $('#nid_show').show();
                $('#bn_show').hide();
                $('#national_id').prop('required', true);
                $('#birth_id').prop('required', false);
            } else if (value == 'Two') {
                $('#nid_show').hide();
                $('#bn_show').show();
                $('#national_id').prop('required', false);
                $('#birth_id').prop('required', true);
            } else {
                $('#nid_show').hide();
                $('#bn_show').hide();
                $('#national_id').prop('required', false);
                $('#birth_id').prop('required', false);
            }
        }

        // Set max date for date fields to today
        const today = new Date().toISOString().split('T')[0];
        $('#date_birth').attr('max', today);
        $('#dose-1').attr('max', today);
        $('#dose-2').attr('max', today);
        $('#dose-3').attr('max', today);

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    function center(that) {
        if (that.value == "other") {
            document.getElementById("ifYes").style.display = "block";
            document.getElementById("vacc_center2").required = true;
        } else {
            document.getElementById("ifYes").style.display = "none";
            document.getElementById("vacc_center2").required = false;
        }
    }

    function vc1(that) {
        if (that.value == "other1") {
            document.getElementById("ifYesv1").style.display = "block";
            document.getElementById("doseone_name2").required = true;
        } else {
            document.getElementById("ifYesv1").style.display = "none";
            document.getElementById("doseone_name2").required = false;
        }
    }

    function vc2(that) {
        if (that.value == "other2") {
            document.getElementById("ifYesv2").style.display = "block";
            document.getElementById("dosetwo_name2").required = true;
        } else {
            document.getElementById("ifYesv2").style.display = "none";
            document.getElementById("dosetwo_name2").required = false;
        }
    }

    function vc3(that) {
        if (that.value == "other3") {
            document.getElementById("ifYesv3").style.display = "block";
            document.getElementById("dosethree_name2").required = true;
        } else {
            document.getElementById("ifYesv3").style.display = "none";
            document.getElementById("dosethree_name2").required = false;
        }
    }
</script>
@endpush