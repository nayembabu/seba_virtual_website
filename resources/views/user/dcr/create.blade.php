@extends('user.layouts.app')
@section('title') @lang($title) @endsection

@push('style')
<style>
body { font-family: 'Kalpurush', sans-serif !important; }
.form-control, label, p, h5, span, div, input, textarea, button, .card, .card-header, .card-body, .section-title, .form-label {
    font-family: 'Kalpurush', sans-serif !important;
}
@font-face { font-family: Kalpurush; src: url({{ asset('assets/hi/Kalpurush.ttf') }}) format("truetype"); font-weight: normal; font-style: normal; }
/* Security: Text selection disabled */
body { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
.card-header { background-color: #0d6efd; color: white; font-weight: bold; }
.form-label { font-weight: 600; }
.section-title { margin-top: 20px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #0d6efd; color: #0d6efd; }
.admin-notice-box { border-left: 4px solid #17a2b8; background-color: #e0f7fa; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
</style>
@endpush

@section('content')
@php $serviceCharge = \App\Models\ServiceCharge::getCharge('dcr'); @endphp

<div class="container-fluid mb-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

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

            <div class="admin-notice-box shadow-sm">
                <h5 class="text-info fw-bold mb-2"><i class="fas fa-bullhorn me-2"></i>নির্দেশনা</h5>
                <p class="mb-0 text-dark" style="font-size: 0.95rem;">
                    সঠিক তথ্য দিয়ে অনলাইন ডিসিআর (DCR) ফর্ম পূরণ করুন। ডকুমেন্ট জেনারেট করলে আপনার ব্যালেন্স থেকে সার্ভিস ফি কাটা হবে। লোগো এবং স্বাক্ষর অবশ্যই PNG ফরম্যাটে আপলোড করবেন।
                </p>
            </div>

            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice"></i> অনলাইন ডিসিআর ফর্ম</h5>
                    <a href="{{ route('user.dcr.logs') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-list"></i> লিস্ট দেখুন
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="d-flex justify-content-end mb-2">
                        <span style="font-size:0.95rem;color:#0d6efd;font-weight:600">সার্ভিস ফি: @if($serviceCharge) ৳{{ number_format($serviceCharge, 2) }} @else ৳0.00 @endif</span>
                    </div>
                    <div class="text-center mb-4">
                        <h2 style="font-size:2rem;font-weight:800;text-shadow:2px 2px 8px rgba(0,0,0,0.25)">অনলাইন ডিসিআর (DCR) জেনারেটর</h2>
                    </div>
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-warning btn-sm" onclick="autoFill()">
                            <i class="fas fa-magic"></i> অটো ফিল
                        </button>
                    </div>
                    <form action="{{ route('user.dcr.store') }}" method="POST" enctype="multipart/form-data" id="dcrForm">
                        @csrf

                        <h5 class="section-title">অফিস ও সাধারণ তথ্য</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">১. ভূমি অফিসের ঠিকানা</label>
                                <input type="text" name="office_address" class="form-control" placeholder="যেমন: ধামইরহাট, নওগা" value="{{ old('office_address') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">২. অনলাইন ডিসিআর নং</label>
                                <input type="text" name="dcr_no" class="form-control" placeholder="যেমন: DCR26338600711843" value="{{ old('dcr_no') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">৩. জমার তারিখ</label>
                                <input type="text" name="deposit_date" class="form-control" placeholder="যেমন: ১৪/০৩/২০২৬" value="{{ old('deposit_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">৪. ভূমি অফিসের লোগো (PNG)</label>
                                <input type="file" name="office_logo" class="form-control" accept="image/png" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">৫. ভূমি কমিশনারের নাম</label>
                                <input type="text" name="commissioner_name" class="form-control" placeholder="যেমন: মো: মিনহাজুল ইসলাম" value="{{ old('commissioner_name') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">৬. স্বাক্ষর (PNG)</label>
                                <input type="file" name="signature_img" class="form-control" accept="image/png" required>
                            </div>
                        </div>

                        <h5 class="section-title">আবেদনকারীর তথ্য</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">৭. আবেদনকারী/গণের নাম</label>
                                <input type="text" name="applicant_name" class="form-control" placeholder="যেমন: ১) ফারিয়া আক্তার, ২) মোঃ সাইফুল ইসলাম" value="{{ old('applicant_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">৯. আবেদন নম্বর</label>
                                <input type="text" name="application_no" class="form-control" placeholder="যেমন: ১৪০৭৭০৭৪" value="{{ old('application_no') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">৮. ঠিকানা</label>
                                <textarea name="applicant_address" class="form-control" rows="2" placeholder="বিস্তারিত ঠিকানা লিখুন" required>{{ old('applicant_address') }}</textarea>
                            </div>
                        </div>

                        <h5 class="section-title">মিউটেশন তথ্য</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">১০. মিউটেশন মামলা নম্বর</label>
                                <input type="text" name="mutation_case_no" class="form-control" value="{{ old('mutation_case_no') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">১১. মিউটেশন খতিয়ান নম্বর</label>
                                <input type="text" name="mutation_khatian_no" class="form-control" value="{{ old('mutation_khatian_no') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">১২. মিউটেশন আদেশের তারিখ</label>
                                <input type="text" name="mutation_order_date" class="form-control" value="{{ old('mutation_order_date') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">১৩. মিউটেশন হোল্ডিং নম্বর</label>
                                <input type="text" name="mutation_holding_no" class="form-control" value="{{ old('mutation_holding_no') }}">
                            </div>
                        </div>

                        <h5 class="section-title">জমির তফসিল</h5>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">১৪. মৌজা</label>
                                <input type="text" name="mouza" class="form-control" value="{{ old('mouza') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">১৫. জে এল নাম্বার</label>
                                <input type="text" name="jl_no" class="form-control" value="{{ old('jl_no') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">১৬. আগত খতিয়ানের ধরণ</label>
                                <input type="text" name="prev_khatian_type" class="form-control" value="{{ old('prev_khatian_type') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">১৭. আগত খতিয়ানের নং</label>
                                <input type="text" name="prev_khatian_no" class="form-control" value="{{ old('prev_khatian_no') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">১৮. দাগ নং</label>
                                <input type="text" name="dag_no" class="form-control" value="{{ old('dag_no') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">১৯. জমির পরিমান</label>
                                <input type="text" name="land_amount" class="form-control" value="{{ old('land_amount') }}" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-label">২০. মোট জমির পরিমান</label>
                                <input type="text" name="total_land_amount" class="form-control" placeholder="যেমন: ০.১৭৫০০০ একর" value="{{ old('total_land_amount') }}" required>
                            </div>
                        </div>

                        <h5 class="section-title">ফি সংক্রান্ত তথ্য</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">২১. ডিসিআর ফি</label>
                                <input type="text" name="dcr_fee" class="form-control" placeholder="যেমন: ১১০০/=" value="{{ old('dcr_fee') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">২২. সর্বমোট</label>
                                <input type="text" name="grand_total" class="form-control" placeholder="যেমন: ১১০০/=" value="{{ old('grand_total') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">২৩. ইউনিক কোড</label>
                                <input type="text" name="unique_code" class="form-control" placeholder="যেমন: 70487a9b8" value="{{ old('unique_code') }}" required>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow" id="submitBtn">
                                <i class="fas fa-file-invoice-dollar"></i> ডকুমেন্ট তৈরি করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function autoFill() {
    var inputs = document.querySelectorAll('#dcrForm input.form-control, #dcrForm textarea.form-control');
    inputs.forEach(function(inp) {
        if (inp.placeholder) inp.value = inp.placeholder;
    });
}
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function(e) {
        if(e.keyCode == 123) { return false; }
        if(e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 67 || e.keyCode == 74)) { return false; }
        if(e.ctrlKey && (e.keyCode == 85 || e.keyCode == 83)) { return false; }
    };
    document.getElementById('dcrForm').addEventListener('submit', function(e) {
        @if($serviceCharge)
        if (!confirm("আপনি কি নিশ্চিত? ডকুমেন্টটি তৈরি করতে আপনার ব্যালেন্স থেকে ৳{{ number_format($serviceCharge, 2) }} কাটা হবে।")) {
        @else
        if (!confirm("আপনি কি নিশ্চিত? ডকুমেন্টটি তৈরি করতে আপনার ব্যালেন্স থেকে সার্ভিস ফি কাটা হবে।")) {
        @endif
            e.preventDefault();
            return false;
        }
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = 'প্রসেসিং হচ্ছে...';
        return true;
    });
</script>
@endsection