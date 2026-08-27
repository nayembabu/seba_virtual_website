<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $name }} - Professional CV</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; font-size: 13px; color: #1e293b; line-height: 1.5; }
        .container { display: flex; min-height: 297mm; width: 210mm; margin: 0 auto; position: relative; }
        .sidebar { width: 35%; background: #0f172a; color: #e2e8f0; padding: 28px 22px 50px; }
        .main { width: 65%; padding: 28px 24px 50px; background: #fff; }
        .photo { width: 110px; height: 110px; border-radius: 50%; border: 3px solid #ffdbd0; margin: 0 auto 18px; overflow: hidden; }
        .photo img { width: 100%; height: 100%; object-fit: cover; }
        .photo-placeholder { width: 110px; height: 110px; border-radius: 50%; border: 3px solid #ffdbd0; margin: 0 auto 18px; display: flex; align-items: center; justify-content: center; font-size: 36px; color: #ffdbd0; }
        .name { font-size: 22px; font-weight: 700; color: #fff; text-align: center; margin-bottom: 4px; }
        .title { font-size: 13px; color: #ffdbd0; text-align: center; margin-bottom: 20px; font-weight: 400; }
        .section-heading { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #ffdbd0; border-bottom: 1px solid #334155; padding-bottom: 5px; margin: 20px 0 10px; }
        .contact-item { display: flex; align-items: center; gap: 8px; font-size: 11px; margin-bottom: 8px; color: #cbd5e1; word-break: break-all; }
        .contact-item .icon { width: 16px; text-align: center; color: #ffdbd0; font-size: 11px; flex-shrink: 0; }
        .info-text { font-size: 11px; color: #94a3b8; margin-bottom: 6px; text-align: center; }
        .main-name { font-size: 30px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
        .main-title { font-size: 15px; color: #6366f1; margin-bottom: 20px; font-weight: 500; }
        .main-section { margin-bottom: 18px; }
        .main-heading { font-size: 14px; font-weight: 700; color: #0f172a; border-bottom: 2px solid #6366f1; padding-bottom: 4px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .exp-item { margin-bottom: 12px; }
        .exp-role { font-weight: 600; font-size: 13px; color: #0f172a; }
        .exp-company { font-weight: 500; font-size: 12px; color: #475569; }
        .exp-duration { font-size: 11px; color: #94a3b8; margin-bottom: 3px; }
        .edu-item { margin-bottom: 8px; }
        .edu-degree { font-weight: 600; font-size: 12px; }
        .edu-inst { font-size: 11px; color: #475569; }
        .edu-year { font-size: 11px; color: #94a3b8; }
        .skill-tags { display: flex; flex-wrap: wrap; gap: 6px; }
        .skill-tag { background: #f1f5f9; color: #334155; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 500; }
        .ref-item { margin-bottom: 10px; }
        .ref-name { font-weight: 600; font-size: 12px; }
        .ref-info { font-size: 11px; color: #64748b; }
        .footer-link { position: absolute; bottom: 8px; left: 0; right: 0; text-align: center; font-size: 9px; color: #94a3b8; }
        .footer-link a { color: #94a3b8; text-decoration: none; }
        @media print { body { -webkit-print-color-adjust: exact; } .footer-link { position: fixed; bottom: 8px; left: 0; right: 0; } }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        @if($photo_path)
        <div class="photo"><img src="{{ $photo_path }}" alt="Photo"></div>
        @else
        <div class="photo-placeholder"><i class="icon">&#x1F464;</i></div>
        @endif
        <div class="name">{{ $name }}</div>
        <div class="title">{{ $title }}</div>

        <div class="section-heading">Contact</div>
        @if($email)<div class="contact-item"><span class="icon">&#9993;</span> {{ $email }}</div>@endif
        @if($phone)<div class="contact-item"><span class="icon">&#9742;</span> {{ $phone }}</div>@endif
        @if($address)<div class="contact-item"><span class="icon">&#9906;</span> {{ $address }}</div>@endif
        @if($linkedin)<div class="contact-item"><span class="icon">&#128279;</span> {{ $linkedin }}</div>@endif

        @if($skills)
        <div class="section-heading">Skills</div>
        <div class="skill-tags">
            @foreach(explode(',', $skills) as $skill)
            <span class="skill-tag">{{ trim($skill) }}</span>
            @endforeach
        </div>
        @endif

        @if($hobbies)
        <div class="section-heading">Hobbies</div>
        <p class="info-text">{{ $hobbies }}</p>
        @endif

        @if(!empty($references))
        <div class="section-heading">References</div>
        @foreach($references as $ref)
        @if(!empty($ref['name']))
        <div class="ref-item">
            <div class="ref-name">{{ $ref['name'] }}</div>
            <div class="ref-info">
                @if(!empty($ref['designation'])){{ $ref['designation'] }}@endif
                @if(!empty($ref['company'])) | {{ $ref['company'] }}@endif
                @if(!empty($ref['contact']))<br>{{ $ref['contact'] }}@endif
            </div>
        </div>
        @endif
        @endforeach
        @endif
    </div>
    <div class="main">
        <div class="main-name">{{ $name }}</div>
        <div class="main-title">{{ $title }}</div>

        @if($objective)
        <div class="main-section">
            <div class="main-heading">Career Objective</div>
            <p style="font-size:12px;color:#475569;line-height:1.6;">{{ $objective }}</p>
        </div>
        @endif

        @if(!empty($education))
        <div class="main-section">
            <div class="main-heading">Education</div>
            @foreach($education as $edu)
            @if(!empty($edu['degree']))
            <div class="edu-item">
                <div class="edu-degree">{{ $edu['degree'] }}</div>
                <div class="edu-inst">{{ $edu['institute'] ?? '' }} @if(!empty($edu['cgpa'])) | CGPA: {{ $edu['cgpa'] }}@endif</div>
                <div class="edu-year">{{ $edu['year'] ?? '' }}</div>
            </div>
            @endif
            @endforeach
        </div>
        @endif

        @if(!empty($experience))
        <div class="main-section">
            <div class="main-heading">Experience</div>
            @foreach($experience as $exp)
            @if(!empty($exp['role']))
            <div class="exp-item">
                <div class="exp-role">{{ $exp['role'] }}</div>
                <div class="exp-company">{{ $exp['company'] ?? '' }}</div>
                <div class="exp-duration">{{ $exp['duration'] ?? '' }}</div>
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
    <div class="footer-link">Generated by <a href="https://e-serviceportal.com/" target="_blank">e-serviceportal.com</a></div>
</div>
</body>
</html>