@extends('user.layouts.app')

@section('title')
    পিডিও সার্টিফিকেট - তৈরি করুন
@endsection

@section('content')
@php
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'pdo_fee')->first();
@endphp

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-plus-circle mr-2"></i> পিডিও সার্টিফিকেট - তৈরি করুন
                    </h5>
                    <a href="{{ route('user.pdo.index') }}" class="btn btn-outline-dark btn-sm px-3">
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
                                    <p class="mb-0 small text-muted">প্রতিটি পিডিও সার্টিফিকেট তৈরির জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> টাকা কাটা হবে।</p>
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

                    <form action="{{ route('user.pdo.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="bg-light p-3 rounded mb-4">
                                    <h6 class="font-weight-bold text-primary mb-3 border-bottom pb-2">
                                        <i class="fas fa-user mr-2"></i> ব্যক্তিগত তথ্য
                                    </h6>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark">নামের উপাধি <span class="text-danger">*</span></label>
                                                <select class="form-control @error('name_title') is-invalid @enderror" name="name_title" required>
                                                    <option value="">নির্বাচন করুন</option>
                                                    <option value="Mr" {{ old('name_title') == 'Mr' ? 'selected' : '' }}>জনাব</option>
                                                    <option value="Mrs" {{ old('name_title') == 'Mrs' ? 'selected' : '' }}>জনাবা</option>
                                                    <option value="Ms" {{ old('name_title') == 'Ms' ? 'selected' : '' }}>মিস</option>
                                                </select>
                                            </div>
                                        </div>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label for="full_name" class="required-label">
                                            <i class="fa fa-user text-primary"></i>পূর্ণ নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" placeholder="পূর্ণ নাম" value="{{ old('full_name') }}" required oninput="this.value = this.value.toUpperCase();">
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
                                            <input type="text" class="form-control @error('fathers_name') is-invalid @enderror" id="fathers_name" name="fathers_name" placeholder="পিতার নাম" value="{{ old('fathers_name') }}" required oninput="this.value = this.value.toUpperCase();">
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
                                            <input type="text" class="form-control @error('mothers_name') is-invalid @enderror" id="mothers_name" name="mothers_name" placeholder="মাতার নাম" value="{{ old('mothers_name') }}" oninput="this.value = this.value.toUpperCase();">
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
                                            <input type="text" class="form-control @error('nid_no') is-invalid @enderror" id="nid_no" name="nid_no" placeholder="এনআইডি নম্বর" value="{{ old('nid_no') }}" required oninput="this.value = this.value.toUpperCase();">
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
                                            <input type="text" class="form-control @error('passport_no') is-invalid @enderror" id="passport_no" name="passport_no" placeholder="পাসপোর্ট নম্বর" value="{{ old('passport_no') }}" required oninput="this.value = this.value.toUpperCase();">
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
                                            <input type="text" class="form-control @error('destination_country') is-invalid @enderror" id="destination_country" name="destination_country" placeholder="গন্তব্য দেশ" value="{{ old('destination_country') }}" required>
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
                                                <option value="Bangladesh Institute of Marine Technology, Narayanganj">Bangladesh Institute of Marine Technology, Narayanganj</option>
                                                <option value="Bangladesh-German Technical Training Centre, Dhaka">Bangladesh-German Technical Training Centre, Dhaka</option>
                                                <option value="Bangladesh-Korea Technical Training Centre, Dhaka">Bangladesh-Korea Technical Training Centre, Dhaka</option>
                                                <option value="Bangladesh-Korea Technical Training Centre, Chittagong">Bangladesh-Korea Technical Training Centre, Chittagong</option>
                                                <option value="Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka">Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka</option>
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
                                            <input type="text" class="form-control @error('roll_no') is-invalid @enderror" id="roll_no" name="roll_no" placeholder="রোল নম্বর" value="{{ old('roll_no') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
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
                                            <input type="text" class="form-control @error('certificate_no') is-invalid @enderror" id="certificate_no" name="certificate_no" value="4688696" required>
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
                                            <input type="text" class="form-control @error('batch_no') is-invalid @enderror" id="batch_no" name="batch_no" value="pdo83092154837" required>
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
                                            <input type="text" class="form-control datepicker @error('course_date') is-invalid @enderror" id="course_date" name="course_date" placeholder="dd/mm/yyyy" value="{{ old('course_date') }}" required>
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
                                            <input type="text" class="form-control datepicker @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" placeholder="dd/mm/yyyy" value="{{ old('issue_date') }}" required>
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
                                <img id="img" src="" alt="ছবি প্রিভিউ" style="max-width: 200px; display: none;" class="img-fluid rounded">
                                <div id="noImage" class="text-muted">
                                    <i class="fas fa-user-circle fa-5x mb-3"></i>
                                    <p>ছবি প্রিভিউ</p>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="photo" class="required-label">
                                    <i class="fa fa-image text-primary"></i>পাসপোর্ট সাইজ ছবি
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept=".png, .jpg, .jpeg" required>
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <small class="form-text">শুধুমাত্র .png, .jpg, .jpeg ফাইল গ্রহণযোগ্য</small>
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
    .photo-preview { border: 2px dashed #e2e5ec; border-radius: 8px; padding: 10px; text-align: center; background: #fff; }
</style>
@endpush

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
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Ensure the date is in dd/mm/yyyy format
                let parts = dateStr.split('/');
                if (parts[0].length === 1) parts[0] = '0' + parts[0];
                if (parts[1].length === 1) parts[1] = '0' + parts[1];
                let formattedDate = parts.join('/');
                instance.input.value = formattedDate;
            }
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Validate date formats
            const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
            const courseDate = document.getElementById('course_date').value;
            const issueDate = document.getElementById('issue_date').value;
            
            if (!dateRegex.test(courseDate)) {
                e.preventDefault();
                alert('কোর্স তারিখ সঠিক ফরম্যাটে লিখুন (dd/mm/yyyy)');
                return false;
            }
            
            if (!dateRegex.test(issueDate)) {
                e.preventDefault();
                alert('ইস্যু তারিখ সঠিক ফরম্যাটে লিখুন (dd/mm/yyyy)');
                return false;
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