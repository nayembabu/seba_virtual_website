@extends('user.layouts.app')

@section('title')
    সাইন টু সার্ভার - তৈরি করুন
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
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #3699ff;
        box-shadow: 0 0 0 0.2rem rgba(54, 153, 255, 0.25);
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
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'sign_to_server')->first();
@endphp

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-graduation-cap fa-fw"></i> সাইন টু সার্ভার - তৈরি
                    </h3>
                    <a href="{{ route('user.sign-to-server.index') }}" class="btn btn-dark">
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
                        <p class="mb-0"  >প্রতিটি কার্ড তৈরির জন্য <span class="font-weight-bold"  style="color:red; " > {{ number_format($serviceCharge->amount, 1) }}</span> টাকা কাটা হবে।</p>
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
                     <form action="{{ route('user.sign-to-server.store') }}" method="POST" enctype="multipart/form-data" id="signForm" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header bg-info text-white py-3">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-alt mr-2"></i>পারিবারিক তথ্য
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        
                                            <!-- Name in Bangla -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-user text-primary"></i> নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name_bangla') is-invalid @enderror" 
                                       name="name_bangla"
                                       value="{{ old('name_bangla') }}"
                                       placeholder="বাংলায় নাম লিখুন"
                                       required>
                                @error('name_bangla')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <!-- Name in English -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-user text-primary"></i> নাম (ইংরেজি)<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name_english') is-invalid @enderror" 
                                       name="name_english"
                                       value="{{ old('name_english') }}"
                                       placeholder="ইংরেজিতে নাম লিখুন"
                                       required>
                                @error('name_english')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                       
                             <!-- Father's Name -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-male text-primary"></i> পিতার নাম<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('father_name') is-invalid @enderror" 
                                       name="father_name"
                                       value="{{ old('father_name') }}"
                                       placeholder="পিতার নাম লিখুন"
                                       required>
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mother's Name -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-female text-primary"></i> মাতার নাম<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('mother_name') is-invalid @enderror" 
                                       name="mother_name"
                                       value="{{ old('mother_name') }}"
                                       placeholder="মাতার নাম লিখুন"
                                       required>
                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Father's ID -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-id-card text-primary"></i> পিতার আইডি</label>
                                <input type="text" 
                                       class="form-control @error('father_id') is-invalid @enderror" 
                                       name="father_id"
                                       value="{{ old('father_id') }}"
                                       placeholder="পিতার আইডি লিখুন">
                                @error('father_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mother's ID -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-id-card text-primary"></i> মাতার আইডি</label>
                                <input type="text" 
                                       class="form-control @error('mother_id') is-invalid @enderror" 
                                       name="mother_id"
                                       value="{{ old('mother_id') }}"
                                       placeholder="মাতার আইডি লিখুন">
                                @error('mother_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-venus-mars text-primary"></i> লিঙ্গ<span class="text-danger">*</span></label>
                                <select class="form-control @error('gender') is-invalid @enderror" 
                                        name="gender"
                                        required>
                                    <option value="">লিঙ্গ নির্বাচন করুন</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>মহিলা</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Spouse Name -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-heart text-primary"></i> স্বামী/স্ত্রীর নাম</label>
                                <input type="text" 
                                       class="form-control @error('spouse_name') is-invalid @enderror" 
                                       name="spouse_name"
                                       value="{{ old('spouse_name') }}"
                                       placeholder="স্বামী/স্ত্রীর নাম লিখুন">
                                @error('spouse_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-phone text-primary"></i> ফোন নম্বর<span class="text-danger">*</span></label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="ফোন নম্বর লিখুন"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Date of Birth -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> জন্ম তারিখ<span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth') }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <!-- Place of Birth -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-map-marker text-primary"></i> জন্মস্থান<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('place_of_birth') is-invalid @enderror" 
                                       name="place_of_birth"
                                       value="{{ old('place_of_birth') }}"
                                       placeholder="জন্মস্থান লিখুন"
                                       required>
                                @error('place_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Education -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-graduation-cap text-primary"></i> শিক্ষাগত যোগ্যতা<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('education') is-invalid @enderror" 
                                       name="education"
                                       value="{{ old('education') }}"
                                       placeholder="শিক্ষাগত যোগ্যতা লিখুন"
                                       required>
                                @error('education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                              <!-- Occupation -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-briefcase text-primary"></i> পেশা<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('occupation') is-invalid @enderror" 
                                       name="occupation"
                                       value="{{ old('occupation') }}"
                                       placeholder="পেশা লিখুন"
                                       required>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <!-- Blood Group -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-tint text-primary"></i> রক্তের গ্রুপ</label>
                                <select class="form-control @error('blood_group') is-invalid @enderror" 
                                        name="blood_group">
                                    <option value="">রক্তের গ্রুপ নির্বাচন করুন</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>এ পজিটিভ (A+)</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>এ নেগেটিভ (A-)</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>বি পজিটিভ (B+)</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>বি নেগেটিভ (B-)</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>এবি পজিটিভ (AB+)</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>এবি নেগেটিভ (AB-)</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>ও পজিটিভ (O+)</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>ও নেগেটিভ (O-)</option>
                                </select>
                                @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Religion -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-book text-primary"></i> ধর্ম<span class="text-danger">*</span></label>
                                <select class="form-control @error('religion') is-invalid @enderror" 
                                        name="religion"
                                        required>
                                    <option value="">ধর্ম নির্বাচন করুন</option>
                                    <option value="islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>ইসলাম</option>
                                    <option value="hinduism" {{ old('religion') == 'Hinduism' ? 'selected' : '' }}>হিন্দু</option>
                                    <option value="christianity" {{ old('religion') == 'Christianity' ? 'selected' : '' }}>খ্রিস্টান</option>
                                    <option value="buddhism" {{ old('religion') == 'Buddhism' ? 'selected' : '' }}>বৌদ্ধ</option>
                                    <option value="other" {{ old('religion') == 'Other' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>






                            <!-- Hidden fields for formatted date -->
                            <input type="hidden" name="dob_day_month_words" id="dob_day_month_words">
                            <input type="hidden" name="dob_year_words" id="dob_year_words">
                        </div>
                    </div>
                </div>

                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-school mr-2"></i>ঠিকানা সংক্রান্ত 
                    </div>
                    <div class="card-body">
                        <div class="form-row">

                            <!-- Address -->
                            <div class="col-md-12 mb-3">
                              <label><i class="fa fa-home text-primary"></i> ঠিকানা<span class="text-danger">*</span></label>
                                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" placeholder="ঠিকানা লিখুন" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Present Address -->
                            <div class="col-md-12 mb-3">
                               <label><i class="fa fa-map-marker text-primary"></i> বর্তমান ঠিকানা<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('present_address') is-invalid @enderror" 
                                          name="present_address"
                                          rows="3"
                                          placeholder="বর্তমান ঠিকানা লিখুন"
                                          required>{{ old('present_address') }}</textarea>
                                @error('present_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Permanent Address -->
                            <div class="col-md-12 mb-3">
                                <label><i class="fa fa-map-pin text-primary"></i> স্থায়ী ঠিকানা<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('permanent_address') is-invalid @enderror" 
                                          name="permanent_address"
                                          rows="3"
                                          placeholder="স্থায়ী ঠিকানা লিখুন"
                                          required>{{ old('permanent_address') }}</textarea>
                                @error('permanent_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-certificate mr-2"></i>ব্যক্তিগত তথ্য
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <!-- Photo Upload -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-camera text-primary"></i> ফটো<span class="text-danger">*</span></label>
                                <input type="file" 
                                       class="form-control @error('photo') is-invalid @enderror" 
                                       name="photo"
                                       accept="image/*"
                                       required>
                                <small class="text-muted">পাসপোর্ট সাইজ ফটো আপলোড করুন</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Signature Upload -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-pencil text-primary"></i> স্বাক্ষর<span class="text-danger">*</span></label>
                                <input type="file" 
                                       class="form-control @error('signature') is-invalid @enderror" 
                                       name="signature"
                                       accept="image/*"
                                       required>
                                <small class="text-muted">স্বাক্ষরের ছবি আপলোড করুন</small>
                                @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-info mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card mr-2"></i>সনদপত্র তথ্য
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                              
                            <!-- ID Number -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-id-badge text-primary"></i> আইডি নম্বর<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('id_number') is-invalid @enderror" 
                                       name="id_number"
                                       value="{{ old('id_number') }}"
                                       placeholder="আইডি নম্বর লিখুন"
                                       required>
                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PIN Number -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-key text-primary"></i> পিন নম্বর<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('pin_number') is-invalid @enderror" 
                                       name="pin_number"
                                       value="{{ old('pin_number') }}"
                                       placeholder="পিন নম্বর লিখুন"
                                       required>
                                @error('pin_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Form No -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-file-text text-primary"></i> ফর্ম নম্বর<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('form_no') is-invalid @enderror" 
                                       name="form_no"
                                       value="{{ old('form_no') }}"
                                       placeholder="ফর্ম নম্বর লিখুন"
                                       required>
                                @error('form_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voter No -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-list-ol text-primary"></i> ভোটার নম্বর<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('voter_no') is-invalid @enderror" 
                                       name="voter_no"
                                       value="{{ old('voter_no') }}"
                                       placeholder="ভোটার নম্বর লিখুন"
                                       required>
                                @error('voter_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Serial No -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-sort-numeric-asc text-primary"></i> সিরিয়াল নম্বর<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('serial_no') is-invalid @enderror" 
                                       name="serial_no"
                                       value="{{ old('serial_no') }}"
                                       placeholder="সিরিয়াল নম্বর লিখুন"
                                       required>
                                @error('serial_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voter Area -->
                            <div class="col-md-6 mb-3">
                                <label><i class="fa fa-map text-primary"></i> ভোটার এলাকা<span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('voter_area') is-invalid @enderror" 
                                       name="voter_area"
                                       value="{{ old('voter_area') }}"
                                       placeholder="ভোটার এলাকা লিখুন"
                                       required>
                                @error('voter_area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fa fa-save"></i> জমা দিন
                                </button>
                                <a href="{{ route('user.sign-to-server.index') }}" class="btn btn-danger ml-3">
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
    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(1.5em + 1.25rem + 2px);
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 1.25rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.5em + 1.25rem + 2px);
        padding: 0.625rem 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.5em + 1.25rem);
        padding: 0.625rem 1rem;
        line-height: 1.5;
        color: #495057;
        content: "Browse";
        background-color: #f7f8fa;
        border-left: inherit;
        border-radius: 0 4px 4px 0;
    }

    .select2-container .select2-selection--single {
        height: 45px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'বিভাগ নির্বাচন করুন'
    });

    // Initialize flatpickr for date inputs
    flatpickr('input[name="dob"]', {
        dateFormat: 'Y-m-d',
        allowInput: true,
        maxDate: 'today'
    });

    // Form submission handling
    $('#sscForm').on('submit', function() {
        const submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-2"></i>প্রক্রিয়াকরণ হচ্ছে...');
        return true;
    });

    // Number field validation
    $('input[type="number"]').on('input', function() {
        let value = $(this).val();
        let min = $(this).attr('min');
        let max = $(this).attr('max');
        
        if (value !== '') {
            if (min && value < min) $(this).val(min);
            if (max && value > max) $(this).val(max);
        }
    });

    // Convert date to words
    function convertDateToWords(dateStr) {
        if (!dateStr) return;
        
        const date = new Date(dateStr);
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        
        const dayNames = [
            'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
            'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 
            'Eighteenth', 'Nineteenth', 'Twentieth', 'Twenty-first', 'Twenty-second', 'Twenty-third',
            'Twenty-fourth', 'Twenty-fifth', 'Twenty-sixth', 'Twenty-seventh', 'Twenty-eighth', 
            'Twenty-ninth', 'Thirtieth', 'Thirty-first'
        ];

        function numberToWords(num) {
            const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            
            if (num < 10) return ones[num];
            if (num < 20) return teens[num - 10];
            if (num < 100) return tens[Math.floor(num / 10)] + (num % 10 ? ' ' + ones[num % 10] : '');
            if (num < 1000) return ones[Math.floor(num / 100)] + ' Hundred' + (num % 100 ? ' And ' + numberToWords(num % 100) : '');
            return numberToWords(Math.floor(num / 1000)) + ' Thousand' + (num % 1000 ? ' ' + numberToWords(num % 1000) : '');
        }

        const dayWord = dayNames[date.getDate() - 1];
        const monthWord = monthNames[date.getMonth()];
        const yearNum = date.getFullYear();
        const yearWord = numberToWords(yearNum);

        return {
            dayMonth: `${dayWord} ${monthWord}`,
            year: yearWord
        };
    }

    // Update date words when date changes
    $('input[name="dob"]').on('change', function() {
        const dateWords = convertDateToWords(this.value);
        if (dateWords) {
            $('#dob_day_month_words').val(dateWords.dayMonth);
            $('#dob_year_words').val(dateWords.year);
        }
    });

    // Client-side validation
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

    // Auto-capitalize inputs
    $('input[type="text"]').on('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endpush
