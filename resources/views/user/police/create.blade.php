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
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'police')->first();
@endphp
<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-file-certificate fa-fw"></i>পুলিশ ক্লিয়ারেন্স সার্টিফিকেট - তৈরি করুন
                    </h3>
                    <a href="{{ route('user.police.index') }}" class="btn btn-dark">
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
                        <p class="mb-0">প্রতিটি সার্টিফিকেট তৈরির জন্য <span class="font-weight-bold" style="color:red;">{{ number_format($serviceCharge->amount, 1) }}</span> টাকা কাটা হবে।</p>
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

        <form action="{{ route('user.police.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            
            <div class="row">
               
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user mr-2"></i>সাধারণ তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="required-label">
                                    <i class="fa fa-hashtag text-primary"></i> রেফারেন্স নম্বর
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control" name="police_reg" value="12{{ strtoupper(generateRandomString(5)) }}" required>
                                </div>
                                <small class="form-text text-muted">রেফারেন্স নম্বর পরিবর্তন করতে পারবেন</small>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-user-tag text-primary"></i> উপাধি
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                            <select class="form-control" name="designation" required>
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="Mr.">জনাব (Mr.)</option>
                                                <option value="Ms.">জনাবা (Ms.)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-user text-primary"></i> আবেদনকারীর নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" name="applicant_name" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-users text-primary"></i> সম্পর্ক
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                            <select class="form-control" name="what_of" required>
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="son">পুত্র</option>
                                                <option value="daughter">কন্যা</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label>
                                            <i class="fa fa-user-friends text-primary"></i> পিতার নাম
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" name="father_name" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-map-marker-alt text-primary"></i> গ্রাম/এলাকা
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" class="form-control" name="village_area" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-envelope text-primary"></i> ডাকঘর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                                            <input type="text" class="form-control" name="post_office" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-shield-alt text-primary"></i> থানা
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="police_station" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-map text-primary"></i> জেলা
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                            <input type="text" class="form-control" name="district" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-passport mr-2"></i>পাসপোর্ট/এনআইডি তথ্য
                            </h5>
                        </div>
                       
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="required-label">
                                            <i class="fa fa-id-card text-primary"></i> ডকুমেন্টের ধরন
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-file-earmark"></i></span>
                                            <select class="form-control" name="document_type" required>
                                                <option value="">নির্বাচন করুন</option>
                                                <option value="Passport">পাসপোর্ট</option>
                                                <option value="NID">জাতীয় পরিচয়পত্র (NID)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>
                                            <i class="fa fa-hashtag text-primary"></i> পাসপোর্ট/এনআইডি নম্বর
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <input type="text" class="form-control" name="passport_no" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>
                                            <i class="fa fa-map-pin text-primary"></i> ইস্যু স্থান
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                            <input type="text" class="form-control" name="issued_location" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>
                                            <i class="fa fa-calendar text-primary"></i> ইস্যু তারিখ
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                            <input type="date" class="form-control date" name="issued_date" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                
                        <div class="card-header bg-warning text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-cog mr-2"></i>সার্টিফিকেট সেটিংস
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="required-label">
                                    <i class="fa fa-calendar-check text-primary"></i> সার্টিফিকেট তারিখ
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" class="form-control date" name="certificate_date" value="" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="required-label">
                                    <i class="fa fa-toggle-on text-primary"></i> অবস্থা
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-toggle2-on"></i></span>
                                    <select class="form-control" name="status" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="1">সক্রিয়</option>
                                        <option value="0">নিষ্ক্রিয়</option>
                                    </select>
                                </div>
                            </div>

                            </div>
                            
                            <div class="form-group mt-4 text-center">
                                <button type="submit" class="btn btn-success btn-lg w-100 py-3" style="font-size: 1.2rem; font-weight: bold;" name="publish">
                                    <i class="fa fa-paper-plane fa-fw"></i> জমা দিন
                                </button>
                                <input type="hidden" name="user_token" value="1756">
                            </div>
                        </div>
                    </div>
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
    .required-label::after {
        content: " *";
        color: #f64e60;
    }
    .input-group-text {
        background-color: #f7f8fa;
        border: 1px solid #e2e5ec;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Flatpickr for date inputs
        $(".date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            $(this).find('[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('দয়া করে সমস্ত প্রয়োজনীয় তথ্য প্রদান করুন।');
            }
        });
    });
</script>
@endpush