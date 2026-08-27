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
    <title>NID Card V3 - {{ $englishName ?? $nidNumber ?? config('app.name') }}</title>
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
    <link rel="stylesheet" href="{{ asset('assets/css/s_v3.css') }}">
    <style>
        strong { font-weight: normal !important; }

        td.রক্তের.গ্রুপ { color: red; }
        td.নাম.\(বাংলা\) { font-weight: bold; }

        @media print {
            body::before { content: none !important; }
            a[href]:after { content: none !important; }
            @page { margin: 0; }
            body { margin: 0; transform: scale(0.95); }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="sub_container">
        <div class="header">
            <div class="header_top">
                <img src="{{ asset('assets/images/logo-server-copy.svg') }}" alt="" class="logo">
                <p class="text_one text">বাংলাদেশ নির্বাচন কমিশন</p>
                <p class="text_two text">নির্বাচন কমিশন সচিবালয়</p>
                <p class="text_three text">জাতীয় পরিচয় নিবন্ধন অনুবিভাগ</p>
            </div>
            <div class="user_photo">
                <img src="{{ $photo ? asset($photo) : asset('assets/images/placeholder.png') }}"
                     alt="" id="user_img">
                <div class="name">{{ $englishName }}</div>
            </div>
        </div>

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
                    @if($form_no)
                        <tr>
                            <td>ফরম নম্বর</td>
                            <td class="ফরম নম্বর">{{ $form_no }}</td>
                        </tr>
                    @endif
                    @if($voter_no)
                        <tr>
                            <td>ভোটার নম্বর</td>
                            <td class="ভোটার নম্বর">{{ $voter_no }}</td>
                        </tr>
                    @endif
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
                    <tr>
                        <td>রক্তের গ্রুপ</td>
                        <td class="রক্তের গ্রুপ">{{ $bloodGroup }}</td>
                    </tr>
                    <tr>
                        <td>জন্মস্থান</td>
                        <td class="জন্মস্থান">{{ $birthPlace }}</td>
                    </tr>
                    @if($nid->gender ?? null)
                        <tr>
                            <td>লিঙ্গ</td>
                            <td class="লিঙ্গ">{{ $nid->gender }}</td>
                        </tr>
                    @endif
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
                    @if($education)
                        <tr>
                            <td>শিক্ষাগত যোগ্যতা</td>
                            <td class="শিক্ষাগত যোগ্যতা">{{ $education }}</td>
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

    <div class="footer_text">
        <p style="text-align: center; color: red;">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</p>
        <p id="footer_english">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.</p>
    </div>
</div>
<script src="{{ asset('assets/js/server_vs1.js') }}"></script>
</body>

</html>