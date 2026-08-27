<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print SSC Certificate</title>
    <style>
        @font-face {
            font-family: 'Minion Pro Semibold Italic';
            src: url('assets/media/card/minion-pro-semibold-italic.ttf') format('truetype');
            font-weight: 600;
            font-style: italic;
        }
        .print-area {
            position: relative;
            width: 1122px;
            height: 793px;
            margin: 30px auto;
            background: #fff;
            box-shadow: 0 4px 24px rgba(34,46,60,0.10);
        }
        .print-area img.bg-template {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            left: 0; top: 0;
            z-index: 1;
        }
        .data-field {
            position: absolute;
            font-family: 'Minion Pro Semibold Italic', serif;
            font-style: italic;
            color: #222;
            font-weight: 600;
            z-index: 2;
            white-space: pre;
        }
        /* Adjust these positions to match your template */
        /* Adjust these sizes to match your template */
        .serial { left: 230px; top: 118px; font-size: 32px; color:rgb(82, 13, 13); }
        .reg { left: 844px; top: 114px; font-size: 24px; }
        .dbcsc { left: 177px; top: 160px; font-size: 22px; }
        .name { left: 378px; top: 252px; width: 600px; font-size: 26px; }
        .father { left: 316px; top: 300px; width: 600px; font-size: 26px; }
        .mother { left: 146px; top: 350px; width: 600px; font-size: 26px; }
        .school { left: 146px; top: 410px; width: 900px; font-size: 26px; }
        .roll { left: 710px; top: 460px; font-size: 26px; }
        .group { left: 685px; top: 510px; font-size: 26px; }
        .gpa { left: 168px; top: 540px; font-size: 26px; }
        .dob { left: 784px; top: 569px; width: 500px; font-size: 26px; }
        .result_date { left: 337px; top: 718px; font-size: 18px; }
        .result_year { left: 820px; top: 204px; font-size: 26px; color:rgb(75, 114, 160); }
        .school_address { left: 244px; top: 458px; font-size: 26px; }
        @media print {
            body { background: #fff; }
            .print-btn, .print-header, header, footer, title { display: none !important; }
            .print-area { box-shadow: none; margin: 0; }
        }
        .print-btn {
            display: block;
            margin: 20px auto 0 auto;
            padding: 10px 32px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        .print-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    
    <button class="print-btn" onclick="window.print()">Print</button>
    <div class="print-area">
        <img src="{{ asset('assets\certificate/Template_page-0001 (1).jpg') }}" class="bg-template" alt="Template">
        <div class="data-field serial">{{ $ssc_certificate->serial_no_dbs }}</div>
        <div class="data-field reg">{{ $ssc_certificate->registration_no }}/{{ $ssc_certificate->registration_year }}</div>
        <div class="data-field dbcsc">{{ $ssc_certificate->dbcsc_no }}</div>
        <div class="data-field name">{{ $ssc_certificate->student_name }}</div>
        <div class="data-field father">{{ $ssc_certificate->father_name }}</div>
        <div class="data-field mother">{{ $ssc_certificate->mother_name }}</div>
        <div class="data-field school">{{ $ssc_certificate->school_name }}</div>
        <?php
        $roll_no = htmlspecialchars($ssc_certificate->roll_no);
        $roll_no_spaced = trim(chunk_split($roll_no, 2, ' '));
        ?>
        <div class="data-field roll"><?= $roll_no_spaced ?></div>
        <div class="data-field group"><?= htmlspecialchars($ssc_certificate->student_group) ?></div>
        <div class="data-field gpa"><?= htmlspecialchars($ssc_certificate->gpa) ?></div>
        <div class="data-field dob" >
            {{ $ssc_certificate->dob_day_month_words }}      
        </div>
        <div class="data-field dob" style="top: 602px; left: 22px; font-size: 26px;">
            {{ $ssc_certificate->dob_year_words }}
        </div>
        <div class="data-field result_date">{{ $ssc_certificate->publication_date }}</div>
        <div class="data-field result_year">{{ $ssc_certificate->publication_year }}</div>
        <div class="data-field school_address">{{ $ssc_certificate->school_address }}</div>
    </div>
</body>
</html>
