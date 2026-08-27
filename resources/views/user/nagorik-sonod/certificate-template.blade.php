<!DOCTYPE html>
<html>
<head>
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ asset('fonts/SolaimanLipi.ttf') }}') format('truetype');
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
                transform: scale(2);
                transform-origin: top left;
            }
        }
    </style>
</head>
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Print Certificate</button>
    <div class="certificate-container">
        <img class="certificate-bg" src="{{ asset('assets\nagorik-sonod\dd_page-0001 (1).jpg') }}" alt="Certificate">
        <div class="text-overlay">
            <div class="header-text" style="top: 7.71%; left: 26.55%; font-size: 36px;">{{ $nagorikSonod->union_name }}</div>
            <div class="header-text" style="top: 11.90%; left: 33.61%; font-size: 14px;">{{ $nagorikSonod->union_address }}</div>

            <div class="certificate-text" style="top: 23.92%; left: 27.73%; font-size: 25px; letter-spacing: 6.7px;">{{ $nagorikSonod->certificate_number }}</div>
            
            <div class="label-text" style="top: 31.52%; left: 14.29%;">নাম:</div>
            <div class="certificate-text" style="top: 31.52%; left: 34.45%;">: {{ $nagorikSonod->name }}</div>

            <div class="label-text" style="top: 34.24%; left: 14.29%;">পিতার নাম:</div>
            <div class="certificate-text" style="top: 34.24%; left: 34.45%;">: {{ $nagorikSonod->father_name }}</div>

            <div class="label-text" style="top: 36.96%; left: 14.29%;">মাতার নাম:</div>
            <div class="certificate-text" style="top: 36.96%; left: 34.45%;">: {{ $nagorikSonod->mother_name }}</div>

            <div class="label-text" style="top: 39.68%; left: 14.29%;">স্বামীর নাম:</div>
            <div class="certificate-text" style="top: 39.68%; left: 34.45%;">: {{ $nagorikSonod->husband_name }}</div>

            <div class="label-text" style="top: 42.40%; left: 14.29%;">ঠিকানা:</div>
            <div class="certificate-text" style="top: 42.40%; left: 34.45%;">: {{ $nagorikSonod->address }}</div>

            <div class="label-text" style="top: 45.12%; left: 14.29%;">ওয়ার্ড নং:</div>
            <div class="certificate-text" style="top: 45.12%; left: 34.45%;">: {{ $nagorikSonod->ward_no }}</div>

            <div class="label-text" style="top: 47.84%; left: 14.29%;">এনআইডি নম্বর:</div>
            <div class="certificate-text" style="top: 47.84%; left: 34.45%;">: {{ $nagorikSonod->nid_number }}</div>

            <div class="label-text" style="top: 50.56%; left: 14.29%;">জন্ম তারিখ:</div>
            <div class="certificate-text" style="top: 50.56%; left: 34.45%;">: {{ $nagorikSonod->birth_date->format('d/m/Y') }}</div>

            <div class="label-text" style="top: 53.28%; left: 14.29%;">ইস্যু তারিখ:</div>
            <div class="certificate-text" style="top: 53.28%; left: 34.45%;">: {{ $nagorikSonod->issue_date->format('d/m/Y') }}</div>

            @if($photo_path)
            <div class="applicant-photo" style="position: absolute; right: 8.57%; top: 13.04%;">
                <img src="{{ $photo_path }}" alt="Applicant Photo" style="width: 78px; height: 91px; border: 1px solid #000;">
            </div>
            @endif

            <div class="label-text" style="top: 58.18%; left: 18.66%;"> অত্র ইউনিয়নের একজন স্থায়ী বাসিন্দা। তিনি জন্মগতভাবে বাংলাদেশী এবং আমার পরিচিত। </div>
            <div class="label-text" style="top: 60.66%; left: 14.29%;">আমি তাহার সর্বাঙ্গীণ মঙ্গল ও উন্নতি কামনা করি। </div>
        </div>

        <div class="qr-code" style="position: absolute; left: 8.91%; top: 71.32%;">
        <img src="{{ $qr_code }}" alt="QR Code">
    </div>
    </div>
    

</body>
</html>
