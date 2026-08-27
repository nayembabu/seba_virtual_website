@extends('user.layouts.app')
@section('title') @lang($title) @endsection
@push('style')
<style>
@font-face { font-family: Nikosh; src:url({{ asset('assets/hi/Nikosh.ttf') }}) format("truetype"); font-weight: normal; font-style: normal; }
body { font-family:'Nikosh', 'Open Sans', sans-serif; background:#525659; margin:0; padding:20px 0; display:flex; flex-direction:column; align-items:center; color:#000; -webkit-user-select:none; user-select:none; font-weight:normal; }
.no-print { margin-bottom:20px; text-align:center; }
.print-btn { background:#1a73e8; color:#fff; border:none; padding:10px 25px; font-size:16px; cursor:pointer; border-radius:5px; box-shadow:0 4px 6px rgba(0,0,0,0.2); display:inline-block; text-decoration:none; margin-left:5px; }
.print-btn:hover { background:#1557b0; }
.print-area { width:297mm; min-height:210mm; background:#fff; padding:15mm; position:relative; box-sizing:border-box; box-shadow:0 0 10px rgba(0,0,0,0.5); font-weight:normal; }
.watermark { position:absolute; top:55%; left:50%; transform:translate(-50%,-50%); width:450px; height:450px; background:url('https://upload.wikimedia.org/wikipedia/commons/8/84/Government_Seal_of_Bangladesh.svg') no-repeat center; background-size:contain; opacity:.20; z-index:0; pointer-events:none; }
.doc-header { display:flex; justify-content:space-between; position:relative; z-index:1; }
.qr-placeholder { width:85px; height:85px; text-align:center; padding-right:0; }
.header-info { text-align:left; font-size:10px; line-height:1.6; margin:0; padding-right:1px; font-weight:normal; }
.title-section h1 { text-align:center; font-size:20px; flex-grow:1; font-weight:normal; }
.title-section { margin:0; width:300px; font-size:20px; text-decoration:none; text-align:center; font-weight:normal; font-family:'Nikosh', Arial, sans-serif; }
.location-grid { display:flex; justify-content:space-between; margin:10px 0 20px 0; font-size:11px; font-weight:normal; border:none; z-index:1; position:relative; }
.khatian-table { width:100%; border-collapse:collapse; z-index:1; position:relative; table-layout:fixed; font-weight:normal; margin-bottom:50px; }
.khatian-table th, .khatian-table td { border:1px solid #000; padding:4px; font-size:10px; text-align:center; vertical-align:top; font-weight:normal; }
.khatian-table th { background:transparent; font-weight:normal; padding:4px; }
.foter-text { width:100%; font-size:7px; text-align:left; font-weight:normal; line-height:1.7; margin-top:15px; }
.data-block { padding:4px 0; display:flex; flex-direction:column; justify-content:flex-start; border-bottom:none; font-weight:normal; }
.data-block:last-child { border-bottom:none; }
.land-block { padding:0; min-height:0; line-height:1.2; justify-content:flex-start; }
.text-left { text-align:left; align-items:flex-start; padding-left:5px; line-height:1.4; font-weight:normal; }
.summary-row td { font-size:10px; height:35px; vertical-align:middle; font-weight:normal; }
.footer-signs { margin-top:90px; display:flex; justify-content:center; align-items:center; position:relative; z-index:1; font-weight:normal; clear:both; }
.sign-box { width:180px; border-top:1px solid #6a1b9a; padding-top:3px; color:#6a1b9a; text-align:center; position:relative; font-weight:normal; margin:0; }
.seal-container { position:absolute; left:calc(50% + 110px); width:150px; text-align:left; }
.seal-container img { width:90px; height:auto; opacity:1; }
.top-text { position:absolute; top:-50px; left:50%; transform:translateX(-50%); font-size:10px; font-weight:normal; color:#000; white-space:nowrap; }
.sign-box span:not(.top-text) { display:block; margin-top:2px; font-weight:normal; }
.sign-box .line1 { font-size:10px; line-height:1.2; font-weight:normal; }
.sign-box .line2 { font-size:10px; line-height:1.1; margin-top:2px; font-weight:normal; }
.sign-box .line3 { font-size:10px; line-height:1.1; margin-top:2px; font-weight:normal; }
@media print {
    body { background:transparent; padding:0; margin:0; display:block; }
    .no-print { display:none !important; }
    .print-area { display:block !important; border:none; box-shadow:none; margin:0 auto; width:297mm; min-height:209mm; padding:10mm 15mm; box-sizing:border-box; }
    .watermark { position:fixed !important; top:50% !important; left:50% !important; transform:translate(-50%,-50%) !important; }
    .header-wrapper { position:fixed; top:10mm; left:15mm; width:calc(297mm - 30mm); background:#fff; z-index:10; }
    .table-wrapper { margin-top:130px; }
    @page { size:A4 landscape; margin:0; }
    * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
}
</style>
@endpush

@section('content')
@php
    $owners = json_decode($khatian->owners_json ?? '[]', true);
    $lands = json_decode($khatian->lands_json ?? '[]', true);
    $max = max(count($owners), count($lands), 1);
@endphp
<div class="no-print">
    <button onclick="window.print()" class="print-btn"><i class="fas fa-print"></i> খতিয়ান প্রিন্ট করুন</button>
    <a href="javascript:history.back()" class="print-btn" style="background:#dc3545;"><i class="fas fa-arrow-left"></i> ফিরে যান</a>
</div>

<div class="print-area">
    <div class="watermark"></div>

    <div class="header-wrapper">
        <div class="doc-header">
            <div style="width:30%;font-size:11px;">বাংলাদেশ ফরম নং ৫৪৬২ (সংশোধিত)</div>
            <div class="title-section">খতিয়ান নং <span>{{ $khatian->khatian_no }}</span></div>
            <div style="width:50%;display:flex;justify-content:flex-end;align-items:flex-start;gap:5px;">
                <div class="qr-placeholder" style="width:80px;height:80px;text-align:center;flex-shrink:0;">
                    @if($khatian->unique_code)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(url('/verify/khatian/' . $khatian->unique_code)) }}" style="width:100%" alt="QR Code">
                    @endif
                </div>
                <div class="header-info" style="text-align:left;font-size:10px;line-height:1.6;">
                    আবেদন নম্বর: <span>{{ $khatian->app_no }}</span><br>
                    আবেদন তারিখ: <span>{{ $khatian->app_date }}</span><br>
                    মিউটেশন মামলা নং: <span>{{ $khatian->mutation_case_no }}</span><br>
                    অনলাইন ডিসিআর নং: <span>{{ $khatian->dcr_no }}</span><br>
                    খতিয়ান পরিচিতি নম্বর: <span>{{ $khatian->khatian_pid }}</span>
                </div>
            </div>
        </div>

        <div class="location-grid">
            <span>জেলা: <span>{{ $khatian->district }}</span></span>
            <span>উপজেলা/সার্কেল: <span>{{ $khatian->upazila }}</span></span>
            <span>মৌজা: <span>{{ $khatian->mouza }}</span></span>
            <span>জে.এল নং: <span>{{ $khatian->jl_no }}</span></span>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="khatian-table">
            <thead>
                <tr>
                    <th style="width:22%;padding:1px 4px;">মালিক, অকৃষি প্রজা বা ইজারাদারের নাম ও ঠিকানা</th>
                    <th style="width:4%;">অংশ</th>
                    <th style="width:8%;">মোট ভূমি উন্নয়ন কর</th>
                    <th style="width:4%;">দাগ নং</th>
                    <th style="width:8%;">জমির শ্রেণী</th>
                    <th style="width:11%;">দাগের মোট জমির পরিমাণ (একর)</th>
                    <th style="width:9%;">দাগের মধ্যে অত্র খতিয়ানের অংশ</th>
                    <th style="width:14%;">অংশানুযায়ী জমির পরিমাণ (একর)</th>
                    <th style="width:20%;">দখল/স্বত্ব বিষয়ক বা অন্যান্য বিষয়ে মন্তব্য</th>
                </tr>
                <tr>
                    <th>১</th><th>২</th><th>৩</th><th>৪</th><th>৫</th><th>৬</th><th>৭</th><th>৮</th><th>৯</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < $max; $i++)
                @php $o = $owners[$i] ?? []; $l = $lands[$i] ?? []; @endphp
                <tr>
                    <td>
                        <div class="data-block text-left" style="padding:2px 0;border:none;min-height:auto;margin-bottom:0;">
                            @if($o)
                            {{ $i+1 }}) {{ $o['name'] ?? '' }}<br>
                            পিতা/স্বামী: {{ $o['father'] ?? '' }}<br>
                            মাতা: {{ $o['mother'] ?? '' }}<br>
                            জাতীয় পরিচয়পত্র: {{ $o['nid'] ?? '' }}<br>
                            বাসা/হোল্ডিং: {{ $o['address'] ?? '' }}
                            @endif
                        </div>
                    </td>
                    <td><div style="padding:2px 0;border:none;">{{ $o['share'] ?? '' }}</div></td>
                    <td><div style="padding:2px 0;border:none;">{{ $o['tax'] ?? '' }}</div></td>
                    <td><div class="data-block land-block" style="border:none;">{{ $l['dag'] ?? '' }}</div></td>
                    <td><div class="data-block land-block" style="border:none;">{{ $l['agri'] ?? '' }}</div></td>
                    <td><div class="data-block land-block" style="border:none;">{{ $l['ta'] ?? '' }}</div></td>
                    <td><div class="data-block land-block" style="border:none;">{{ $l['ks'] ?? '' }}</div></td>
                    <td><div class="data-block land-block" style="border:none;">{{ $l['pa'] ?? '' }}</div></td>
                    <td><div class="data-block land-block text-left" style="border:none;white-space:pre-wrap;line-height:1.5;padding:4px;">{{ $l['rem'] ?? '' }}</div></td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr class="summary-row">
                    <td style="text-align:left;font-size:10px;font-weight:normal;line-height:1.2;">এস এ এন্ড টি এ্যাক্ট, ১৯৫০ এর ১৪৩ ও ১১৬/১১৭ ধারামতে আদেশ দেয়া হলো</td>
                    <td>{{ $max }}</td>
                    <td colspan="4" style="text-align:center;">হোল্ডিং নং: {{ $khatian->khatian_no }}</td>
                    <td style="text-align:right;padding-right:4px;">মোট জমি</td>
                    <td>{{ $khatian->total_land_val }}</td>
                    <td style="text-align:left;font-size:10px;">কথায়: <span>{{ $khatian->amount_in_words }}</span></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div>
        <div class="footer-signs">
            <div class="sign-box">
                <span class="top-text">অনুমোদিত খতিয়ান</span>
                <span class="line1">({{ $khatian->ac_name ?? '' }})</span>
                <span class="line2">সহকারী কমিশনার(ভূমি)</span>
                <span class="line3">উপজেলা ভূমি অফিস</span>
            </div>
            <div class="seal-container">
                @if($khatian->seal)
                <img src="{{ asset($khatian->seal) }}" alt="Seal">
                @endif
            </div>
        </div>
                <div class="foter-text">
            বিশেষ দ্রষ্টব্য:<br>
            ১। এই মিউটেশন খতিয়ানটি অনলাইন মিউটেশন সিস্টেম কর্তৃক প্রনীত। ইহা আইনগত ভাবে বৈধ ও সর্বক্ষেত্রে গ্রহণযোগ্য হবে।<br>
            ২। অনলাইন খতিয়ানের সঠিকতা যাচাইয়ের জন্য কিউআর(QR) কোডটি স্ক্যান করে ভূমি মন্ত্রণালয়ের ওয়েবসাইট থেকে যাচাই করতে পারবেন।<br>
            ৩। ভূমি অফিস থেকে ম্যানুয়াল খতিয়ান সংগ্রহ করার প্রয়োজনীয়তা নেই।<br>
            ৪। ভূমি বিষয়িক যেকোন পরামর্শের জন্য ১৬১২২ নম্বরে কল করুন।<br>
            ৫। খতিয়ান পরিচিতি নম্বর এর প্রথম ৬ ডিজিট জমির সংশ্লিষ্ট বিভাগ, জেলা উপজেলার জিও লোকেশন, পরবর্তী ১ ডিজিট আগত খতিয়ানের রেকর্ড; সি এস-১, এস এ-২, আর এস-৩, বি এস-৪, সিটি জরিপ-৫, নামজারি-৬, পরবর্তী ১ ডিজিট মালিকানা পরিচিতি;<br>
            ব্যাক্তি মালিকানাধীন -১,RJSC নিবন্ধিত প্রতিষ্ঠান-২, অন্যান্য প্রতিষ্ঠান বা সংস্থা-৩, পরবর্তী ২ ডিজিট খতিয়ানের অনুমোদনের মাস ও সর্বশেষ দুই ডিজিট বছর নির্দেশ করেছে।
        </div>
</div>
@endsection
@push('script')
<script>
document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
document.onkeydown = function(e) {
    if(e.keyCode == 123 || (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(e.keyCode)) || (e.ctrlKey && [85, 83].includes(e.keyCode))) {
        return false;
    }
};
</script>
@endpush
