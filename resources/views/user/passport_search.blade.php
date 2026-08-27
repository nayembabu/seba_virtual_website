@extends('user.layouts.app')

@section('title') পাসপোর্ট স্লিপ @endsection

@push('style')
<link href="https://fonts.cdnfonts.com/css/santeria-signature" rel="stylesheet">
<style>
:root {
    --primary: #4f46e5; --primary-light: #e0e7ff; --bg-color: #f8fafc;
    --text-dark: #0f172a; --text-muted: #64748b; --white: #ffffff;
    --border-color: #e2e8f0; --status-success: #10b981;
}
.premium-panel {
    border: none; border-radius: 20px;
    box-shadow: 0 15px 35px rgba(15,23,42,0.04);
    background: var(--white); padding: 30px;
}
.page-main-title {
    font-size: 24px; font-weight: 700;
    color: var(--text-dark); letter-spacing: -0.5px;
}
.search-zone-wrapper {
    background: linear-gradient(135deg,#1e293b 0%,#0f172a 100%);
    border-radius: 16px; padding: 28px;
    box-shadow: 0 8px 25px rgba(15,23,42,0.12);
}
.form-label-search {
    font-size: 14px; font-weight: 500;
    color: #cbd5e1; margin-bottom: 8px;
}
.form-label-custom {
    font-size: 13px; font-weight: 600;
    color: #475569; margin-bottom: 5px;
}
.custom-input-box {
    border-radius: 8px; border: 1px solid #d1d5db;
    padding: 10px 14px; font-size: 14px; color: #1f2937;
    background-color: #fff; transition: all 0.2s ease-in-out;
}
.custom-input-box:focus {
    border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,238,0.15);
}
.editor-section-card {
    background: var(--white); border: 1px solid #e5e7eb;
    border-radius: 16px; padding: 25px; margin-top: 30px;
}
.loading-overlay {
    display: none; position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15,23,42,0.85); backdrop-filter: blur(6px);
    z-index: 9999; justify-content: center; align-items: center;
    flex-direction: column; color: #fff;
}
/* Slip Design */
.enrollment-slip-container {
    background: #fff; color: #000; font-family: Arial, sans-serif;
    padding: 10px 18px 6px 18px;
    border: 3px solid #0f172a; border-radius: 8px;
    max-width: 1020px; margin: 0 auto; position: relative;
    box-sizing: border-box;
}
.slip-quotation-header {
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 2px solid #0f172a; padding-bottom: 4px; margin-bottom: 6px;
}
.slip-quotation-left { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #1e3a8a; letter-spacing: 0.5px; }
.slip-quotation-right { font-size: 11px; font-weight: 700; color: #0d9488; }
.slip-official-quote-box {
    background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0f172a;
    padding: 5px 10px; font-size: 9.5px; font-style: italic; color: #334155;
    margin-bottom: 8px; line-height: 1.3; font-weight: 500;
}
.enroll-header-section {
    display: flex; border-bottom: 1px solid #cbd5e1;
    padding-bottom: 5px; margin-bottom: 6px;
}
.enroll-photo-box {
    width: 100px; height: 118px;
    border: 2px solid #0f172a; border-radius: 4px; margin-right: 15px;
    display: flex; align-items: center; justify-content: center;
    background: #f8fafc; flex-shrink: 0;
}
.enroll-photo-box img { width: 100%; height: 100%; object-fit: cover; }
.enroll-top-meta { flex-grow: 1; }
.meta-grid-row {
    display: flex; flex-wrap: wrap; margin-bottom: 2px; font-size: 11.5px;
}
.meta-label { width: 140px; font-weight: 600; color: #475569; }
.meta-sep { width: 12px; text-align: center; font-weight: bold; }
.meta-val { flex-grow: 1; font-weight: 700; color: #000; }
.section-premium-heading {
    background: #e0f2fe; color: #0369a1; border-left: 5px solid #0284c7;
    padding: 3px 8px; font-size: 11.5px; font-weight: 800;
    text-transform: uppercase; margin-top: 5px; margin-bottom: 5px;
    border-radius: 2px; letter-spacing: 0.3px;
}
.data-grid-container {
    display: flex; justify-content: space-between;
    font-size: 11.5px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;
}
.data-column-left, .data-column-right { width: 49%; }
.data-item-row { display: flex; margin-bottom: 2px; line-height: 1.25; }
.data-lbl { width: 140px; color: #475569; font-weight: 600; }
.data-sep { width: 12px; text-align: center; }
.data-val { flex-grow: 1; font-weight: 700; color: #000; text-transform: uppercase; word-break: break-all; }
.footer-signature-area {
    display: flex; justify-content: space-between; margin-top: 14px; font-size: 10.5px;
}
.sig-line {
    border-top: 1px dashed #0f172a; width: 160px;
    text-align: center; padding-top: 2px; font-weight: bold; color: #334155;
}
.disclaimer-text {
    font-size: 9px; color: #475569; margin-top: 6px; line-height: 1.25;
    border-top: 1px dashed #cbd5e1; padding-top: 3px;
}
.domain-footer-stamp {
    text-align: center; font-size: 9.5px; font-weight: 700;
    color: #0284c7; margin-top: 5px; text-transform: lowercase;
}
.emergency-box { font-size: 11.5px; margin-bottom: 4px; }
#rep_signature_draw {
    font-family: 'Santeria Signature', 'Great Vibes', 'Brush Script MT', cursive;
    font-size: 28px; color: #1e3a8a;
    line-height: 1; display: inline-block;
    transform: rotate(-2deg);
}
@media print {
    @page { size: A4 landscape; margin: 2mm 3mm; }
    body { background: #fff !important; color: #000 !important; margin: 0; padding: 0; }
    .no-print { display: none !important; }
    #print_report_area { display: block !important; position: absolute; left: 0; top: 0; width: 100% !important; }
    .enrollment-slip-container { width: 100% !important; max-width: 100% !important; border: 3px solid #0f172a !important; padding: 8px 14px !important; }
    .section-premium-heading { background: #e0f2fe !important; color: #0369a1 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .slip-official-quote-box { background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>
@endpush

@section('content')
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-light mb-3" style="width: 3.5rem; height: 3.5rem;" role="status"></div>
    <h5 class="fw-bold text-white">পাসপোর্ট লাইভ ডাটাবেজ অনুসন্ধান করা হচ্ছে...</h5>
    <p class="text-light opacity-75 small">অনুগ্রহ করে কয়েক সেকেন্ড অপেক্ষা করুন, তথ্য সংগ্রহের প্রসেস চলছে।</p>
</div>

<div class="container py-4 main-app-container no-print">
    <div class="card premium-panel shadow-sm">
        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h4 class="page-main-title m-0">পাসপোর্ট অনলাইন স্লিপ জেনারেটর প্যানেল</h4>
                <p class="text-muted small m-0">রিয়েল-টাইম ডাটাবেজ ভেরিফিকেশন এবং প্রিমিয়াম স্লিপ কপি অটো-ডাউনলোডার</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Area -->
        <div class="search-zone-wrapper mb-4">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label-search">পাসপোর্ট ক্যাটাগরি ও মূল্য তালিকা</label>
                    <select class="form-select bg-dark text-white border-secondary" id="inp_passport_type" style="border-radius:10px; font-size:15px; height:50px;">
                        <option value="MRP">MRP Passport (চার্জ: 350.00 ৳)</option>
                        <option value="E-Passport">E-Passport (চার্জ: 450.00 ৳)</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-search">পাসপোর্ট নম্বর টাইপ করুন</label>
                    <input type="text" class="form-control bg-dark text-white border-secondary text-uppercase font-monospace" id="inp_passport_no" placeholder="যেমন: A03245192" style="border-radius:10px; font-size:16px; height:50px; letter-spacing:1px;">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" id="btn_verify_search" style="border-radius:10px; font-size:15px; height:50px; background-color:#2563eb;">
                        <i class="fas fa-search me-1"></i> অনুসন্ধান
                    </button>
                </div>
            </div>
        </div>

        <!-- Editable Data Section -->
        <div id="editable_data_section" style="display:none;">
            <div class="card editor-section-card bg-light border">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <h5 class="m-0 text-dark fw-bold text-uppercase"><i class="fas fa-sliders text-warning me-2"></i> এপিআই থেকে প্রাপ্ত অল ফিল্ডস এডিটর প্যানেল</h5>
                    <span class="badge bg-success px-3 py-2" style="border-radius:6px;">ডাটা রিসিভড</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 border-bottom pb-2 mb-2"><span class="fw-bold text-secondary text-uppercase small">১. টপ স্লিপ ইনফরমেশন</span></div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">Passport No</label>
                        <input type="text" class="form-control custom-input-box font-monospace fw-bold" id="edit_passport_no">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Date of Issue</label>
                        <input type="text" class="form-control custom-input-box" id="edit_issue_date">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Date of Expiry</label>
                        <input type="text" class="form-control custom-input-box" id="edit_expiry_date">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">Enrolment ID</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_enrolment_id">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Date of Bio-Enrolment</label>
                        <input type="text" class="form-control custom-input-box" id="edit_bio_date">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Collection Date</label>
                        <input type="text" class="form-control custom-input-box" id="edit_collection_date">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">Passport Status</label>
                        <input type="text" class="form-control custom-input-box fw-semibold text-primary" id="edit_status">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Counter ID</label>
                        <input type="text" class="form-control custom-input-box" id="edit_counter_id">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Enrolled By</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_enrolled_by">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">Passport Type</label>
                        <input type="text" class="form-control custom-input-box fw-semibold text-primary" id="edit_passport_type">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Application Type</label>
                        <input type="text" class="form-control custom-input-box" id="edit_app_type">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">National ID / Birth ID</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_national_id">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Old Passport No.</label>
                        <input type="text" class="form-control custom-input-box font-monospace text-uppercase" id="edit_old_passport">
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label-custom">Photo Edit Status</label>
                        <input type="text" class="form-control custom-input-box" id="edit_photo_edit">
                    </div>

                    <div class="col-12 border-bottom pb-2 mt-4 mb-2"><span class="fw-bold text-secondary text-uppercase small">২. ব্যক্তিগত তথ্য</span></div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom fw-bold text-dark">Full Name</label>
                        <input type="text" class="form-control custom-input-box text-uppercase fw-bold text-dark" id="edit_name">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">Father's Name</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_father">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">Mother's Name</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_mother">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">Spouse's Name</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_spouse">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">Date of Birth</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_dob">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">Gender</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_gender">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">Marital Status</label>
                        <input type="text" class="form-control custom-input-box text-uppercase fw-bold" id="edit_marital_status">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">Occupation</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_occupation">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">Mobile No.</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_mobile">
                    </div>

                    <div class="col-12 border-bottom pb-2 mt-4 mb-2"><span class="fw-bold text-secondary text-uppercase small">৩. ঠিকানা</span></div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom text-primary">উপজেলা / থানা</label>
                        <input type="text" class="form-control custom-input-box text-uppercase border-primary" id="edit_thana">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom text-primary">জেলা</label>
                        <input type="text" class="form-control custom-input-box text-uppercase border-primary" id="edit_district">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পোস্ট কোড</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_post_code">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পোস্ট অফিস</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_post_office">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পার্মানেন্ট জেলা</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_per_district">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পার্মানেন্ট থানা</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_per_thana">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পার্মানেন্ট পোস্ট কোড</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_per_post_code">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label-custom">পার্মানেন্ট পোস্ট অফিস</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_per_post_office">
                    </div>
                    <div class="col-12">
                        <label class="form-label-custom">ঠিকানা</label>
                        <textarea class="form-control custom-input-box text-uppercase" id="edit_address" rows="2"></textarea>
                    </div>

                    <div class="col-12 border-bottom pb-2 mt-4 mb-2"><span class="fw-bold text-danger text-uppercase small">৪. Emergency Contact Details</span></div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">EC Name (জরুরি যোগাযোগ)</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_ec_name">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">EC Relationship (সম্পর্ক)</label>
                        <input type="text" class="form-control custom-input-box text-uppercase fw-semibold" id="edit_ec_relation">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label-custom">EC Contact No.</label>
                        <input type="text" class="form-control custom-input-box font-monospace" id="edit_ec_phone">
                    </div>
                    <div class="col-12">
                        <label class="form-label-custom">EC Address</label>
                        <input type="text" class="form-control custom-input-box text-uppercase" id="edit_ec_address">
                    </div>

                    <div class="col-12 mt-4 pt-2">
                        <button type="button" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-sm text-uppercase" onclick="generateOfficialSlip()" style="border-radius:12px; font-size:16px; background-color:#10b981; border:none;">
                            <i class="fas fa-file-pdf me-1"></i> স্লিপ জেনারেট ও প্রিভিউ করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Official Slip -->
<div class="container my-3" id="print_report_area" style="display:none;">
    <div class="enrollment-slip-container shadow-sm">
        <div class="slip-quotation-header">
            <div class="slip-quotation-left">Government of the People's Republic of Bangladesh</div>
            <div class="slip-quotation-right">Live Verification Summary Slip — Official Record Copy</div>
        </div>
        <div class="slip-official-quote-box">
            "This document constitutes a certified digital replication of the live biometric enrolment and verification records retrieved securely from the central passport database infrastructure. Any unauthorized data alteration, duplication, or tampering with this information system printout renders this official summary strictly null, void, and subject to legal prosecution."
        </div>

        <div class="enroll-header-section">
            <div class="enroll-photo-box">
                <img id="rep_photo" src="" alt="Applicant Photo" style="display:none;">
                <div id="rep_photo_none" style="font-size:11px; color:#666; font-weight:bold; text-align:center; padding:5px;">PHOTO</div>
            </div>

            <div class="enroll-top-meta">
                <div style="height:28px; border:1px dashed #0f172a; margin-bottom:5px; padding:1px 12px; display:flex; align-items:center; background:#fafafa; border-radius:4px;">
                    <span id="rep_signature_draw"></span>
                </div>

                <div class="meta-grid-row">
                    <div class="meta-label">Enrolment ID</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val font-monospace text-primary" id="rep_enrolment_id"></div>
                    <div style="width:140px; font-weight:600; color:#475569; margin-left:auto;">Passport Status</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val text-success fw-bold" id="rep_status" style="max-width:260px;"></div>
                </div>
                <div class="meta-grid-row">
                    <div class="meta-label">Date of Bio-Enrolment</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val" id="rep_bio_date"></div>
                    <div style="width:140px; font-weight:600; color:#475569; margin-left:auto;">Counter ID</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val" id="rep_counter_id"></div>
                </div>
                <div class="meta-grid-row">
                    <div class="meta-label">Collection Date</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val" style="flex-grow:0; width:auto; margin-right:5px;" id="rep_collection_date"></div>
                    <div style="font-size:9px; color:#64748b; align-self:center; font-weight:500;">( Subject to Police Verification )</div>
                    <div style="width:140px; font-weight:600; color:#475569; margin-left:auto;">Enrolled By</div>
                    <div class="meta-sep">:</div>
                    <div class="meta-val text-uppercase" id="rep_enrolled_by"></div>
                </div>
            </div>
        </div>

        <div class="section-premium-heading">1. Personal & Biometric Enrolment Particulars</div>
        <div class="data-grid-container">
            <div class="data-column-left">
                <div class="data-item-row"><div class="data-lbl">Bangladesh Mission</div><div class="data-sep">:</div><div class="data-val" id="rep_mission"></div></div>
                <div class="data-item-row"><div class="data-lbl">SB (Present Address)</div><div class="data-sep">:</div><div class="data-val" id="rep_sb_present"></div></div>
                <div class="data-item-row"><div class="data-lbl">SB (Permanent Address)</div><div class="data-sep">:</div><div class="data-val" id="rep_sb_permanent"></div></div>
                <div class="data-item-row"><div class="data-lbl">Passport Type</div><div class="data-sep">:</div><div class="data-val" id="rep_p_type"></div></div>
                <div class="data-item-row"><div class="data-lbl">Application Type</div><div class="data-sep">:</div><div class="data-val" id="rep_app_type"></div></div>
                <div class="data-item-row"><div class="data-lbl" style="color:#1e3a8a;">Name of Applicant</div><div class="data-sep">:</div><div class="data-val" id="rep_name" style="font-size:12px; color:#1e3a8a;"></div></div>
                <div class="data-item-row"><div class="data-lbl">Father's Name</div><div class="data-sep">:</div><div class="data-val" id="rep_father"></div></div>
                <div class="data-item-row"><div class="data-lbl">Mother's Name</div><div class="data-sep">:</div><div class="data-val" id="rep_mother"></div></div>
                <div class="data-item-row"><div class="data-lbl">Spouse's Name</div><div class="data-sep">:</div><div class="data-val" id="rep_spouse"></div></div>
                <div class="data-item-row"><div class="data-lbl">Mobile No.</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_mobile"></div></div>
                </div>
            <div class="data-column-right">
                <div class="data-item-row"><div class="data-lbl">Second Part (Surname)</div><div class="data-sep">:</div><div class="data-val" id="rep_surname"></div></div>
                <div class="data-item-row"><div class="data-lbl">First Part (Given Name)</div><div class="data-sep">:</div><div class="data-val" id="rep_given_name"></div></div>
                <div class="data-item-row"><div class="data-lbl">Nationality</div><div class="data-sep">:</div><div class="data-val" id="rep_nationality"></div></div>
                <div class="data-item-row"><div class="data-lbl">Place of Birth</div><div class="data-sep">:</div><div class="data-val" id="rep_pob"></div></div>
                <div class="data-item-row"><div class="data-lbl">Birth ID / NID</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_birth_id"></div></div>
                <div class="data-item-row"><div class="data-lbl">Date of Birth</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_dob"></div></div>
                <div class="data-item-row"><div class="data-lbl">Old Passport No.</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_old_passport"></div></div>
                <div class="data-item-row"><div class="data-lbl">Gender</div><div class="data-sep">:</div><div class="data-val" id="rep_gender"></div></div>
                <div class="data-item-row"><div class="data-lbl">Marital Status</div><div class="data-sep">:</div><div class="data-val text-uppercase" id="rep_marital_status"></div></div>
                <div class="data-item-row"><div class="data-lbl" style="font-weight:700; color:#b91c1c;">*Passport No.</div><div class="data-sep">:</div><div class="data-val font-monospace text-danger" style="font-size:12.5px;" id="rep_passport_no_field"></div></div>
                <div class="data-item-row"><div class="data-lbl">*Date of Issue</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_issue"></div></div>
                <div class="data-item-row"><div class="data-lbl">*Date of Expiry</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_expiry"></div></div>
                <div class="data-item-row"><div class="data-lbl">*Photo Edit Status</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_photo_edit"></div></div>
            </div>
        </div>

        <div class="section-premium-heading">2. Address Information</div>
        <div class="data-grid-container" style="border-bottom:none;">
            <div class="data-column-left">
                <div class="data-item-row"><div class="data-lbl">Present Address</div><div class="data-sep">:</div><div class="data-val" id="rep_present_address" style="font-size:10.5px;"></div></div>
            </div>
            <div class="data-column-right">
                <div class="data-item-row"><div class="data-lbl">Permanent Address</div><div class="data-sep">:</div><div class="data-val" id="rep_permanent_address" style="font-size:10.5px;"></div></div>
            </div>
        </div>

        <div class="section-premium-heading">3. Emergency Contact Delineation Details</div>
        <div class="emergency-box" style="font-size:11.5px; margin-bottom:4px;">
            <div style="display:flex; width:100%;">
                <div style="width:50%;">
                    <div class="data-item-row"><div class="data-lbl">Name</div><div class="data-sep">:</div><div class="data-val" id="rep_ec_name"></div></div>
                    <div class="data-item-row"><div class="data-lbl">Address</div><div class="data-sep">:</div><div class="data-val" id="rep_ec_address" style="font-size:10.5px;"></div></div>
                    <div class="data-item-row"><div class="data-lbl">Relationship</div><div class="data-sep">:</div><div class="data-val" id="rep_ec_relation" style="font-weight:700; color:#0369a1;"></div></div>
                </div>
                <div style="width:50%; padding-left:20px;">
                    <div class="data-item-row"><div class="data-lbl">Contact No.</div><div class="data-sep">:</div><div class="data-val font-monospace" id="rep_ec_phone"></div></div>
                </div>
            </div>
        </div>

        <div class="footer-signature-area">
            <div><div style="height:12px;"></div><div class="sig-line">Data Enrollment Operator</div></div>
            <div><div style="height:12px;"></div><div class="sig-line">Applicant's Signature</div></div>
            <div><div style="height:12px;"></div><div class="sig-line">Issuing Authority Stamp</div></div>
        </div>

        <div class="disclaimer-text">
            Important Notice: Passport updates will be automatically pushed to your registered mobile number. For raw status queries, please send an SMS from any mobile operator network to 6969 formatting: MRP &lt;space&gt; Enrolment ID. Please ensure your old physical passport is produced during MRP booklet distribution.
        </div>
        <div class="domain-footer-stamp">secure online tracking server: {{ request()->getHost() }}</div>

        <div class="text-center mt-2 no-print">
            <button onclick="triggerAutoDownload()" class="btn btn-lg btn-dark px-5 py-2.5 fw-bold shadow-lg" style="border-radius:10px; background-color:#0f172a;">
                <i class="fas fa-download"></i> অটো ডাউনলোড পিডিএফ (PDF)
            </button>
        </div>
    </div>
</div>

<!-- Search History -->
<div class="container mt-4 no-print main-app-container">
    <div class="card premium-panel shadow-sm">
        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-clock text-danger me-1"></i> আপনার সাম্প্রতিক অনুসন্ধান হিস্ট্রি</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle border text-center m-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th>পাসপোর্ট নম্বর</th>
                        <th>আবেদনকারীর নাম</th>
                        <th>ধরণ</th>
                        <th>পোস্ট অফিস (থানা)</th>
                        <th>চার্জকৃত ফি</th>
                        <th>তারিখ ও সময়</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody id="history_table_body" style="font-size:13.5px;">
                    @forelse($histories as $h)
                    <tr>
                        <td class="fw-bold font-monospace">{{ $h->passport_no }}</td>
                        <td>{{ $h->applicant_name }}</td>
                        <td>{{ $h->passport_type }}</td>
                        <td>{{ $h->thana }}</td>
                        <td>{{ number_format($h->charged_amount, 2) }} ৳</td>
                        <td>{{ $h->created_at ? $h->created_at->format('d/m/Y h:i A') : '' }}</td>
                        <td><button type="button" class="btn btn-sm btn-outline-primary history-print" onclick="loadHistoryToForm('{{ addslashes($h->passport_no) }}', '{{ addslashes($h->passport_type) }}', '{{ addslashes($h->api_response) }}')"><i class="fas fa-print"></i> ভিউ</button></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">এখনো কোনো সফল ভেরিফিকেশন করা হয়নি।</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
let globalPassportNo = '';
let globalFullName = '';
let tempPhotoSrc = '';

document.getElementById('btn_verify_search').addEventListener('click', function() {
    const passportNo = document.getElementById('inp_passport_no').value.trim();

    if(passportNo === '') {
        alert('দয়া করে সঠিক পাসপোর্ট নম্বর টাইপ করুন।');
        return;
    }

    document.getElementById('loadingOverlay').style.display = 'flex';
    document.getElementById('editable_data_section').style.display = 'none';
    document.getElementById('print_report_area').style.display = 'none';

    const formData = new FormData();
    formData.append('passport', passportNo);
    formData.append('passport_type', document.getElementById('inp_passport_type').value);

    const url = '{{ route("passport.search") }}?ajax=1';
    fetch(url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        document.getElementById('loadingOverlay').style.display = 'none';

        if(res.success && res.data) {
            populateForm(passportNo, res.data);
            if (res.histories) {
                updateHistoryTable(res.histories);
            }
        } else {
            alert(res.message || 'ডাটা পাওয়া যায়নি। কোনো ব্যালেন্স কাটা হয়নি।');
        }
    })
    .catch(err => {
        document.getElementById('loadingOverlay').style.display = 'none';
        alert('সার্ভার থেকে কোনো রেসপন্স পাওয়া যায়নি! পুনরায় চেষ্টা করুন।');
    });
});

function loadHistoryToForm(passportNo, passportType, rawJsonString) {
    try {
        const parsedData = JSON.parse(rawJsonString);
        const actualData = (parsedData && parsedData.data) ? parsedData.data : parsedData;
        if(actualData) {
            document.getElementById('inp_passport_no').value = passportNo;
            document.getElementById('inp_passport_type').value = passportType;
            populateForm(passportNo, actualData);
            generateOfficialSlip();
        }
    } catch(e) {
        alert('হিস্ট্রি ডাটা প্রসেস করতে ত্রুটি হয়েছে।');
    }
}

function updateHistoryTable(histories) {
    const tbody = document.getElementById('history_table_body');
    if (!histories || histories.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">এখনো কোনো সফল ভেরিফিকেশন করা হয়নি।</td></tr>';
        return;
    }
    let html = '';
    histories.forEach(function(h) {
        let dateStr = '';
        if (h.created_at) {
            try {
                let d = new Date(h.created_at);
                dateStr = ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth()+1)).slice(-2) + '/' + d.getFullYear() + ' ' +
                    ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);
            } catch(e) { dateStr = h.created_at; }
        }
        let amount = '0.00';
        if (h.charged_amount) {
            amount = parseFloat(h.charged_amount).toFixed(2);
        }
        let escapedJson = (h.api_response || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
        html += '<tr>' +
            '<td class="fw-bold font-monospace">' + (h.passport_no || '') + '</td>' +
            '<td>' + (h.applicant_name || '') + '</td>' +
            '<td>' + (h.passport_type || '') + '</td>' +
            '<td>' + (h.thana || '') + '</td>' +
            '<td>' + amount + ' ৳</td>' +
            '<td>' + dateStr + '</td>' +
            '<td><button type="button" class="btn btn-sm btn-outline-primary history-print" onclick="loadHistoryToForm(\'' + (h.passport_no || '') + '\', \'' + (h.passport_type || '') + '\', \'' + escapedJson + '\')"><i class="fas fa-print"></i> ভিউ</button></td>' +
            '</tr>';
    });
    tbody.innerHTML = html;
}

function populateForm(passportNo, d) {
    console.log('API raw data:', d);
    console.log('API keys:', Object.keys(d));

    let fName = d.fathersName || d.fatherName || d.father_name || d.fathers_name || '';
    let mName = d.mothersName || d.motherName || d.mother_name || d.mothers_name || '';
    let sName = d.spouseName || d.spouse_name || '';
    let primaryMobile = d.mobile || d.mobileNo || d.phone || d.mobile_no || '';

    globalPassportNo = d.passportNumber || passportNo;
    globalFullName = d.fullName || d.name || d.applicantName || d.applicant_name || '';

    if (!globalFullName && fName) {
        globalFullName = "APPLICANT (" + fName + "'S CHILD)";
    } else if (!globalFullName) {
        globalFullName = 'PASSPORT HOLDER';
    }

    let nameParts = globalFullName.trim().split(/\s+/);
    let surname = nameParts.length > 1 ? nameParts.pop() : '';
    let givenName = nameParts.join(' ');

    document.getElementById('edit_passport_no').value = globalPassportNo;
    document.getElementById('edit_enrolment_id').value = d.enrollmentId || d.enrolmentId || d.applicationId || d.enrollment_id || d.application_id || d.bmetNo || '';
    document.getElementById('edit_bio_date').value = d.dateOfBioEnrolment || d.bioDate || d.enrolmentDate || d.date_of_bio_enrolment || d.clearanceDate || '';
    document.getElementById('edit_collection_date').value = d.collectionDate || d.deliveryDate || d.collection_date || d.delivery_date || '';
    document.getElementById('edit_status').value = d.status || d.passportStatus || d.statusDescription || d.status_name || d.dataSourceCategory || '';
    document.getElementById('edit_counter_id').value = d.counterId || d.counterName || d.counter_id || '';
    document.getElementById('edit_enrolled_by').value = d.enrolledBy || d.operatorName || d.enrolled_by || '';
    document.getElementById('edit_passport_type').value = d.passportType || d.type || 'MRP';
    document.getElementById('edit_app_type').value = d.applicationType || d.appType || d.application_type || d.clearanceTypeId || '';
    document.getElementById('edit_national_id').value = d.birthId || d.nid || d.nationalId || d.birth_id || '';
    document.getElementById('edit_old_passport').value = d.oldPassportNo || d.prevPassportNo || d.old_passport_no || '';
    document.getElementById('edit_photo_edit').value = d.photoEdit || d.photoStatus || d.photo_edit || (d.photo ? 'RECEIVED' : '');
    document.getElementById('edit_name').value = globalFullName;
    document.getElementById('edit_father').value = fName;
    document.getElementById('edit_mother').value = mName;
    document.getElementById('edit_spouse').value = sName;
    document.getElementById('edit_dob').value = d.dateofBirth || d.dob || d.dateOfBirth || d.date_of_birth || '';
    document.getElementById('edit_gender').value = d.gender || d.sex || '';
    let mStatus = d.maritalStatus || d.maritalStatusDescription || d.marital_status || d.marriageStatus || '';
    if (!mStatus && d.maritalStatusId) {
        mStatus = String(d.maritalStatusId) === '2' ? 'MARRIED' : 'SINGLE';
    }
    if (!mStatus && sName && sName.trim() !== '') { mStatus = 'MARRIED'; } else if (!mStatus) { mStatus = 'SINGLE'; }
    document.getElementById('edit_marital_status').value = mStatus;
    document.getElementById('edit_occupation').value = d.occupation || d.jobCategory || '';
    document.getElementById('edit_mobile').value = primaryMobile;

    let thana = d.preVillage || d.perVillage || d.preThana || d.perThana || d.thana || d.upazila || d.police_station || d.thanaName || d.preAddress || d.perAddress || '';
    let district = d.preDistrict || d.perDistrict || d.district || d.placeOfBirth || d.pob || d.districtName || '';
    let pOffice = d.prePostOffice || d.perPostOffice || d.postOffice || d.post_office || '';
    let pCode = d.prePostCode || d.perPostCode || d.postCode || d.post_code || '';
    let rawAddress = d.combinePerAddress || d.perAddress || d.combinePreAddress || d.preAddress || d.preAddressDetails || d.address || d.perVillage || d.preVillage || '';
    if (!rawAddress) rawAddress = [d.preVillage || d.preRoad, d.preThana, d.preDistrict].filter(Boolean).join(', ');

    document.getElementById('edit_thana').value = thana;
    document.getElementById('edit_district').value = district;
    document.getElementById('edit_post_code').value = pCode;
    document.getElementById('edit_post_office').value = pOffice;
    document.getElementById('edit_address').value = rawAddress;

    document.getElementById('edit_per_district').value = d.perDistrict || '';
    document.getElementById('edit_per_thana').value = d.perThana || '';
    document.getElementById('edit_per_post_code').value = d.perPostCode || '';
    document.getElementById('edit_per_post_office').value = d.perPostOffice || '';

    let ecName = (d.ecName || d.emergencyName || d.emergency_contact_name || '').trim();
    if (!ecName) ecName = fName;
    document.getElementById('edit_ec_name').value = ecName;
    let ecRelation = (d.ecRelationship || d.emergencyRelationship || d.ec_relationship || '').trim();
    if (ecName && ecName.toUpperCase() === fName.toUpperCase()) ecRelation = 'Father';
    else if (ecName && ecName.toUpperCase() === mName.toUpperCase()) ecRelation = 'Mother';
    else if (ecName && ecName.toUpperCase() === sName.toUpperCase()) ecRelation = 'Spouse';
    if (!ecRelation) ecRelation = 'FATHER';
    document.getElementById('edit_ec_relation').value = ecRelation;
    let ecPhone = d.ecContactNo || d.emergencyContact || d.ecPhone || d.ecMobile || d.ec_contact_no || '';
    if (!ecPhone) ecPhone = primaryMobile;
    document.getElementById('edit_ec_phone').value = ecPhone;
    document.getElementById('edit_ec_address').value = d.ecAddress || d.emergencyAddress || d.ec_address || rawAddress;

    tempPhotoSrc = (d.photo && d.photo.length > 50) ? d.photo : '';

    document.getElementById('editable_data_section').style.display = 'block';
    document.getElementById('editable_data_section').scrollIntoView({ behavior: 'smooth' });
}

function generateOfficialSlip() {
    let fullName = document.getElementById('edit_name').value;
    let nameParts = fullName.trim().split(/\s+/);
    let surname = nameParts.length > 1 ? nameParts.pop() : '';
    let givenName = nameParts.join(' ');
    let thana = document.getElementById('edit_thana').value;
    let district = document.getElementById('edit_district').value;
    let postCode = document.getElementById('edit_post_code').value;
    let postOffice = document.getElementById('edit_post_office').value;
    let village = document.getElementById('edit_address').value;

    document.getElementById('rep_enrolment_id').innerText = document.getElementById('edit_enrolment_id').value;
    document.getElementById('rep_status').innerText = document.getElementById('edit_status').value;
    document.getElementById('rep_bio_date').innerText = document.getElementById('edit_bio_date').value;
    document.getElementById('rep_counter_id').innerText = document.getElementById('edit_counter_id').value;
    document.getElementById('rep_collection_date').innerText = document.getElementById('edit_collection_date').value;
    document.getElementById('rep_enrolled_by').innerText = document.getElementById('edit_enrolled_by').value;
    document.getElementById('rep_mission').innerText = '';
    document.getElementById('rep_sb_present').innerText = '';
    document.getElementById('rep_sb_permanent').innerText = '';
    document.getElementById('rep_p_type').innerText = document.getElementById('edit_passport_type').value;
    document.getElementById('rep_app_type').innerText = document.getElementById('edit_app_type').value;

    globalFullName = fullName;
    document.getElementById('rep_name').innerText = globalFullName;
    document.getElementById('rep_father').innerText = document.getElementById('edit_father').value;
    document.getElementById('rep_mother').innerText = document.getElementById('edit_mother').value;
    document.getElementById('rep_spouse').innerText = document.getElementById('edit_spouse').value;
    document.getElementById('rep_mobile').innerText = document.getElementById('edit_mobile').value;

    let presentAddr = [village, thana, district].filter(Boolean).join(', ');
    let addrParts = [];
    if (village) addrParts.push(village);
    if (postOffice && postOffice !== village) addrParts.push(postOffice);
    if (thana) addrParts.push(thana);
    if (district) addrParts.push(district);
    let fullPresentAddr = addrParts.join(', ');
    if (postCode) fullPresentAddr += ' - ' + postCode;
    document.getElementById('rep_present_address').innerText = fullPresentAddr;

    let perDistrict = document.getElementById('edit_per_district').value;
    let perThana = document.getElementById('edit_per_thana').value;
    let perPostCode = document.getElementById('edit_per_post_code').value;
    let perPostOffice = document.getElementById('edit_per_post_office').value;
    let perAddrParts = [];
    if (perThana) perAddrParts.push(perThana);
    if (perPostOffice && perPostOffice !== perThana) perAddrParts.push(perPostOffice);
    if (perDistrict) perAddrParts.push(perDistrict);
    let perAddr = perAddrParts.join(', ');
    if (perPostCode) perAddr += ' - ' + perPostCode;
    document.getElementById('rep_permanent_address').innerText = perAddr;

    document.getElementById('rep_surname').innerText = surname;
    document.getElementById('rep_given_name').innerText = givenName;
    document.getElementById('rep_nationality').innerText = 'BANGLADESHI';
    document.getElementById('rep_pob').innerText = district;
    document.getElementById('rep_birth_id').innerText = document.getElementById('edit_national_id').value;
    document.getElementById('rep_dob').innerText = document.getElementById('edit_dob').value;
    document.getElementById('rep_old_passport').innerText = document.getElementById('edit_old_passport').value;
    document.getElementById('rep_gender').innerText = document.getElementById('edit_gender').value;
    document.getElementById('rep_marital_status').innerText = document.getElementById('edit_marital_status').value;
    document.getElementById('rep_passport_no_field').innerText = document.getElementById('edit_passport_no').value;
    document.getElementById('rep_issue').innerText = document.getElementById('edit_issue_date').value;
    document.getElementById('rep_expiry').innerText = document.getElementById('edit_expiry_date').value;
    document.getElementById('rep_photo_edit').innerText = document.getElementById('edit_photo_edit').value;

    document.getElementById('rep_ec_name').innerText = document.getElementById('edit_ec_name').value;
    document.getElementById('rep_ec_relation').innerText = document.getElementById('edit_ec_relation').value;
    document.getElementById('rep_ec_phone').innerText = document.getElementById('edit_ec_phone').value;
    document.getElementById('rep_ec_address').innerText = document.getElementById('edit_ec_address').value;

    document.getElementById('rep_signature_draw').innerText = globalFullName ? globalFullName.toLowerCase() : '';

    const imgEl = document.getElementById('rep_photo');
    const noneEl = document.getElementById('rep_photo_none');
    if(tempPhotoSrc) {
        imgEl.src = tempPhotoSrc;
        imgEl.style.display = 'block';
        noneEl.style.display = 'none';
    } else {
        imgEl.style.display = 'none';
        noneEl.style.display = 'block';
    }

    document.getElementById('print_report_area').style.display = 'block';
    document.getElementById('print_report_area').scrollIntoView({ behavior: 'smooth' });
}

function triggerAutoDownload() {
    let sanitizedName = globalFullName.trim().replace(/\s+/g, '_');
    if (!sanitizedName) sanitizedName = 'Passport_Slip';
    let generatedFilename = (globalPassportNo || 'Slip') + '_' + sanitizedName + '.pdf';

    const element = document.querySelector('.enrollment-slip-container');
    const noPrintItems = element.querySelectorAll('.no-print');
    noPrintItems.forEach(item => { item.style.setProperty('display', 'none', 'important'); });

    const options = {
        margin: 3,
        filename: generatedFilename,
        image: { type: 'jpeg', quality: 0.99 },
        html2canvas: { scale: 2, useCORS: true, logging: false, scrollY: 0 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape', compress: true }
    };

    html2pdf().set(options).from(element).save().then(() => {
        noPrintItems.forEach(item => { item.style.removeProperty('display'); });
    }).catch(err => {
        console.error('PDF Generation Error:', err);
        noPrintItems.forEach(item => { item.style.removeProperty('display'); });
    });
}
</script>
@endpush
