<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $name }} - CV (BD Popular)</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&family=Inter:wght@300;400;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Noto Sans Bengali', sans-serif; font-size: 12px; color: #1e293b; padding: 20px; background: #fff; }
        .container { max-width: 190mm; margin: 0 auto; position: relative; padding-bottom: 30px; }
        .header { text-align: center; margin-bottom: 18px; }
        .header h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .header .subtitle { font-size: 14px; color: #6366f1; font-weight: 500; }
        .header .cv-label { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .photo-area { text-align: center; margin: 10px 0; }
        .photo-area img { width: 100px; height: 115px; object-fit: cover; border: 2px solid #cbd5e1; }
        .photo-placeholder { width: 100px; height: 115px; border: 2px dashed #cbd5e1; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table th, table td { border: 1px solid #cbd5e1; padding: 5px 8px; text-align: left; font-size: 11px; }
        table th { background: #0f172a; color: #fff; font-weight: 600; font-size: 11px; text-align: center; }
        .bio-table th { width: 25%; }
        .section-title { background: #0f172a; color: #ffdbd0; padding: 5px 10px; font-size: 12px; font-weight: 700; margin: 16px 0 8px; text-align: center; letter-spacing: 1px; }
        .declaration { margin-top: 30px; }
        .declaration .sign-line { display: flex; justify-content: space-between; margin-top: 25px; }
        .declaration .sign-line span { border-top: 1px solid #1e293b; padding-top: 4px; font-size: 11px; }
        .footer-link { position: absolute; bottom: 5px; left: 0; right: 0; text-align: center; font-size: 9px; color: #94a3b8; }
        .footer-link a { color: #94a3b8; text-decoration: none; }
        @media print { body { -webkit-print-color-adjust: exact; } .footer-link { position: fixed; bottom: 5px; left: 0; right: 0; } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>CURRICULUM VITAE</h1>
        <div class="subtitle">{{ $name }}</div>
        <div class="cv-label">{{ $title }}</div>
    </div>

    @if($photo_path)
    <div class="photo-area"><img src="{{ $photo_path }}" alt="Photo"></div>
    @endif

    <div class="section-title">BIO DATA / PERSONAL INFORMATION</div>
    <table class="bio-table">
        <tr><th>Name</th><td>{{ $name }}</td></tr>
        <tr><th>Professional Title</th><td>{{ $title }}</td></tr>
        @if($father_name)<tr><th>Father's Name</th><td>{{ $father_name }}</td></tr>@endif
        @if($mother_name)<tr><th>Mother's Name</th><td>{{ $mother_name }}</td></tr>@endif
        @if($dob)<tr><th>Date of Birth</th><td>{{ $dob }}</td></tr>@endif
        @if($blood_group)<tr><th>Blood Group</th><td>{{ $blood_group }}</td></tr>@endif
        @if($religion)<tr><th>Religion</th><td>{{ $religion }}</td></tr>@endif
        @if($marital_status)<tr><th>Marital Status</th><td>{{ $marital_status }}</td></tr>@endif
        @if($nid)<tr><th>NID / Passport</th><td>{{ $nid }}</td></tr>@endif
        <tr><th>Email</th><td>{{ $email }}</td></tr>
        <tr><th>Phone</th><td>{{ $phone }}</td></tr>
        <tr><th>Address</th><td>{{ $address }}</td></tr>
        @if($linkedin)<tr><th>LinkedIn / URL</th><td>{{ $linkedin }}</td></tr>@endif
    </table>

    @if($objective)
    <div class="section-title">CAREER OBJECTIVE</div>
    <p style="font-size:12px;line-height:1.6;padding:0 8px;text-align:justify;">{{ $objective }}</p>
    @endif

    @if(!empty($education))
    <div class="section-title">EDUCATIONAL QUALIFICATION</div>
    <table>
        <tr>
            <th>Degree</th>
            <th>Institute</th>
            <th>Board/University</th>
            <th>Passing Year</th>
            <th>CGPA / Result</th>
            <th>Group / Subject</th>
        </tr>
        @foreach($education as $edu)
        @if(!empty($edu['degree']))
        <tr>
            <td>{{ $edu['degree'] ?? '' }}</td>
            <td>{{ $edu['institute'] ?? '' }}</td>
            <td>{{ $edu['board'] ?? '' }}</td>
            <td style="text-align:center;">{{ $edu['year'] ?? '' }}</td>
            <td style="text-align:center;">{{ $edu['cgpa'] ?? '' }}</td>
            <td>{{ $edu['group'] ?? '' }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    @if(!empty($experience))
    <div class="section-title">WORK EXPERIENCE</div>
    <table>
        <tr><th>Position / Role</th><th>Company / Organization</th><th>Duration</th></tr>
        @foreach($experience as $exp)
        @if(!empty($exp['role']))
        <tr>
            <td>{{ $exp['role'] ?? '' }}</td>
            <td>{{ $exp['company'] ?? '' }}</td>
            <td style="text-align:center;">{{ $exp['duration'] ?? '' }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    @if($skills)
    <div class="section-title">SKILLS</div>
    <p style="padding:0 8px;font-size:12px;">{{ $skills }}</p>
    @endif

    @if($hobbies)
    <div class="section-title">HOBBIES / INTERESTS</div>
    <p style="padding:0 8px;font-size:12px;">{{ $hobbies }}</p>
    @endif

    @if(!empty($references))
    <div class="section-title">REFERENCES</div>
    <table>
        <tr><th>Name</th><th>Designation</th><th>Company</th><th>Contact</th></tr>
        @foreach($references as $ref)
        @if(!empty($ref['name']))
        <tr>
            <td>{{ $ref['name'] ?? '' }}</td>
            <td>{{ $ref['designation'] ?? '' }}</td>
            <td>{{ $ref['company'] ?? '' }}</td>
            <td>{{ $ref['contact'] ?? '' }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    <div class="declaration">
        <p style="font-size:11px;text-align:justify;padding:0 8px;">
            I hereby declare that all the information provided above is true and correct to the best of my knowledge and belief.
            I am fully responsible for any discrepancy found in the information provided.
        </p>
        <div class="sign-line">
            <span>Date: ....................</span>
            <span>Signature: ....................</span>
        </div>
    </div>
    <div class="footer-link">Generated by <a href="https://e-serviceportal.com/" target="_blank">e-serviceportal.com</a></div>
</div>
</body>
</html>