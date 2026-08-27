<!DOCTYPE html>
<html lang="en">

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
    <title>NID Card - {{ $englishName ?? $nidNumber ?? config('app.name') }}</title>
    <meta charset="utf-8"/>
    <style>
        @page {
            size: letter;
            margin: 0;
        }
    </style>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <link rel="stylesheet" href="{{ asset('assets/css/nid_css.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/e521caf613e4ad87.css') }}" data-n-g=""/>
    <style>
        @font-face {
            font-family: 'custom_arial';
            src: url('{{ asset('fonts/arial.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Bangla';
            src: url('{{ asset('fonts/Bangla.ttf') }}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @media print, screen and (max-width: 990px) {
            #nid_wrapper {
                transform: scale(1);
            }
        }

        @media print {
            .increase_decrease {
                display: none;
            }
            .back_button {
                display: none;
            }
        }

        .back_button {
            padding: 15px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            background: linear-gradient(-20deg, #b721ff 0%, #21d4fd 100%)
        }
    </style>
    <script src="{{ asset('assets/js/bcmath-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pdf417-min.js') }}" type="text/javascript"></script>
    <script>
        window.onload = function () {
            {{-- Build the PDF417 barcode payload dynamically from Blade variables --}}
            var hub3_code = '<pin>{{ $pin }}</pin>'
                + '<name>{{ $englishName }}</name>'
                + '<DOB>{{ $formattedDob }}</DOB>'
                + '<FP></FP>'
                + '<F>Right Index</F>'
                + '<TYPE>{{ $bloodGroup }}</TYPE>'
                + '<V>2.0</V>';

            PDF417.init(hub3_code);
            var barcode = PDF417.getBarcodeArray();

            var bw = 2;
            var bh = 2;

            var canvas = document.createElement('canvas');
            canvas.width = bw * barcode['num_cols'];
            canvas.height = bh * barcode['num_rows'];
            document.getElementById('barcode').appendChild(canvas);

            var ctx = canvas.getContext('2d');

            var y = 0;
            for (var r = 0; r < barcode['num_rows']; ++r) {
                var x = 0;
                for (var c = 0; c < barcode['num_cols']; ++c) {
                    if (barcode['bcode'][r][c] == 1) {
                        ctx.fillRect(x, y, bw, bh);
                    }
                    x += bw;
                }
                y += bh;
            }
        }
    </script>
</head>

<body>
<div id="__next" data-reactroot="">
    <main>
        <div>
            <main class="w-full overflow-hidden">
                <div class="container w-full py-12 lg:flex lg:items-start" style="padding-top: 0;">
                    <div class="w-full lg:pl-6">
                        <div class="flex items-center justify-center">
                            <div class="w-full">
                                <div class="flex items-start gap-x-2 bg-transparent mx-auto w-fit" id="nid_wrapper"
                                     style="margin-top: 10px;">

                                    {{-- ===== NID FRONT ===== --}}
                                    <div id="nid_front" class="w-full border-[1.999px] border-black">
                                        <header class="px-1.5 flex items-start gap-x-2 justify-between relative">
                                            <img class="w-[38px] absolute top-1.5 left-[4.5px]"
                                                 src="{{ asset('assets/images/map-logo.jpg') }}"/>
                                            <div class="w-full h-[60px] flex flex-col justify-center">
                                                <h3 style="font-size:20px"
                                                    class="text-center font-medium tracking-normal pl-11 bn leading-5">
                                                    <span style="margin-top:1px;display:inline-block">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span>
                                                </h3>
                                                <p class="text-[#007700] text-right tracking-[-0rem] leading-3 gov_text_for_mobile"
                                                   style="font-size:11.46px;font-family:custom_arial;margin-bottom:-0.02px">
                                                    Government of the People&#x27;s Republic of Bangladesh
                                                </p>
                                                <p class="text-center font-medium pl-10 leading-4" style="padding-top:0px">
                                                    <span class="text-[#ff0002]" style="font-size:10px;font-family:custom_arial">National ID Card</span>
                                                    <span class="ml-1" style="display:inline-block">
                                                        <span style="font-size:13px;font-family:custom_arial">/</span>
                                                    </span>
                                                    <span class="bn ml-1" style="font-size:13.33px">জাতীয় পরিচয় পত্র</span>
                                                </p>
                                            </div>
                                        </header>

                                        <div class="w-[101%] -ml-[0.5%] border-b-[1.9999px] border-black"
                                             style="width: 100%;margin-left: 0;"></div>

                                        <div class="pt-[3.8px] pr-1 pl-[2px] bg-center w-full flex justify-between gap-x-2 pb-5 relative">
                                            <div class="absolute inset-x-0 top-[2px] mx-auto z-10 flex items-start justify-center">
                                                <img style="background:transparent;width: 114px;height: 114px;"
                                                     class="ml-[20px] w-[125px] h-[116px]"
                                                     src="{{ asset('assets/images/flower-logo.png') }}" alt=""/>
                                            </div>

                                            <div class="relative z-50">
                                                <img style="margin-top:-2px" id="userPhoto" class="w-[68.2px] h-[78px]"
                                                     alt=""
                                                     src="{{ $photo ? asset($photo) : asset('assets/images/placeholder.png') }}"/>
                                                <div class="text-center text-xs flex items-start justify-center pt-[5px] w-[68.2px] mx-auto h-[38.5px] overflow-hidden"
                                                     id="card_signature">
                                                    @if($signature)
                                                        <img id="user_sign" style="max-height: 100%;width:100%"
                                                             src="{{ asset($signature) }}" alt="">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="w-full relative z-50">
                                                <div style="height:5px"></div>
                                                <div class="flex flex-col gap-y-[10px]" style="margin-top: 1px;">
                                                    <div>
                                                        <p class="space-x-4 leading-3" style="padding-left:1px">
                                                            <span class="bn" style="font-size:16.53px">নাম:</span>
                                                            <span class="" style="font-size:16.53px;padding-left:3px;-webkit-text-stroke:0.4px black"
                                                                  id="nameBn">{{ $banglaName }}</span>
                                                        </p>
                                                    </div>
                                                    <div style="margin-top: 1px;">
                                                        <p class="space-x-2 leading-3"
                                                           style="margin-bottom:-1.4px;margin-top:1.4px;padding-left:1px">
                                                            <span style="font-size:10px">Name: </span>
                                                            <span style="font-size:12.73px;padding-left:1px"
                                                                  id="nameEn">{{ $englishName }}</span>
                                                        </p>
                                                    </div>
                                                    <div style="margin-top: 1px;">
                                                        <p class="bn space-x-3 leading-3" style="padding-left:1px">
                                                            <span id="fatherOrHusband" style="font-size:14px;">পিতা: </span>
                                                            <span style="font-size:14px;transform:scaleX(0.724)"
                                                                  id="card_father_name">{{ $fatherName }}</span>
                                                        </p>
                                                    </div>
                                                    <div style="margin-top: 1px;">
                                                        <p class="bn space-x-3 leading-3"
                                                           style="margin-top:-2.5px;padding-left:1px">
                                                            <span style="font-size:14px">মাতা: </span>
                                                            <span style="font-size:14px;transform:scaleX(0.724)"
                                                                  id="card_mother_name">{{ $motherName }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="leading-4" style="font-size:12px;margin-top:-1.2px">
                                                        <p style="margin-top:-2px">
                                                            <span>Date of Birth: </span>
                                                            <span id="card_date_of_birth" class="text-[#ff0000]"
                                                                  style="margin-left: -1px;">{{ $formattedDob }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="-mt-0.5 leading-4" style="font-size:12px;margin-top:-5px">
                                                        <p style="margin-top:-3px">
                                                            <span>ID NO: </span>
                                                            <span class="text-[#ff0000] font-bold"
                                                                  id="card_nid_no">{{ $nidNumber }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== NID BACK ===== --}}
                                    <div id="nid_back" class="w-full border-[1.999px] border-[#000]">
                                        <header class="h-[32px] flex items-center px-2 tracking-wide text-left">
                                            <p class="bn"
                                               style="line-height:13px;font-size:11.33px;letter-spacing:0.05px;margin-bottom:-0px">
                                                এই কার্ডটি গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সম্পত্তি। কার্ডটি ব্যবহারকারী ব্যতীত
                                                অন্য কোথাও পাওয়া গেলে নিকটস্থ পোস্ট অফিসে জমা দেবার জন্য অনুরোধ করা হলো।
                                            </p>
                                        </header>

                                        <div class="w-[101%] -ml-[0.5%] border-b-[1.999px] border-black"
                                             style="width: 100%;margin-left: 0;"></div>

                                        <div class="px-1 pt-[3px] h-[66px] grid grid-cols-12 relative"
                                             style="font-size:12px">
                                            <div class="col-span-1 bn px-1 leading-[11px]"
                                                 style="font-size:11.73px;letter-spacing:-0.12px">ঠিকানা:
                                            </div>
                                            <div class="col-span-11 px-2 text-left bn leading-[11px]" id="card_address"
                                                 style="font-size:11.73px;letter-spacing:-0.12px">
                                                {{ $address ?? $present_address }}
                                            </div>
                                            <div class="col-span-12 mt-auto flex justify-between">
                                                <p class="bn flex items-center font-medium"
                                                   style="margin-bottom:-5px;padding-left:0px">
                                                    <span style="font-size:11.6px">রক্তের গ্রুপ</span>
                                                    <span style="display:inline-block;margin-left:3px;margin-right:3px">
                                                        <span style="display:inline-block;font-size:11px;font-family:custom_arial;margin-top:2px;margin-bottom: 3px;">/</span>
                                                    </span>
                                                    <span style="font-size:9px">Blood Group:</span>
                                                    <b style="font-size:9.33px;margin-bottom:-1.7px;display:inline-block"
                                                       class="text-[#ff0000] mx-1 font-bold sans w-5"
                                                       id="card_blood">{{ $bloodGroup }}</b>
                                                    <span style="font-size:10.66px"> জন্মস্থান: </span>
                                                    <span class="ml-1" id="card_birth_place"
                                                          style="font-size:10.66px">{{ $birthPlace }}</span>
                                                </p>
                                                <div class="text-gray-100 absolute -bottom-[2px] w-[30.5px] h-[13px] -right-[2px] overflow-hidden"
                                                     style="margin-right: 1px;margin-bottom: 1px;">
                                                    <img src="{{ asset('assets/images/duddron.png') }}" alt=""/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-[101%] -ml-[0.5%] border-b-[1.999px] border-black"
                                             style="width: 100%;margin-left: 0;"></div>

                                        <div class="py-1 pl-2 pr-1">
                                            <img style="width: 85px; margin-left: 17px; margin-top:3px; margin-bottom: 5px; transform: scale(1, 1.3)"
                                                 src="{{ asset('assets/images/start_16_07_2025.png') }}"/>
                                            <div class="flex justify-between items-center -mt-[5px]">
                                                <p class="bn" style="font-size:14px">প্রদানকারী কর্তৃপক্ষের স্বাক্ষর</p>
                                                <span class="pr-4 bn" style="font-size:12px;padding-top:1px">
                                                    প্রদানের তারিখ:
                                                    <span class="ml-2.5" id="card_date">{{ $issueDate }}</span>
                                                </span>
                                            </div>
                                            <div id="barcode" class="w-full h-[39px] mt-1"
                                                 alt="NID Card Generator"
                                                 style="margin-top: 1.5px;height: 42px;margin-left: -3px;width: 101.5%;">
                                                <style>
                                                    canvas { width: 100%; height: 100%; }
                                                </style>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            {{-- Font size controls --}}
            <div class="increase_decrease">
                <div class="BanglaGroup group-button">
                    <button class="left-button" onclick="adjustFontSize('nameBn', fontSizeStep)">+</button>
                    <span>বাংলা নাম</span>
                    <button onclick="adjustFontSize('nameBn', -fontSizeStep)">-</button>
                </div>
                <div class="EnglishGroup group-button">
                    <button class="left-button" onclick="adjustFontSize('nameEn', fontSizeStep)">+</button>
                    <span>ইংরেজি নাম</span>
                    <button onclick="adjustFontSize('nameEn', -fontSizeStep)">-</button>
                </div>
                <div class="fatherGroup group-button">
                    <button class="left-button" onclick="adjustFontSize('card_father_name', fontSizeStep)">+</button>
                    <span>বাবার নাম</span>
                    <button onclick="adjustFontSize('card_father_name', -fontSizeStep)">-</button>
                </div>
                <div class="motherGroup group-button">
                    <button class="left-button" onclick="adjustFontSize('card_mother_name', fontSizeStep)">+</button>
                    <span>মায়ের নাম</span>
                    <button onclick="adjustFontSize('card_mother_name', -fontSizeStep)">-</button>
                </div>
                <button id="print_id" onclick="window.print();">প্রিন্ট আইডি</button>
            </div>

            <div style="display: flex; justify-content: center; margin-top: 10px;">
                <a href="{{ route('user.nid-card.index') }}" class="back_button">Back</a>
            </div>
        </div>
    </main>

    <script>
        window.print();
        var fontSizeStep = 0.5;

        function adjustFontSize(elementId, adjustment) {
            var element = document.getElementById(elementId);
            var currentFontSize = parseFloat(window.getComputedStyle(element).fontSize);
            element.style.fontSize = (currentFontSize + adjustment) + 'px';
        }
    </script>
</div>
</body>
</html>