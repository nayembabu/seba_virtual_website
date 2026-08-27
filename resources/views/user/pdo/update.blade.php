@extends('user.layouts.app')

@section('title')
    পিডিও সার্টিফিকেট - সম্পাদনা করুন
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
    .photo-preview {
        border: 2px dashed #e2e5ec;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        background: #f8f9fa;
    }
    .current-photo {
        max-width: 200px;
        border: 2px solid #dee2e6;
        border-radius: 4px;
    }
</style>

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-edit fa-fw"></i>পিডিও সার্টিফিকেট - সম্পাদনা করুন
                    </h3>
                    <a href="{{ route('user.pdo.index') }}" class="btn btn-dark">
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

        <form action="{{ route('user.pdo.update', $pdo->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Personal Information -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user mr-2"></i>ব্যক্তিগত তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="name_title" class="required-label">
                                            <i class="fa fa-user-tag text-primary"></i>নামের উপাধি
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <select class="form-control @error('name_title') is-invalid @enderror" id="name_title" name="name_title" required>
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="Mr" {{ old('name_title', $pdo->name_title) == 'Mr' ? 'selected' : '' }}>জনাব</option>
                                                <option value="Mrs" {{ old('name_title', $pdo->name_title) == 'Mrs' ? 'selected' : '' }}>জনাবা</option>
                                                <option value="Ms" {{ old('name_title', $pdo->name_title) == 'Ms' ? 'selected' : '' }}>মিস</option>
                                            </select>
                                            @error('name_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label for="full_name" class="required-label">
                                            <i class="fa fa-user text-primary"></i>পূর্ণ নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" placeholder="পূর্ণ নাম" value="{{ old('full_name', $pdo->full_name) }}" required oninput="this.value = this.value.toUpperCase();">
                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="fathers_name" class="required-label">
                                            <i class="fa fa-male text-primary"></i>পিতার নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control @error('fathers_name') is-invalid @enderror" id="fathers_name" name="fathers_name" placeholder="পিতার নাম" value="{{ old('fathers_name', $pdo->fathers_name) }}" required oninput="this.value = this.value.toUpperCase();">
                                            @error('fathers_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="mothers_name">
                                            <i class="fa fa-female text-primary"></i>মাতার নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control @error('mothers_name') is-invalid @enderror" id="mothers_name" name="mothers_name" placeholder="মাতার নাম" value="{{ old('mothers_name', $pdo->mothers_name) }}" oninput="this.value = this.value.toUpperCase();">
                                            @error('mothers_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nid_no" class="required-label">
                                            <i class="fa fa-id-card text-primary"></i>এনআইডি নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                            <input type="text" class="form-control @error('nid_no') is-invalid @enderror" id="nid_no" name="nid_no" placeholder="এনআইডি নম্বর" value="{{ old('nid_no', $pdo->nid_no) }}" required oninput="this.value = this.value.toUpperCase();">
                                            @error('nid_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="passport_no" class="required-label">
                                            <i class="fa fa-passport text-primary"></i>পাসপোর্ট নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-journal"></i></span>
                                            <input type="text" class="form-control @error('passport_no') is-invalid @enderror" id="passport_no" name="passport_no" placeholder="পাসপোর্ট নম্বর" value="{{ old('passport_no', $pdo->passport_no) }}" required oninput="this.value = this.value.toUpperCase();">
                                            @error('passport_no')
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

                    <!-- Course Information -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-book mr-2"></i>কোর্স তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="course_name">
                                            <i class="fa fa-graduation-cap text-primary"></i>কোর্সের নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-journal-bookmark"></i></span>
                                            <input type="text" class="form-control" id="course_name" name="course_name" value="Pre-Departure Orientation" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="destination_country" class="required-label">
                                            <i class="fa fa-globe text-primary"></i>গন্তব্য দেশ
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" class="form-control @error('destination_country') is-invalid @enderror" id="destination_country" name="destination_country" placeholder="গন্তব্য দেশ" value="{{ old('destination_country', $pdo->destination_country) }}" required>
                                            @error('destination_country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="connected_by" class="required-label">
                                            <i class="fa fa-university text-primary"></i>কেন্দ্র নির্বাচন করুন
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select class="form-control @error('connected_by') is-invalid @enderror" id="connected_by" name="connected_by" required>
                                                <option value="">-কেন্দ্র নির্বাচন করুন-</option>
                                                <option value="Bangladesh Institute of Marine Technology, Narayanganj" {{ old('connected_by', $pdo->connected_by) == 'Bangladesh Institute of Marine Technology, Narayanganj' ? 'selected' : '' }}>Bangladesh Institute of Marine Technology, Narayanganj</option>
                                                <option value="Bangladesh-German Technical Training Centre, Dhaka" {{ old('connected_by', $pdo->connected_by) == 'Bangladesh-German Technical Training Centre, Dhaka' ? 'selected' : '' }}>Bangladesh-German Technical Training Centre, Dhaka</option>
                                                <option value="Bangladesh-Korea Technical Training Centre, Dhaka" {{ old('connected_by', $pdo->connected_by) == 'Bangladesh-Korea Technical Training Centre, Dhaka' ? 'selected' : '' }}>Bangladesh-Korea Technical Training Centre, Dhaka</option>
                                                <option value="Bangladesh-Korea Technical Training Centre, Chittagong" {{ old('connected_by', $pdo->connected_by) == 'Bangladesh-Korea Technical Training Centre, Chittagong' ? 'selected' : '' }}>Bangladesh-Korea Technical Training Centre, Chittagong</option>
                                                <option value="Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka" {{ old('connected_by', $pdo->connected_by) == 'Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka' ? 'selected' : '' }}>Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka</option>
                                                <!-- Add other options as needed -->
                                            </select>
                                            @error('connected_by')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="roll_no" class="required-label">
                                            <i class="fa fa-sort-numeric-up text-primary"></i>রোল নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <input type="text" class="form-control @error('roll_no') is-invalid @enderror" id="roll_no" name="roll_no" placeholder="রোল নম্বর" value="{{ old('roll_no', $pdo->roll_no) }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                            @error('roll_no')
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

                    <!-- Certificate Information -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-certificate mr-2"></i>সার্টিফিকেট তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="certificate_no" class="required-label">
                                            <i class="fa fa-hashtag text-primary"></i>সার্টিফিকেট নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                            <input type="text" class="form-control @error('certificate_no') is-invalid @enderror" id="certificate_no" name="certificate_no" value="{{ old('certificate_no', $pdo->certificate_no) }}" required>
                                            @error('certificate_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="batch_no" class="required-label">
                                            <i class="fa fa-layer-group text-primary"></i>ব্যাচ নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-collection"></i></span>
                                            <input type="text" class="form-control @error('batch_no') is-invalid @enderror" id="batch_no" name="batch_no" value="{{ old('batch_no', $pdo->batch_no) }}" required>
                                            @error('batch_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="course_date" class="required-label">
                                            <i class="fa fa-calendar text-primary"></i>কোর্স তারিখ
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            <input type="text" class="form-control datepicker @error('course_date') is-invalid @enderror" id="course_date" name="course_date" placeholder="dd/mm/yyyy" value="{{ old('course_date', $pdo->course_date) }}" required>
                                            @error('course_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Format: dd/mm/yyyy</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="issue_date" class="required-label">
                                            <i class="fa fa-calendar-check text-primary"></i>ইস্যু তারিখ
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                            <input type="text" class="form-control datepicker @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" placeholder="dd/mm/yyyy" value="{{ old('issue_date', $pdo->issue_date) }}" required>
                                            @error('issue_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Format: dd/mm/yyyy</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="col-lg-4">
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-camera mr-2"></i>ছবি আপলোড
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="photo-preview mb-3">
                                @if($pdo->photo)
                                    <img src="{{ asset('storage/uploads/' . $pdo->photo) }}" alt="বর্তমান ছবি" class="current-photo img-fluid rounded mb-3">
                                    <p class="text-success"><i class="fas fa-check-circle"></i> বর্তমান ছবি</p>
                                @else
                                    <div id="noImage" class="text-muted">
                                        <i class="fas fa-user-circle fa-5x mb-3"></i>
                                        <p>কোন ছবি নেই</p>
                                    </div>
                                @endif
                                <img id="img" src="" alt="নতুন ছবি প্রিভিউ" style="max-width: 200px; display: none;" class="img-fluid rounded mt-3">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="photo">
                                    <i class="fa fa-image text-primary"></i>পাসপোর্ট সাইজ ছবি
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept=".png, .jpg, .jpeg">
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text">শুধুমাত্র .png, .jpg, .jpeg ফাইল গ্রহণযোগ্য</small>
                                <small class="form-text text-info">ছবি পরিবর্তন না করতে চাইলে ফাঁকা রাখুন</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                        <i class="fa fa-save"></i> আপডেট করুন
                    </button>
                    <a href="{{ route('user.pdo.index') }}" class="btn btn-danger btn-lg ml-3">
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
        // Photo preview functionality
        $(document).on('change', '#photo', function(){
            let file = $(this)[0].files[0];
            if (file) {
                let src = URL.createObjectURL(file);
                $('#img').attr('src', src).show();
                $('#noImage').hide();
            }
        });

        // Initialize flatpickr datepicker
        flatpickr(".datepicker", {
            dateFormat: "d/m/Y",
            maxDate: "today",
            allowInput: true,
            altInput: true,
            altFormat: "d/m/Y",
            locale: {
                firstDayOfWeek: 0
            }
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Auto-uppercase for name fields
        $('#full_name, #fathers_name, #mothers_name, #nid_no, #passport_no').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Numeric only for roll number
        $('#roll_no').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush