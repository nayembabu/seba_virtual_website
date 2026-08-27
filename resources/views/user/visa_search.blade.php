@extends('user.layouts.app')

@section('title') ভিসা ইনফো @endsection

@push('style')
<link href="https://fonts.cdnfonts.com/css/santeria-signature" rel="stylesheet">
<style>
* {
    box-sizing: border-box;
}

body {
    background: #0a1628 !important;
    font-family: 'Segoe UI', 'Arial', sans-serif;
}

.visa-main-wrapper {
    max-width: 820px;
    margin: 0 auto;
    padding: 20px 0;
}

.visa-card {
    background: linear-gradient(145deg, #0f1d35 0%, #1a2744 100%);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    padding: 28px 28px 24px;
    margin-bottom: 28px;
    backdrop-filter: blur(4px);
}

.visa-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 14px;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 8px;
}

.visa-card-header h4 {
    margin: 0;
    font-weight: 700;
    color: #f59e0b;
    font-size: 1.3rem;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.visa-card-header h4 i {
    font-size: 1.5rem;
    color: #f59e0b;
}

.balance-label {
    background: rgba(255, 255, 255, 0.06);
    padding: 6px 16px;
    border-radius: 50px;
    color: #94a3b8;
    font-weight: 600;
    font-size: 0.85rem;
    border: 1px solid rgba(255, 255, 255, 0.06);
}

.balance-label span {
    color: #facc15;
    font-weight: 700;
    font-size: 1rem;
}

.visa-form-group {
    margin-bottom: 18px;
}

.visa-form-group label {
    display: block;
    color: #cbd5e1;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 6px;
}

.visa-input-wrapper {
    position: relative;
}

.visa-input-wrapper .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 1.1rem;
    z-index: 2;
}

.visa-input-wrapper input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1.5px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 13px 14px 13px 44px;
    color: #f1f5f9;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.25s ease;
    text-transform: uppercase;
}

.visa-input-wrapper input:focus {
    outline: none;
    border-color: #f59e0b;
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
}

.visa-input-wrapper input::placeholder {
    color: #475569;
    font-weight: 400;
    letter-spacing: 0;
}

.visa-charge-note {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #f59e0b;
    font-weight: 600;
    font-size: 0.82rem;
    margin-top: 8px;
    background: rgba(245, 158, 11, 0.08);
    padding: 8px 14px;
    border-radius: 8px;
    border-left: 3px solid #f59e0b;
}

.btn-visa-search {
    width: 100%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    color: #0f1d35;
    font-weight: 700;
    font-size: 1.05rem;
    padding: 14px 20px;
    border-radius: 12px;
    transition: all 0.25s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-visa-search:hover {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    transform: translateY(-1px);
}

.btn-visa-search:active {
    transform: translateY(0);
}

/* Loader */
.visa-loader {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px 0 10px;
}

.visa-loader .spinner {
    width: 48px;
    height: 48px;
    border: 4px solid rgba(255, 255, 255, 0.05);
    border-top: 4px solid #f59e0b;
    border-radius: 50%;
    animation: visa-spin 0.9s linear infinite;
}

@keyframes visa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.visa-loader p {
    margin-top: 14px;
    color: #f59e0b;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Result Container */
.visa-result-box {
    display: none;
    margin-top: 25px;
}

/* A4 Report Paper */
.a4-report {
    background: #ffffff;
    border-radius: 14px;
    padding: 35px 32px 28px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
}

.a4-report::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #1e3a8a, #f59e0b, #1e3a8a);
}

.a4-report-watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-35deg);
    font-size: 200px;
    color: rgba(30, 58, 138, 0.025);
    font-weight: 900;
    pointer-events: none;
    z-index: 0;
    font-family: 'Segoe UI', sans-serif;
}

.report-toolbar {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-bottom: 16px;
}

.report-toolbar button {
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1.5px solid #cbd5e1;
    background: white;
    color: #334155;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.report-toolbar button:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
}

.report-toolbar .btn-pdf {
    border-color: #dc2626;
    color: #dc2626;
}

.report-toolbar .btn-pdf:hover {
    background: #dc2626;
    color: white;
}

/* Report Header */
.report-header {
    text-align: center;
    border-bottom: 3px double #1e3a8a;
    padding-bottom: 14px;
    margin-bottom: 22px;
    position: relative;
    z-index: 1;
}

.report-header .govt-icon {
    font-size: 2.5rem;
    color: #1e3a8a;
    margin-bottom: 4px;
    display: inline-block;
    transform: rotate(45deg);
}

.report-header h2 {
    color: #1e3a8a;
    font-weight: 800;
    font-size: 1.35rem;
    letter-spacing: 0.5px;
    margin: 2px 0 0;
}

.report-header .sub {
    color: #64748b;
    font-weight: 700;
    font-size: 0.7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin: 0;
}

/* Profile Row */
.profile-row {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.profile-row .info {
    flex: 1;
}

.profile-row .info .candidate-name {
    font-weight: 800;
    color: #1e3a8a;
    font-size: 1.2rem;
    text-transform: uppercase;
    margin-bottom: 2px;
}

.profile-row .info .candidate-label {
    color: #64748b;
    font-weight: 600;
    font-size: 0.8rem;
    margin-bottom: 6px;
}

.profile-row .info .meta-item {
    color: #475569;
    font-size: 0.85rem;
    margin-bottom: 1px;
}

.profile-row .info .meta-item strong {
    color: #0f172a;
}

.profile-row .photo-col {
    flex-shrink: 0;
    text-align: right;
}

.profile-row .photo-col img {
    width: 110px;
    height: 135px;
    object-fit: cover;
    border: 3px solid #1e3a8a;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* Info Table */
.visa-info-table {
    width: 100%;
    border-collapse: collapse;
    position: relative;
    z-index: 1;
}

.visa-info-table th,
.visa-info-table td {
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    font-size: 0.88rem;
    vertical-align: middle;
}

.visa-info-table th {
    background: #f1f5f9;
    color: #1e293b;
    font-weight: 700;
    width: 32%;
}

.visa-info-table td {
    color: #0f172a;
    background: white;
}

.visa-info-table .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    padding: 5px 14px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.75rem;
    letter-spacing: 0.3px;
}

/* Signature */
.report-signature {
    margin-top: 22px;
    padding-top: 16px;
    border-top: 2px dashed #cbd5e1;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    position: relative;
    z-index: 1;
}

.report-signature .signature-text {
    font-family: 'Santeria Signature', cursive;
    font-size: 28px;
    color: #1e3a8a;
    transform: rotate(-2deg);
    display: inline-block;
    line-height: 1;
}

.report-signature .signature-label {
    display: block;
    font-family: 'Segoe UI', sans-serif;
    font-size: 0.65rem;
    font-weight: 600;
    color: #94a3b8;
    letter-spacing: 0.5px;
    border-top: 1px solid #e2e8f0;
    padding-top: 3px;
    margin-top: 2px;
}

.report-footer-bar {
    margin-top: 20px;
    padding-top: 14px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    font-size: 0.68rem;
    color: #64748b;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

/* History */
.visa-history-card {
    background: linear-gradient(145deg, #0f1d35 0%, #1a2744 100%);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    padding: 24px 28px;
    margin-bottom: 28px;
}

.visa-history-card h5 {
    color: #f59e0b;
    font-weight: 700;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 12px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.05rem;
}

.visa-history-card .table {
    color: #e2e8f0;
    font-size: 0.85rem;
    margin-bottom: 0;
}

.visa-history-card .table thead th {
    border-color: rgba(255, 255, 255, 0.08);
    color: #f59e0b;
    font-weight: 700;
    background: rgba(245, 158, 11, 0.06);
    border-bottom: 2px solid rgba(245, 158, 11, 0.15);
}

.visa-history-card .table tbody td {
    border-color: rgba(255, 255, 255, 0.05);
    vertical-align: middle;
}

.visa-history-card .table tbody tr:hover {
    background: rgba(255, 255, 255, 0.03);
}

/* WhatsApp */
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
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
}

/* Responsive */
@media (max-width: 600px) {
    .visa-card, .visa-history-card {
        padding: 18px 14px;
    }
    .a4-report {
        padding: 20px 14px;
    }
    .profile-row {
        flex-direction: column;
        text-align: center;
    }
    .profile-row .photo-col {
        text-align: center;
        margin-top: 10px;
    }
    .visa-info-table th {
        width: 40%;
    }
    .report-signature {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .visa-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endpush

@section('content')
<div class="visa-main-wrapper">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Search Card -->
            <div class="visa-card">
                <div class="visa-card-header">
                    <h4><i class="fa-solid fa-plane-departure"></i> এয়ারপোর্ট ইমিগ্রেশন ও ভিসা যাচাই</h4>
                    <div class="balance-label">
                        <i class="fa-regular fa-wallet me-1"></i> ব্যালেন্স: <span id="live-balance">{{ number_format(auth()->user()->balance ?? 0, 2) }}</span> ৳
                    </div>
                </div>

                <form id="visaFormSubmit">
                    @csrf
                    <div class="visa-form-group">
                        <label for="passportNo"><i class="fa-regular fa-passport me-1"></i> পাসপোর্ট নম্বরটি টাইপ করুন</label>
                        <div class="visa-input-wrapper">
                            <i class="fa-regular fa-passport input-icon"></i>
                            <input type="text" id="passportNo" name="passportNo" placeholder="যেমন: A01234567" required autocomplete="off">
                        </div>
                        <div class="visa-charge-note">
                            <i class="fa-solid fa-circle-info"></i> প্রতিটি রিপোর্টের জন্য অটোমেটিক ১০০/- টাকা চার্জ কাটা হবে।
                        </div>
                    </div>

                    <button type="submit" class="btn-visa-search">
                        <i class="fa-solid fa-magnifying-glass"></i> অনুসন্ধান করুন
                    </button>
                </form>

                <div class="visa-loader" id="searchLoader">
                    <div class="spinner"></div>
                    <p><i class="fa-regular fa-hourglass-half me-1"></i> ইমিগ্রেশন সার্ভার থেকে তথ্য ডাউনলোড হচ্ছে, অপেক্ষা করুন...</p>
                </div>
            </div>

            <!-- Result Card -->
            <div class="visa-result-box" id="resultContainer">
                <div id="printable-report" class="a4-report">
                    <div class="a4-report-watermark">&#x2708;</div>

                    <div class="report-toolbar">
                        <button onclick="copyVisaData()"><i class="fa-regular fa-copy"></i> কপি</button>
                        <button class="btn-pdf" onclick="downloadPDFReport()"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                    </div>

                    <div class="report-header">
                        <div class="govt-icon"><i class="fa-solid fa-plane-up"></i></div>
                        <h2>GOVERNMENT IMMIGRATION &amp; VISA REPORT</h2>
                        <p class="sub">Official Smart Verification System</p>
                    </div>

                    <div class="profile-row">
                        <div class="info">
                            <div class="candidate-name" id="res_fullname_top">N/A</div>
                            <div class="candidate-label">Candidate Profile</div>
                            <div class="meta-item"><strong>Passport No:</strong> <span id="res_passport"></span></div>
                            <div class="meta-item"><strong>Destination:</strong> <span id="res_country" class="text-uppercase"></span></div>
                        </div>
                        <div class="photo-col">
                            <img id="res_photo" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Photo">
                        </div>
                    </div>

                    <table class="visa-info-table">
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td id="res_fullname" class="fw-bold text-uppercase">N/A</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td id="res_dob" class="fw-bold">N/A</td>
                            </tr>
                            <tr>
                                <th>BMET Reg Number</th>
                                <td id="res_bmet" class="fw-bold text-primary">N/A</td>
                            </tr>
                            <tr>
                                <th>Visa Number</th>
                                <td id="res_visa" class="fw-bold text-success">N/A</td>
                            </tr>
                            <tr>
                                <th>Clearance Date</th>
                                <td id="res_clearance_date">N/A</td>
                            </tr>
                            <tr>
                                <th>Employer / Sponsor</th>
                                <td id="res_employer" class="text-uppercase">N/A</td>
                            </tr>
                            <tr>
                                <th>Date of Issue</th>
                                <td id="res_issue_date">N/A</td>
                            </tr>
                            <tr>
                                <th>Date of Expiry</th>
                                <td id="res_expiry_date">N/A</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="status-badge"><i class="fa-solid fa-circle-check"></i> VERIFIED ON CLEARANCE</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="report-signature">
                        <div>
                            <span class="signature-text">BD Service 24</span>
                            <span class="signature-label">Authorized Signature</span>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:0.75rem; font-weight:600; color:#334155;">(দেওয়া তথ্য ইমিগ্রেশন কর্তৃপক্ষের দ্বারা নিশ্চিত)</div>
                        </div>
                    </div>

                    <div class="report-footer-bar">
                        <span>Gateway Domain: {{ request()->getHost() }}</span>
                        <span>Generated On: {{ date('Y-m-d h:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="visa-history-card">
                <h5><i class="fa-solid fa-history"></i> আপনার সাম্প্রতিক অনুসন্ধান লগ</h5>
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>পাসপোর্ট নং</th>
                                <th>ভিসা নং</th>
                                <th>অনুসন্ধানের সময়</th>
                                <th>সার্ভিস চার্জ</th>
                            </tr>
                        </thead>
                        <tbody id="history_table_body">
                            @forelse($histories as $h)
                            <tr>
                                <td class="fw-bold" style="color:#f59e0b;">{{ $h->passport_no }}</td>
                                <td>{{ $h->visa_no }}</td>
                                <td>{{ $h->created_at ? $h->created_at->format('d M Y, h:i A') : '' }}</td>
                                <td><span class="badge bg-danger">-{{ number_format($h->charged_amount, 0) }} ৳</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="color:#64748b; padding:20px;">এখনো কোনো অনুসন্ধানের ইতিহাস নেই।</td></tr>
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
let globalVisaDataString = "";

document.getElementById('visaFormSubmit').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const passportNo = document.getElementById('passportNo').value.trim();
    if(!passportNo) return;

    document.getElementById('resultContainer').style.display = 'none';
    document.getElementById('searchLoader').style.display = 'flex';

    const formData = new FormData();
    formData.append('passport', passportNo);
    formData.append('ajax', '1');

    const url = '{{ route("visa.search") }}?ajax=1';
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
            
            globalVisaDataString = `--- OFFICIAL IMMIGRATION REPORT ---\nName: ${d.name || 'N/A'}\nDate of Birth: ${d.DateofBirth || 'N/A'}\nPassport No: ${d.passportNumber || 'N/A'}\nCountry: ${d.jobSeekerCountry || 'N/A'}\nBMET No: ${d.bmetNo || 'N/A'}\nVisa No: ${d.visaNo || 'N/A'}\nEmployer: ${d.employerName || 'N/A'}`;

            document.getElementById('res_fullname_top').innerText = d.name || 'NOT PROVIDED';
            document.getElementById('res_fullname').innerText = d.name || 'N/A';
            document.getElementById('res_dob').innerText = d.DateofBirth || 'N/A';
            document.getElementById('res_passport').innerText = d.passportNumber || 'N/A';
            document.getElementById('res_country').innerText = d.jobSeekerCountry || 'N/A';
            document.getElementById('res_bmet').innerText = d.bmetNo || 'N/A';
            document.getElementById('res_visa').innerText = d.visaNo || 'N/A';
            document.getElementById('res_clearance_date').innerText = d.clearanceDate || 'N/A';
            document.getElementById('res_employer').innerText = d.employerName || 'N/A';
            document.getElementById('res_issue_date').innerText = d.dateOfIssue || 'N/A';
            document.getElementById('res_expiry_date').innerText = d.dateOfExpiry || 'N/A';
            
            if (d.photo && d.photo.length > 50) {
                document.getElementById('res_photo').src = d.photo.startsWith('data:') ? d.photo : 'data:image/jpeg;base64,' + d.photo;
            } else {
                document.getElementById('res_photo').src = '{{ asset("assets/images/faces/face8.jpg") }}';
            }

            if (res.histories) {
                updateHistoryTable(res.histories);
            }

            let liveBal = document.getElementById('live-balance');
            if (res.new_balance && liveBal) {
                liveBal.innerText = parseFloat(res.new_balance).toFixed(2);
            }

            document.getElementById('resultContainer').style.display = 'block';
            document.getElementById('resultContainer').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert(res.message || 'ডাটা পাওয়া যায়নি।');
        }
    })
    .catch(err => {
        document.getElementById('searchLoader').style.display = 'none';
        alert("সার্ভার রেসপন্স ত্রুটি! অনুগ্রহ করে আবার চেষ্টা করুন।");
        console.error(err);
    });
});

function updateHistoryTable(histories) {
    const tbody = document.getElementById('history_table_body');
    if (!histories || histories.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="color:#64748b; padding:20px;">এখনো কোনো অনুসন্ধানের ইতিহাস নেই।</td></tr>';
        return;
    }
    let html = '';
    histories.forEach(function(h) {
        let dateStr = '';
        if (h.created_at) {
            try {
                let d = new Date(h.created_at);
                const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                dateStr = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + ', ' +
                    ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);
            } catch(e) { dateStr = h.created_at; }
        }
        html += '<tr>' +
            '<td class="fw-bold" style="color:#f59e0b;">' + (h.passport_no || '') + '</td>' +
            '<td>' + (h.visa_no || '') + '</td>' +
            '<td>' + dateStr + '</td>' +
            '<td><span class="badge bg-danger">-' + (h.charged_amount || '0') + ' ৳</span></td>' +
            '</tr>';
    });
    tbody.innerHTML = html;
}

function copyVisaData() {
    if(!globalVisaDataString) return;
    navigator.clipboard.writeText(globalVisaDataString).then(() => {
        alert("ভিসা ও প্রার্থীর সমস্ত তথ্য কপি করা হয়েছে!");
    }).catch(() => {
        prompt("কপি করতে নিচের টেক্সট সিলেক্ট করে কপি করুন:", globalVisaDataString);
    });
}

function downloadPDFReport() {
    const element = document.getElementById('printable-report');
    const passportVal = document.getElementById('res_passport').innerText || 'Verification';
    
    const opt = {
        margin:       [10, 10, 10, 10],
        filename:     'Immigration_Report_' + passportVal + '.pdf',
        image:        { type: 'jpeg', quality: 0.99 },
        html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().set(opt).from(element).save();
}
</script>
@endpush
