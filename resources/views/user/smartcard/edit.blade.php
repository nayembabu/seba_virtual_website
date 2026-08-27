@extends('user.layouts.app')
@section('title')
    স্মার্ট কার্ড সম্পাদনা
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

        .current-image {
            max-width: 160px;
            max-height: 160px;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            padding: 5px;
            background: #fff;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .image-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
            display: block;
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
    $chargeAmount = $serviceCharge->amount ?? 0;
@endphp

@section('content')
@if($chargeAmount > 0)
    <div class="alert alert-info border-info mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-2x mr-3"></i>
            <div>
                <h4 class="alert-heading mb-1">সার্ভিস চার্জ</h4>
                <p class="mb-0">প্রতিটি কার্ড তৈরির জন্য <span class="font-weight-bold" style="color:red;">{{ number_format($chargeAmount, 1) }}</span> টাকা কাটা হবে।</p>
            </div>
        </div>
    </div>
@endif

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded border bg-light">
            <h3 class="card-title text-primary mb-0">
                <i class="fas fa-edit fa-fw"></i> স্মার্ট কার্ড সম্পাদনা
            </h3>
            <a href="{{ route('user.smartcard.index') }}" class="btn btn-outline-dark">
                <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
            </a>
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
        
        <form action="{{ route('user.smartcard.update', $smartcard->id) }}" method="POST" enctype="multipart/form-data" class="form needs-validation" novalidate>
            @csrf
            @method('PUT')
            
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
                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" 
                                               id="name_bn" name="name_bn" value="{{ old('name_bn', $smartcard->name_bn) }}" 
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
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                               id="name_en" name="name_en" value="{{ old('name_en', $smartcard->name_en) }}" 
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
                                        <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                                               id="father_name" name="father_name" value="{{ old('father_name', $smartcard->father_name) }}" 
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
                                        <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                                               id="mother_name" name="mother_name" value="{{ old('mother_name', $smartcard->mother_name) }}" 
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
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', \Carbon\Carbon::parse($smartcard->date_of_birth)->format('Y-m-d')) }}" required>
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
                                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" 
                                               id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $smartcard->place_of_birth) }}" 
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
                                        <input type="text" class="form-control @error('nid_no') is-invalid @enderror" 
                                               id="nid_no" name="nid_no" value="{{ old('nid_no', $smartcard->nid_no) }}" 
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
                                                       id="pin" name="pin" value="{{ old('pin', $smartcard->pin) }}"
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
                                                <option value="{{ $group }}" {{ old('blood_group', $smartcard->blood_group) == $group ? 'selected' : '' }}>
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
                                        <input type="date" class="form-control @error('issue_date') is-invalid @enderror" 
                                               id="issue_date" name="issue_date" value="{{ old('issue_date', \Carbon\Carbon::parse($smartcard->issue_date)->format('Y-m-d')) }}" required>
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
                                            <option value="male" {{ old('gender', $smartcard->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                            <option value="female" {{ old('gender', $smartcard->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                            <option value="other" {{ old('gender', $smartcard->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
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
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="3" 
                                                  placeholder="আপনার স্থায়ী ঠিকানা লিখুন" required>{{ old('address', $smartcard->address) }}</textarea>
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
                                <label>ছবি</label>
                                
                                @if($smartcard->photo)
                                   
                                @endif
                                
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" 
                                            id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="photo">নতুন ছবি নির্বাচন করুন</label>
                                    </div>
                                </div>
                                <div id="photo-preview" class="mt-2"></div>
                                <small class="form-text text-muted">নতুন ছবি আপলোড করতে চাইলে নির্বাচন করুন | সর্বোচ্চ সাইজ: ২MB | ফরম্যাট: JPG, JPEG, PNG</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>স্বাক্ষর</label>
                                
                                @if($smartcard->signature)
                                  
                                @endif
                                
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('signature') is-invalid @enderror" 
                                            id="signature" name="signature" accept=".jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="signature">নতুন স্বাক্ষর নির্বাচন করুন</label>
                                    </div>
                                </div>
                                <div id="signature-preview" class="mt-2"></div>
                                <small class="form-text text-muted">নতুন স্বাক্ষর আপলোড করতে চাইলে নির্বাচন করুন | সর্বোচ্চ সাইজ: ২MB | ফরম্যাট: JPG, JPEG, PNG</small>
                                @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                               
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>পরিবর্তন সংরক্ষণ করুন
                    </button>
                    <a href="{{ route('user.smartcard.index') }}" class="btn btn-danger btn-lg px-5 ml-3">
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
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
<script>
    // File input label update
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Browse';
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });

    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('photo-preview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 160px; max-height: 160px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });

    // Signature preview
    document.getElementById('signature').addEventListener('change', function(e) {
        const preview = document.getElementById('signature-preview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 160px; max-height: 160px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
</script>
@endpush

@endsection