@extends('user.layouts.app')

@section('title') BMET ইনফো @endsection

@push('style')
<link href="https://fonts.cdnfonts.com/css/santeria-signature" rel="stylesheet">
<style>
:root {
    --diplomatic-blue: #1e3a8a;
    --deep-slate: #0f172a;
    --emerald-govt: #065f46;
    --premium-gold: #b45309;
    --light-plate: #f8fafc;
    --border-slate: #cbd5e1;
}

.gateway-card-wrapper {
    background: linear-gradient(145deg, #ffffff, #f1f5f9);
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(30, 58, 138, 0.06);
    border: 1px solid var(--border-slate);
    padding: 24px;
    margin-bottom: 25px;
}

.gateway-brand-title {
    font-weight: 900;
    color: var(--diplomatic-blue);
    font-size: 1.45rem;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid var(--premium-gold);
    padding-bottom: 12px;
    margin-bottom: 22px;
}

.search-input-box {
    border: 2px solid var(--border-slate);
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
}
.search-input-box:focus {
    border-color: var(--diplomatic-blue);
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.15);
}

.btn-diplomatic-search {
    background: linear-gradient(135deg, var(--diplomatic-blue), var(--deep-slate));
    color: #fff !important;
    font-weight: 700;
    border-radius: 10px;
    padding: 14px;
    border: none;
    transition: all 0.3s;
}
.btn-diplomatic-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 58, 138, 0.25);
}

.pulse-loader-box {
    display: none;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
}
.diplomatic-spinner {
    width: 48px;
    height: 48px;
    border: 5px solid var(--light-plate);
    border-top-color: var(--diplomatic-blue);
    border-bottom-color: var(--premium-gold);
    border-radius: 50%;
    animation: spin-pulse 1s linear infinite;
}
@keyframes spin-pulse {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#bmet-premium-pdf {
    padding: 12px;
    background: #ffffff;
    border: 3px double var(--diplomatic-blue);
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
    font-family: 'Arial', sans-serif;
    line-height: 1.1;
}

#bmet-premium-pdf::before {
    content: "\f5b0";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: absolute;
    font-size: 240px;
    color: rgba(30, 58, 138, 0.018);
    top: 52%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    z-index: 0;
    pointer-events: none;
}

.report-header-grid {
    border-bottom: 2px solid var(--diplomatic-blue);
    padding-bottom: 6px;
    margin-bottom: 8px;
}

.official-verified-seal {
    border: 2px solid var(--emerald-govt);
    background: #f0fdf4;
    padding: 4px 6px;
    border-radius: 6px;
    display: inline-block;
    position: relative;
    box-shadow: inset 0 0 4px rgba(6, 95, 70, 0.1);
}
.official-verified-seal span {
    display: block;
    font-family: 'Impact', 'Arial Black', sans-serif;
    font-size: 8px;
    letter-spacing: 0.5px;
    color: var(--emerald-govt);
    line-height: 1;
}
.official-verified-seal .seal-bold {
    font-size: 11px;
    font-weight: 900;
    color: var(--premium-gold);
    border-top: 1px dashed var(--emerald-govt);
    margin-top: 2px;
    padding-top: 2px;
}

.section-bar-title {
    background: linear-gradient(90deg, #eff6ff, #ffffff);
    color: var(--diplomatic-blue);
    font-size: 9px;
    font-weight: 800;
    padding: 3px 6px;
    margin-top: 6px;
    margin-bottom: 3px;
    border-left: 3px solid var(--premium-gold);
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.matrix-dense-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
    box-sizing: border-box;
}
.matrix-dense-table th {
    background-color: #f8fafc;
    color: #475569;
    font-weight: 700;
    width: 22%;
    font-size: 9px;
    padding: 2.5px 4px !important;
    border: 1px solid #cbd5e1 !important;
    text-align: left;
}
.matrix-dense-table td {
    font-size: 9px;
    color: var(--deep-slate);
    padding: 2.5px 4px !important;
    border: 1px solid #cbd5e1 !important;
    width: 28%;
    background: #ffffff;
    font-weight: 500;
}
.full-row-td {
    width: 78% !important;
}

.candidate-avatar-frame {
    width: 76px;
    height: 92px;
    object-fit: cover;
    border: 1.5px solid var(--diplomatic-blue);
    border-radius: 3px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}
.whatsapp-float a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    background: #25D366;
    border-radius: 50%;
    color: white;
    font-size: 1.6rem;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    transition: all 0.3s;
    text-decoration: none;
}
.whatsapp-float a:hover {
    background: #1ebe57;
    transform: scale(1.08);
}

@media (max-width: 600px) {
    .gateway-card-wrapper { padding: 14px; }
    .gateway-brand-title { font-size: 1.1rem; }
    #bmet-premium-pdf .row { flex-direction: column; }
    .matrix-dense-table th, .matrix-dense-table td { font-size: 8px; padding: 2px !important; }
}
</style>
@endpush

@section('content')
<div class="container-fluid p-2">
    <div class="row justify-content-center m-0">
        <div class="col-12 col-md-11 col-lg-9 p-1">
            
            <!-- Search Card -->
            <div class="gateway-card-wrapper mt-1">
                <h4 class="gateway-brand-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#1e3a8a"/><path d="M2 17L12 22L22 17" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round"/><path d="M2 12L12 17L22 12" stroke="#b45309" stroke-width="2" stroke-linecap="round"/></svg>
                    BMET Verification Console
                </h4>
                
                <form id="diplomaticSearchForm">
                    @csrf
                    <div class="mb-3">
                        <label for="passportNo" class="form-label fw-bold text-dark small">পাসপোর্ট নম্বর টাইপ করুন</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-passport text-muted"></i></span>
                            <input type="text" class="form-control form-control-lg search-input-box" id="passportNo" name="passportNo" placeholder="পাসপোর্ট নম্বর প্রদান করুন" required style="text-transform: uppercase;">
                        </div>
                        <div class="form-text text-dark fw-bold small mt-2">
                            <i class="fa-solid fa-circle-exclamation text-danger me-1"></i> প্রতিটি অনুসন্ধানের জন্য ব্যালেন্স থেকে ২০০/- টাকা চার্জ কেটে নেওয়া হবে।
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-diplomatic-search btn-lg"><i class="fa-solid fa-fingerprint me-2"></i>ভেরিফাই রেকর্ড</button>
                    </div>
                </form>

                <div class="pulse-loader-box" id="searchLoader">
                    <div class="diplomatic-spinner"></div>
                    <p class="mt-3 fw-bold text-primary small">ইমিগ্রেশন ডাটাবেজ থেকে সিকিউর ডেটা পার্স করা হচ্ছে...</p>
                </div>
            </div>

            <!-- Result -->
            <div class="gateway-card-wrapper" id="resultContainer" style="display:none;">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="badge bg-success px-3 py-2 text-uppercase fw-bold"><i class="fa-solid fa-certificate me-1"></i> Cryptographic Verified</span>
                    <button class="btn btn-sm btn-dark fw-bold px-3" onclick="exportA4SinglePagePDF()" style="font-size:11px; border-radius:6px; background: var(--deep-slate);">
                        <i class="fa-solid fa-file-pdf me-1 text-warning"></i> ডাউনলোড করুন (A4 1-Page PDF)
                    </button>
                </div>

                <div id="bmet-premium-pdf">
                    
                    <div class="report-header-grid">
                        <div class="row align-items-center m-0">
                            <div class="col-2 p-0 text-start">
                                <svg width="45" height="45" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="46" fill="none" stroke="#1e3a8a" stroke-width="4"/>
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="#b45309" stroke-width="2" stroke-dasharray="5,3"/>
                                    <path d="M50 20 L25 40 L35 40 L35 70 L65 70 L65 40 L75 40 Z" fill="#065f46"/>
                                    <path d="M20 50 Q50 85 80 50" fill="none" stroke="#b45309" stroke-width="3"/>
                                    <circle cx="50" cy="50" r="8" fill="#1e3a8a"/>
                                </svg>
                            </div>
                            <div class="col-8 p-0 text-center">
                                <h5 style="color: var(--diplomatic-blue); font-weight:900; margin:0; font-size: 12.5px; letter-spacing: 0.3px;">BUREAU OF MANPOWER, EMPLOYMENT &amp; TRAINING</h5>
                                <p class="text-muted mb-0 fw-bold" style="font-size: 8.5px; color:#475569 !important;">GOVERNMENT OF THE PEOPLE'S REPUBLIC OF BANGLADESH</p>
                                <span style="font-size: 7.5px; background: var(--diplomatic-blue); color: #fff; padding: 1px 8px; border-radius: 3px; font-weight: bold; margin-top: 2px; display: inline-block;">IMMIGRATION CLEARANCE VERIFICATION LEDGER</span>
                            </div>
                            <div class="col-2 p-0 text-end">
                                <div class="official-verified-seal">
                                    <span>INTELLIGENCE</span>
                                    <span class="seal-bold"><i class="fa-solid fa-seal"></i> VERIFIED</span>
                                    <span style="font-size:6px; font-weight: bold; color: #475569; margin-top:1px;">SECURE NOD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center m-0 mb-2" style="position:relative; z-index:1;">
                        <div class="col-9 p-0">
                            <h5 class="fw-bold text-dark mb-1 text-uppercase" id="res_hdr_name" style="color: var(--diplomatic-blue) !important; font-size: 11px;">N/A</h5>
                            <p class="mb-0 small text-muted" style="font-size: 9px;"><strong>Passport Account:</strong> <span id="res_hdr_passport" class="text-dark fw-bold text-uppercase"></span> | <strong>Job Destination:</strong> <span id="res_hdr_country" class="text-dark fw-bold text-uppercase"></span></p>
                        </div>
                        <div class="col-3 p-0 text-end">
                            <img id="res_photo" src="{{ asset('assets/images/faces/face8.jpg') }}" class="candidate-avatar-frame" alt="Photo">
                        </div>
                    </div>

                    <div class="section-bar-title">1. Personal Demographics &amp; Identification Data</div>
                    <table class="matrix-dense-table">
                        <tr>
                            <th>Name</th>
                            <td id="res_name">N/A</td>
                            <th>Full Name</th>
                            <td id="res_fullName">N/A</td>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td id="res_fathersName">N/A</td>
                            <th>Mother's Name</th>
                            <td id="res_mothersName">N/A</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td id="res_dateofBirth" class="fw-bold">N/A</td>
                            <th>Age</th>
                            <td id="res_age">N/A</td>
                        </tr>
                        <tr>
                            <th>Gender (ID)</th>
                            <td><span id="res_gender">N/A</span> (<span id="res_genderId">N/A</span>)</td>
                            <th>Mobile Number</th>
                            <td id="res_mobile">N/A</td>
                        </tr>
                        <tr>
                            <th>NID / UID No</th>
                            <td id="res_nid" class="fw-bold">N/A</td>
                            <th>Religion (ID)</th>
                            <td><span id="res_religionName">N/A</span> (<span id="res_religionId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Marital Status (ID)</th>
                            <td><span id="res_maritalStatusId">N/A</span></td>
                            <th>Spouse Name</th>
                            <td id="res_spouseName">N/A</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td id="res_nationality" colspan="3" class="full-row-td">N/A</td>
                        </tr>
                    </table>

                    <div class="section-bar-title">2. Present Residential Address Mapping</div>
                    <table class="matrix-dense-table">
                        <tr>
                            <th>Division (ID)</th>
                            <td><span id="res_preDivision">N/A</span> (<span id="res_preDivisionId">N/A</span>)</td>
                            <th>District (ID)</th>
                            <td><span id="res_preDistrict">N/A</span> (<span id="res_preDistrictId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Thana (ID)</th>
                            <td><span id="res_preThana">N/A</span> (<span id="res_preThanaId">N/A</span>)</td>
                            <th>Post Office (ID)</th>
                            <td><span id="res_prePostOffice">N/A</span> (<span id="res_prePostOfficeId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Road &amp; House</th>
                            <td>Road: <span id="res_preRoad">N/A</span> / H: <span id="res_preHouse">N/A</span></td>
                            <th>Post Code / Ward</th>
                            <td>Code: <span id="res_prePostCode">N/A</span> / W: <span id="res_preWard">N/A</span></td>
                        </tr>
                        <tr>
                            <th>Mauza / Village</th>
                            <td>M: <span id="res_preMauza">N/A</span> / V: <span id="res_preVillage">N/A</span></td>
                            <th>Address Details</th>
                            <td id="res_preAddressDetails">N/A</td>
                        </tr>
                        <tr>
                            <th>Combined Address</th>
                            <td id="res_combinePreAddress" colspan="3" class="full-row-td text-muted" style="font-size:8.5px;">N/A</td>
                        </tr>
                    </table>

                    <div class="section-bar-title">3. Permanent Legal Address Mapping</div>
                    <table class="matrix-dense-table">
                        <tr>
                            <th>Division (ID)</th>
                            <td><span id="res_perDivision">N/A</span> (<span id="res_perDivisionId">N/A</span>)</td>
                            <th>District (ID)</th>
                            <td><span id="res_perDistrict">N/A</span> (<span id="res_perDistrictId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Thana (ID)</th>
                            <td><span id="res_perThana">N/A</span> (<span id="res_perThanaId">N/A</span>)</td>
                            <th>Post Office (ID)</th>
                            <td><span id="res_perPostOffice">N/A</span> (<span id="res_perPostOfficeId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Road &amp; House</th>
                            <td>Road: <span id="res_perRoad">N/A</span> / H: <span id="res_perHouse">N/A</span></td>
                            <th>Post Code / Ward</th>
                            <td>Code: <span id="res_perPostCode">N/A</span> / W: <span id="res_perWard">N/A</span></td>
                        </tr>
                        <tr>
                            <th>Mauza / Village</th>
                            <td>M: <span id="res_perMauza">N/A</span> / V: <span id="res_perVillage">N/A</span></td>
                            <th>Address Details</th>
                            <td id="res_perAddressDetails">N/A</td>
                        </tr>
                        <tr>
                            <th>Combined Address</th>
                            <td id="res_combinePerAddress" colspan="3" class="full-row-td text-muted" style="font-size:8.5px;">N/A</td>
                        </tr>
                    </table>

                    <div class="section-bar-title">4. Visa, Employment &amp; BMET Clearance Logs</div>
                    <table class="matrix-dense-table">
                        <tr>
                            <th>Passport Number</th>
                            <td id="res_passportNumber" class="fw-bold text-uppercase text-primary">N/A</td>
                            <th>BMET Number</th>
                            <td id="res_bmetNo" class="fw-bold text-success">N/A</td>
                        </tr>
                        <tr>
                            <th>Job Seeker Country</th>
                            <td><span id="res_jobSeekerCountry">N/A</span> (ID: <span id="res_jobSeekerCountryId">N/A</span>)</td>
                            <th>Job Category (ID)</th>
                            <td><span id="res_jobCategory">N/A</span> (ID: <span id="res_jobCategoryId">N/A</span>)</td>
                        </tr>
                        <tr>
                            <th>Visa Number</th>
                            <td id="res_visaNo" class="fw-bold">N/A</td>
                            <th>Visa Type</th>
                            <td id="res_visaType">N/A</td>
                        </tr>
                        <tr>
                            <th>Employer Name</th>
                            <td id="res_employerName">N/A</td>
                            <th>Clearance Type ID</th>
                            <td id="res_clearanceTypeId">N/A</td>
                        </tr>
                        <tr>
                            <th>Date of Issue</th>
                            <td id="res_dateOfIssue">N/A</td>
                            <th>Date of Expiry</th>
                            <td id="res_dateOfExpiry">N/A</td>
                        </tr>
                        <tr>
                            <th>Clearance Date</th>
                            <td id="res_clearanceDate">N/A</td>
                            <th>Data Source Cat.</th>
                            <td id="res_dataSourceCategory">N/A</td>
                        </tr>
                        <tr>
                            <th>Travel Records</th>
                            <td id="res_travels">N/A</td>
                            <th>Manual Application</th>
                            <td id="res_manualApplicationYn">N/A</td>
                        </tr>
                    </table>

                    <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center" style="font-size: 7.5px; color: #64748b; font-weight: 700; position:relative; z-index:1;">
                        <span>Verification Node Server: {{ request()->getHost() }}</span>
                        <span>Date Timestamp: {{ date('Y-m-d h:i:s A') }}</span>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="gateway-card-wrapper">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3" style="font-size:0.95rem;">
                    <i class="fa-solid fa-clock-rotate-left me-1 text-amber-600"></i> আপনার সাম্প্রতিক অনুসন্ধান হিস্ট্রি
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover text-center align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-dark" style="background: var(--deep-slate);">
                            <tr>
                                <th>পাসপোর্ট নং</th>
                                <th>ভিসা / ক্লিয়ারেন্স নং</th>
                                <th>তারিখ ও সময়</th>
                                <th>সার্ভিস চার্জ</th>
                            </tr>
                        </thead>
                        <tbody id="bmet_history_body">
                            @forelse($histories as $h)
                            <tr>
                                <td class="fw-bold text-dark">{{ $h->passport_no }}</td>
                                <td>{{ $h->bmet_no }}</td>
                                <td>{{ $h->created_at ? $h->created_at->format('d-m-Y h:i A') : '' }}</td>
                                <td><span class="badge bg-danger">-{{ number_format($h->charged_amount, 0) }} ৳</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-muted py-2">এখনো কোনো অনুসন্ধানের ইতিহাস পাওয়া যায়নি।</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- WhatsApp -->
<div class="whatsapp-float">
    <a href="https://chat.whatsapp.com/JgZVDDIwlHV3k86GxmPsHN" target="_blank" rel="noopener noreferrer" title="Join WhatsApp Group">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.getElementById('diplomaticSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const passportNo = document.getElementById('passportNo').value.trim();
    if(!passportNo) return;

    document.getElementById('resultContainer').style.display = 'none';
    document.getElementById('searchLoader').style.display = 'flex';

    const formData = new FormData();
    formData.append('passport', passportNo);
    formData.append('ajax', '1');

    const url = '{{ route("bmet.search.submit") }}?ajax=1';
    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        document.getElementById('searchLoader').style.display = 'none';
        
        if(res.success && res.data) {
            const d = res.data;
            
            const resolvedName = d.fullName || d.name || 'N/A';
            document.getElementById('res_hdr_name').innerText = resolvedName;
            document.getElementById('res_hdr_passport').innerText = d.passportNumber || passportNo;
            document.getElementById('res_hdr_country').innerText = d.jobSeekerCountry || 'N/A';
            
            const keys = [
                'name', 'fullName', 'fathersName', 'mothersName', 'dateofBirth', 'age', 'genderId', 'gender', 'mobile', 'nid', 'religionId', 'religionName', 'maritalStatusId', 'spouseName', 'nationality',
                'preDivisionId', 'preDivision', 'preDistrictId', 'preDistrict', 'preThanaId', 'preThana', 'preRoad', 'preHouse', 'prePostOfficeId', 'prePostOffice', 'prePostCode', 'preMauza', 'preWard', 'preVillage', 'preAddressDetails', 'preAddress', 'combinePreAddress',
                'perDivisionId', 'perDivision', 'perDistrictId', 'perDistrict', 'perThanaId', 'perThana', 'perHouse', 'perRoad', 'perPostOfficeId', 'perPostOffice', 'perPostCode', 'perMauza', 'perWard', 'perVillage', 'perAddressDetails', 'perAddress', 'combinePerAddress',
                'jobSeekerCountryId', 'jobSeekerCountry', 'jobCategoryId', 'jobCategory', 'visaType', 'passportNumber', 'clearanceTypeId', 'bmetNo', 'clearanceDate', 'dataSourceCategory', 'employerName', 'visaNo', 'dateOfIssue', 'dateOfExpiry', 'travels', 'manualApplicationYn'
            ];

            keys.forEach(key => {
                const el = document.getElementById('res_' + key);
                if(el) {
                    el.innerText = (d[key] !== null && d[key] !== undefined && d[key] !== '') ? d[key] : 'N/A';
                }
            });

            if (d.photo && d.photo.length > 50) {
                document.getElementById('res_photo').src = d.photo.startsWith('data:') ? d.photo : 'data:image/jpeg;base64,' + d.photo;
            } else {
                document.getElementById('res_photo').src = '{{ asset("assets/images/faces/face8.jpg") }}';
            }

            if (res.histories) {
                updateBmetHistory(res.histories);
            }

            let liveBalEl = document.getElementById('live-balance');
            if (res.new_balance && liveBalEl) {
                liveBalEl.innerText = parseFloat(res.new_balance).toFixed(2);
            }

            document.getElementById('resultContainer').style.display = 'block';
            document.getElementById('resultContainer').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert(res.message || 'ডাটা পাওয়া যায়নি।');
        }
    })
    .catch(err => {
        document.getElementById('searchLoader').style.display = 'none';
        alert("সার্ভার কানেকশন এরর অথবা ডেটা পার্সিং সমস্যা! অনুগ্রহ করে আবার চেষ্টা করুন।");
        console.error(err);
    });
});

function updateBmetHistory(histories) {
    const tbody = document.getElementById('bmet_history_body');
    if (!histories || histories.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-muted py-2">এখনো কোনো অনুসন্ধানের ইতিহাস পাওয়া যায়নি।</td></tr>';
        return;
    }
    let html = '';
    histories.forEach(function(h) {
        let dateStr = '';
        if (h.created_at) {
            try {
                let d = new Date(h.created_at);
                dateStr = ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + d.getFullYear() + ' ' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);
            } catch(e) { dateStr = h.created_at; }
        }
        html += '<tr>' +
            '<td class="fw-bold text-dark">' + (h.passport_no || '') + '</td>' +
            '<td>' + (h.bmet_no || '') + '</td>' +
            '<td>' + dateStr + '</td>' +
            '<td><span class="badge bg-danger">-' + (h.charged_amount || '0') + ' ৳</span></td>' +
            '</tr>';
    });
    tbody.innerHTML = html;
}

function exportA4SinglePagePDF() {
    const element = document.getElementById('bmet-premium-pdf');
    const passportVal = document.getElementById('res_passportNumber').innerText || 'Verification_Report';
    
    const opt = {
        margin:       [4, 4, 4, 4],
        filename:     'BMET_Clearance_Report_' + passportVal + '.pdf',
        image:        { type: 'jpeg', quality: 0.99 },
        html2canvas:  { scale: 2.3, useCORS: true, logging: false, letterRendering: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().set(opt).from(element).save();
}
</script>
@endpush
