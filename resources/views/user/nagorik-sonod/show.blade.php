<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নাগরিক সনদ</title>
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ asset('assets/nagorikk/SolaimanLipi (1).ttf') }}') format('truetype');
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: #e0e0e0;
        }
        .certificate-container {
            width: 595px;
            height: 882px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            background: none;
            box-shadow: none;
        }
        .certificate-bg {
            display: block;
            max-width: 100%;
            height: auto;
        }
        .text-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .header-text, .label-text, .certificate-text {
            position: absolute;
            font-family: 'SolaimanLipi', sans-serif;
            margin: 0;
            padding: 0;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            z-index: 1000; /* Ensure it's above the certificate */
        }
        .print-button:hover {
            background: #0056b3;
        }
        @media print {
            @page {
                margin: 0;
            }
            html, body {
                width: 595px;
                height: 882px;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                transform: scale(1); /* Adjust scale if needed for print */
                transform-origin: top left;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Print Certificate</button>
    <div class="certificate-container">
        @php
            function convertToBengaliNumerals($number) {
                $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                $bengali_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
                return str_replace($english_digits, $bengali_digits, $number);
            }
            
            // QR Code data
            $qr_data = "Name: {$nagorik->name}\nNID: {$nagorik->nid_number}\nCertificate No: {$nagorik->certificate_number}";
            $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=" . urlencode($qr_data);
        @endphp

        <img class="certificate-bg" src="{{ asset('/assets/nagorikk/nagorik.jpg') }}" alt="Certificate">
        
        <div class="text-overlay">
            <div class="header-text" style="top: 7.71%; left: 26.55%; font-size: 36px;">{{ $nagorik->union_name }}</div>
            <div class="header-text" style="top: 11.90%; left: 33.61%; font-size: 14px;">{{ $nagorik->union_address }}</div>

            <div class="certificate-text" style="top: 24.40%; left: 27.80%; font-size: 22px; letter-spacing: 6.7px;">{{ $nagorik->certificate_number }}</div>
            
            <div class="label-text" style="top: 31.52%; left: 14.29%;">নাম:</div>
            <div class="certificate-text" style="top: 31.52%; left: 34.45%;">: {{ $nagorik->name }}</div>

            <div class="label-text" style="top: 34.24%; left: 14.29%;">পিতার নাম:</div>
            <div class="certificate-text" style="top: 34.24%; left: 34.45%;">: {{ $nagorik->father_name }}</div>

            <div class="label-text" style="top: 36.96%; left: 14.29%;">মাতার নাম:</div>
            <div class="certificate-text" style="top: 36.96%; left: 34.45%;">: {{ $nagorik->mother_name }}</div>

            <div class="label-text" style="top: 39.68%; left: 14.29%;">স্বামীর নাম:</div>
            <div class="certificate-text" style="top: 39.68%; left: 34.45%;">: {{ $nagorik->husband_name ?? 'N/A' }}</div>

            <div class="label-text" style="top: 42.40%; left: 14.29%;">ঠিকানা:</div>
            <div class="certificate-text" style="top: 42.40%; left: 34.45%;">: {{ $nagorik->address }}</div>

            <div class="label-text" style="top: 45.12%; left: 14.29%;">ওয়ার্ড নং:</div>
            <div class="certificate-text" style="top: 45.12%; left: 34.45%;">: {{ $nagorik->ward_no }}</div>

            <div class="label-text" style="top: 47.84%; left: 14.29%;">এনআইডি নম্বর:</div>
            <div class="certificate-text" style="top: 47.84%; left: 34.45%;">: {{ $nagorik->nid_number }}</div>

            <div class="label-text" style="top: 50.56%; left: 14.29%;">জন্ম তারিখঃ</div>
            <div class="certificate-text" style="top: 50.56%; left: 34.45%;">{{ \App\Helpers\CertificateDateFormatter::format($nagorik->birth_date) }}</div>

            <div class="label-text" style="top: 53.28%; left: 14.29%;">ইস্যু তারিখঃ</div> 
            <div class="certificate-text" style="top: 53.28%; left: 34.45%;">{{ \App\Helpers\CertificateDateFormatter::format($nagorik->issue_date) }}</div>

            <div class="label-text" style="top: 58.18%; left: 18.66%;"> অত্র ইউনিয়নের একজন স্থায়ী বাসিন্দা। তিনি জন্মগতভাবে বাংলাদেশী এবং আমার পরিচিত। </div>
            <div class="label-text" style="top: 60.66%; left: 14.29%;">আমি তাহার সর্বাঙ্গীণ মঙ্গল ও উন্নতি কামনা করি। </div>
        </div>

        <div class="qr-code" style="position: absolute; left: 8.91%; top: 71.32%;">
            <img src="{{ $qr_code_url }}" alt="QR Code">
        </div>
    </div>
</body>
</html>
