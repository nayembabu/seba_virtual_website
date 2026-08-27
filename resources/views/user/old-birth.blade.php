@extends('user.layouts.app')
@section('title') পুরাতন নিবন্ধন @endsection

@push('css')
<style>
    .required-field::after { content: " *"; color: #dc3545; font-weight: bold; }
    .form-section-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 6px;
        margin-bottom: 14px;
    }
    .lang-tabs {
        display: flex;
        gap: 0;
        margin-bottom: 24px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e0e0e0;
    }
    .lang-tab {
        flex: 1;
        padding: 12px 20px;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        background: #f8f9fa;
        color: #666;
        transition: all 0.3s ease;
    }
    .lang-tab.active {
        background: linear-gradient(135deg, #1e4db7, #6610f2);
        color: #fff;
        box-shadow: 0 4px 12px rgba(30,77,183,0.3);
    }
    .lang-tab:hover:not(.active) {
        background: #e9ecef;
        color: #333;
    }
    .lang-tab i { margin-right: 6px; }
    .form-panel { display: none; }
    .form-panel.active { display: block; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-md-3">
    <div class="card card-primary m-0 shadow">
        <div class="card-body p-3 p-md-4">

            @if($errors->has('msg'))
                <div class="alert alert-danger">{{ $errors->first('msg') }}</div>
            @endif

            {{-- Header with Title + Charge --}}
            <div class="text-center mb-3 position-relative">
                <h3 style="font-size:28px; font-weight:700; color:#1e4db7; margin:0;">
                    <i class="fas fa-archive"></i> পুরাতন নিবন্ধন মেক
                </h3>
                <span style="display:inline-block; background:#1e4db7; color:#fff; padding:6px 16px; border-radius:6px; font-size:14px; font-weight:600; position:absolute; top:0; right:0;">সার্ভিস চার্জ: ৳{{ $charge ?? 0 }}</span>
            </div>

            {{-- Language Tabs --}}
            <div class="lang-tabs">
                <button type="button" class="lang-tab active" onclick="switchLang('bn')">
                    <i class="fas fa-language"></i> বাংলা
                </button>
                <button type="button" class="lang-tab" onclick="switchLang('en')">
                    <i class="fas fa-language"></i> English
                </button>
            </div>

            {{-- BANGLA PANEL --}}
            <div class="form-panel active" id="panel-bn">
                <h5 class="mb-3" style="font-size:16px;"><i class="fas fa-archive"></i> বাংলা ফর্ম</h5>

                <form action="{{ route('user.old-birth-bn') }}" method="POST">
                    @csrf

                    <div class="form-section-title"><i class="fas fa-user"></i> ব্যক্তিগত তথ্য</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">নাম (বাংলা)</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="আবেদনকারীর নাম" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">জন্ম তারিখ</label>
                            <input type="date" class="form-control" name="dob" value="{{ old('dob') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">লিঙ্গ</label>
                            <select class="form-select" name="gendar">
                                <option value="">নির্বাচন করুন</option>
                                <option value="পুরুষ" {{ old('gendar')=='পুরুষ'?'selected':'' }}>পুরুষ</option>
                                <option value="মহিলা" {{ old('gendar')=='মহিলা'?'selected':'' }}>মহিলা</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">জন্মস্থান</label>
                            <input type="text" class="form-control" name="pob" value="{{ old('pob') }}" placeholder="জন্মস্থান">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">কত তম সন্তান</label>
                            <input type="text" class="form-control" name="ooc" value="{{ old('ooc') }}" placeholder="যেমন: ১ম">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-id-card"></i> নিবন্ধন তথ্য</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">জন্ম নিবন্ধন নম্বর</label>
                            <input type="text" class="form-control @error('brNo') is-invalid @enderror" name="brNo" value="{{ old('brNo') }}" placeholder="BRN নম্বর" required>
                            @error('brNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">নিবন্ধন বহি নম্বর</label>
                            <input type="text" class="form-control" name="registerNo" value="{{ old('registerNo') }}" placeholder="রেজিস্টার নং">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">নিবন্ধনের তারিখ</label>
                            <input type="date" class="form-control" name="dor" value="{{ old('dor') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ইস্যুর তারিখ</label>
                            <input type="date" class="form-control" name="doi" value="{{ old('doi') }}">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-users"></i> পিতা-মাতার তথ্য</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">পিতার নাম</label>
                            <input type="text" class="form-control @error('fatherName') is-invalid @enderror" name="fatherName" value="{{ old('fatherName') }}" placeholder="পিতার নাম" required>
                            @error('fatherName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">পিতার এনআইডি</label>
                            <input type="text" class="form-control" name="fatherNid" value="{{ old('fatherNid') }}" placeholder="এনআইডি নম্বর">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">পিতার BRN</label>
                            <input type="text" class="form-control" name="fatherBrn" value="{{ old('fatherBrn') }}" placeholder="BRN">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">পিতার জাতীয়তা</label>
                            <input type="text" class="form-control" name="fatherNationality" value="{{ old('fatherNationality', 'বাংলাদেশী') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">মাতার নাম</label>
                            <input type="text" class="form-control @error('motherName') is-invalid @enderror" name="motherName" value="{{ old('motherName') }}" placeholder="মাতার নাম" required>
                            @error('motherName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">মাতার এনআইডি</label>
                            <input type="text" class="form-control" name="motherNid" value="{{ old('motherNid') }}" placeholder="এনআইডি নম্বর">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">মাতার BRN</label>
                            <input type="text" class="form-control" name="motherBrn" value="{{ old('motherBrn') }}" placeholder="BRN">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">মাতার জাতীয়তা</label>
                            <input type="text" class="form-control" name="motherNationality" value="{{ old('motherNationality', 'বাংলাদেশী') }}">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-map-marker-alt"></i> ঠিকানা</div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">অফিসের নাম</label>
                            <input type="text" class="form-control" name="address1" value="{{ old('address1') }}" placeholder="যেমন: ইউনিয়ন পরিষদ, সদর">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">উপজেলা/জেলা</label>
                            <input type="text" class="form-control" name="address2" value="{{ old('address2') }}" placeholder="উপজেলা, জেলা">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">বিভাগ</label>
                            <input type="text" class="form-control" name="address3" value="{{ old('address3') }}" placeholder="বিভাগ">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">পূর্ণ ঠিকানা</label>
                            <textarea class="form-control" name="fullAddress" rows="2" placeholder="পূর্ণ ঠিকানা">{{ old('fullAddress') }}</textarea>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5" style="font-size:16px; font-weight:700;">
                            <i class="fas fa-print me-1"></i> বাংলা সনদ তৈরি করুন
                        </button>
                    </div>
                </form>
            </div>

            {{-- ENGLISH PANEL --}}
            <div class="form-panel" id="panel-en">
                <h5 class="mb-3" style="font-size:16px;"><i class="fas fa-archive"></i> English Form</h5>

                <form action="{{ route('user.old-birth-en') }}" method="POST">
                    @csrf

                    <div class="form-section-title"><i class="fas fa-user"></i> Personal Information</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Name (English)</label>
                            <input type="text" class="form-control en-name" name="name" placeholder="Applicant Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control en-dob" name="dob">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select en-gendar" name="gendar">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" class="form-control en-pob" name="pob" placeholder="Place of Birth">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order of Child</label>
                            <input type="text" class="form-control en-ooc" name="ooc" placeholder="e.g. 1st">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-id-card"></i> Registration Info</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Birth Reg. Number</label>
                            <input type="text" class="form-control en-brNo" name="brNo" placeholder="BRN Number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Register No</label>
                            <input type="text" class="form-control en-registerNo" name="registerNo" placeholder="Register No">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Registration Date</label>
                            <input type="date" class="form-control en-dor" name="dor">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Issue Date</label>
                            <input type="date" class="form-control en-doi" name="doi">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-users"></i> Parents Information</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Father's Name</label>
                            <input type="text" class="form-control en-fatherName" name="fatherName" placeholder="Father's Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Father's NID</label>
                            <input type="text" class="form-control en-fatherNid" name="fatherNid" placeholder="NID Number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Father's BRN</label>
                            <input type="text" class="form-control en-fatherBrn" name="fatherBrn" placeholder="BRN">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Father's Nationality</label>
                            <input type="text" class="form-control en-fatherNationality" name="fatherNationality" value="Bangladeshi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Mother's Name</label>
                            <input type="text" class="form-control en-motherName" name="motherName" placeholder="Mother's Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mother's NID</label>
                            <input type="text" class="form-control en-motherNid" name="motherNid" placeholder="NID Number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mother's BRN</label>
                            <input type="text" class="form-control en-motherBrn" name="motherBrn" placeholder="BRN">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mother's Nationality</label>
                            <input type="text" class="form-control en-motherNationality" name="motherNationality" value="Bangladeshi">
                        </div>
                    </div>

                    <div class="form-section-title mt-3"><i class="fas fa-map-marker-alt"></i> Address</div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Office Name</label>
                            <input type="text" class="form-control en-address1" name="address1" placeholder="e.g. Union Council">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upazila / District</label>
                            <input type="text" class="form-control en-address2" name="address2" placeholder="Upazila, District">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Division</label>
                            <input type="text" class="form-control en-address3" name="address3" placeholder="Division">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Address</label>
                            <textarea class="form-control en-fullAddress" name="fullAddress" rows="2" placeholder="Full Address"></textarea>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-outline-primary px-5" style="font-size:16px; font-weight:700;">
                            <i class="fas fa-print me-1"></i> Generate English Certificate
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function switchLang(lang) {
    $('.lang-tab').removeClass('active');
    $('.lang-tab').each(function(){
        if ($(this).text().trim().indexOf(lang === 'bn' ? 'বাংলা' : 'English') !== -1) {
            $(this).addClass('active');
        }
    });
    // Simpler: use index
    $('.lang-tab').eq(lang === 'bn' ? 0 : 1).addClass('active');
    $('.form-panel').removeClass('active');
    $('#panel-' + lang).addClass('active');
}

// Sync data between panels
$(function(){
    function syncToEn() {
        var nameMap = {
            'gendar': { 'পুরুষ': 'Male', 'মহিলা': 'Female' }
        };
        $('#panel-bn [name]').each(function(){
            var name = $(this).attr('name');
            var val = $(this).val();
            if (nameMap[name] && nameMap[name][val]) val = nameMap[name][val];
            $('#panel-en [name="'+name+'"]').val(val);
        });
    }
    $('#panel-bn input, #panel-bn select, #panel-bn textarea').on('change input', syncToEn);
});
</script>
@endpush
