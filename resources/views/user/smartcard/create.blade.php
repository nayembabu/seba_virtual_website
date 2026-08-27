@extends('user.layouts.app')
@section('title')
    স্মার্ট কার্ড তৈরি
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            height: calc(1.5em + 1.5rem + 2px);
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #495057;
        }

        .form-control.is-invalid {
            border-color: #e74a3b;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23e74a3b' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e74a3b' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .card {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            background: #fff;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.5rem 2rem;
        }

        .card-header h5 {
            margin: 0;
            color: #4e73df;
            font-weight: 500;
        }

        .required-label::after {
            content: " *";
            color: #e74a3b;
            font-weight: bold;
        }

        .img-preview {
            max-width: 160px;
            max-height: 160px;
            margin: 15px auto;
            border: 1px solid #dee2e6;
            padding: 3px;
            border-radius: 4px;
            display: block;
        }

        .photo-upload-section {
            text-align: center;
            margin-top: 2rem;
        }

        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            margin-bottom: 0;
        }

        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            margin: 0;
            opacity: 0;
            cursor: pointer;
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
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
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
            background-color: #e9ecef;
            border-left: inherit;
            border-radius: 0 0.25rem 0.25rem 0;
        }

        #photo-preview, #signature-preview {
            width: 160px;
            height: 160px;
            border: 2px dashed #dee2e6;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        #photo-preview img, #signature-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .alert {
            border-radius: 0.35rem;
            border-left: 0.25rem solid !important;
        }

        .alert-info {
            color: #1c606a;
            background-color: #eef8fb;
            border-color: #36b9cc !important;
        }

        .alert-danger {
            color: #78261f;
            background-color: #fef0ed;
            border-color: #e74a3b !important;
        }

        .btn {
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            border-radius: 0.35rem;
            transition: all 0.15s ease-in-out;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-1px);
        }

        .btn-dark {
            background-color: #5a5c69;
            border-color: #5a5c69;
        }

        .btn-dark:hover {
            background-color: #484a54;
            border-color: #42444e;
        }

        .form-text {
            font-size: 0.875rem;
            color: #858796;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .btn {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
@endpush

@php
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'smartcard')->first();
    $chargeAmount = $serviceCharge->amount;
@endphp

@section('content')
    @if($chargeAmount > 0)
        <div class="alert alert-info border-info mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x mr-3"></i>
                <div>
                    <h4 class="alert-heading mb-1">সার্ভিস চার্জ</h4>
                    <p class="mb-0">প্রতিটি কার্ড তৈরির জন্য <span class="font-weight-bold"
                                                                   style="color:red; "> {{ number_format($serviceCharge->amount, 1) }}</span>
                        টাকা কাটা হবে।</p>
                </div>
            </div>
        </div>
    @endif

    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded border bg-light">
                <h3 class="card-title text-primary mb-0">
                    <i class="fas fa-id-card"></i> স্মার্ট কার্ড তৈরি
                </h3>
                <a href="{{ route('user.smartcard.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-arrow-left"></i> তালিকায় ফিরে যান
                </a>
            </div>

            <!-- PDF Upload Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-left-info shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-file-pdf fa-3x text-info"></i>
                                </div>
                                <div class="col">
                                    <h5 class="mb-2"><i class="fas fa-magic mr-2"></i>পিডিএফ থেকে অটো পূরণ</h5>
                                    <p class="mb-0 text-muted">এনআইডি পিডিএফ আপলোড করুন এবং সমস্ত তথ্য স্বয়ংক্রিয়ভাবে
                                        পূরণ হবে</p>
                                </div>
                            </div>
                            <div class="row mt-3">
    <div class="col">
        <div class="form-group mb-0 text-center">

            <!-- Hidden File Input -->
            <input type="file"
                   class="d-none"
                   id="pdf"
                   name="pdf"
                   accept=".pdf">

            <!-- GIF Upload Button -->
            <label id="upload_label" for="pdf" style="cursor: pointer;">
                <img id="uploadAnimation"
                     width="200px"
                     style="margin-top:-30px"
                     src="{{ asset('assets/smart_card/upload_animation.gif') }}"
                     alt="Upload PDF">
            </label>

            <!-- Selected File Name -->
            <div id="selectedFileName" class="mt-2 text-muted small"></div>

            <small class="form-text">
                শুধুমাত্র PDF ফাইল আপলোড করুন (সর্বোচ্চ 5MB) -
                প্রক্রিয়াকরণ সময় ৩০ সেকেন্ড থেকে ২ মিনিট হতে পারে
            </small>

            <div id="pdfUploadStatus" style="margin-top: 10px; display: none;"></div>

        </div>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
       

            @if($errors->any())
                <div class="alert alert-danger border-left border-danger border-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h4 class="alert-heading mb-1">ত্রুটি সংশোধন করুন!</h4>
                            <ul class="list-unstyled mb-0">
                                @foreach($errors->all() as $error)
                                    <li><i class="fas fa-times-circle mr-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('user.smartcard.store') }}" method="POST" enctype="multipart/form-data"
                  class="form needs-validation" novalidate>
                @csrf

                <div class="row">
                    <!-- All form fields in one card -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-user mr-1"></i>নাম (বাংলায়)
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('name_bn') is-invalid @enderror"
                                                           id="name_bn" name="name_bn" value="{{ old('name_bn') }}"
                                                           placeholder="বাংলায় নাম লিখুন" required>
                                                    @error('name_bn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-user mr-1"></i>Name (English)
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('name_en') is-invalid @enderror"
                                                           id="name_en" name="name_en" value="{{ old('name_en') }}"
                                                           placeholder="ENTER NAME IN ENGLISH" required>
                                                    @error('name_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-male mr-1"></i>পিতার নাম
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('father_name') is-invalid @enderror"
                                                           id="father_name" name="father_name"
                                                           value="{{ old('father_name') }}"
                                                           placeholder="পিতার নাম লিখুন" required>
                                                    @error('father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-female mr-1"></i>মাতার নাম
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('mother_name') is-invalid @enderror"
                                                           id="mother_name" name="mother_name"
                                                           value="{{ old('mother_name') }}"
                                                           placeholder="মাতার নাম লিখুন" required>
                                                    @error('mother_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-calendar-alt mr-1"></i>জন্ম তারিখ
                                                    </label>
                                                    <input type="date"
                                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                                           id="date_of_birth" name="date_of_birth"
                                                           value="{{ old('date_of_birth') }}" required>
                                                    @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-map-marker-alt mr-1"></i>জন্মস্থান
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('place_of_birth') is-invalid @enderror"
                                                           id="place_of_birth" name="place_of_birth"
                                                           value="{{ old('place_of_birth') }}"
                                                           placeholder="জন্মস্থানের নাম লিখুন" required>
                                                    @error('place_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-id-card mr-1"></i>জাতীয় পরিচয়পত্র নম্বর
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('nid_no') is-invalid @enderror"
                                                           id="nid_no" name="nid_no" value="{{ old('nid_no') }}"
                                                           placeholder="১০ অথবা ১৭ ডিজিটের এনআইডি নম্বর" required>
                                                    @error('nid_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="fas fa-key mr-1"></i>পিন নম্বর
                                                    </label>
                                                    <input type="text"
                                                           class="form-control @error('pin') is-invalid @enderror"
                                                           id="pin" name="pin" value="{{ old('pin') }}"
                                                           placeholder="পিন নম্বর লিখুন">
                                                    @error('pin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="fas fa-tint mr-1"></i>রক্তের গ্রুপ
                                                    </label>
                                                    <select class="form-control @error('blood_group') is-invalid @enderror"
                                                            id="blood_group" name="blood_group">
                                                        <option value="">রক্তের গ্রুপ নির্বাচন করুন</option>
                                                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                                            <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>
                                                                {{ $group }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('blood_group')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-calendar-check mr-1"></i>ইস্যু তারিখ
                                                    </label>
                                                    <input type="date"
                                                           class="form-control @error('issue_date') is-invalid @enderror"
                                                           id="issue_date" name="issue_date"
                                                           value="{{ old('issue_date', date('Y-m-d')) }}" required>
                                                    @error('issue_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-venus-mars mr-1"></i>লিঙ্গ
                                                    </label>
                                                    <select class="form-control @error('gender') is-invalid @enderror"
                                                            id="gender" name="gender" required>
                                                        <option value="">লিঙ্গ নির্বাচন করুন</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                            পুরুষ
                                                        </option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                            মহিলা
                                                        </option>
                                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                                            অন্যান্য
                                                        </option>
                                                    </select>
                                                    @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="required-label">
                                                        <i class="fas fa-home mr-1"></i>স্থায়ী ঠিকানা
                                                    </label>
                                                    <textarea
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            id="address" name="address" rows="3"
                                                            placeholder="আপনার স্থায়ী ঠিকানা লিখুন"
                                                            required>{{ old('address') }}</textarea>
                                                    @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo & Signature Upload Section -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required-label">ছবি</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('photo') is-invalid @enderror"
                                                           id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="photo">Browse</label>
                                                </div>
                                            </div>
                                            <div id="photo-preview" class="mt-2"></div>
                                            <small class="form-text text-muted">সর্বোচ্চ সাইজ: ২MB | ফরম্যাট: JPG, JPEG,
                                                PNG (পিডিএফ থেকে স্বয়ংক্রিয়ভাবে পূরণ হতে পারে)</small>
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required-label">স্বাক্ষর</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('signature') is-invalid @enderror"
                                                           id="signature" name="signature" accept=".jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="signature">Browse</label>
                                                </div>
                                            </div>
                                            <div id="signature-preview" class="mt-2"></div>
                                            <small class="form-text text-muted">সর্বোচ্চ সাইজ: ২MB | ফরম্যাট: JPG, JPEG,
                                                PNG (পিডিএফ থেকে স্বয়ংক্রিয়ভাবে পূরণ হতে পারে)</small>
                                            @error('signature')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <input type="hidden" name="photo_url" id="photo_url" value="">
                                <input type="hidden" name="signature_url" id="signature_url" value="">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-save mr-2"></i>স্মার্ট কার্ড তৈরি করুন
                                    </button>
                                    <a href="{{ route('user.smartcard.index') }}"
                                       class="btn btn-danger btn-lg px-5 ml-3">
                                        <i class="fas fa-times mr-2"></i>বাতিল করুন
                                    </a>
                                </div>
                            </div>
            </form>
        </div>
    </div>

    <style>
        .form-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .preview-container {
            margin-top: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            max-height: 100px;
        }

        .btn {
            margin: 0 5px;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // File input label update
            document.querySelectorAll('.custom-file-input').forEach(input => {
                input.addEventListener('change', function (e) {
                    const fileName = e.target.files[0]?.name || 'পিডিএফ ফাইল ব্রাউজ করুন...';
                    const label = e.target.nextElementSibling;
                    label.textContent = fileName;
                });
            });

            // Photo preview
            const photoInput = document.getElementById('photo');
            if (photoInput) {
                photoInput.addEventListener('change', function (e) {
                    const preview = document.getElementById('photo-preview');
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 160px; max-height: 160px;">`;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = '';
                    }
                });
            }

            // Signature preview
            const signatureInput = document.getElementById('signature');
            if (signatureInput) {
                signatureInput.addEventListener('change', function (e) {
                    const preview = document.getElementById('signature-preview');
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 160px; max-height: 160px;">`;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = '';
                    }
                });
            }

            // PDF Upload and Parse
            let pdfUploadAbortController = null;

            // Function to convert date formats
            function convertDateToISO(dateStr) {
                if (!dateStr) return '';

                // If already in YYYY-MM-DD format, return as is
                if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
                    return dateStr;
                }

                // Parse "25 Sep 1993" format
                const months = {
                    'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
                    'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'
                };

                // Try to parse various date formats
                let match = dateStr.match(/(\d{1,2})\s+([A-Za-z]{3})\s+(\d{4})/);
                if (match) {
                    const day = match[1].padStart(2, '0');
                    const month = months[match[2]] || match[2];
                    const year = match[3];
                    return `${year}-${month}-${day}`;
                }

                // Try DD/MM/YYYY format
                match = dateStr.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
                if (match) {
                    const day = match[1].padStart(2, '0');
                    const month = match[2].padStart(2, '0');
                    const year = match[3];
                    return `${year}-${month}-${day}`;
                }

                // Try DD-MM-YYYY format
                match = dateStr.match(/(\d{1,2})-(\d{1,2})-(\d{4})/);
                if (match) {
                    const day = match[1].padStart(2, '0');
                    const month = match[2].padStart(2, '0');
                    const year = match[3];
                    return `${year}-${month}-${day}`;
                }

                // If unable to parse, return as is
                console.warn('Unable to parse date format:', dateStr);
                return dateStr;
            }

            const pdfInput = document.getElementById('pdf');
            if (pdfInput) {
                pdfInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Validate file type
                    if (file.type !== 'application/pdf') {
                        Swal.fire({
                            icon: 'error',
                            title: 'ত্রুটি!',
                            text: 'শুধুমাত্র PDF ফাইল আপলোড করুন',
                            confirmButtonText: 'ঠিক আছে'
                        });
                        pdfInput.value = '';
                        return;
                    }

                    // Validate file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ত্রুটি!',
                            text: 'ফাইলের আকার 5MB এর বেশি হতে পারে না',
                            confirmButtonText: 'ঠিক আছে'
                        });
                        pdfInput.value = '';
                        return;
                    }

                    const formData = new FormData();
                    formData.append('pdf', file);

                    // Create abort controller for this request
                    pdfUploadAbortController = new AbortController();

                    // Show progress in status div
                    const statusDiv = document.getElementById('pdfUploadStatus');
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="alert alert-info mb-0"><i class="fas fa-spinner fa-spin mr-2"></i>পিডিএফ আপলোড হচ্ছে...</div>';
                        statusDiv.style.display = 'block';
                    }

                    // Show loading state with cancel button
                    let progressUpdated = false;
                    const progressInterval = setInterval(() => {
                        if (progressUpdated || !statusDiv) return;
                        progressUpdated = true;
                        if (statusDiv) {
                            statusDiv.innerHTML = '<div class="alert alert-warning mb-0"><i class="fas fa-hourglass-half mr-2"></i>API সার্ভার প্রক্রিয়া করছে... এটি ১-২ মিনিট সময় নিতে পারে</div>';
                        }
                    }, 3000);

                    Swal.fire({
                        title: 'অনুগ্রহ করে অপেক্ষা করুন...',
                        html: '<p>পিডিএফ থেকে তথ্য লোড হচ্ছে</p><p style="font-size: 0.9rem; color: #666;">এটি ৩০ সেকেন্ড থেকে ২ মিনিট সময় নিতে পারে</p><p id="uploadProgress" style="font-size: 0.85rem; color: #999; margin-top: 10px;">প্রক্রিয়া চলছে...</p>',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCancelButton: true,
                        cancelButtonText: 'বাতিল করুন',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            clearInterval(progressInterval);
                            pdfUploadAbortController.abort();
                            if (statusDiv) {
                                statusDiv.innerHTML = '<div class="alert alert-secondary mb-0">আপলোড বাতিল করা হয়েছে। অন্য ফাইল নির্বাচন করুন।</div>';
                            }
                        }
                    });

                    // Send PDF to server for parsing
                    const timeoutId = setTimeout(() => {
                        console.warn('PDF processing timeout - aborting');
                        clearInterval(progressInterval);
                        pdfUploadAbortController.abort();
                    }, 180000); // 3 minutes timeout

                    console.log('Starting PDF upload...');
                    console.log('File name:', file.name);
                    console.log('File size:', file.size, 'bytes');

                    // Get CSRF token safely
                    const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfTokenEl ? csrfTokenEl.content : '';

                    // Build the request URL
                    const requestUrl = '{{ route("user.smartcard.parsePdf") }}';
                    console.log('Request URL:', requestUrl);
                    console.log('CSRF Token present:', !!csrfToken);

                    fetch(requestUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        signal: pdfUploadAbortController.signal
                    })
                        .then(response => {
                            clearTimeout(timeoutId);
                            clearInterval(progressInterval);
                            console.log('Response received. Status:', response.status);
                            console.log('Content-Type:', response.headers.get('content-type'));

                            if (!response.ok) {
                                return response.text().then(text => {
                                    console.error('Error response (not ok):', text.substring(0, 500));
                                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                                });
                            }

                            // Check if response is actually JSON
                            const contentType = response.headers.get('content-type');
                            console.log('Full Content-Type header:', contentType);

                            if (!contentType || !contentType.includes('application/json')) {
                                return response.text().then(text => {
                                    console.error('Response is not JSON!');
                                    console.error('Expected: application/json');
                                    console.error('Got: ' + contentType);
                                    console.error('Response body length:', text.length);
                                    console.error('Response body (first 1000 chars):', text.substring(0, 1000));

                                    // Check if it's an HTML error page (contains HTML tags)
                                    if (text.includes('<!DOCTYPE') || text.includes('<html') || text.includes('<body')) {
                                        console.error('Server returned an HTML error page');
                                        // Try to extract the error message
                                        const errorMatch = text.match(/<h1[^>]*>([^<]+)<\/h1>/);
                                        const errorMsg = errorMatch ? errorMatch[1] : 'Server error page';
                                        console.error('Extracted error:', errorMsg);
                                        throw new Error(`Server error (${response.status}): ${errorMsg}. Please refresh and try again.`);
                                    }

                                    throw new Error(`Server returned ${contentType || 'invalid content type'} instead of JSON`);
                                });
                            }

                            return response.json().catch(err => {
                                console.error('Failed to parse JSON:', err.message);
                                throw new Error('Server returned invalid JSON: ' + err.message);
                            });
                        })
                        .then(data => {
                            console.log('=== RAW API RESPONSE ===');
                            console.log(JSON.stringify(data, null, 2));
                            console.log('=== END RAW RESPONSE ===');
                            console.log('Parsed JSON response:', data);
                            // Debug: show API response in alert
                            try {
                                const hasPhoto = !!(data && ((data.data && (data.data.photo || data.data.photo_url || data.data.image)) || data.photo || data.photo_url || data.image));
                                const hasSig = !!(data && ((data.data && (data.data.signature || data.data.signature_url || data.data.sign)) || data.signature || data.signature_url || data.sign));
                                Swal.fire({
                                    icon: hasPhoto ? "success" : "warning",
                                    title: hasPhoto ? "PDF parsed successfully" : "Photo/Signature not found",
                                    html: "Photo: " + (hasPhoto ? "✓" : "✗") + "<br>Signature: " + (hasSig ? "✓" : "✗") + "<br><br>Check console (F12) for full response",
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            } catch(e) {
                                console.log("Debug alert error:", e);
                            }
                            // Handle both nested (data.data) and flat response formats
                            const d = data && data.data ? data.data : data;
                            console.log('Response data keys:', Object.keys(d || {}));
                            console.log('Full response data:', JSON.stringify(d, null, 2));

                            if (data && data.success && d) {
                                console.log('API returned success, filling form...');

                                // Auto-fill form fields
                                const fillField = (id, value) => {
                                    const element = document.getElementById(id);
                                    if (element) {
                                        // Convert date format if it's a date field
                                        let finalValue = value || '';
                                        if (id === 'date_of_birth' || id === 'issue_date') {
                                            finalValue = convertDateToISO(finalValue);
                                        }
                                        element.value = finalValue;
                                        console.log(`Filled ${id} with: ${finalValue}`);
                                    }
                                };

                                function getField(obj, keys) {
                                    for (let k of keys) {
                                        if (obj[k] !== undefined && obj[k] !== null && obj[k] !== '') return obj[k];
                                    }
                                    return '';
                                }
                                fillField('name_bn', getField(d, ['name_bn', 'name_ban', 'bangla_name', 'name_bangla', 'nameBn', 'banglaName']));
                                fillField('name_en', getField(d, ['name_en', 'name_eng', 'english_name', 'name_english', 'nameEn', 'englishName']));
                                fillField('father_name', getField(d, ['father_name', 'fatherName', 'fathers_name', 'father']));
                                fillField('mother_name', getField(d, ['mother_name', 'motherName', 'mothers_name', 'mother']));
                                fillField('date_of_birth', getField(d, ['date_of_birth', 'dob', 'birth_date', 'dateOfBirth', 'birthdate']));
                                fillField('place_of_birth', getField(d, ['place_of_birth', 'birth_place', 'birthPlace', 'placeOfBirth', 'pob']));
                                fillField('nid_no', getField(d, ['nid_no', 'nid', 'nationalId', 'nid_number', 'national_id', 'nidNumber']));
                                fillField('blood_group', getField(d, ['blood_group', 'bloodGroup', 'blood', 'bloodtype']));
                                fillField('gender', getField(d, ['gender', 'sex']));
                                fillField('address', getField(d, ['address', 'permanent_address', 'permanentAddress', 'addr']));
                                fillField('birth_place_en', getField(d, ['birth_place_en', 'birthPlaceEn', 'birth_place_english']));
                                fillField('postal_code', getField(d, ['postal_code', 'postCode', 'postcode', 'zip_code', 'zip']));
                                fillField('pin', getField(d, ['pin', 'pin_no', 'pin_number', 'pinNumber']));

                                // Handle photo image from API
                                const photoUrlHidden = d.userIMG || d.photo_url || "";
                                document.getElementById('photo_url').value = photoUrlHidden;
                                const photoData = d.userIMG || d.photo || d.photo_url || d.image || d.photo_base64 || d.photoBase64 || d.photograph || "";
                                console.log('Photo value:', photoData);
                                console.log('Photo source field:', photoData ? photoData.substring(0, 50) : 'empty');
                                if (photoData) {
                                    console.log('✓ Photo image received from API, length:', photoData.length);
                                    const photoPreview = document.getElementById('photo-preview');
                                    if (photoPreview) {
                                        photoPreview.innerHTML = `<img src="${photoData}" style="max-width: 160px; max-height: 160px;" onerror="console.error('Photo image failed to load')">`;
                                        console.log('✓ Photo preview updated');
                                    }

                                    // Set photo file input 
                                    try {
                                        const photoInput = document.getElementById('photo');
                                        if (photoInput && photoData) {
                                            console.log('Downloading photo to file...');
                                            fetch(photoData)
                                                .then(res => res.blob())
                                                .then(blob => {
                                                    console.log('✓ Photo blob created:', blob.size, 'bytes, type:', blob.type);
                                                    const dataTransfer = new DataTransfer();
                                                    const file = new File([blob], 'photo.jpg', {type: blob.type});
                                                    dataTransfer.items.add(file);
                                                    photoInput.files = dataTransfer.files;
                                                    console.log('✓ Photo file set successfully');
                                                })
                                                .catch(err => console.warn('✗ Could not set photo file:', err));
                                        } else {
                                            console.log('Photo is not a data URI, skipping file input');
                                        }
                                    } catch (err) {
                                        console.warn('Error handling photo file:', err);
                                    }
                                } else {
                                    console.log('✗ No photo received from API');
                                }

                                // Handle signature image from API
                                const sigUrlHidden = d.signIMG || d.signature_url || "";
                                document.getElementById('signature_url').value = sigUrlHidden;
                                const sigData = d.signIMG || d.signature || d.signature_url || d.sign || d.sig || d.signature_base64 || d.signatureBase64 || "";
                                console.log('Signature value:', sigData);
                                console.log('Signature source field:', sigData ? sigData.substring(0, 50) : 'empty');
                                if (sigData) {
                                    console.log('✓ Signature image received from API, length:', sigData.length);
                                    const signaturePreview = document.getElementById('signature-preview');
                                    if (signaturePreview) {
                                        signaturePreview.innerHTML = `<img src="${sigData}" style="max-width: 160px; max-height: 160px;" onerror="console.error('Signature image failed to load')">`;
                                        console.log('✓ Signature preview updated');
                                    }

                                    // Set signature file input 
                                    try {
                                        const signatureInput = document.getElementById('signature');
                                        if (signatureInput && sigData) {
                                            console.log('Downloading signature to file...');
                                            fetch(sigData)
                                                .then(res => res.blob())
                                                .then(blob => {
                                                    console.log('✓ Signature blob created:', blob.size, 'bytes, type:', blob.type);
                                                    const dataTransfer = new DataTransfer();
                                                    const file = new File([blob], 'signature.png', {type: blob.type});
                                                    dataTransfer.items.add(file);
                                                    signatureInput.files = dataTransfer.files;
                                                    console.log('✓ Signature file set successfully');
                                                })
                                                .catch(err => console.warn('✗ Could not set signature file:', err));
                                        } else {
                                            console.log('Signature is not a data URI, skipping file input');
                                        }
                                    } catch (err) {
                                        console.warn('Error handling signature file:', err);
                                    }
                                } else {
                                    console.log('✗ No signature received from API');
                                }

                                Swal.close();
                                if (statusDiv) {
                                    statusDiv.innerHTML = '<div class="alert alert-success mb-0"><i class="fas fa-check-circle mr-2"></i>পিডিএফ সফলভাবে প্রক্রিয়া করা হয়েছে এবং ফর্ম পূরণ করা হয়েছে।</div>';
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'সফল!',
                                    html: '<p>পিডিএফ থেকে সকল তথ্য সফলভাবে লোড করা হয়েছে</p><p style="font-size: 0.9rem; color: #666;">অনুগ্রহ করে ফর্ম চেক করুন এবং প্রয়োজন অনুযায়ী সম্পাদনা করুন</p>',
                                    confirmButtonText: 'ঠিক আছে'
                                });
                            } else {
                                console.error('API returned failure:', data);
                                throw new Error(data.message || 'পিডিএফ প্রক্রিয়াকরণ ব্যর্থ');
                            }
                        })
                        .catch(error => {
                            clearTimeout(timeoutId);
                            clearInterval(progressInterval);
                            console.error('Full Error:', error);
                            console.error('Error name:', error.name);
                            console.error('Error message:', error.message);

                            Swal.close();

                            let errorTitle = 'ত্রুটি!';
                            let errorMessage = error.message || 'অনুগ্রহ করে আবার চেষ্টা করুন';

                            if (error.name === 'AbortError') {
                                errorTitle = 'বাতিল করা হয়েছে';
                                errorMessage = 'পিডিএফ প্রক্রিয়াকরণ বাতিল করা হয়েছে বা সময়সীমা অতিক্রম হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
                                if (statusDiv) {
                                    statusDiv.innerHTML = '<div class="alert alert-danger mb-0"><i class="fas fa-times-circle mr-2"></i>সময়সীমা অতিক্রম - অনুগ্রহ করে ফর্মটি ম্যানুয়ালি পূরণ করুন</div>';
                                }
                            } else if (error.message.includes('HTTP')) {
                                errorMessage = 'সার্ভারে একটি সমস্যা হয়েছে। অনুগ্রহ করে কিছুক্ষণ পরে আবার চেষ্টা করুন।';
                                if (statusDiv) {
                                    statusDiv.innerHTML = '<div class="alert alert-danger mb-0"><i class="fas fa-server mr-2"></i>সার্ভার ত্রুটি - ফর্মটি ম্যানুয়ালি পূরণ করুন</div>';
                                }
                            } else {
                                if (statusDiv) {
                                    statusDiv.innerHTML = '<div class="alert alert-danger mb-0"><i class="fas fa-exclamation-triangle mr-2"></i>পিডিএফ প্রক্রিয়া করা যায়নি - ফর্মটি ম্যানুয়ালি পূরণ করুন</div>';
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: errorTitle,
                                html: `<p>পিডিএফ প্রক্রিয়াকরণে সমস্যা হয়েছে</p><p style="font-size: 0.85rem; color: #666;">${errorMessage}</p><p style="font-size: 0.85rem; color: #999; margin-top: 10px;">অনুগ্রহ করে নিচের ফর্মটি ম্যানুয়ালি পূরণ করুন</p>`,
                                confirmButtonText: 'ঠিক আছে'
                            });

                            pdfInput.value = '';
                        });
                });
            }
        </script>
    @endpush

@endsection
