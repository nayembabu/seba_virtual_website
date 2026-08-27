@extends('user.layouts.app')

@section('title')
    এনআইডি - সম্পাদনা করুন
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
    .existing-image {
        max-width: 150px;
        border: 2px solid #e2e5ec;
        border-radius: 4px;
        padding: 5px;
    }
</style>


<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-edit fa-fw"></i>এনআইডি - সম্পাদনা
                    </h3>
                    <a href="{{ route('user.nid.index') }}" class="btn btn-dark">
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

        <form action="{{ route('user.nid.update', $nid->id) }}" method="POST" enctype="multipart/form-data" id="signForm" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                               <i class="fas fa-certificate mr-2"></i>ব্যক্তিগত তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mb-3">
                                    <label><i class="fa fa-pencil text-primary"></i> স্বাক্ষর<span class="text-danger">*</span></label>
                                    @if(!empty($nid->signature))
                                        @php
                                            $signaturePath = $nid->signature;
                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($signaturePath)) {
                                                try {
                                                    $signatureContents = \Illuminate\Support\Facades\Storage::disk('public')->get($signaturePath);
                                                    $mime = finfo_buffer(finfo_open(), $signatureContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                                                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($signatureContents);
                                                } catch (\Exception $e) {
                                                    $signatureBase64 = null;
                                                }
                                            }
                                        @endphp
                                        <div class="mb-2">
                                            @if(!empty($signatureBase64))
                                                <img src="{{ $signatureBase64 }}" alt="বর্তমান স্বাক্ষর" class="existing-image">
                                            @else
                                                <img src="{{ asset('storage/' . $nid->signature) }}" alt="বর্তমান স্বাক্ষর" class="existing-image">
                                            @endif
                                            <p class="text-muted small mt-1">বর্তমান স্বাক্ষর</p>
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                                        <input type="file" class="form-control @error('signature') is-invalid @enderror" id="signature" name="signature" accept="image/*" onchange="previewImage(this, 'signaturePreview')">
                                        @error('signature')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <img id="signaturePreview" src="#" alt="স্বাক্ষর প্রিভিউ" class="mt-2" style="max-width: 200px; display: none;">
                                    <small class="form-text text-muted">নতুন স্বাক্ষর আপলোড করতে চাইলে নির্বাচন করুন</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label><i class="fa fa-camera text-primary"></i> ফটো<span class="text-danger">*</span></label>
                                    @if(!empty($nid->photo))
                                        @php
                                            $photoPath = $nid->photo;
                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                                                try {
                                                    $photoContents = \Illuminate\Support\Facades\Storage::disk('public')->get($photoPath);
                                                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                                                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                                                } catch (\Exception $e) {
                                                    $photoBase64 = null;
                                                }
                                            }
                                        @endphp
                                        <div class="mb-2">
                                            @if(!empty($photoBase64))
                                                <img src="{{ $photoBase64 }}" alt="বর্তমান ফটো" class="existing-image">
                                            @else
                                                <img src="{{ asset('storage/' . $nid->photo) }}" alt="বর্তমান ফটো" class="existing-image">
                                            @endif
                                            <p class="text-muted small mt-1">বর্তমান ফটো</p>
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-camera"></i></span>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(this, 'photoPreview')">
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <img id="photoPreview" src="#" alt="ছবি প্রিভিউ" class="mt-2" style="max-width: 200px; display: none;">
                                    <small class="form-text text-muted">নতুন ফটো আপলোড করতে চাইলে নির্বাচন করুন</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name_en">
                                        <i class="fa fa-user text-primary"></i>নাম (ইংরেজি)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-fonts"></i></span>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $nid->name_en) }}">
                                        @error('name_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name_bn">
                                        <label><i class="fa fa-user text-primary"></i> নাম (বাংলায়)<span class="text-danger">*</span></label>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-translate"></i></span>
                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" id="name_bn" name="name_bn" value="{{ old('name_bn', $nid->name_bn) }}">
                                        @error('name_bn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label><i class="fa fa-calendar text-primary"></i> জন্ম তারিখ<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $nid->date_of_birth) }}">
                                        @error('date_of_birth')
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
                                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="male" {{ old('gender', $nid->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                            <option value="female" {{ old('gender', $nid->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                            <option value="other" {{ old('gender', $nid->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label><i class="fa fa-tint text-primary"></i> রক্তের গ্রুপ</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-heart-pulse-fill"></i></span>
                                        <select class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="A+" {{ old('blood_group', $nid->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_group', $nid->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_group', $nid->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_group', $nid->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="O+" {{ old('blood_group', $nid->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_group', $nid->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                            <option value="AB+" {{ old('blood_group', $nid->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_group', $nid->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        </select>
                                        @error('blood_group')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Hidden fields for formatted date -->
                                <input type="hidden" name="dob_day_month_words" id="dob_day_month_words">
                                <input type="hidden" name="dob_year_words" id="dob_year_words">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt mr-2"></i>পারিবারিক তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label><i class="fa fa-id-card text-primary"></i> পিতার নাম</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name', $nid->father_name) }}">
                                        @error('father_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label><i class="fa fa-id-card text-primary"></i> মাতার নাম</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', $nid->mother_name) }}">
                                        @error('mother_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
                                <label><i class="fa fa-id-badge text-primary"></i> আইডি নম্বর<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control @error('nid_number') is-invalid @enderror" id="nid_number" name="nid_number" value="{{ old('nid_number', $nid->nid_number) }}">
                                    @error('nid_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-key text-primary"></i> পিন নম্বর<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                    <input type="text" class="form-control @error('pin_number') is-invalid @enderror" id="pin_number" name="pin_number" value="{{ old('pin_number', $nid->pin_number) }}">
                                    @error('pin_number')
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
                                    <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date', $nid->issue_date) }}" required>
                                    @error('issue_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-school mr-2"></i>ঠিকানা সংক্রান্ত
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label><i class="fa fa-map-marker text-primary"></i> জন্মস্থান<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                        <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $nid->birth_place) }}">
                                        @error('birth_place')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-12 mb-3">
                                    <label><i class="fa fa-home text-primary"></i> ঠিকানা<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $nid->address) }}</textarea>
                                        @error('address')
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
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fa fa-save"></i> আপডেট করুন
                    </button>
                    <a href="{{ route('user.nid.index') }}" class="btn btn-danger ml-3">
                        <i class="fa fa-times"></i> বাতিল
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

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