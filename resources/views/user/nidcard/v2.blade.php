<!DOCTYPE html>
<html>

<head>
<style>
@font-face {
    font-family: 'Solaiman Lipi';
    font-style: normal;
    font-weight: normal;
    src: url('/fonts/SolaimanLipi.woff2') format('woff2'),
         url('/fonts/SolaimanLipi.ttf') format('truetype');
}
@font-face {
    font-family: 'Solaiman Lipi';
    font-style: normal;
    font-weight: bold;
    src: url('/fonts/SolaimanLipi.woff2') format('woff2'),
         url('/fonts/SolaimanLipi.ttf') format('truetype');
}
body { font-family: 'Solaiman Lipi' !important; }
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NID Card V2 - {{ $englishName ?? $nidNumber ?? config('app.name') }}</title>
    <style>
        @font-face {
            font-family: 'Solaiman Lipi';
            font-display: swap;
            font-style: normal;
            font-weight: bold;
            src: url('{{ asset('fonts/solaimanlipi-bold-v1.0.woff2') }}') format('woff2'),
            url('{{ asset('fonts/solaimanlipi-bold-v1.0.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Solaiman Lipi';
            font-display: swap;
            font-style: normal;
            font-weight: normal;
            src: url('{{ asset('fonts/solaimanlipi-normal-v1.0.woff2') }}') format('woff2'),
            url('{{ asset('fonts/solaimanlipi-normal-v1.0.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Solaiman Lipi';
            font-display: swap;
            font-style: normal;
            font-weight: 300;
            src: url('{{ asset('fonts/solaimanlipi-thin-v1.0.woff2') }}') format('woff2'),
            url('{{ asset('fonts/solaimanlipi-thin-v1.0.ttf') }}') format('truetype');
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/s_v2.css') }}">
    <style>
        body {
            font-family: 'Solaiman Lipi', Arial, sans-serif;
            margin: auto;
            padding: 0;
            background-color: #f4f4f9;
            width: 210mm;
            height: 297mm;
        }
        div#image_text {
            text-align: center;
            font-weight: bold;
            color: rgb(255 224 0);
            font-family: arial;
            margin-top: -35px;
            margin-bottom: 30px;
            font-size: 17px;
            transform: scale(1, 1.1);
        }
        strong { font-weight: normal !important; }
        .flex { padding-top: 25px !important; }

        @media print {
            @page { margin: 0; }
            body { margin: 0; padding: 0; transform: none !important; }
            .container { position: static !important; border: 1px solid green !important; }
        }
        @media print and (max-width: 1024px) {
            @page { margin: 20px; }
            .container { border: 1px solid green !important; }
        }
        @media print and (min-width: 1025px) {
            .container { border: none !important; }
        }
        td.রক্তের.গ্রুপ { color: red; }
        td.নাম.\(বাংলা\) { font-weight: bold; }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <div class="header_logo">
            <img id="logo_img" src="{{ asset('assets/images/bg_img_v2.png') }}" alt="">
            <div id="image_text">National Identity Registration Wing (NIDW)</div>
        </div>
        <div class="header_top">
            <p class="text__one">Select Your Search Category</p>
            <div class="input_group">
                <input type="radio" name="radio" id="nid_vuter" checked="">
                <label class="nid_vuter_label" for="nid_vuter">Search By NID / Voter No.</label>
                <br>
                <input type="radio" name="radio" id="form_num">
                <label class="form_num_label" for="form_num">Search By Form No.</label>
            </div>
            <button class="button_top">Home</button>
            <div class="header_line"></div>
            <div class="search">
                <span id="nid_lavel">NID or Voter No*</span>
                <input type="text" style="color: #555" placeholder="NID" readonly="" id="nid_input"
                       value="{{ $nidNumber }}">
                <button class="submit_btn">Submit</button>
            </div>
        </div>

        <div class="flex">
            <div class="user">
                <div class="user_photo">
                    <img src="{{ $photo ? asset($photo) : asset('assets/images/placeholder.png') }}"
                         alt="" id="user_img">
                    <div class="name">{{ $englishName }}</div>
                    {{--
                        Dynamic QR code: encodes name, NID number, and date of birth.
                        Uses the free api.qrserver.com service (same as original).
                    --}}
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($englishName . ' ' . $nidNumber . ' ' . ($dateOfBirth ? $dateOfBirth->format('Y-m-d') : '')) }}"
                         alt="QR Code" id="qr_img">
                </div>
            </div>

            <div class="sub_container">
                {{-- জাতীয় পরিচিতি তথ্য --}}
                <div class="section">
                    <div class="section-title">জাতীয় পরিচিতি তথ্য</div>
                    <div class="section-content">
                        <table>
                            <colgroup><col><col></colgroup>
                            <tbody>
                            <tr>
                                <td>জাতীয় পরিচয় পত্র নম্বর</td>
                                <td class="জাতীয় পরিচয় পত্র নম্বর">{{ $nidNumber }}</td>
                            </tr>
                            <tr>
                                <td>পিন নম্বর</td>
                                <td class="পিন নম্বর">{{ $pin }}</td>
                            </tr>
                            <tr>
                                <td>ফরম নম্বর</td>
                                <td class="ফরম নম্বর">{{ $form_no }}</td>
                            </tr>
                            <tr>
                                <td>ভোটার নম্বর</td>
                                <td class="ভোটার নম্বর">{{ $voter_no }}</td>
                            </tr>
                            <tr>
                                <td>ভোটার এলাকা</td>
                                <td class="ভোটার এলাকা">{{ $vote_center }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ব্যক্তিগত তথ্য --}}
                <div class="section">
                    <div class="section-title">ব্যক্তিগত তথ্য</div>
                    <div class="section-content">
                        <table>
                            <colgroup><col><col></colgroup>
                            <tbody>
                            <tr>
                                <td>নাম (বাংলা)</td>
                                <td class="নাম (বাংলা)">{{ $banglaName }}</td>
                            </tr>
                            <tr>
                                <td>নাম (ইংরেজি)</td>
                                <td class="নাম (ইংরেজি)">{{ $englishName }}</td>
                            </tr>
                            <tr>
                                <td>জন্ম তারিখ</td>
                                <td class="জন্ম তারিখ">{{ $dateOfBirth }}</td>
                            </tr>
                            <tr>
                                <td>পিতার নাম</td>
                                <td class="পিতার নাম">{{ $fatherName }}</td>
                            </tr>
                            <tr>
                                <td>মাতার নাম</td>
                                <td class="মাতার নাম">{{ $motherName }}</td>
                            </tr>
                            @if($spouse_name)
                                <tr>
                                    <td>স্বামী/স্ত্রীর নাম</td>
                                    <td class="স্বামী/স্ত্রীর নাম">{{ $spouse_name }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- অন্যান্য তথ্য --}}
                <div class="section">
                    <div class="section-title">অন্যান্য তথ্য</div>
                    <div class="section-content">
                        <table>
                            <colgroup><col><col></colgroup>
                            <tbody>
                            @if($nid->gender ?? null)
                                <tr>
                                    <td>লিঙ্গ</td>
                                    <td class="লিঙ্গ">{{ $nid->gender }}</td>
                                </tr>
                            @endif
                            @if($education)
                                <tr>
                                    <td>শিক্ষাগত যোগ্যতা</td>
                                    <td class="শিক্ষাগত যোগ্যতা">{{ $education }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>রক্তের গ্রুপ</td>
                                <td class="রক্তের গ্রুপ">{{ $bloodGroup }}</td>
                            </tr>
                            <tr>
                                <td>জন্মস্থান</td>
                                <td class="জন্মস্থান">{{ $birthPlace }}</td>
                            </tr>
                            @if($religion)
                                <tr>
                                    <td>ধর্ম</td>
                                    <td class="ধর্ম">{{ $religion }}</td>
                                </tr>
                            @endif
                            @if($occupation)
                                <tr>
                                    <td>পেশা</td>
                                    <td class="পেশা">{{ $occupation }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- বর্তমান ঠিকানা --}}
                <div class="section">
                    <div class="section-title">বর্তমান ঠিকানা</div>
                    <div class="section-content">
                        <table>
                            <colgroup><col></colgroup>
                            <tbody>
                            <tr>
                                <td>{{ $present_address }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- স্থায়ী ঠিকানা --}}
                <div class="section">
                    <div class="section-title">স্থায়ী ঠিকানা</div>
                    <div class="section-content">
                        <table>
                            <colgroup><col></colgroup>
                            <tbody>
                            <tr>
                                <td>{{ $address }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer_text">
            <p style="text-align: center; color: red;">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</p>
            <p id="footer_english">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.</p>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/search_vs3.js') }}"></script>
</body>

</html>