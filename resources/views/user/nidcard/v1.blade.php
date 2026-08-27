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
    <title>NID Card V1 - {{ $englishName ?? $nidNumber ?? config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/s_v1.css') }}">
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

        td.রক্তের.গ্রুপ { color: red; }
        td.নাম.\(বাংলা\) { font-weight: bold; }

        @media print {
            @page { margin: 0; }
            body { margin: 0; }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <div class="header_top">
            <img src="{{ asset('assets/images/logo-server-copy.svg') }}" alt="" class="logo">
            <p class="text_one text">বাংলাদেশ নির্বাচন কমিশন</p>
            <p class="text_two text">নির্বাচন কমিশন সচিবালয়</p>
            <p class="text_three text">জাতীয় পরিচয় নিবন্ধন অনুবিভাগ</p>
        </div>
        <div class="user_photo">
            <img src="{{ $photo ? asset($photo) : asset('assets/images/placeholder.png') }}" alt="" id="user_img">
            <div style="text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 5px">
                {{ $englishName }}
            </div>
        </div>
    </div>

    <div class="sub_container">
        {{-- জাতীয় পরিচিতি তথ্য --}}
        <div class="section">
            <div class="section-title">জাতীয় পরিচিতি তথ্য</div>
            <div class="section-content">
                <table>
                    <colgroup><col><col></colgroup>
                    <tbody style="font-size: 13.5px;">
                    <tr>
                        <td style="padding: 4px;">জাতীয় পরিচয় পত্র নম্বর</td>
                        <td class="জাতীয় পরিচয় পত্র নম্বর" style="padding: 4px;">{{ $nidNumber }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">পিন নম্বর</td>
                        <td class="পিন নম্বর" style="padding: 4px;">{{ $pin }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">ফরম নম্বর</td>
                        <td class="ফরম নম্বর" style="padding: 4px;">{{ $form_no }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">ভোটার নম্বর</td>
                        <td class="ভোটার নম্বর" style="padding: 4px;">{{ $voter_no }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">ভোটার এলাকা</td>
                        <td class="ভোটার এলাকা" style="padding: 4px;">{{ $vote_center }}</td>
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
                    <tbody style="font-size: 13.5px;">
                    <tr>
                        <td style="padding: 4px;">নাম (বাংলা)</td>
                        <td class="নাম (বাংলা)" style="padding: 4px;">{{ $banglaName }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">নাম (ইংরেজি)</td>
                        <td class="নাম (ইংরেজি)" style="padding: 4px;">{{ $englishName }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">জন্ম তারিখ</td>
                        <td class="জন্ম তারিখ" style="padding: 4px;">{{ $dateOfBirth }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">পিতার নাম</td>
                        <td class="পিতার নাম" style="padding: 4px;">{{ $fatherName }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">মাতার নাম</td>
                        <td class="মাতার নাম" style="padding: 4px;">{{ $motherName }}</td>
                    </tr>
                    @if($spouse_name)
                        <tr>
                            <td style="padding: 4px;">স্বামী/স্ত্রীর নাম</td>
                            <td class="স্বামী/স্ত্রীর নাম" style="padding: 4px;">{{ $spouse_name }}</td>
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
                    <tbody style="font-size: 13.5px;">
                    @if($nid->gender ?? null)
                        <tr>
                            <td style="padding: 4px;">লিঙ্গ</td>
                            <td class="লিঙ্গ" style="padding: 4px;">{{ $nid->gender }}</td>
                        </tr>
                    @endif
                    @if($education)
                        <tr>
                            <td style="padding: 4px;">শিক্ষাগত যোগ্যতা</td>
                            <td class="শিক্ষাগত যোগ্যতা" style="padding: 4px;">{{ $education }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 4px;">রক্তের গ্রুপ</td>
                        <td class="রক্তের গ্রুপ" style="padding: 4px;">{{ $bloodGroup }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">জন্মস্থান</td>
                        <td class="জন্মস্থান" style="padding: 4px;">{{ $birthPlace }}</td>
                    </tr>
                    @if($religion)
                        <tr>
                            <td style="padding: 4px;">ধর্ম</td>
                            <td class="ধর্ম" style="padding: 4px;">{{ $religion }}</td>
                        </tr>
                    @endif
                    @if($occupation)
                        <tr>
                            <td style="padding: 4px;">পেশা</td>
                            <td class="পেশা" style="padding: 4px;">{{ $occupation }}</td>
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
                    <tbody style="font-size: 13.5px;">
                    <tr>
                        <td style="padding: 4px;">{{ $present_address }}</td>
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
                    <tbody style="font-size: 13.5px;">
                    <tr>
                        <td style="padding: 4px;">{{ $address }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer_text">
            <p style="text-align: center; color: red;">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</p>
            <p id="footer_english">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.</p>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/v1.js') }}"></script>
</body>

</html>