@extends('user.layouts.app')

@section('title')
    TIN Certificate
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="main-content">

                        <div class="floating-controls no-print">
                            <button onclick="window.print()" class="btn btn-primary fw-bold shadow">🖨️ Print Certificate</button>
                            <a href="{{ route('user.tin.index') }}" class="btn btn-secondary fw-bold shadow">← Back</a>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="card-header-custom" style="background: #0d6efd; color: white; padding: 10px 15px; font-weight: bold;">
                                        TIN Certificate View
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="cert-preview-container">
                                            <div class="a4-cert cert-text" id="printableArea">
                                                <img src="https://secure.incometax.gov.bd/Images/tin_cert_logo.png" class="logo-top" alt="BD Seal">
                                                <img src="https://secure.incometax.gov.bd/Images/tin_cert_logo.png" class="watermark" alt="Watermark">

                                                <div style="margin-top:var(--header-gap); text-align:center;">
                                                    <h3 style="font-size:var(--title-font); font-weight:bold;">Government of the People's Republic of Bangladesh</h3>
                                                    <h4 style="font-size:calc(var(--title-font) - 2px); font-weight:bold; margin-top:5px;">National Board of Revenue</h4>
                                                    <h5 style="margin-top:6px; font-size:calc(var(--base-font) + 1px);">Taxpayer's Identification Number (TIN) Certificate</h5>
                                                    <h3 style="margin-top:12px; font-weight:bold; font-size:var(--title-font); border-bottom:1px solid #000; display:inline-block; padding-bottom:3px;">
                                                        TIN : {{ $tin->tin_number ?? $tin->tin_num }}
                                                    </h3>
                                                </div>

                                                <div style="margin-top:var(--body-gap); font-size:var(--base-font); line-height:1.65;">
                                                    <p>This is to Certify that <span class="bold">{{ $tin->name }}</span> is a Registered Taxpayer of National Board of Revenue under the jurisdiction of <strong>Taxes</strong> <span class="bold">{{ $tin->taxesCircle }}</span>, Taxes Zone <span class="bold">{{ $tin->taxesZone }}</span>.</p>

                                                    <p class="bold section-gap">Taxpayer's Particulars :</p>
                                                    <p>1) Name : <span class="bold">{{ $tin->name }}</span></p>
                                                    <p>2) Father's Name : <span class="bold">{{ $tin->fatherName }}</span></p>
                                                    <p>3) Mother's Name : <span class="bold">{{ $tin->motherName }}</span></p>
                                                    <p>4.a) Current Address : <span class="bold">
                                                        {{ $tin->curr_line1 }}, {{ $tin->curr_line2 ? $tin->curr_line2.', ' : '' }}
                                                            {{ $tin->currThana }}, {{ $tin->currDistrict }}, {{ $tin->curr_post ?? '' }}
                                                    </span></p>
                                                    <p>4.b) Permanent Address : <span class="bold">
                                                        {{ $tin->perm_line1 }}, {{ $tin->perm_line2 ? $tin->perm_line2.', ' : '' }}
                                                            {{ $tin->permThana }}, {{ $tin->permDistrict }}, {{ $tin->perm_post ?? '' }}
                                                    </span></p>
                                                    <p>5) Previous TIN : <span class="bold">Not Applicable</span></p>
                                                    <p>6) Status : <span class="bold">Individual</span></p>
                                                    <p style="margin-top:25px;">Date : <span>{{ \Carbon\Carbon::parse($tin->certDate ?? $tin->created_at)->format('d F Y') }}</span></p>
                                                </div>

                                                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:40px; position: relative; z-index: 10;">
                                                    <div style="width:32%; font-size:8px; line-height:1;">
                                                        <p class="bold" style="font-size:10px; margin-bottom:5px;"><u>Please Note:</u></p>
                                                        <p>1. A Taxpayer is liable to file the Return of Income under section 166 of the Income Tax Act, 2023.</p>
                                                        <p>2. Failure to file Return of Income under Section 166 is liable to–</p>
                                                        <p style="margin-left:5px;">(a) Penalty under section 266; and</p>
                                                        <p style="margin-left:5px;">(b) Prosecution under section 311 of the Income Tax</p>
                                                        <p style="margin-left:10px;">Act, 2023.</p>
                                                    </div>

                                                    <div style="text-align:center; width:33%; position:relative; transform:translateY(5px);">
                                                        @php
                                                            $qrData = "Taxpayer's Name : {$tin->name}\nDOB : {$tin->dob}\nFather's Name : {$tin->fatherName}\nTIN : ".($tin->tin_number ?? $tin->tin_num)."\nDate : ".($tin->certDate ?? $tin->created_at->format('Y-m-d'))."\nZone : {$tin->taxesZone}\nCircle : {$tin->taxesCircle}";
                                                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=H&qzone=1&data=".urlencode($qrData);
                                                        @endphp
                                                        <img src="{{ $qrUrl }}" width="210" height="210" style="border:0; pointer-events: none;">
                                                        <img src="https://kajnao.naturesblissbd.shop/nbr_qr_logo.jpg" style="position:absolute; top:50%; left:50%; width:25px; height:8px; transform:translate(-50%,-50%); border:none; background:white; pointer-events: none;">
                                                    </div>

                                                    <div style="width:32%; font-size:8px; text-align:left; line-height:1;">
                                                        <p class="bold">Deputy Commissioner of Taxes</p>
                                                        <p>{{ $tin->taxesCircle }}</p>
                                                        <p>Taxes Zone {{ $tin->taxesZone }}</p>
                                                        <p>Address: {{ $tin->officeAddress }}</p>
                                                        <p>Phone: {{ $tin->officePhone }}</p>
                                                    </div>
                                                </div>

                                                <p style="text-align:center; font-size:8px; margin-top:20px; text-decoration:underline;">
                                                    N.B: This is a system generated certificate and requires no manual signature.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Main Content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* CSS Variables */
        :root {
            --base-font: 13px;
            --title-font: 16px;
            --header-gap: 120px;
            --body-gap: 40px;
        }

        body { -webkit-user-select: none; user-select: none; }

        /* Screen Display Wrapper */
        .cert-preview-container {
            background: #525659;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            overflow-x: auto;
        }

        /* The A4 Certificate Box */
        .a4-cert {
            width: 210mm;
            height: 297mm;
            position: relative;
            background: url('assets/tinbg.jpg') center/cover no-repeat white !important;
            padding: 22mm 20mm;
            box-sizing: border-box;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            color: #000;
            font-family: 'Arial', sans-serif;
            flex-shrink: 0;
            line-height: 1.6;
        }

        /* Internal Elements */
        .logo-top { position: absolute; top: 25mm; left: 50%; transform: translateX(-50%); width: 75px; height: 75px; pointer-events: none;}
        .watermark { position: absolute; top: 42%; left: 50%; width: 310px; height: 300px; opacity: 0.25; transform: translate(-50%, -50%); z-index: 0; pointer-events: none; }
        .bold { font-weight: bold; }
        .cert-text p { margin: 0 0 3px 0; position: relative; z-index: 10; }
        .cert-text h3, .cert-text h4, .cert-text h5 { margin: 0; text-align: center; color: #000; position: relative; z-index: 10; }

        /* Control Buttons Floating */
        .floating-controls {
            position: fixed;
            top: 100px;
            right: 30px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* --- PRINT SETTINGS (CRITICAL) --- */
        @media print {
            /* Hide ALL Dashboard Elements */
            body * { visibility: hidden; }

            /* Hide Buttons */
            .floating-controls, .no-print, header, footer, .sidebar, .navbar { display: none !important; }

            /* Show Only Certificate */
            .a4-cert, .a4-cert * { visibility: visible; }

            /* Force Certificate to fill page */
            .a4-cert {
                position: fixed; left: 0; top: 0; margin: 0; padding: 22mm 20mm; width: 210mm; height: 297mm; z-index: 99999; box-shadow: none;
                background: url('assets/tinbg.jpg') center/cover no-repeat white !important;
                -webkit-print-color-adjust: exact; print-color-adjust: exact;
            }

            @page { size: A4; margin: 0; }
        }
    </style>
@endpush

@push('js')
    {{-- Optional: any additional JS for dynamic behavior can go here --}}
@endpush