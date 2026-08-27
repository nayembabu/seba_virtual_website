@extends('user.layouts.app')
@section('title') @if($city == 'dncc') DNCC @else DSCC @endif @lang('Trade License') @endsection
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { font-family: 'SolaimanLipi', 'NotoSansBengali', sans-serif !important; background: #f8f9fa; }
.license-form { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
.form-header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #1a4a8d; }
.form-header .title-main { font-size: 28px; color: #1a4a8d; font-weight: bold; }
.form-header .title-sub { font-size: 22px; color: #333; }
.cost-info { background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-bottom: 20px; text-align: center; }
.form-label { font-weight: 600; color: #333; margin-bottom: 8px; }
.form-control, .form-select { border-radius: 8px; padding: 10px 15px; border: 1px solid #ccc; font-family: 'SolaimanLipi', sans-serif; }
.required-field::after { content: " *"; color: #fc4b6c; }
.submit-btn { background: linear-gradient(135deg, #1a4a8d 0%, #2c5cc5 100%); border: none; padding: 12px 30px; font-size: 18px; border-radius: 8px; width: 100%; margin-top: 20px; color: white; font-weight: bold; }
.submit-btn:hover { background: linear-gradient(135deg, #2c5cc5 0%, #1a4a8d 100%); }
.section-title { background-color: #1a4a8d; color: white; padding: 10px 15px; font-weight: bold; margin-bottom: 20px; border-radius: 8px; font-size: 18px; }
.fee-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
.total-fee { grid-column: 1 / -1; background: #e8f0fe; padding: 15px; border-radius: 8px; text-align: center; font-weight: bold; font-size: 18px; margin-top: 10px; }
.address-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px; }
.same-address-checkbox { margin-top: 10px; padding: 10px; background: #f5f5f5; border-radius: 8px; border: 1px solid #ddd; }
.validity-period { background: #e8f4ff; padding: 20px; border-radius: 8px; border: 1px solid #b3d7ff; margin-bottom: 20px; }
.license-generator { display: flex; gap: 10px; align-items: center; }
.generate-btn { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: bold; white-space: nowrap; }
.generate-btn:hover { background-color: #218838; }
.declaration-box { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
.is-invalid { border-color: #dc3545 !important; }
.invalid-feedback { display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
@media (max-width: 768px) { .license-form { padding: 15px; } .fee-grid, .address-grid { grid-template-columns: 1fr; } .license-generator { flex-direction: column; } }
</style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="license-form">
        <div class="form-header">
            <div class="title-main">@if($city == 'dncc') ঢাকা উত্তর সিটি কর্পোরেশন @else ঢাকা দক্ষিন সিটি কর্পোরেশন @endif</div>
            <div class="title-sub">@if($city == 'dncc') ই-ট্রেড লাইসেন্স আবেদন ফর্ম (DNCC) @else ই-ট্রেড লাইসেন্স আবেদন ফর্ম (DSCC) @endif</div>
            <p class="text-muted mt-2">নিচের ফর্মটি পূরণ করে ট্রেড লাইসেন্সের জন্য আবেদন করুন</p>
        </div>

        <div class="cost-info">💰 প্রতিটি ট্রেড লাইসেন্স আবেদনের খরচ: <strong>৫০ টাকা</strong>
            <button type="button" class="btn btn-sm btn-info ms-3" onclick="autoFillForm()"><i class="fas fa-magic"></i> অটো ফিল</button>
        </div>

        <form id="tradeLicenseForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="city" value="{{ $city }}">

            <div class="section-title">১। মৌলিক তথ্য</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">লাইসেন্স নং</label>
                    <div class="license-generator">
                        <input type="text" class="form-control" name="license_no" id="license_no" value="{{ $license_no ?? '' }}" placeholder="@if($city=='dncc') TRAD/DNCC/XXXXXX/XXXX @else TRAD/DSCC/XXXXXX/XXXX @endif" required>
                        <button type="button" class="generate-btn" onclick="generateLicenseNumber()" id="generateBtn">নতুন লাইসেন্স নং</button>
                    </div>
                    <div class="invalid-feedback">লাইসেন্স নং প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ব্যবসা প্রতিষ্ঠানের নাম</label>
                    <input type="text" class="form-control" name="business_name" id="business_name" placeholder="ব্যবসা প্রতিষ্ঠানের নাম লিখুন" required>
                    <div class="invalid-feedback">ব্যবসা প্রতিষ্ঠানের নাম প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">প্রতিষ্ঠানের মালিকের নাম</label>
                    <input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="উদাহরণ: রহিম উদ্দিন" required>
                    <div class="invalid-feedback">মালিকের নাম প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">পিতা / স্বামীর নাম</label>
                    <input type="text" class="form-control" name="father_husband_name" id="father_husband_name" placeholder="উদাহরণ: আব্দুল করিম" required>
                    <div class="invalid-feedback">পিতা/স্বামীর নাম প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">মাতার নাম</label>
                    <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="উদাহরণ: রাহেলা বেগম" required>
                    <div class="invalid-feedback">মাতার নাম প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ব্যবসার প্রকৃতি</label>
                    <select class="form-select" name="business_nature" id="business_nature" required>
                        <option value="" disabled selected>ব্যবসার প্রকৃতি নির্বাচন করুন</option>
                        <option value="একক">একক</option>
                        <option value="অংশীদারি">অংশীদারি</option>
                        <option value="কোম্পানি">কোম্পানি</option>
                        <option value="অন্যান্য">অন্যান্য</option>
                    </select>
                    <div class="invalid-feedback">ব্যবসার প্রকৃতি নির্বাচন করুন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ব্যবসার ধরণ</label>
                    <select class="form-select" name="business_type" id="business_type" required>
                        <option value="">নির্বাচন করুন</option>
                        <option value="সরবরাহকারী">সরবরাহকারী</option>
                        <option value="খুচরা">খুচরা বিক্রেতা</option>
                        <option value="পাইকারি">পাইকারি বিক্রেতা</option>
                        <option value="সেবা">সেবা প্রদানকারী</option>
                        <option value="উৎপাদন">উৎপাদনকারী</option>
                    </select>
                    <div class="invalid-feedback">ব্যবসার ধরণ নির্বাচন করুন</div>
                </div>
            </div>

            <div class="section-title">২। ঠিকানা তথ্য</div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="mb-3" style="color:#1a4a8d;">প্রতিষ্ঠানের ঠিকানা</h5>
                    <div class="address-grid">
                        <div><label class="form-label">বাড়ি নং</label><input type="text" class="form-control" name="business_address_house" placeholder="উদাহরণ: ১২৩"></div>
                        <div><label class="form-label">রোড নং</label><input type="text" class="form-control" name="business_address_road" placeholder="উদাহরণ: ৪৫"></div>
                        <div style="grid-column:span 2"><label class="form-label">ব্লক / এলাকা</label><input type="text" class="form-control" name="business_address_block" placeholder="উদাহরণ: বি/৪"></div>
                        <div><label class="form-label">ওয়ার্ড</label><input type="text" class="form-control" name="business_address_ward" placeholder="উদাহরণ: ৫২"></div>
                        <div><label class="form-label">থানা</label><input type="text" class="form-control" name="business_address_thana" placeholder="উদাহরণ: উত্তরা"></div>
                        <div><label class="form-label">জেলা</label><input type="text" class="form-control" name="business_address_district" value="ঢাকা"></div>
                        <div style="grid-column:span 2"><label class="form-label">পোস্ট কোড</label><input type="text" class="form-control" name="business_address_postcode" placeholder="উদাহরণ: ১২৩০"></div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="mb-3" style="color:#1a4a8d;">ব্যবসা এলাকা তথ্য</h5>
                    <div class="mb-3"><label class="form-label">অঞ্চল / বাজার শাখা</label><input type="text" class="form-control" name="business_zone" placeholder="উদাহরণ: উত্তরাঞ্চল"></div>
                    <div class="mb-3"><label class="form-label">ওয়ার্ড / মার্কেট</label><input type="text" class="form-control" name="business_ward_market" placeholder="উদাহরণ: উত্তরা সেক্টর ৭ মার্কেট"></div>
                    <div class="mb-3"><label class="form-label">এলাকা</label><input type="text" class="form-control" name="business_address_area" placeholder="উদাহরণ: উত্তরা সেক্টর ৭"></div>
                </div>
            </div>

            <div class="section-title">৩। যোগাযোগ ও পরিচয়পত্র তথ্য</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">এনআইডি/পাসপোর্ট/জন্ম নিবন্ধ নং</label>
                    <input type="text" class="form-control" name="nid_passport_birth_no" placeholder="উদাহরণ: ১৯৮৪৫৬৭৮৯০১২৩" required>
                    <div class="invalid-feedback">এনআইডি/পাসপোর্ট/জন্ম নিবন্ধ নং প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">বিআইএন নং</label>
                    <input type="text" class="form-control" name="bin_no" placeholder="উদাহরণ: ১২৩৪৫৬৭৮৯-০১">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">মোবাইল নম্বর</label>
                    <input type="tel" class="form-control" name="phone" placeholder="উদাহরণ: ০১৭১২৩৪৫৬৭৮" required>
                    <div class="invalid-feedback">মোবাইল নম্বর প্রয়োজন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">ই-মেইল</label>
                    <input type="email" class="form-control" name="email" placeholder="উদাহরণ: example@email.com">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">অর্থ বছর</label>
                    <select class="form-select" name="financial_year" required>
                        <option value="">নির্বাচন করুন</option>
                        <option value="2023-2024">২০২৩-২০২৪</option>
                        <option value="2024-2025">২০২৪-২০২৫</option>
                        <option value="2025-2026">২০২৫-২০২৬</option>
                        <option value="2026-2027">২০২৬-২০২৭</option>
                    </select>
                    <div class="invalid-feedback">অর্থ বছর নির্বাচন করুন</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ব্যবসা শুরুর তারিখ</label>
                    <input type="date" class="form-control" name="business_start_date" required>
                    <div class="invalid-feedback">ব্যবসা শুরুর তারিখ প্রয়োজন</div>
                </div>
            </div>

            <div class="section-title">৪। মালিকের ঠিকানা</div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="mb-3" style="color:#1a4a8d;">বর্তমান ঠিকানা</h5>
                    <div class="address-grid">
                        <div><label class="form-label">হোল্ডিং নং</label><input type="text" class="form-control" name="current_address_holding" placeholder="উদাহরণ: ৭৮"></div>
                        <div><label class="form-label">রোড নং</label><input type="text" class="form-control" name="current_address_road" placeholder="উদাহরণ: ১৭"></div>
                        <div style="grid-column:span 2"><label class="form-label">গ্রাম / মহল্লা</label><input type="text" class="form-control" name="current_address_village" placeholder="উদাহরণ: শাহীপাড়া"></div>
                        <div><label class="form-label">থানা</label><input type="text" class="form-control" name="current_address_thana" placeholder="উদাহরণ: উত্তরা"></div>
                        <div><label class="form-label">জেলা</label><input type="text" class="form-control" name="current_address_district" placeholder="উদাহরণ: ঢাকা"></div>
                        <div><label class="form-label">বিভাগ</label><input type="text" class="form-control" name="current_address_division" placeholder="উদাহরণ: ঢাকা"></div>
                        <div><label class="form-label">পোস্ট কোড</label><input type="text" class="form-control" name="current_address_postcode" placeholder="উদাহরণ: ১২৩০"></div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="mb-3" style="color:#1a4a8d;">স্থায়ী ঠিকানা</h5>
                    <div class="same-address-checkbox mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sameAddressCheckbox" name="same_as_current_address" value="1">
                            <label class="form-check-label" for="sameAddressCheckbox">বর্তমান ঠিকানা এর সমান</label>
                        </div>
                    </div>
                    <div class="address-grid" id="permanentAddressSection">
                        <div><label class="form-label">হোল্ডিং নং</label><input type="text" class="form-control" name="permanent_address_holding" placeholder="উদাহরণ: ৭৮"></div>
                        <div><label class="form-label">রোড নং</label><input type="text" class="form-control" name="permanent_address_road" placeholder="উদাহরণ: ১৭"></div>
                        <div style="grid-column:span 2"><label class="form-label">গ্রাম / মহল্লা</label><input type="text" class="form-control" name="permanent_address_village" placeholder="উদাহরণ: শাহীপাড়া"></div>
                        <div><label class="form-label">থানা</label><input type="text" class="form-control" name="permanent_address_thana" placeholder="উদাহরণ: উত্তরা"></div>
                        <div><label class="form-label">জেলা</label><input type="text" class="form-control" name="permanent_address_district" placeholder="উদাহরণ: ঢাকা"></div>
                        <div><label class="form-label">বিভাগ</label><input type="text" class="form-control" name="permanent_address_division" placeholder="উদাহরণ: ঢাকা"></div>
                        <div><label class="form-label">পোস্ট কোড</label><input type="text" class="form-control" name="permanent_address_postcode" placeholder="উদাহরণ: ১২৩০"></div>
                    </div>
                </div>
            </div>

            <div class="section-title">৫। ফি বাবদ পরিশোধ</div>
            <div class="fee-grid">
                <div>
                    <div class="mb-3"><label class="form-label">লাইসেন্স / নবায়ন ফি</label><input type="number" class="form-control" name="license_fee" value="2000"></div>
                    <div class="mb-3"><label class="form-label">সারচার্জ</label><input type="number" class="form-control" name="surcharge" value="0"></div>
                    <div class="mb-3"><label class="form-label">আয়কর / উৎসকর</label><input type="number" class="form-control" name="tax" value="3000"></div>
                    <div class="mb-3"><label class="form-label">বকেয়া</label><input type="number" class="form-control" name="due_amount" value="0"></div>
                    <div class="mb-3"><label class="form-label">সংশোধনী ফি</label><input type="number" class="form-control" name="amendment_fee" value="0"></div>
                </div>
                <div>
                    <div class="mb-3"><label class="form-label">সাইনবোর্ড কর</label><input type="number" class="form-control" name="signboard_fee" value="480"></div>
                    <div class="mb-3"><label class="form-label">ভ্যাট</label><input type="number" class="form-control" name="vat" value="372"></div>
                    <div class="mb-3"><label class="form-label">বই মূল্য</label><input type="number" class="form-control" name="book_price" value="270"></div>
                    <div class="mb-3"><label class="form-label">ফরম ফি</label><input type="number" class="form-control" name="form_fee" value="0"></div>
                    <div class="mb-3"><label class="form-label">অন্যান্য ফি</label><input type="number" class="form-control" name="other_fee" value="500"></div>
                </div>
                <div class="total-fee" id="totalFeeDisplay">সর্বমোট ফি: ৬,৬২২ টাকা</div>
            </div>

            <div class="section-title">৬। ট্রেড লাইসেন্স এর মেয়াদ</div>
            <div class="validity-period">
                <div class="mb-3">
                    <label class="form-label required-field">লাইসেন্স মেয়াদ শেষ হওয়ার তারিখ</label>
                    <input type="date" class="form-control" name="license_validity_date" id="validity_date" required>
                    <div class="invalid-feedback">লাইসেন্স মেয়াদ শেষ হওয়ার তারিখ প্রয়োজন</div>
                </div>
                <p class="mb-0">অত্র ট্রেড লাইসেন্স এর মেয়াদ <span id="displayDate">২৫ জুলাই, ২০২৭</span> পর্যন্ত</p>
            </div>

            <div class="section-title">৭। নথিপত্র সংযোজন</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">মালিকের ছবি (Passport Size)</label>
                    <input type="file" class="form-control" name="owner_photo" accept="image/*">
                    <small class="text-muted">সর্বোচ্চ 5MB, JPG/PNG</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">অন্যান্য প্রাসঙ্গিক নথি</label>
                    <input type="file" class="form-control" name="other_documents[]" multiple>
                    <small class="text-muted">একাধিক ফাইল নির্বাচন করতে পারেন</small>
                </div>
            </div>

            <div class="section-title">৮। ঘোষণা</div>
            <div class="declaration-box">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="declaration" id="declaration" required>
                    <label class="form-check-label" for="declaration">
                        আমি ঘোষণা করছি যে, উপরে প্রদত্ত সকল তথ্য সঠিক এবং বাস্তবসম্মত।
                    </label>
                </div>
                <div class="invalid-feedback">আপনাকে ঘোষণা গ্রহণ করতে হবে</div>
            </div>

            <input type="hidden" name="total_fee" id="total_fee_hidden" value="6622.00">

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <button type="reset" class="btn btn-secondary btn-lg w-100 py-3">ফর্ম রিসেট করুন</button>
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" class="btn submit-btn py-3" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <span class="submit-text">আবেদন জমা দিন</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-wrap mt-4">
        <h4 class="mb-3" style="color:#1a4a8d;">@if($city == 'dncc') DNCC @else DSCC @endif ট্রেড লাইসেন্স তালিকা</h4>
        <table class="data-table">
            <thead>
                <tr><th>লাইসেন্স নং</th><th>প্রতিষ্ঠানের নাম</th><th>মালিকের নাম</th><th>মোট ফি</th><th>স্ট্যাটাস</th><th>আবেদনের তারিখ</th><th>অ্যাকশন</th></tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td data-label="লাইসেন্স নং">{{ $app->license_no }}</td>
                    <td data-label="প্রতিষ্ঠানের নাম">{{ $app->business_name }}</td>
                    <td data-label="মালিকের নাম">{{ $app->owner_name }}</td>
                    <td data-label="মোট ফি">৳ {{ number_format($app->total_fee, 2) }}</td>
                    <td data-label="স্ট্যাটাস">
                        @if($app->status == 'pending')
                            <span class="badge-warning">অপেক্ষমাণ</span>
                        @elseif($app->status == 'approved')
                            <span class="badge-success">অনুমোদিত</span>
                        @elseif($app->status == 'rejected')
                            <span class="badge-danger">বাতিল</span>
                        @else
                            <span class="badge-info">{{ $app->status }}</span>
                        @endif
                    </td>
                    <td data-label="আবেদনের তারিখ">{{ $app->created_at->format('d M, Y') }}</td>
                    <td data-label="অ্যাক্সন">
                        <a href="{{ route('user.' . $app->city . '-trade.print', $app->id) }}" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-print"></i> প্রিন্ট
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:32px 10px;color:#C4CAD9;">কোনো আবেদন নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $applications->links() }}</div>
    </div>
</div>

<style>
.table-wrap { background: #fff; border-radius: 16px; border: 1px solid #E2E6F2; overflow-x: auto; margin-bottom: 28px; padding: 20px; }
.data-table { width: 100%; border-collapse: collapse; min-width: 680px; }
.data-table th { background: #F5F7FC; padding: 13px 18px; text-align: left; font-size: 10.5px; font-weight: 700; color: #757CA0; text-transform: uppercase; letter-spacing: .6px; border-bottom: 1px solid #E2E6F2; }
.data-table td { padding: 13px 18px; font-size: 13px; border-bottom: 1px solid #EEF1F7; color: #3B4166; }
.badge-success { background: #E3F7EE; color: #16A76B; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 30px; font-size: 10.5px; font-weight: 700; }
.badge-warning { background: #FCF1DE; color: #D9962E; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 30px; font-size: 10.5px; font-weight: 700; }
.badge-danger { background: #FCEAEE; color: #DE3E52; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 30px; font-size: 10.5px; font-weight: 700; }
.badge-info { background: #EAEEFC; color: #2A46C9; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 30px; font-size: 10.5px; font-weight: 700; }
@media(max-width:768px){ .data-table thead{display:none} .data-table tbody tr{display:block;border:1px solid #E2E6F2;border-radius:15px;padding:10px 14px;margin-bottom:12px} .data-table td{display:flex;align-items:center;justify-content:space-between;padding:8px 2px;border-bottom:1px dashed #E2E6F2;font-size:12.5px} .data-table td:last-child{border-bottom:none} .data-table td::before{content:attr(data-label);font-weight:700;color:#757CA0;font-size:11px} }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    var city = '{{ $city }}';
    var prefix = city === 'dncc' ? 'TRAD/DNCC' : 'TRAD/DSCC';
    window.autoFillForm = function(){
        var data = {
            'business_name': 'আলোচিত এন্টারপ্রাইজ',
            'owner_name': 'মোঃ রহিম উদ্দিন',
            'father_husband_name': 'মোঃ আব্দুল করিম',
            'mother_name': 'রাহেলা বেগম',
            'business_nature': 'একক',
            'business_type': 'সরবরাহকারী',
            'nid_passport_birth_no': '১৯৮৪৫৬৭৮৯০১২৩',
            'bin_no': '১২৩৪৫৬৭৮৯-০১',
            'phone': '০১৭১২৩৪৫৬৭৮',
            'email': 'rahim@email.com',
            'financial_year': '2026-2027',
            'business_address_house': '১২৩',
            'business_address_road': '৪৫',
            'business_address_block': 'বি/৪',
            'business_address_ward': '৫২',
            'business_address_thana': 'উত্তরা',
            'business_address_district': 'ঢাকা',
            'business_address_postcode': '১২৩০',
            'business_zone': 'উত্তরাঞ্চল',
            'business_ward_market': 'উত্তরা সেক্টর ৭ মার্কেট',
            'business_address_area': 'উত্তরা সেক্টর ৭',
            'current_address_holding': '৭৮',
            'current_address_road': '১৭',
            'current_address_village': 'শাহীপাড়া',
            'current_address_thana': 'উত্তরা',
            'current_address_district': 'ঢাকা',
            'current_address_division': 'ঢাকা',
            'current_address_postcode': '১২৩০',
            'license_fee': 2000,
            'surcharge': 0,
            'tax': 3000,
            'due_amount': 0,
            'amendment_fee': 0,
            'signboard_fee': 480,
            'vat': 372,
            'book_price': 270,
            'form_fee': 0,
            'other_fee': 500,
        };
        $.each(data, function(key, val){
            var el = $('[name="'+key+'"]');
            if(el.length) el.val(val).trigger('change').trigger('input');
        });
        $('#sameAddressCheckbox').prop('checked', true).trigger('change');
        calcFee();
        Swal.fire({icon:'success',title:'অটো ফিল সম্পন্ন!',text:'সকল ফিল্ড পূরণ করা হয়েছে',timer:1500,showConfirmButton:false});
    };
    window.generateLicenseNumber = function(){
        var inp = $('#license_no'), btn = $('#generateBtn');
        btn.html('<i class="fas fa-spinner fa-spin"></i> জেনারেট হচ্ছে...').prop('disabled', true);
        $.ajax({
            url: '{{ route("user.".$city."-trade.generate") }}', type: 'GET', dataType: 'json',
            success: function(d) {
                if(d.success && d.nextLicenseNo) { inp.val(d.nextLicenseNo); Swal.fire({icon:'success',title:'সফল!',text:'নতুন লাইসেন্স নং জেনারেট করা হয়েছে'}); }
                else { Swal.fire({icon:'error',title:'ত্রুটি!',text:d.message||'সমস্যা হয়েছে'}); }
            },
            error: function(){ Swal.fire({icon:'error',title:'সার্ভার ত্রুটি',text:'সার্ভারে সমস্যা হয়েছে'}); },
            complete: function(){ btn.text('নতুন লাইসেন্স নং').prop('disabled',false); }
        });
    };
    function calcFee(){
        var t=0; $('.fee-grid input[type="number"]').each(function(){t+=parseFloat($(this).val())||0;});
        $('#totalFeeDisplay').text('সর্বমোট ফি: '+t.toLocaleString('bn-BD')+' টাকা');
        $('#total_fee_hidden').val(t.toFixed(2));
    }
    $('.fee-grid input[type="number"]').on('input', calcFee);
    $('#sameAddressCheckbox').on('change', function(){
        if(this.checked){
            ['holding','road','village','thana','district','division','postcode'].forEach(function(f){
                $('#permanent_address_'+f).val($('#current_address_'+f).val());
            });
            $('#permanentAddressSection input').prop('disabled',true).css('background-color','#f0f0f0');
        } else {
            $('#permanentAddressSection input').prop('disabled',false).css('background-color','');
        }
    });
    $('#validity_date').on('change', function(){
        var d=new Date(this.value);
        $('#displayDate').text(d.toLocaleDateString('bn-BD',{year:'numeric',month:'long',day:'numeric'}));
    });
    calcFee();
    var t=new Date(), o=new Date(t); o.setFullYear(o.getFullYear()+1);
    $('#validity_date').val(o.toISOString().split('T')[0]).trigger('change');
    $('#business_start_date').val(t.toISOString().split('T')[0]);
    $('[required]').on('input change', function(){
        $(this).val().trim()===''?$(this).addClass('is-invalid'):$(this).removeClass('is-invalid');
    });
    $('#declaration').on('change', function(){if($(this).is(':checked'))$(this).removeClass('is-invalid');});
    $('button[type="reset"]').on('click', function(){
        $('.is-invalid').removeClass('is-invalid');
        $('#license_no').val(prefix+'/032723/2026');
        $('#validity_date').val(o.toISOString().split('T')[0]).trigger('change');
        $('#business_start_date').val(t.toISOString().split('T')[0]); calcFee();
        $('#permanentAddressSection input').prop('disabled',false).css('background-color','');
        $('#sameAddressCheckbox').prop('checked',false);
    });
    $('#tradeLicenseForm').on('submit', function(e){
        e.preventDefault(); var valid=true;
        $('[required]').each(function(){ if($(this).val().trim()===''){$(this).addClass('is-invalid');valid=false;} });
        if(!$('#declaration').is(':checked')){$('#declaration').addClass('is-invalid');valid=false;}
        if(!valid){ Swal.fire({icon:'error',title:'ত্রুটি!',text:'সব আবশ্যক ফিল্ড পূরণ করুন'}); return; }
        Swal.fire({
            title:'নিশ্চিত করুন', html:'আপনি কি আবেদন জমা দিতে চান?', icon:'question',
            showCancelButton:true, confirmButtonColor:'#1a4a8d', cancelButtonColor:'#6c757d',
            confirmButtonText:'হ্যাঁ, জমা দিন', cancelButtonText:'বাতিল করুন', reverseButtons:true
        }).then(function(r){
            if(r.isConfirmed){
                var btn=$('#submitBtn'); btn.prop('disabled',true).find('.spinner-border').removeClass('d-none');
                btn.find('.submit-text').text('জমা হচ্ছে...');
                $.ajax({
                    url: '{{ route("user.".$city."-trade.submit") }}', type:'POST',
                    data: new FormData(e.target), dataType:'json',
                    contentType:false, processData:false,
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    success:function(resp){
                        if(resp.status==='success'||resp.success){
                            Swal.fire({icon:'success', title:'সফল!', html:resp.message+'<br><br><strong>আইডি:</strong> '+resp.application_id+'<br><strong>লাইসেন্স:</strong> '+resp.license_no, allowOutsideClick:false}).then(function(){if(resp.redirect)window.location.href=resp.redirect;});
                        } else { Swal.fire({icon:'error',title:'ত্রুটি!',text:resp.message||'সমস্যা হয়েছে'}); }
                    },
                    error:function(){ Swal.fire({icon:'error',title:'সার্ভার ত্রুটি',text:'সার্ভারে সমস্যা হয়েছে'}); },
                    complete:function(){ btn.prop('disabled',false).find('.spinner-border').addClass('d-none'); btn.find('.submit-text').text('আবেদন জমা দিন'); }
                });
            }
        });
    });
});
</script>
@endsection