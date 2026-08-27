@extends('user.layouts.app')

@section('title')
    Return Make
@endsection

@push('css')
    <style>
        body {
            background: #e2e8f0;
            font-family: Arial, 'Noto Sans Bengali', sans-serif;
            -webkit-user-select: none;
            user-select: none;
            margin: 0;
            padding: 0;
        }

        .a4-container, .certificate-output {
            background: white;
            width: 794px;
            min-height: 1123px;
            padding: 5px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .document-to-print {
            user-select: none;
            -webkit-user-select: none;
        }

        img {
            pointer-events: none;
            -webkit-user-drag: none;
        }

        /* Controls */
        .controls {
            text-align: center;
            margin: 20px 0;
        }

        .print-btn {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            border: none;
            margin: 0 5px;
            transition: 0.3s;
            font-size: 14px;
        }

        .print-btn.cert { background: #16a34a; }
        .print-btn.back { background: #64748b; }
        .print-btn:hover { opacity: 0.9; }

        /* Language Switcher */
        .lang-switcher {
            background: #cbd5e1;
            padding: 4px;
            border-radius: 8px;
            display: inline-flex;
            gap: 4px;
        }

        .lang-switcher button {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .lang-active {
            background: white;
            color: #2563eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .lang-inactive {
            background: transparent;
            color: #475569;
        }

        /* Layout helpers */
        .flex { display: flex; }
        .inline-block { display: inline-block; }
        .grid { display: grid; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .flex-wrap { flex-wrap: wrap; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-justify { text-align: justify; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .font-bold { font-weight: 700; }
        .font-normal { font-weight: 400; }
        .italic { font-style: italic; }
        .underline { text-decoration: underline; }
        .whitespace-nowrap { white-space: nowrap; }
        .border-collapse { border-collapse: collapse; }
        .leading-tight { line-height: 1.25; }
        .leading-relaxed { line-height: 1.625; }

        /* Sizes */
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }

        /* Margins */
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-5 { margin-bottom: 1.25rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-7 { margin-bottom: 1.75rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-10 { margin-bottom: 2.5rem; }
        .mb-16 { margin-bottom: 4rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-10 { margin-top: 2.5rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-1-5 { margin-right: 0.375rem; }
        .ml-60px { margin-left: 60px; }

        /* TIN box */
        .tin-box {
            border: 1px solid black;
            width: 1.5rem;
            height: 1.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.375rem;
            background: white;
            font-weight: 700;
            font-size: 0.75rem;
        }

        /* Table */
        .return-table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 0.875rem;
            margin-bottom: 4rem;
            width: 360px;
            margin-left: 60px;
            transform: translateX(-0.6in);
            margin-top: 1rem;
        }

        .return-table td {
            border: 1px solid black;
            padding: 0.25rem 0.5rem;
        }

        /* Certificate grid */
        .cert-grid {
            display: grid;
            grid-template-columns: 240px 40px 1fr;
        }

        .cert-grid > div:nth-child(2) {
            text-align: right;
        }

        .cert-grid > div:nth-child(3) {
            padding-left: 1rem;
        }

        /* Colors */
        .text-gray-700 { color: #374151; }

        /* Max widths */
        .max-w-794 { max-width: 794px; }
        .max-w-450 { max-width: 450px; }
        .max-w-520 { max-width: 520px; }
        .max-w-535 { max-width: 535px; }
        .max-w-600 { max-width: 600px; }

        /* Translate */
        .translate-x-04 { transform: translateX(0.4in); }
        .translate-x-neg04 { transform: translateX(-0.4in); }

        /* Padding */
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .pl-4 { padding-left: 1rem; }

        /* Gap */
        .gap-5 { gap: 1.25rem; }

        .mt-0-7in { margin-top: 0.7in; }
        .mt-neg30 { margin-top: -30px; }

        /* eReturn logo color */
        .ereturn-logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #22c55e;
            letter-spacing: -1px;
            font-style: italic;
        }
        .ereturn-logo-text span {
            color: #1d4ed8;
        }

        @media print {
            .no-print { display: none !important; }
            .hidden-for-print { display: none !important; position: absolute; left: -9999px; }
            body { background: white; margin: 0; padding: 0; }
            .a4-container, .certificate-output {
                box-shadow: none;
                margin: 0 !important;
                width: 100%;
                display: block !important;
                border: none;
            }
            @page { size: A4 portrait; margin: 0; }
            html, body { height: 100%; overflow: hidden; }
        }
    </style>
@endpush

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="container-fluid py-3">

            {{-- Controls --}}
            <div class="controls no-print">
                <button class="print-btn back" onclick="window.history.back()">⬅️ Back</button>
                <button class="print-btn" onclick="printDocument('ack')">🖨️ Print Acknowledgement</button>
                <button class="print-btn cert" onclick="printDocument('cert')">🖨️ Print Certificate</button>
            </div>

            {{-- Header bar --}}
            <div class="flex justify-between items-center mb-4 max-w-794 mx-auto no-print">
                <h2 class="text-xl font-bold text-gray-700">Document Preview</h2>
                <div class="lang-switcher">
                    <button id="btn-lang-en" class="lang-active" onclick="switchLang('en')">English</button>
                    <button id="btn-lang-bn" class="lang-inactive" onclick="switchLang('bn')">Bangla</button>
                </div>
            </div>

            {{-- ======================================================= --}}
            {{-- ACKNOWLEDGEMENT SLIP - ENGLISH --}}
            {{-- ======================================================= --}}
            <div class="a4-container document-to-print" id="acknowledgement-slip-en">

                {{-- eReturn logo top right --}}
                <div class="flex justify-end items-center mb-0" style="margin-top: 30px; padding-top: 0; position: relative; z-index: 100;">
                    <div style="display: block; margin-right: 80px;">
                        <img src="{{ asset('assets/return/eReturn_logo_png.png') }}" width="100" alt="eReturn Logo">
                    </div>
                </div>

                {{-- Govt logo --}}
                <div class="flex justify-center mt-2 mb-3">
                    <img src="{{ asset('assets/return/bd-govt-logo.png') }}" width="80" alt="Bangladesh Government Logo">
                </div>

                {{-- Header text --}}
                <div class="text-center text-sm leading-tight font-bold">
                    <p>Government of the People's Republic of Bangladesh</p>
                    <p>National Board of Revenue</p>
                    <p>(Income Tax Office)</p>
                </div>

                <p class="text-center text-sm mt-3 mb-2 underline font-bold">Acknowledgement Receipt/Certificate of Return of Income</p>

                <p class="text-center text-sm mb-6">
                    <span class="font-bold">Assessment Year:</span>
                    <span class="font-normal">{{ $returnData->assessment_year }}</span>
                </p>

                {{-- Taxpayer Info --}}
                <div class="mx-auto text-sm max-w-450 translate-x-04">

                    <p class="mb-2">Name of the Taxpayer: <span>{{ $returnData->name }}</span></p>
                    <p class="mb-2">NID / Passport No (if No NID): <span>{{ $returnData->nid }}</span></p>

                    {{-- TIN boxes --}}
                    <div class="mb-2 flex items-center flex-wrap">
                        <span class="mr-2">TIN:</span>
                        <div class="flex">
                            @foreach(str_split($returnData->tin) as $digit)
                                <span class="tin-box">{{ $digit }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mb-5 flex-wrap">
                        <span>Circle: <span>{{ $returnData->circle }}</span></span>
                        <span class="inline-block translate-x-neg04">Taxes Zone: <span>{{ $returnData->zone }}</span></span>
                    </div>

                    <p class="mb-1">Total Income Shown: <span>{{ number_format($returnData->total_income, 0) }}</span> Taka</p>
                    <p class="mb-1">Total Tax Paid: <span>{{ number_format($returnData->paid_tax, 0) }}</span> Taka</p>

                    {{-- Return Register Table --}}
                    <table class="return-table">
                        <tr>
                            <td class="text-left">Serial No. of Return Register</td>
                            <td class="text-center font-normal">{{ $returnData->return_serial_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Volume No. of Return Register</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-left">Date of Return Submission</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($returnData->submission_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Seal and Signature --}}
                <div class="flex justify-between text-xs mb-10 mx-auto max-w-600 flex-wrap gap-5">
                    <span>Seal of Tax Office</span>
                    <span class="text-left max-w-600">Signature and Seal of the Official Receiving the Return</span>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center mb-6 mt-10">
                    {!! QrCode::size(75)->generate(url('/user/view_return/' . $returnData->id)) !!}
                </div>

                <p style="font-size: 14px; font-weight: bold; font-style: italic; text-align: center; margin-bottom: 64px;">
                    System generated document. No signature required.
                </p>

                <p class="text-xs text-center mx-auto max-w-520 mt-0-7in">
                    Please Visit: <strong>"https://etaxnbr.gov.bd"</strong> website to get Income Tax Certificate in Online
                </p>
            </div>

            {{-- ======================================================= --}}
            {{-- ACKNOWLEDGEMENT SLIP - BANGLA --}}
            {{-- ======================================================= --}}
            <div class="a4-container document-to-print" id="acknowledgement-slip-bn" style="display: none;">

                {{-- eReturn logo --}}
                <div class="flex justify-end items-center mb-0" style="margin-top: 30px; padding-top: 0; position: relative; z-index: 100;">
                    <div style="display: block; margin-right: 80px;">
                        <img src="{{ asset('assets/return/eReturn_logo_png.png') }}" width="100" alt="eReturn Logo">
                    </div>
                </div>

                <div class="flex justify-center mt-2 mb-3">
                    <img src="{{ asset('assets/return/bd-govt-logo.png') }}" width="80" alt="Bangladesh Government Logo">
                </div>

                <div class="text-center text-sm leading-tight font-bold">
                    <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
                    <p>জাতীয় রাজস্ব বোর্ড</p>
                    <p>(আয়কর অফিস)</p>
                </div>

                <p class="text-center text-sm mt-3 mb-2 underline font-bold">আয়কর রিটার্ন প্রাপ্তি স্বীকার পত্র/প্রত্যয়ন পত্র</p>

                <p class="text-center text-sm mb-6">
                    <span class="font-bold">করবর্ষ :</span>
                    <span class="font-normal">{{ $returnData->assessment_year }}</span>
                </p>

                <div class="mx-auto text-sm max-w-450 translate-x-04">

                    <p class="mb-2">করদাতার নাম: <span>{{ $returnData->name }}</span></p>
                    <p class="mb-2">জাতীয় পরিচয়পত্র নম্বর: <span>{{ $returnData->nid }}</span></p>

                    {{-- TIN boxes (Bengali numerals) --}}
                    <div class="mb-2 flex items-center flex-wrap">
                        <span class="mr-2">টি আইএন:</span>
                        <div class="flex">
                            @php
                                $bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                            @endphp
                            @foreach(str_split($returnData->tin) as $digit)
                                <span class="tin-box">{{ $bnDigits[(int)$digit] }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mb-5 flex-wrap">
                        <span>সার্কেল: <span>{{ $returnData->circle }}</span></span>
                        <span class="inline-block translate-x-neg04">কর অঞ্চল: <span>{{ $returnData->zone }}</span></span>
                    </div>

                    <p class="mb-1">প্রদর্শিত মোট আয়: <span>{{ number_format($returnData->total_income, 0) }}</span> টাকা</p>
                    <p class="mb-1">মোট পরিশোধিত কর: <span>{{ number_format($returnData->paid_tax, 0) }}</span> টাকা</p>

                    <table class="return-table">
                        <tr>
                            <td class="text-left">রিটার্ন রেজিস্টারের ক্রমিক নং</td>
                            <td class="text-center font-normal">{{ $returnData->return_serial_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-left">রিটার্ন রেজিস্টারের ভলিউম নং</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-left">রিটার্ন দাখিলের তারিখ</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($returnData->submission_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="flex justify-between text-xs mb-10 mx-auto max-w-600 flex-wrap gap-5">
                    <span>আয়কর অফিসের সিল</span>
                    <span class="text-left max-w-600">রিটার্ন গ্রহণকারী কর্মকর্তার স্বাক্ষর ও সিল</span>
                </div>

                <div class="flex justify-center mb-6 mt-10">
                    {!! QrCode::size(75)->generate(url('/user/view_return/' . $returnData->id)) !!}
                </div>

                <p style="font-size: 14px; font-weight: bold; font-style: italic; text-align: center; margin-bottom: 64px;">
                    সিস্টেম জেনারেটেড ডকুমেন্ট। কোন স্বাক্ষরের প্রয়োজন নেই।
                </p>

                <p class="text-xs text-center mx-auto max-w-520 mt-0-7in">
                    অনলাইনে আয়কর সার্টিফিকেট পেতে অনুগ্রহ করে: <strong>"https://etaxnbr.gov.bd"</strong> ওয়েবসাইট ভিজিট করুন।
                </p>
            </div>

            {{-- ======================================================= --}}
            {{-- TAX CERTIFICATE --}}
            {{-- ======================================================= --}}
            <div class="certificate-output document-to-print mt-4" id="tax-certificate">

                {{-- eReturn logo --}}
                <div class="flex justify-end items-center mb-0" style="margin-top: 30px; padding-top: 0; position: relative; z-index: 100;">
                    <div style="display: block; margin-right: 80px;">
                        <img src="{{ asset('assets/return/eReturn_logo_png.png') }}" width="100" alt="eReturn Logo">
                    </div>
                </div>

                {{-- Reference number --}}
                <div style="text-align: left; font-size: 11px; margin-bottom: 24px; padding-left: 545px;">
                    Reference Number: <span style="font-weight: normal;">{{ $returnData->return_serial_no }}</span>
                </div>

                {{-- Govt logo --}}
                <div class="mb-2 mt-neg30 text-center">
                    <img class="mx-auto" src="{{ asset('assets/return/bd-govt-logo.png') }}" width="60" alt="Bangladesh Government Logo">
                </div>

                {{-- Certificate Header --}}
                <div style="font-size: 12px; line-height: 1.25; margin-bottom: 1.75rem; text-align: center; font-weight: normal;">
                    <p>Government of the People's Republic of Bangladesh</p>
                    <p>National Board of Revenue</p>
                    <p>Income Tax Department</p>
                    <br>
                    <p>Income Tax Certificate</p>
                    <p>Assessment Year: <span>{{ $returnData->assessment_year }}</span></p>
                </div>

                {{-- Certificate Details --}}
                <div style="font-size: 12px; max-width: 535px; margin: 0 auto 2rem auto;">
                    <div class="cert-grid">
                        <div class="whitespace-nowrap">Taxpayer's Name</div>
                        <div>:</div>
                        <div>{{ $returnData->name }}</div>

                        <div class="whitespace-nowrap">Taxpayer's Identification Number (TIN)</div>
                        <div>:</div>
                        <div>{{ $returnData->tin }}</div>

                        <div>Father's Name</div>
                        <div>:</div>
                        <div>{{ $tinData->fatherName ?? $returnData->father_name }}</div>

                        <div>Mother's Name</div>
                        <div>:</div>
                        <div>{{ $tinData->motherName ?? $returnData->mother_name }}</div>

                        <div>Current Address</div>
                        <div>:</div>
                        <div>
                            @if($tinData)
                                {{ $tinData->curr_line1 }}{{ $tinData->curr_line2 ? ', ' . $tinData->curr_line2 : '' }},
                                {{ $tinData->currThana }}, {{ $tinData->currDistrict }}
                            @else
                                {{ $returnData->current_address }}
                            @endif
                        </div>

                        <div>Permanent Address</div>
                        <div>:</div>
                        <div>
                            @if($tinData)
                                {{ $tinData->perm_line1 }}{{ $tinData->perm_line2 ? ', ' . $tinData->perm_line2 : '' }},
                                {{ $tinData->permThana }}, {{ $tinData->permDistrict }}, Bangladesh
                            @else
                                {{ $returnData->permanent_address }}
                            @endif
                        </div>

                        <div>Status</div>
                        <div>:</div>
                        <div>Individual -&gt; Bangladeshi -&gt; Having NID</div>
                    </div>
                </div>

                {{-- Certificate Body Text --}}
                <div style="font-size: 12px; max-width: 535px; margin: 0 auto 2.5rem auto; line-height: 1.625; text-align: justify;">
                    <p>
                        This is to certify that <span class="font-normal">{{ $returnData->name }}</span> is a registered taxpayer of
                        <span class="font-normal">{{ $returnData->circle }}</span>, Taxes
                        <span class="font-normal">{{ $returnData->zone }}</span>.
                        The taxpayer has filed the return of income for the Assessment Year
                        <span class="font-normal">{{ $returnData->assessment_year }}</span>.
                        Shown Total Income <span class="font-normal">{{ number_format($returnData->total_income, 0) }}</span> BDT
                        and Paid Tax <span class="font-normal">{{ number_format($returnData->paid_tax, 0) }}</span> BDT.
                    </p>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center mb-10">
                    {!! QrCode::size(75)->generate(url('/user/view_return/' . $returnData->id)) !!}
                </div>

                <p style="font-size: 11px; text-align: center; font-weight: normal; font-style: italic;">
                    This is a system generated certificate, and requires no signature.
                </p>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        // Language switcher
        function switchLang(lang) {
            document.getElementById('acknowledgement-slip-en').style.display = (lang === 'en') ? 'block' : 'none';
            document.getElementById('acknowledgement-slip-bn').style.display = (lang === 'bn') ? 'block' : 'none';

            document.getElementById('btn-lang-en').className = (lang === 'en') ? 'lang-active' : 'lang-inactive';
            document.getElementById('btn-lang-bn').className = (lang === 'bn') ? 'lang-active' : 'lang-inactive';
        }

        // Print logic
        function printDocument(type) {
            if (type === "ack") {
                const isBnActive = document.getElementById("btn-lang-bn")
                    .classList.contains("lang-active");

                const targetId = isBnActive
                    ? "acknowledgement-slip-bn"
                    : "acknowledgement-slip-en";

                printDocumentById(
                    targetId,
                    "Return_Ack_{{ $returnData->tin }}"
                );
            } else {
                printDocumentById(
                    "tax-certificate",
                    "Tax_Certificate_{{ $returnData->tin }}"
                );
            }
        }
        function printDocumentById(divId, title = '') {
            const originalContent = document.body.innerHTML;
            const printContent = document.getElementById(divId).innerHTML;

            document.body.innerHTML = printContent;

            if (title) {
                document.title = title;
            }

            window.print();

            // Restore original page
            document.body.innerHTML = originalContent;

            // Reload scripts/styles if needed
            // window.location.reload();
        }
    </script>
@endpush