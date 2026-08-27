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
            /* Added to prevent long content from overlapping */
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .certificate-text {
            font-size: 14px;
            color: #000;
            line-height: 1.5;
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
        .signature-area {
            position: absolute;
            bottom: 15%;
            right: 10%;
            text-align: center;
        }
        @media print {
            @page {
                margin: 0;
            }
            html, body {
                width: 595px;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                page-break-after: always;
                transform: scale(2);
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
    @php
        $itemsPerPage = 4;
        $totalPages = ceil(count($certificate->relatives) / $itemsPerPage);
    @endphp
    
    @for($page = 0; $page < $totalPages; $page++)
    <div class="certificate-container">
        <img class="certificate-bg" src="{{ asset('assets\uttoradhikar-sonod\bg-image.jpg') }}" alt="Certificate">
        <div class="text-overlay">
            <div class="header-text" style="top: 7.71%; left: 26.55%; font-size: 36px;">{{ $union_name }}</div>
            <div class="header-text" style="top: 11.90%; left: 34.61%; font-size: 14px;">{{ $union_address }}</div>
            <div class="certificate-text" style="top: 23.70%; left: 28.1%; font-size: 25px; letter-spacing: 6.7px; text-align: center;">
                {{ $certificate_number }}
            </div>
            <div class="certificate-text" style="top: 31.52%; left: 11.29%; font-size: 14px; line-height: 1.8; max-width: 86%;">
                এই মর্মে য়ারিশ সনদ ্রদান করা যচ্ছে যে, {{ $certificate->person_bn }},
                পিতা/সবামী: {{ $certificate->guardian_bn }},
                ওয়ার্ড না্বার: {{ $certificate->word_no }},
                গ্রাম: {{ $certificate->village_name }},
                ডাকঘ: {{ $certificate->post_office }},
                থান: {{ $certificate->thana }},
                পজেলা: {{ $certificate->upozila }},
                জেলা: {{ $certificate->zila }}
                @if($certificate->he_she_is === 'death')
                    <br>মৃত্যুকলে তিি নিম্লিখত ওয়ারিশগণকে রেখে যান。
                @endif
            </div>

            @if(!empty($certificate->relatives))
            <div class="certificate-text" style="top: 42%; left: 14.29%; font-size: 14px; width: 75%; max-height: 25%;">
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">ক্রমিক নং</th>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">াম</th>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">সম্পর্ক</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_slice($certificate->relatives, $page * $itemsPerPage, $itemsPerPage) as $index => $relative)
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;">{{ bn_number($page * $itemsPerPage + $index + 1) }}</td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;">{{ $relative['name_bn'] }}</td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;">{{ $relative['relation'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
           
            <div class="qr-code" style="position: absolute; left: 60px; bottom: 160px; width: 90px; height: 90px; background: white;">
                @php
                    $api_url = "https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=" . urlencode("http://clearance.amarnothi.com/verify/uttoradhikar/" . $certificate_number) . "&color=000&format=svg";
                @endphp
                <object data="{{ $api_url }}" type="image/svg+xml" style="width: 100%; height: 100%;"></object>
            </div>
           
        </div>
    </div>
    @endfor
</body>
</html>
