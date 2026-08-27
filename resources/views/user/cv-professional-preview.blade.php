<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pro CV - {{ $name ?? 'Your Name' }}</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&family=Noto+Serif:wght@400;700&family=Merriweather:wght@300;400;700&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
<style>
:root { --cv-theme: #2563eb; --cv-font: 'Roboto', sans-serif; --txt-dark: #0f172a; --txt-main: #334155; --photo-zoom: 1; --photo-x: 0px; --photo-y: 0px; }
body { background: #cbd5e1; margin: 0; padding-bottom: 50px; user-select: none; -webkit-user-select: none; }
#controlPanel { background: #fff; padding: 15px 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; gap: 15px; position: sticky; top: 0; z-index: 9999; border-bottom: 4px solid var(--cv-theme); align-items: center; justify-content: space-between; }
.form-select { padding: 8px 12px; border-radius: 5px; border: 1px solid #cbd5e1; outline: none; font-weight: bold; cursor: pointer; }
.color-picker { border: none; width: 35px; height: 35px; padding: 0; border-radius: 50%; cursor: pointer; }
.btn-action { color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
.btn-action:hover { opacity: 0.9; }
#cvWrapper { width: 100%; display: flex; justify-content: center; padding: 40px 0; }
.a4-page { width: 210mm; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.15); font-family: var(--cv-font); margin: 0 auto; padding: 15mm 20mm; box-sizing: border-box; color: var(--txt-main); position: relative; overflow: hidden; }
.page-mode-natural { min-height: 297mm; height: auto; overflow: visible; }
.page-mode-force1 { height: 297mm; max-height: 297mm; overflow: hidden; }
.page-mode-force2 { height: 297mm; max-height: 297mm; overflow: hidden; font-size: 12.5px; }
.pdf-rendering { box-shadow: none !important; padding: 0 !important; width: 170mm !important; background: #fff !important; }
@page { size: A4 portrait; margin: 12mm 15mm; }
@media print { body { background: #fff !important; margin: 0 !important; padding: 0 !important; } .no-print { display: none !important; } #cvWrapper { padding: 0 !important; display: block !important; } .a4-page { box-shadow: none !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background: #fff !important; } }
.header-section { margin-bottom: 20px; }
.cv-name { font-size: 28px; font-weight: bold; margin: 0 0 3px 0; text-transform: uppercase; letter-spacing: 1px; line-height: 1.2; }
.cv-title { font-size: 16px; font-weight: 500; margin: 0 0 8px 0; color: var(--cv-theme); }
.contact-line { font-size: 13px; display: flex; gap: 15px; flex-wrap: wrap; }
.contact-line span { display: flex; align-items: center; gap: 5px; }
.contact-line i { width: 14px; text-align: center; font-size: 12px; }
.photo-container { width: 110px; height: 130px; overflow: hidden; border: 2px solid #e2e8f0; border-radius: 4px; display: inline-block; flex-shrink: 0; }
.photo-img { width: 100%; height: 100%; object-fit: cover; transform: scale(var(--photo-zoom)) translate(var(--photo-x), var(--photo-y)); transform-origin: center; transition: transform 0.1s ease-out; }
.section-box { margin-bottom: 14px; }
.sec-title { font-size: 15px; font-weight: bold; text-transform: uppercase; margin: 0 0 8px 0; padding: 5px 0; letter-spacing: 0.5px; }
.text-content { font-size: 13px; text-align: justify; line-height: 1.6; }
.cv-table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 6px; }
.cv-table th, .cv-table td { padding: 5px 7px; text-align: left; vertical-align: middle; }
.bio-table { border: none; width: 100%; }
.bio-table td { border: none; padding: 4px 0; vertical-align: top; font-size: 13px; }
.bio-table td:first-child { width: 30%; font-weight: bold; }
.pill { display: inline-block; padding: 3px 10px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 3px; font-size: 12px; margin: 0 4px 6px 0; }
.header-split { display: flex; gap: 20px; align-items: center; }
.body-split { display: flex; gap: 20px; }
.body-split .left-col { width: 67%; flex-shrink: 0; }
.body-split .right-col { width: 33%; flex-shrink: 0; }
.top-header-block { display: flex; gap: 15px; padding: 15px 20px; margin: -15mm -20mm 15px -20mm; min-height: 100px; }
.top-header-block .info-area { flex: 1; }
.top-header-block .photo-area { width: 105px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.side-section { margin-bottom: 12px; }
.side-sec-title { font-size: 13px; font-weight: bold; text-transform: uppercase; margin: 0 0 6px 0; padding: 4px 0; letter-spacing: 0.5px; }
.side-text { font-size: 12px; line-height: 1.5; }
.ats-contact { display: flex; flex-direction: column; gap: 2px; font-size: 12.5px; }
.ats-contact span i { width: 16px; text-align: center; margin-right: 6px; }
.photo-box-small { width: 80px; height: 90px; overflow: hidden; border: 2px solid #fff; border-radius: 4px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
.photo-box-small img { width: 100%; height: 100%; object-fit: cover; }
.tpl-1 .cv-name, .tpl-2 .cv-name { color: var(--txt-dark); }
.tpl-1 .sec-title { color: var(--txt-dark); border-bottom: 2px solid var(--txt-dark); }
.tpl-1 .cv-table th { background: #f8fafc; color: var(--txt-dark); border: 1px solid #94a3b8; }
.tpl-1 .cv-table td { border: 1px solid #cbd5e1; }
.tpl-1 .bio-table td:first-child { color: var(--txt-dark); }
.tpl-1 .header-section { border-bottom: 2px solid var(--txt-dark); padding-bottom: 10px; }
.tpl-2 .sec-title { color: var(--cv-theme); border-bottom: 2px solid var(--cv-theme); }
.tpl-2 .cv-table th { background: var(--cv-theme); color: #fff; border: 1px solid var(--cv-theme); }
.tpl-2 .cv-table td { border: 1px solid #cbd5e1; }
.tpl-2 .bio-table td { border-bottom: 1px dashed #e2e8f0; }
.tpl-2 .bio-table td:first-child { color: var(--cv-theme); }
.tpl-2 .header-section { border-left: 4px solid var(--cv-theme); padding-left: 15px; }
.tpl-3 .cv-name { color: var(--txt-dark); }
.tpl-3 .sec-title { color: var(--txt-dark); background: #f1f5f9; padding: 6px 10px; border-radius: 4px; }
.tpl-3 .cv-table th { background: #f1f5f9; color: var(--txt-dark); border: 1px solid #cbd5e1; }
.tpl-3 .cv-table td { border: 1px solid #e2e8f0; }
.tpl-3 .bio-table td:first-child { color: var(--txt-dark); }
.tpl-3 .ats-header { background: #f8fafc; padding: 12px 15px; border-radius: 4px; margin-bottom: 15px; }
.tpl-4 .top-header-block, .tpl-5 .top-header-block { background: var(--cv-theme); color: #fff; }
.tpl-4 .top-header-block .cv-name, .tpl-4 .top-header-block .cv-title, .tpl-4 .top-header-block .contact-line, .tpl-4 .top-header-block .contact-line i,
.tpl-5 .top-header-block .cv-name, .tpl-5 .top-header-block .cv-title, .tpl-5 .top-header-block .contact-line, .tpl-5 .top-header-block .contact-line i { color: #fff; }
.tpl-4 .photo-container, .tpl-5 .photo-container { border-color: #fff; }
.tpl-4 .sec-title { color: var(--cv-theme); border-bottom: 1px solid #cbd5e1; }
.tpl-4 .cv-table th { background: transparent; color: var(--cv-theme); border-top: 2px solid var(--cv-theme); border-bottom: 2px solid var(--cv-theme); border-left: none; border-right: none; }
.tpl-4 .cv-table td { border-left: none; border-right: none; border-bottom: 1px solid #e2e8f0; border-top: none; }
.tpl-4 .bio-table td { border-bottom: 1px solid #f1f5f9; }
.tpl-5 .sec-title { color: var(--txt-dark); border-left: 4px solid var(--cv-theme); padding-left: 10px; }
.tpl-5 .cv-table { border: 1px solid var(--cv-theme); }
.tpl-5 .cv-table th { background: var(--cv-theme); color: #fff; border: 1px solid var(--cv-theme); }
.tpl-5 .cv-table td { border: 1px solid #e2e8f0; }
.tpl-5 .bio-table td:first-child { color: var(--cv-theme); }
@media print { .page-mode-force1, .page-mode-force2 { height: 257mm !important; max-height: 257mm !important; overflow: hidden !important; page-break-inside: avoid !important; } .page-mode-natural { min-height: 0 !important; height: auto !important; overflow: visible !important; } .sec-title, .cv-table th, .bio-table td:first-child, .top-header-block { -webkit-print-color-adjust: exact; print-color-adjust: exact; } .section-box, tr, .header-section, .body-split, .top-header-block, .signature-block { page-break-inside: avoid !important; break-inside: avoid !important; } }
</style>
</head>
<body>
<div id="controlPanel" class="no-print">
    <div>
        <span class="fw-bold me-2">Template:</span>
        <select class="form-select" onchange="changeTemplate(this.value)">
            <option value="tpl-1">1. Professional Corporate</option>
            <option value="tpl-2">2. Modern Blue (Solid Theme)</option>
            <option value="tpl-3">3. Classic Clean (Light Gray)</option>
            <option value="tpl-4">4. Header Highlight (Dark Top)</option>
            <option value="tpl-5">5. Full Featured (Side Split)</option>
        </select>
    </div>
    <div>
        <span class="fw-bold me-2">Page:</span>
        <select class="form-select" id="pageModeSelector" onchange="changePageMode(this.value)" style="border-color:#f59e0b;">
            <option value="page-mode-natural">Natural (Multi-page)</option>
            <option value="page-mode-force1">Force 1 Page (A4)</option>
            <option value="page-mode-force2">Force 1 Page (Compact)</option>
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
            <option value="'Raleway', sans-serif">Raleway</option>
            <option value="'Merriweather', serif">Merriweather</option>
        </select>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="fw-bold">Theme:</span>
        <input type="color" class="color-picker" value="#2563eb" onchange="document.documentElement.style.setProperty('--cv-theme', this.value);">
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
    <div id="cvDocument" class="a4-page tpl-1 page-mode-natural">
        @if(in_array($current_tpl ?? 'tpl-1', ['tpl-4', 'tpl-5']))
        <div class="top-header-block">
            <div class="info-area">
                <h1 class="cv-name">{{ $name ?? 'Your Name' }}</h1>
                <div class="cv-title">{{ $title ?? 'Professional Title' }}</div>
                <div class="contact-line">
                    @if(!empty($phone))<span><i class="fas fa-phone-alt"></i> {{ $phone }}</span>@endif
                    @if(!empty($email))<span><i class="fas fa-envelope"></i> {{ $email }}</span>@endif
                    @if(!empty($address))<span><i class="fas fa-map-marker-alt"></i> {{ $address }}</span>@endif
                    @if(!empty($linkedin))<span><i class="fab fa-linkedin-in"></i> {{ $linkedin }}</span>@endif
                </div>
            </div>
            <div class="photo-area">
                @if(!empty($photo_path))
                <div class="photo-box-small"><img src="{{ $photo_path }}" alt="" class="photo-img" id="cvPhoto"></div>
                @endif
            </div>
        </div>
        @else
        <div class="header-section">
            <div class="header-split">
                <div style="flex:1;">
                    <h1 class="cv-name">{{ $name ?? 'Your Name' }}</h1>
                    <div class="cv-title">{{ $title ?? 'Professional Title' }}</div>
                    <div class="contact-line">
                        @if(!empty($phone))<span><i class="fas fa-phone-alt"></i> {{ $phone }}</span>@endif
                        @if(!empty($email))<span><i class="fas fa-envelope"></i> {{ $email }}</span>@endif
                        @if(!empty($address))<span><i class="fas fa-map-marker-alt"></i> {{ $address }}</span>@endif
                        @if(!empty($linkedin))<span><i class="fab fa-linkedin-in"></i> {{ $linkedin }}</span>@endif
                    </div>
                </div>
                <div>
                    @if(!empty($photo_path))
                    <div class="photo-container"><img src="{{ $photo_path }}" alt="" class="photo-img" id="cvPhoto"></div>
                    @endif
                </div>
            </div>
            @if(($current_tpl ?? 'tpl-1') === 'tpl-3')
            <div class="ats-contact ats-header">
                @if(!empty($phone))<span><i class="fas fa-phone-alt"></i> {{ $phone }}</span>@endif
                @if(!empty($email))<span><i class="fas fa-envelope"></i> {{ $email }}</span>@endif
                @if(!empty($address))<span><i class="fas fa-map-marker-alt"></i> {{ $address }}</span>@endif
                @if(!empty($linkedin))<span><i class="fab fa-linkedin-in"></i> {{ $linkedin }}</span>@endif
            </div>
            @endif
        </div>
        @endif
        @if(($current_tpl ?? 'tpl-1') === 'tpl-5')
        <div class="body-split">
            <div class="left-col">
                @if(!empty($objective))
                <div class="section-box">
                    <div class="sec-title">Professional Summary</div>
                    <div class="text-content">{{ $objective }}</div>
                </div>
                @endif
                <div class="section-box">
                    <div class="sec-title">Education</div>
                    <table class="cv-table">
                        <thead><tr><th>Degree</th><th>Institute</th><th>Year</th><th>Result</th></tr></thead>
                        <tbody>
                            @forelse($education ?? [] as $edu)
                            <tr><td>{{ $edu['degree'] ?? '' }}</td><td>{{ $edu['institute'] ?? '' }}</td><td>{{ $edu['year'] ?? '' }}</td><td>{{ $edu['cgpa'] ?? '' }}</td></tr>
                            @empty
                            <tr><td colspan="4">No education listed</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(!empty($experience))
                <div class="section-box">
                    <div class="sec-title">Experience</div>
                    <table class="cv-table">
                        <thead><tr><th>Position</th><th>Company</th><th>Duration</th></tr></thead>
                        <tbody>
                            @foreach($experience as $exp)
                            <tr><td>{{ $exp['role'] ?? '' }}</td><td>{{ $exp['company'] ?? '' }}</td><td>{{ $exp['duration'] ?? '' }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="right-col">
                @if(!empty($skills))
                <div class="side-section">
                    <div class="side-sec-title">Skills</div>
                    <div class="side-text">@foreach(explode(',', $skills) as $skill)<span class="pill">{{ trim($skill) }}</span> @endforeach</div>
                </div>
                @endif
                @if(!empty($hobbies))
                <div class="side-section">
                    <div class="side-sec-title">Interests</div>
                    <div class="side-text">@foreach(explode(',', $hobbies) as $hobby)<span class="pill">{{ trim($hobby) }}</span> @endforeach</div>
                </div>
                @endif
                <div class="side-section">
                    <div class="side-sec-title">Personal</div>
                    <div class="side-text">
                        @if(!empty($father_name))<div><strong>Father:</strong> {{ $father_name }}</div>@endif
                        @if(!empty($mother_name))<div><strong>Mother:</strong> {{ $mother_name }}</div>@endif
                        @if(!empty($dob))<div><strong>DOB:</strong> {{ $dob }}</div>@endif
                        @if(!empty($blood_group))<div><strong>Blood:</strong> {{ $blood_group }}</div>@endif
                        @if(!empty($religion))<div><strong>Religion:</strong> {{ $religion }}</div>@endif
                        @if(!empty($marital_status))<div><strong>Marital:</strong> {{ $marital_status }}</div>@endif
                        @if(!empty($nid))<div><strong>NID:</strong> {{ $nid }}</div>@endif
                    </div>
                </div>
                @if(!empty($references))
                <div class="side-section">
                    <div class="side-sec-title">References</div>
                    <div class="side-text">
                        @foreach($references as $ref)
                        <div style="margin-bottom:6px;"><strong>{{ $ref['name'] ?? '' }}</strong><br>{{ $ref['designation'] ?? '' }}@if(!empty($ref['company']))<br>{{ $ref['company'] }}@endif @if(!empty($ref['contact']))<br>{{ $ref['contact'] }}@endif</div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        @if(!empty($objective))
        <div class="section-box">
            <div class="sec-title">Professional Summary</div>
            <div class="text-content">{{ $objective }}</div>
        </div>
        @endif
        <div class="section-box">
            <div class="sec-title">Education</div>
            <table class="cv-table">
                <thead><tr><th>Degree</th><th>Institute</th><th>Board</th><th>Group</th><th>Year</th><th>Result</th></tr></thead>
                <tbody>
                    @forelse($education ?? [] as $edu)
                    <tr><td>{{ $edu['degree'] ?? '' }}</td><td>{{ $edu['institute'] ?? '' }}</td><td>{{ $edu['board'] ?? '' }}</td><td>{{ $edu['group'] ?? '' }}</td><td>{{ $edu['year'] ?? '' }}</td><td>{{ $edu['cgpa'] ?? '' }}</td></tr>
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
                <thead><tr><th>Position</th><th>Company</th><th>Duration</th></tr></thead>
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
            <div class="sec-title">Skills</div>
            <div>@foreach(explode(',', $skills) as $skill)<span class="pill">{{ trim($skill) }}</span> @endforeach</div>
        </div>
        @endif
        @if(!empty($hobbies))
        <div class="section-box">
            <div class="sec-title">Interests</div>
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
        @endif
        <div class="signature-block" style="margin-top:60px;text-align:right;padding-right:20px;page-break-inside:avoid;">
            <span style="border-top:1px solid #000;padding-top:5px;font-weight:bold;">Signature of Applicant</span>
        </div>
    </div>
</div>
<script>
let currentTemplate = 'tpl-1';
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
}
function changePageMode(mode) { currentPageMode = mode; updateClasses(); }
function downloadPDF() {
    const element = document.getElementById('cvDocument');
    element.classList.add('pdf-rendering');
    Swal.fire({ title: 'Generating PDF...', text: 'Please wait for high-quality A4 PDF.', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
    var opt = {
        margin: (currentPageMode === 'page-mode-force1' || currentPageMode === 'page-mode-force2') ? 0 : [20, 20, 20, 20],
        filename: 'Pro_CV_{{ preg_replace("/[^A-Za-z0-9\-]/", "_", $name ?? "document") }}.pdf',
        image: { type: 'jpeg', quality: 1.0 },
        html2canvas: { scale: 2, useCORS: true, letterRendering: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: (currentPageMode !== 'page-mode-natural') ? { mode: ['avoid-all'] } : { mode: ['css', 'legacy'] }
    };
    html2pdf().set(opt).from(element).save().then(() => { element.classList.remove('pdf-rendering'); Swal.close(); })
    .catch(err => { element.classList.remove('pdf-rendering'); Swal.fire('Error', 'PDF generation failed.', 'error'); });
}
</script>
</body>
</html>
