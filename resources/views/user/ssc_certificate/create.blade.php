@extends('user.layouts.app')

@section('title')
    SSC সার্টিফিকেট তৈরি
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
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'certificate')->first();
@endphp

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-graduation-cap fa-fw"></i> SSC সার্টিফিকেট তৈরি
                    </h3>
                    <a href="{{ route('user.ssc_certificate.index') }}" class="btn btn-dark">
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
                        <p class="mb-0 font-weight-bold">{{ number_format($serviceCharge->amount, 1) }} টাকা</p>
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
                    <form action="{{ route('user.ssc_certificate.store') }}" method="POST" id="sscForm" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header bg-info text-white py-3">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-alt mr-2"></i>ছাত্র/ছাত্রীর তথ্য
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Student Name -->
                                            <div class="col-md-6 mb-3">
                            <label class="control-label required-label">
                                <i class="fas fa-user mr-1"></i>ছাত্র/ছাত্রীর নাম
                            </label>
                            <input type="text" 
                                   class="form-control @error('student_name') is-invalid @enderror" 
                                   name="student_name" 
                                   value="{{ old('student_name') }}" 
                                   required>
                            @error('student_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6 mb-3">
                            <label class="control-label required-label">
                                <i class="fas fa-birthday-cake mr-1"></i>জন্ম তারিখ
                            </label>
                            <input type="date" 
                                   class="form-control @error('dob') is-invalid @enderror" 
                                   name="dob" 
                                   value="{{ old('dob') }}" 
                                   min="1900-01-01"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                            <!-- Father's Name -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-user-friends mr-1"></i>পিতার নাম
                                </label>
                                <input type="text" 
                                       class="form-control @error('father_name') is-invalid @enderror" 
                                       name="father_name" 
                                       value="{{ old('father_name') }}" 
                                       required>
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mother's Name -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-user-friends mr-1"></i>মাতার নাম
                                </label>
                                <input type="text" 
                                       class="form-control @error('mother_name') is-invalid @enderror" 
                                       name="mother_name" 
                                       value="{{ old('mother_name') }}" 
                                       required>
                                @error('mother_name')
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
                            <i class="fas fa-school mr-2"></i>শিক্ষা প্রতিষ্ঠানের তথ্য
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <!-- School Name -->
                            <div class="col-md-12 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-school mr-1"></i>স্কুলের নাম
                                </label>
                                <input type="text" 
                                       class="form-control @error('school_name') is-invalid @enderror" 
                                       name="school_name" 
                                       value="{{ old('school_name') }}" 
                                       required>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- School Address -->
                            <div class="col-md-12 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-map-marker-alt mr-1"></i>স্কুলের ঠিকানা
                                </label>
                                <textarea class="form-control @error('school_address') is-invalid @enderror" 
                                          name="school_address" 
                                          rows="3" 
                                          required>{{ old('school_address') }}</textarea>
                                @error('school_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Roll No -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-hashtag mr-1"></i>রোল নম্বর
                                </label>
                                <input type="text" 
                                       class="form-control @error('roll_no') is-invalid @enderror" 
                                       name="roll_no" 
                                       value="{{ old('roll_no') }}" 
                                       required>
                                @error('roll_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Student Group -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-users mr-1"></i>বিভাগ
                                </label>
                                <select class="form-control select2 @error('student_group') is-invalid @enderror" 
                                        name="student_group" 
                                        required>
                                    <option value="">বিভাগ নির্বাচন করুন</option>
                                    <option value="Science" {{ old('student_group') == 'Science' ? 'selected' : '' }}>বিজ্ঞান</option>
                                    <option value="Commerce" {{ old('student_group') == 'Commerce' ? 'selected' : '' }}>বাণিজ্য</option>
                                    <option value="Arts" {{ old('student_group') == 'Arts' ? 'selected' : '' }}>মানবিক</option>
                                </select>
                                @error('student_group')
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
                            <i class="fas fa-certificate mr-2"></i>ফলাফল সংক্রান্ত তথ্য
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <!-- GPA -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-star mr-1"></i>জি.পি.এ
                                </label>
                                <input type="number" 
                                       class="form-control @error('gpa') is-invalid @enderror" 
                                       name="gpa" 
                                       step="0.01" 
                                       min="0" 
                                       max="5"
                                       value="{{ old('gpa') }}" 
                                       required>
                                @error('gpa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Publication Date -->
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-calendar-check mr-1"></i>ফলাফল প্রকাশের তারিখ
                                </label>
                                <input type="number" 
                                       class="form-control @error('publication_date') is-invalid @enderror" 
                                       name="publication_date" 
                                       min="1900" 
                                       max="{{ date('Y') }}"
                                       value="{{ old('publication_date') }}" 
                                       required>
                                @error('publication_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Publication Year -->
                            <div class="col-md-12 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-calendar-alt mr-1"></i>ফলাফল প্রকাশের বছর
                                </label>
                                <input type="number" 
                                       class="form-control @error('publication_year') is-invalid @enderror" 
                                       name="publication_year" 
                                       min="1900" 
                                       max="{{ date('Y') }}"
                                       value="{{ old('publication_year') }}" 
                                       required>
                                @error('publication_year')
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
                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-fingerprint mr-1"></i>সিরিয়াল নম্বর DBS
                                </label>
                                <input type="text" 
                                       class="form-control @error('serial_no_dbs') is-invalid @enderror" 
                                       name="serial_no_dbs" 
                                       value="{{ old('serial_no_dbs') }}" 
                                       required>
                                @error('serial_no_dbs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-id-card mr-1"></i>রেজিস্ট্রেশন নম্বর
                                </label>
                                <input type="text" 
                                       class="form-control @error('registration_no') is-invalid @enderror" 
                                       name="registration_no" 
                                       value="{{ old('registration_no') }}" 
                                       required>
                                @error('registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-calendar mr-1"></i>রেজিস্ট্রেশন বছর
                                </label>
                                <input type="number" 
                                       class="form-control @error('registration_year') is-invalid @enderror" 
                                       name="registration_year" 
                                       value="{{ old('registration_year') }}"
                                       min="1900"
                                       max="{{ date('Y') }}" 
                                       required>
                                @error('registration_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="control-label required-label">
                                    <i class="fas fa-hashtag mr-1"></i>DBCSC নম্বর
                                </label>
                                <input type="text" 
                                       class="form-control @error('dbcsc_no') is-invalid @enderror" 
                                       name="dbcsc_no" 
                                       value="{{ old('dbcsc_no') }}" 
                                       required>
                                @error('dbcsc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                <i class="fas fa-save mr-2"></i>সার্টিফিকেট সংরক্ষণ করুন
            </button>
            <a href="{{ route('user.ssc_certificate.index') }}" class="btn btn-danger btn-lg ml-3">
                <i class="fas fa-times mr-2"></i>বাতিল করুন
            </a>
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
