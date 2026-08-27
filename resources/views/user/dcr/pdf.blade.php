<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>DCR PDF</title>
<style>
@font-face { font-family: Nikosh; src:url('{{ public_path('assets/hi/Nikosh.ttf') }}') format('truetype'); font-weight: normal; font-style: normal; }


* { box-sizing:border-box; margin:0; padding:0; }
body { font-family:'Nikosh', sans-serif !important; font-size:11px; line-height:1.3; color:#000; background:#e5e7eb; }
.a4-page { width:210mm; min-height:297mm; padding:10mm 8mm; margin:10px auto; background:#fff; box-shadow:0 5px 15px rgba(0,0,0,.2); position:relative; overflow:hidden; }
.watermark { position:absolute; top:45%; left:50%; transform:translate(-50%,-50%); width:500px; opacity:.08; z-index:1; }
.content-wrapper { position:relative; z-index:2; }
.header-text { text-align:center; }
.header-text h1 { font-size:22px; margin-bottom:2px; }
.header-text h2 { font-size:20px; margin-bottom:2px; }
.header-text h3 { font-size:18px; margin-bottom:3px; }
.dcr-badge { display:inline-block; margin:5px 0 25px; font-size:26px; font-weight:700; }
.first-line { border-top:1px solid #000; width:100%; margin-bottom:10px; }
.data-table { width:100%; border-collapse:collapse; margin-bottom:5px; }
.data-table td { border:1px solid #000; padding:5px 6px; vertical-align:middle; font-size:15px; }
.text-center { text-align:center; }
.font-bold { font-weight:700; }
.footer-notes { margin-top:5px; border-top:1px solid #000; padding-top:20px; }
.footer-notes h4 { font-size:16px; margin-bottom:4px; }
.footer-notes p { font-size:14px; margin-bottom:4px; text-align:justify; }
.btn-bar { text-align:right; width:210mm; margin:10px auto; }
.btn-dcr { background:#2563eb; color:#fff; border:none; padding:8px 16px; cursor:pointer; border-radius:4px; font-family:sans-serif; font-weight:700; font-size:14px; text-decoration:none; display:inline-block; margin-left:5px; } .btn-dcr:hover { opacity:.85; }
@page { size:A4; margin:0; }
@media print { @page { size:A4; margin:3mm; } html, body { width:210mm; height:297mm; margin:0; padding:0; background:#fff; -webkit-print-color-adjust:exact; print-color-adjust:exact; } .btn-bar { display:none!important; } .a4-page { width:210mm; min-height:297mm; margin:0; padding:5mm 4mm; box-shadow:none; border:none; overflow:visible; } .footer-notes { page-break-inside:avoid; } }
</style>
</head><body>
<div class="a4-page" id="printableArea">
    @if($dcr->office_logo)
    <img class="watermark" src="{{ asset($dcr->office_logo) }}" alt="">
    @endif
    <div class="content-wrapper">
        <div class="header-text">
            <h1>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
            <h2>ভূমি অফিস</h2>
            <h3>{{ $dcr->office_address }}</h3>
            <div class="dcr-badge">Duplicate Carbon Receipt</div>
        </div>
        <div class="first-line"></div>
        <table class="data-table"><tr>
            <td style="width:25%">অনলাইন ডিসিআর নম্বর</td>
            <td style="width:30%">{{ $dcr->dcr_no }}</td>
            <td style="width:25%">জমার তারিখ</td>
            <td style="width:20%">{{ $dcr->deposit_date }}</td>
        </tr></table>
        <table class="data-table"><tr>
            <td style="width:25%">আবেদনকারীর নাম</td>
            <td style="width:75%">{{ $dcr->applicant_name }}</td>
        </tr></table>
        <table class="data-table"><tr>
            <td style="width:25%">আবেদনকারীর ঠিকানা</td>
            <td style="width:75%">{{ $dcr->applicant_address }}</td>
        </tr></table>
        <table class="data-table"><tr>
            <td style="width:25%">আবেদন নম্বর</td>
            <td style="width:75%">{{ $dcr->application_no }}</td>
        </tr></table>
        <table class="data-table"><tr>
            <td style="width:25%">মিউটেশন মামলা নম্বর</td>
            <td style="width:25%">{{ $dcr->mutation_case_no }}</td>
            <td style="width:25%">মিউটেশন আদেশের তারিখ</td>
            <td style="width:25%">{{ $dcr->mutation_order_date }}</td>
        </tr></table>
        <table class="data-table">
            <tr><td rowspan="3" style="width:25%;vertical-align:middle;">জমির তফসিল</td>
                <td style="text-align:center;">মৌজা</td><td style="text-align:center;">জে এল নম্বর</td><td style="text-align:center;">আগত খতিয়ানের ধরণ</td><td style="text-align:center;">আগত খতিয়ানের নং</td><td style="text-align:center;">দাগ নং</td><td style="text-align:center;">জমির পরিমাণ</td></tr>
            <tr><td style="text-align:center;">{{ $dcr->mouza }}</td><td style="text-align:center;">{{ $dcr->jl_no }}</td><td style="text-align:center;">{{ $dcr->prev_khatian_type }}</td><td style="text-align:center;">{{ $dcr->prev_khatian_no }}</td><td style="text-align:center;">{{ $dcr->dag_no }}</td><td style="text-align:center;">{{ $dcr->land_amount }}</td></tr>
            <tr><td colspan="3" style="text-align:center;">মোট জমির পরিমাণ</td><td colspan="3" style="text-align:center;">{{ $dcr->total_land_amount }}</td></tr>
        </table>
        <table class="data-table" style="text-align:left;">
            <tr><td rowspan="3" style="width:25%;vertical-align:middle;">ফি সংক্রান্ত তথ্য</td><td style="width:20%">বিবরণ</td><td style="width:55%">পরিমাণ (টাকায়)</td></tr>
            <tr><td>ডিসিআর ফি</td><td>{{ number_format((float)$dcr->dcr_fee, 2) }}/=</td></tr>
            <tr><td class="font-bold">সর্বমোট</td><td class="font-bold">{{ number_format((float)$dcr->grand_total, 2) }}/=</td></tr>
        </table>
        <table style="width:100%;margin-top:10px;border:none;">
            <tr>
                <td style="width:35%;text-align:center;vertical-align:middle;border:none;">
                    @if($dcr->unique_code)
                    <img src="data:image/png;base64,{{ $dcr->unique_code }}" style="width:80px;padding:1px;" alt="QR">
                    <p style="margin-top:0;font-size:10px;">ভেরিফাই কোড</p>
                    @endif
                </td>
                <td style="width:30%;text-align:center;vertical-align:middle;border:none;">
                    @if($dcr->office_logo)
                    <img src="{{ asset($dcr->office_logo) }}" style="width:80px;" alt="Logo">
                    @endif
                </td>
                <td style="width:35%;text-align:center;vertical-align:middle;border:none;">
                    <p style="margin-bottom:2px;">স্বাক্ষর</p>
                    @if($dcr->signature_img)
                    <div style="height:40px;"><img src="{{ asset($dcr->signature_img) }}" style="width:175px;" alt=""></div>
                    @endif
                    <p style="font-size:14px;color:#d307e6;border-top:1px solid #d307e6;padding-top:5px;">{{ $dcr->commissioner_name }}</p>
                    <p style="color:#d307e6;font-size:12px;">ভূমি কমিশনার (স্বাক্ষর)</p>
                    <p style="color:#d307e6;font-size:12px;">{{ $dcr->office_address }}</p>
                </td>
            </tr>
        </table>
                <div class="footer-notes">
            <h4>বিশেষ দ্রষ্টব্যঃ</h4>
            <p>১। ভূমি মন্ত্রণালয়ের স্মারক নং ৩১.০০.০০০০.০৪২.৮.০১১.২০-৫৫৯; তারিখঃ ০২-১১-২০২১ খ্রিঃ এর পরিপত্র মোতাবেক অনলাইন ডিসিআর (DCR) ম্যানুয়াল পদ্ধতিতে প্রদত্ত ডিসিআর-এর সমতুল্য। ইহা আইনগতভাবে বৈধ ও সর্বক্ষেত্রে গ্রহণযোগ্য হবে।</p>
            <p>২। অনলাইন ডিসিআর (DCR) এর সঠিকতা যাচাইয়ের জন্য কিউআর (QR) কোডটি স্ক্যান করে যাচাই করতে পারবেন।</p>
            <p>৩। ভূমি অফিস থেকে ম্যানুয়াল ডিসিআর সংগ্রহ করার প্রয়োজনীয়তা নেই।</p>
            <p>৪। ভূমি বিষয়ক যেকোন তথ্য বা পরামর্শের জন্য ১৬১২২ নম্বরে কল করুন।</p>
        </div></div>
</div>
</body></html>
