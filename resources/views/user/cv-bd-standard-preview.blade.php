<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BD Standard CV - {{ $name ?? 'Your Name' }}</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&family=Noto+Serif:wght@400;700&family=Merriweather:wght@300;400;700&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
<style>
:root { --cv-theme: #0f172a; --cv-font: 'Roboto', sans-serif; --txt-dark: #0f172a; --txt-main: #334155; --photo-zoom: 1; --photo-x: 0px; --photo-y: 0px; }
body { background: #cbd5e1; margin: 0; padding-bottom: 50px; }
#controlPanel { background: #fff; padding: 15px 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; gap: 15px; position: sticky; top: 0; z-index: 9999; border-bottom: 4px solid var(--cv-theme); align-items: center; justify-content: space-between; }
.form-select { padding: 8px 12px; border-radius: 5px; border: 1px solid #cbd5e1; outline: none; font-weight: bold; cursor: pointer; }
.color-picker { border: none; width: 35px; height: 35px; padding: 0; border-radius: 50%; cursor: pointer; }
.btn-action { color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
.btn-action:hover { opacity: 0.9; }
#cvWrapper { width: 100%; display: flex; justify-content: center; padding: 40px 0; }
.a4-page { width: 210mm; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.15); font-family: var(--cv-font); margin: 0 auto; padding: 15mm 20mm; box-sizing: border-box; color: var(--txt-main); position: relative; }
.page-mode-natural { min-height: 297mm; height: auto; overflow: visible; }
.page-mode-force1 { height: 297mm; max-height: 297mm; overflow: hidden; }
.pdf-rendering { box-shadow: none !important; padding: 0 !important; width: 170mm !important; background: #fff !important; }
@page { size: A4 portrait; margin: 12mm 15mm; }
@media print { body { background: #fff !important; margin: 0 !important; padding: 0 !important; } .no-print { display: none !important; } #cvWrapper { padding: 0 !important; display: block !important; } .a4-page { box-shadow: none !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background: #fff !important; } }
.header-table { width: 100%; margin-bottom: 20px; }
.header-table td { vertical-align: middle; }
.cv-name { font-size: 26px; font-weight: bold; margin: 0 0 5px 0; text-transform: uppercase; color: var(--txt-dark); }
.cv-title { font-size: 16px; margin: 0 0 10px 0; font-weight: 600; color: var(--cv-theme); }
.contact-info { font-size: 13.5px; line-height: 1.6; }
.contact-info i { width: 18px; color: var(--cv-theme); text-align: center; }
.photo-container { width: 105px; height: 125px; overflow: hidden; border: 1px solid #cbd5e1; padding: 2px; background: #fff; border-radius: 4px; display: inline-block; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.photo-img { width: 100%; height: 100%; object-fit: cover; transform: scale(var(--photo-zoom)) translate(var(--photo-x), var(--photo-y)); transform-origin: center; transition: transform 0.1s ease-out; }
.section-box { margin-bottom: 20px; }
.sec-title { font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 0 0 12px 0; padding: 6px 10px; }
.text-content { font-size: 13.5px; text-align: justify; line-height: 1.6; }
.cv-table { width: 100%; border-collapse: collapse; font-size: 13.5px; margin-bottom: 10px; }
.cv-table th, .cv-table td { padding: 6px 8px; text-align: left; vertical-align: middle; border: 1px solid #94a3b8; }
.cv-table th { font-weight: bold; }
.bio-table { border: none; }
.bio-table td { border: none; padding: 4px 0; }
.bio-table td:first-child { width: 35%; font-weight: bold; }
.pill { display: inline-block; padding: 4px 12px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 12.5px; margin: 0 5px 8px 0; font-weight: 500; color: #334155; }
.bd-tpl-1 .header-table { border-bottom: 2px solid var(--cv-theme); padding-bottom: 10px; }
.bd-tpl-1 .cv-name { color: var(--cv-theme); text-align: center; }
.bd-tpl-1 .cv-title { text-align: center; color: #475569; }
.bd-tpl-1 .contact-info { text-align: center; display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; margin-top: 10px; }
.bd-tpl-1 .photo-td { display: none; }
.bd-tpl-1 .sec-title { background: #e2e8f0; color: #0f172a; border: 1px solid #cbd5e1; text-align: center; }
.bd-tpl-1 .cv-table th { background: #f1f5f9; color: #0f172a; border: 1px solid #000; }
.bd-tpl-1 .cv-table td { border: 1px solid #000; }
.bd-tpl-2 .header-table { border-bottom: 3px solid var(--cv-theme); padding-bottom: 15px; }
.bd-tpl-2 .cv-name { color: var(--cv-theme); }
.bd-tpl-2 .sec-title { background: transparent; color: var(--cv-theme); border-bottom: 2px solid var(--cv-theme); padding-left: 0; }
.bd-tpl-2 .cv-table th { background: var(--cv-theme); color: #fff; border: 1px solid var(--cv-theme); }
.bd-tpl-2 .cv-table td { border: 1px solid #cbd5e1; }
.bd-tpl-2 .bio-table td { border-bottom: 1px dashed #cbd5e1; }
.bd-tpl-3 .cv-name { color: var(--txt-dark); }
.bd-tpl-3 .sec-title { background: #f8fafc; color: var(--cv-theme); border-left: 5px solid var(--cv-theme); }
.bd-tpl-3 .cv-table th { background: #f1f5f9; color: var(--cv-theme); }
.bd-tpl-3 .bio-table td:first-child { color: var(--cv-theme); }
.bd-tpl-4 .header-table { border-bottom: 1px solid #ccc; }
.bd-tpl-4 .cv-name { font-weight: normal; letter-spacing: 2px; }
.bd-tpl-4 .sec-title { background: transparent; color: var(--txt-dark); border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: center; }
.bd-tpl-4 .cv-table th { background: transparent; color: #000; border-top: 2px solid #000; border-bottom: 2px solid #000; border-left: none; border-right: none; }
.bd-tpl-4 .cv-table td { border-left: none; border-right: none; border-bottom: 1px solid #e2e8f0; border-top: none; }
.bd-tpl-5 .header-table { background: var(--cv-theme); color: #fff; padding: 20px; border-radius: 8px; }
.bd-tpl-5 .cv-name, .bd-tpl-5 .cv-title, .bd-tpl-5 .contact-info, .bd-tpl-5 .contact-info i { color: #fff; }
.bd-tpl-5 .sec-title { color: var(--cv-theme); background: transparent; border-bottom: 2px dashed var(--cv-theme); padding-left: 0; }
.bd-tpl-5 .cv-table th { background: var(--cv-theme); color: #fff; border: 1px solid var(--cv-theme); }
.bd-tpl-5 .cv-table td { border: 1px solid var(--cv-theme); }
.bd-tpl-5 .bio-table td { border-bottom: 1px solid #f1f5f9; }
@media print { .page-mode-force1 { height: 257mm !important; max-height: 257mm !important; overflow: hidden !important; page-break-inside: avoid !important; } .page-mode-natural { min-height: 0 !important; height: auto !important; overflow: visible !important; } .sec-title, .cv-table th, .bio-table td:first-child { -webkit-print-color-adjust: exact; print-color-adjust: exact; } .section-box, tr, .header-table, .signature-block { page-break-inside: avoid !important; break-inside: avoid !important; } }
</style>
</head>
<body>
<div id="controlPanel" class="no-print">
    <div>
        <span class="fw-bold me-2">BD Design:</span>
        <select class="form-select" onchange="changeTemplate(this.value)">
            <option value="bd-tpl-2">1. Modern Corporate (Solid Borders)</option>
            <option value="bd-tpl-3">2. Elegant Shaded (Left Highlight)</option>
            <option value="bd-tpl-4">3. Executive Clean (Minimalist)</option>
            <option value="bd-tpl-1">4. Classic Standard (Centered)</option>
            <option value="bd-tpl-5">5. Colored Block (Highlighted)</option>
        </select>
    </div>
    <div>
        <span class="fw-bold me-2">Page:</span>
        <select class="form-select" id="pageModeSelector" onchange="changePageMode(this.value)" style="border-color:#f59e0b;">
            <option value="page-mode-natural">Normal (Multi-page)</option>
            <option value="page-mode-force1">Force 1 Page</option>
        </select>
    </div>
    <div>
        <span class="fw-bold me-2">Font:</span>
        <select class="form-select" onchange="document.documentElement.style.setProperty('--cv-font', this.value);">
            <option value="'Roboto', sans-serif">Roboto</option>
            <option value="'Times New Roman', serif">Times New Roman</option>
            <option value="'Open Sans', sans-serif">Open Sans</option>
            <option value="'Lato', sans-serif">Lato</option>
            <option value="'Montserrat', sans-serif">Montserrat</option>
            <option value="'Poppins', sans-serif">Poppins</option>
            <option value="'Noto Serif', serif">Noto Serif</option>
            <option value="'Lora', serif">Lora</option>
            <option value="'Oswald', sans-serif">Oswald</option>
            <option value="'Playfair Display', serif">Playfair Display</option>
        </select>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="fw-bold">Theme:</span>
        <input type="color" class="color-picker" value="#0f172a" onchange="document.documentElement.style.setProperty('--cv-theme', this.value);">
    </div>
    <div class="d-flex align-items-center gap-2" style="border-left:2px solid #cbd5e1;padding-left:15px;">
        <span class="fw-bold"><i class="fas fa-image text-primary me-1"></i> Photo:</span>
        <div class="btn-group btn-group-sm">
            <button onclick="adjustPhoto('zoom',0.1)" class="btn btn-outline-secondary" style="padding:4px 8px;">Z+</button>
            <button onclick="adjustPhoto('zoom',-0.1)" class="btn btn-outline-secondary" style="padding:4px 8px;">Z-</button>
            <button onclick="adjustPhoto('moveX',-5)" class="btn btn-outline-secondary" style="padding:4px 8px;">&larr;</button>
            <button onclick="adjustPhoto('moveX',5)" class="btn btn-outline-secondary" style="padding:4px 8px;">&rarr;</button>
            <button onclick="adjustPhoto('moveY',-5)" class="btn btn-outline-secondary" style="padding:4px 8px;">&uarr;</button>
            <button onclick="adjustPhoto('moveY',5)" class="btn btn-outline-secondary" style="padding:4px 8px;">&darr;</button>
        </div>
    </div>
    <div style="display:flex;gap:8px;">
        <button onclick="window.print()" class="btn-action" style="background:#0284c7;"><i class="fas fa-print"></i> Print</button>
        <button onclick="downloadPDF()" class="btn-action" style="background:var(--cv-theme);"><i class="fas fa-file-pdf"></i> PDF</button>
@isset($id)
        <a href="{{ route('user.cv-maker.edit', $id) }}" class="btn-action" style="background:#f59e0b;"><i class="fas fa-edit"></i> Edit</a>
@else
        <a href="{{ route('user.cv-maker.index') }}" class="btn-action" style="background:#f59e0b;"><i class="fas fa-edit"></i> Edit</a>
@endisset
    </div>
</div>
<div id="cvWrapper">
    <div id="cvDocument" class="a4-page bd-tpl-2 page-mode-natural">
        <table class="header-table">
            <tbody><tr>
                <td style="width:70%;">
                    <h1 class="cv-name">{{ $name ?? 'Your Name' }}</h1>
                    <h2 class="cv-title">{{ $title ?? 'Professional Title' }}</h2>
                    <div class="contact-info">
                        @if(!empty($address))<div><i class="fas fa-map-marker-alt"></i> {{ $address }}</div>@endif
                        @if(!empty($phone))<div><i class="fas fa-phone"></i> {{ $phone }}</div>@endif
                        @if(!empty($email))<div><i class="fas fa-envelope"></i> {{ $email }}</div>@endif
                    </div>
                </td>
                <td style="width:30%;text-align:right;" class="photo-td">
                    @if(!empty($photo_path))
                    <div class="photo-container">
                        <img src="{{ $photo_path }}" alt="Photo" class="photo-img" id="cvPhoto">
                    </div>
                    @endif
                </td>
            </tr>
        </tbody></table>
        @if(!empty($objective))
        <div class="section-box">
            <div class="sec-title">Career Objective</div>
            <div class="text-content">{{ $objective }}</div>
        </div>
        @endif
        <div class="section-box">
            <div class="sec-title">Educational Qualification</div>
            <table class="cv-table">
                <thead><tr><th>Exam/Degree</th><th>Institute</th><th>Board/University</th><th>Group/Subject</th><th>Year</th><th>CGPA/Result</th></tr></thead>
                <tbody>
                    @forelse($education ?? [] as $edu)
                    <tr>
                        <td>{{ $edu['degree'] ?? '' }}</td>
                        <td>{{ $edu['institute'] ?? '' }}</td>
                        <td>{{ $edu['board'] ?? '' }}</td>
                        <td>{{ $edu['group'] ?? '' }}</td>
                        <td>{{ $edu['year'] ?? '' }}</td>
                        <td>{{ $edu['cgpa'] ?? '' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6">No education listed</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(!empty($experience))
        <div class="section-box">
            <div class="sec-title">Work Experience</div>
            <table class="cv-table">
                <thead><tr><th>Position/Role</th><th>Organization</th><th>Duration</th></tr></thead>
                <tbody>
                    @foreach($experience as $exp)
                    <tr><td>{{ $exp['role'] ?? '' }}</td><td>{{ $exp['company'] ?? '' }}</td><td>{{ $exp['duration'] ?? '' }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @if(!empty($skills))
        <div class="section-box">
            <div class="sec-title">Professional Skills</div>
            <div>@foreach(explode(',', $skills) as $skill)<span class="pill">{{ trim($skill) }}</span> @endforeach</div>
        </div>
        @endif
        @if(!empty($hobbies))
        <div class="section-box">
            <div class="sec-title">Hobbies & Interests</div>
            <div>@foreach(explode(',', $hobbies) as $hobby)<span class="pill">{{ trim($hobby) }}</span> @endforeach</div>
        </div>
        @endif
        <div class="section-box">
            <div class="sec-title">Personal Information</div>
            <table class="cv-table bio-table">
                <tbody>
                    @if(!empty($father_name))<tr><td>Father's Name</td><td>: {{ $father_name }}</td></tr>@endif
                    @if(!empty($mother_name))<tr><td>Mother's Name</td><td>: {{ $mother_name }}</td></tr>@endif
                    @if(!empty($dob))<tr><td>Date of Birth</td><td>: {{ $dob }}</td></tr>@endif
                    @if(!empty($blood_group))<tr><td>Blood Group</td><td>: {{ $blood_group }}</td></tr>@endif
                    @if(!empty($religion))<tr><td>Religion</td><td>: {{ $religion }}</td></tr>@endif
                    @if(!empty($marital_status))<tr><td>Marital Status</td><td>: {{ $marital_status }}</td></tr>@endif
                    @if(!empty($nid))<tr><td>National ID</td><td>: {{ $nid }}</td></tr>@endif
                </tbody>
            </table>
        </div>
        @if(!empty($references))
        <div class="section-box">
            <div class="sec-title">References</div>
            <table class="cv-table">
                <thead><tr><th>Name</th><th>Designation</th><th>Organization</th><th>Contact</th></tr></thead>
                <tbody>
                    @foreach($references as $ref)
                    <tr><td>{{ $ref['name'] ?? '' }}</td><td>{{ $ref['designation'] ?? '' }}</td><td>{{ $ref['company'] ?? '' }}</td><td>{{ $ref['contact'] ?? '' }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div class="signature-block" style="margin-top:80px;text-align:right;padding-right:20px;page-break-inside:avoid;">
            <span style="border-top:1px solid #000;padding-top:5px;font-weight:bold;">Signature of Applicant</span>
        </div>
    </div>
</div>
<script>
let currentTemplate = 'bd-tpl-2';
let currentPageMode = 'page-mode-natural';
let photoZoom = 1.0, photoX = 0, photoY = 0;
function adjustPhoto(action, value) {
    if (action === 'zoom') { photoZoom = Math.max(0.5, Math.min(3.0, photoZoom + value)); }
    else if (action === 'moveX') { photoX += value; }
    else if (action === 'moveY') { photoY += value; }
    document.documentElement.style.setProperty('--photo-zoom', photoZoom);
    document.documentElement.style.setProperty('--photo-x', photoX + 'px');
    document.documentElement.style.setProperty('--photo-y', photoY + 'px');
}
function updateClasses() {
    const doc = document.getElementById('cvDocument');
    if (doc) doc.className = 'a4-page ' + currentTemplate + ' ' + currentPageMode;
}
function changeTemplate(tpl) {
    currentTemplate = tpl;
    updateClasses();
    let pt = document.querySelector('.photo-td');
    if (pt) pt.style.display = (tpl === 'bd-tpl-1') ? 'none' : 'table-cell';
}
function changePageMode(mode) { currentPageMode = mode; updateClasses(); }
function downloadPDF() {
    const element = document.getElementById('cvDocument');
    element.classList.add('pdf-rendering');
    Swal.fire({ title: 'Generating PDF...', text: 'Please wait for high-quality A4 PDF.', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
    var opt = {
        margin: (currentPageMode === 'page-mode-force1') ? 0 : [20, 20, 20, 20],
        filename: 'BD_CV_{{ preg_replace("/[^A-Za-z0-9\-]/", "_", $name ?? "document") }}.pdf',
        image: { type: 'jpeg', quality: 1.0 },
        html2canvas: { scale: 2, useCORS: true, letterRendering: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: (currentPageMode === 'page-mode-force1') ? { mode: ['avoid-all'] } : { mode: ['css', 'legacy'] }
    };
    html2pdf().set(opt).from(element).save().then(() => { element.classList.remove('pdf-rendering'); Swal.close(); })
    .catch(err => { element.classList.remove('pdf-rendering'); Swal.fire('Error', 'PDF generation failed.', 'error'); });
}
</script>
</body>
</html>
