<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mongolia Visa</title>
    <style>
        @font-face {
            font-family: "Manrope";
            src: url("{{ asset('fonts/Manrope-Bold.ttf') }}") format("truetype");
            font-weight: bold;
            font-style: normal;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: "Manrope-Bold.ttf", Arial, sans-serif;
        }
        
        .visa-container {
            position: relative;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            aspect-ratio: 7/9.9; /* Maintains 46.67:66 ratio */
            background-image: url('{{ asset("assets/mongolia_visa_files/img_01.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Background image element for print compatibility */
        .visa-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("assets/mongolia_visa_files/img_01.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }
        
        /* Force background images to print */
        @media print {
            * {
                margin: 0 !important;
                padding: 0 !important;
            }
            
            @page {
                margin: 0 !important;
                size: A4;
            }
            
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }
            
            .visa-container,
            .visa-container::before {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .visa-container {
                max-width: none !important;
                width: 100vw !important;
                height: 100vh !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-inside: avoid;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
            }
            
            .visa-field {
                font-size: 12px !important;
            }
            
            .visa-field-small {
                font-size: 10px !important;
            }
        }
        
        .visa-field {
            position: absolute;
            font-family: "Manrope-Bold", Arial, sans-serif;
            font-weight: bold;
            color: #000000;
            white-space: nowrap;
            font-size: 0.78478em;
            line-height: 1.379em;
        }
        
        .visa-field-small {
            font-size: clamp(6px, 1.34vw, 11px);
        }
        
        .qr-code {
            position: absolute;
            width: 15%;
            height: auto;
            aspect-ratio: 1;
        }
        
        /* Field positions converted from em to percentage */
        .first-name { right: 53%; top: 25.27%; text-align: right; }
        .middle-name { right: 53%; top: 26.59%; text-align: right; }
        .nationality { right: 10%; top: 26.48%; text-align: right; }
        .last-name { right: 53%; top: 30.27%; text-align: right; }
        .gender { right: 53%; top: 33.70%; text-align: right; }
        .passport-number { right: 10%; top: 33.58%; text-align: right; }
        .passport-issue-date { right: 10%; top: 37.15%; text-align: right; }
        .passport-expiry-date { right: 10%; top: 40.72%; text-align: right; }
        .date-of-birth { right: 53%; top: 37.15%; text-align: right; }
        .inviting-company { right: 53%; top: 46.85%; text-align: right; }
        .visa-validity { right: 10%; top: 47.14%; text-align: right; }
        .application-date { right: 10%; top: 50.58%; text-align: right; }
        .remaining-stay { right: 10%; top: 54.03%; text-align: right; }
        .visa-class { right: 53%; top: 53.32%; text-align: right; }
        .entry-type { right: 53%; top: 56.77%; text-align: right; }
        .port-entry-1 { right: 10%; top: 58.01%; text-align: right; }
        .port-entry-2 { right: 10%; top: 59.69%; text-align: right; }
        .port-entry-3 { right: 10%; top: 61.40%; text-align: right; }
        .type-of-visa { right: 53%; top: 60.45%; text-align: right; }
        .visa-issue-date { right: 55%; top: 67.20%; text-align: right; }
        .visa-effective-date { right: 57%; top: 77.13%; text-align: right; }
        .visa-permit-number { right: 10%; top: 79.12%; text-align: right; }
        .contact-number { right: 13.14%; top: 94.94%; text-align: right; }
        .qr-position { right: 13.14%; top: 66.88%; }
    </style>
</head>
<body>
    <div class="visa-container">
        <!-- Background image as img element for print compatibility -->
        <img src="{{ asset('assets/mongolia_visa_files/img_01.png') }}" 
             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;" 
             alt="Visa Background">
        
        <!-- Personal Information -->
        <div class="visa-field first-name">{{ strtoupper($mongoliaVisa->first_name) }}</div>
        <div class="visa-field middle-name">{{ strtoupper($mongoliaVisa->middle_name) }}</div>
        <div class="visa-field nationality">{{ strtoupper($mongoliaVisa->nationality) }}</div>
        <div class="visa-field last-name">{{ strtoupper($mongoliaVisa->last_name) }}</div>
        <div class="visa-field gender">{{ strtoupper($mongoliaVisa->gender) }}</div>
        
        <!-- Passport Information -->
        <div class="visa-field passport-number">{{ strtoupper($mongoliaVisa->passport_number) }}</div>
        <div class="visa-field passport-issue-date">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->passport_issue_date)->format('Y M d')) }}</div>
        <div class="visa-field passport-expiry-date">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->passport_expiry_date)->format('Y M d')) }}</div>
        <div class="visa-field date-of-birth">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->date_of_birth)->format('Y M d')) }}</div>
        
        <!-- Visa Information -->
        <div class="visa-field inviting-company">{{ strtoupper($mongoliaVisa->inviting_company) }}</div>
        <div class="visa-field visa-validity">{{ $mongoliaVisa->visa_validity_days }} DAYS</div>
        <div class="visa-field application-date">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->application_date)->format('Y M d')) }}</div>
        <div class="visa-field remaining-stay">{{ $mongoliaVisa->remaining_stay_days }} DAYS</div>
        <div class="visa-field visa-class">{{ strtoupper($mongoliaVisa->visa_class) }}</div>
        <div class="visa-field entry-type">{{ strtoupper($mongoliaVisa->entry_type) }}</div>
        
        <!-- Port of Entry (split into 3 parts) -->
        <div class="visa-field visa-field-small port-entry-1">{{ strtoupper(Str::before($mongoliaVisa->port_of_entry, ' ')) }}</div>
        <div class="visa-field visa-field-small port-entry-2">{{ strtoupper(trim(Str::after(Str::beforeLast($mongoliaVisa->port_of_entry, ' '), ' '))) }}</div>
        <div class="visa-field visa-field-small port-entry-3">{{ strtoupper(Str::afterLast($mongoliaVisa->port_of_entry, ' ')) }}</div>
        
        <div class="visa-field type-of-visa">{{ strtoupper($mongoliaVisa->type_of_visa) }}</div>
        <div class="visa-field visa-field-small visa-issue-date">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->visa_issue_date)->format('Y-m-d')) }}</div>
        <div class="visa-field visa-field-small visa-effective-date">{{ strtoupper(\Carbon\Carbon::parse($mongoliaVisa->visa_effective_date)->format('Y M d')) }}</div>
        <div class="visa-field visa-permit-number">{{ strtoupper($mongoliaVisa->visa_permit_number) }}</div>
        <div class="visa-field contact-number">{{ strtoupper($mongoliaVisa->contact_number) }}</div>
        
        <!-- QR Code -->
       <img class="qr-code qr-position" 
			 src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode('https://isf.lat/mn/mn/approval/' . $mongoliaVisa->visa_permit_number) }}" 
			 alt="QR Code">
    </div>
</body>
</html>