<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $license_no }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">



    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        #licence {
            width: 210mm;
            height: 297mm;
            position: relative;
            overflow: hidden;
        }

        .bg_img img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .bg_img img {
                display: block;
            }
        }

        /* text position css */
        .lic_text {
            position: absolute;
            top: 0;
            font-family: "Noto Sans TC", sans-serif;
            font-weight: 800;
            font-size: 14.3px;
        }

        .front {
            position: relative;
            margin-left: 264px;
        }

        .name {
            top: 150px;
            position: absolute;
            width: 350px;
        }

        .dob {
            top: 201px;
            position: absolute;
            width: 200px;
        }

        .bloodGroup {
            margin-top: 252px;
            position: absolute;
        }

        .fatherOrHusband {
            margin-top: 307px;
            position: absolute;
            width: 350px;
        }

        .issueValidity {
            top: 360px;
            position: absolute;
            width: 500px;
        }

        .validityDate,
        .authority {
            position: absolute;
            top: 0px;
            left: 229px;
            width: 200px;
        }

        .licenceAuth {
            top: 420px;
            position: absolute;
            width: 527px;
        }

        .user_photo_sign {
            position: absolute;
            top: 0;
        }

        .user_photo {
            width: 215px;
            height: 271px;
            overflow: hidden;
            margin-top: 148px;
            margin-left: 26px;
            position: relative;
        }

        .user_sign {
            overflow: hidden;
            width: 217px;
            height: 65px;
            margin-top: 8px;
            margin-left: 24px;
        }

        .user_photo_sign img {
            width: 100%;
            height: 100%;
        }

        .imgBlack img,
        .user_photo img {
            -webkit-filter: grayscale(100);
            filter: grayscale(100);
            opacity: 0.9;
        }

        .position_relative {
            position: absolute;
        }

        .user_back_two {
            width: 48px;
            position: absolute;
            top: 478px;
            left: 72px;
            height: 59px;
        }

        .user_back_one.imgBlack {
            width: 80px;
            margin-top: 105px;
            margin-left: 69px;
            height: 106px;
        }

        .imgBlack img {
            border-radius: 2px;
            opacity: 0.8;
        }

        .back {
            top: 617px;
            left: 218px;
            position: absolute;
        }

        .back_licence {
            left: 12px;
            position: absolute;
            top: 60px;
            font-size: 18px;
        }

        .address {
            top: 108px;
            width: 260px;
            position: absolute;
        }

        .refNo {
            position: absolute;
            left: 379px;
            top: 99px;
        }

        .issueBack {
            left: 379px;
            position: absolute;
            width: 100px;
            top: 136px;
        }

        .driveClass {
            top: 0px;
            margin-left: 4px;
            width: 270px;
            position: absolute;
        }

        div#class_driving {
            position: absolute;
            top: 243px;
            width: 281px;
        }

        /* ── TOP Code128 barcode ── */
        .forBarCode {
            position: absolute;
            left: 3px;
            top: 0;
            width: 466px;
            height: 43px;
            overflow: hidden;
            line-height: 0;
        }

        .forBarCode img {
            display: block;
            width: 466px;
            height: 43px;
        }

        /* ── SMALL Code128 above driving class ── */
        .driveClass .small-barcode-wrap {
            display: block;
            width: 466px;
            height: 43px;
            overflow: hidden;
            line-height: 0;
        }

        .driveClass .small-barcode-wrap img {
            display: block;
            width: 466px;
            height: 43px;
        }

        /* ── BOTTOM PDF417 barcode ───────────────────────────────────
           Image from bwipjs-api (same as reference PHP).
           542 × 120 px — same as original CSS.
        ────────────────────────────────────────────────────────────── */
        .barcode {
            top: 310px;
            margin-left: 10px;
            position: absolute;
        }

        .barcode img {
            width: 542px;
            height: 120px;
            display: block;
        }

        .user_photo_tr {
            position: absolute;
            left: 195px;
            width: 95px;
            top: 273px;
        }
    </style>
</head>

<body>
<div id="licence">
    <div id="imgText">

        <div class="bg_img">
            <img src="{{ asset('assets/driving/driving_bg.png') }}" alt="Driving Licence Background">
        </div>

        <div class="user_photo_sign">
            <div class="user_photo">
                <img src="{{ asset($photo_path) }}" alt="">
            </div>

            <div class="user_photo_tr">
                <img src="{{ asset('assets/driving/t_driving.png') }}" alt="">
            </div>

            <div class="user_sign">
                <img src="{{ asset($sign_path) }}" alt="">
            </div>

            <div class="position_relative">
                <div class="user_back_one imgBlack">
                    <img src="{{ asset($photo_path) }}" alt="">
                </div>
                <div class="user_back_two imgBlack">
                    <img src="{{ asset($photo_path) }}" alt="">
                </div>
            </div>
        </div>

        <div class="lic_text">

            <div class="front">
                <div class="name">{{ $name }}</div>
                <div class="dob">{{ convertToCustomDate($dob) }}</div>
                <div class="bloodGroup">{{ $blood_group }}</div>
                <div class="fatherOrHusband">{{ $father_or_husband }}</div>
                <div class="issueValidity">
                    <div class="issuDate">{{ convertToCustomDate($issue_date) }}</div>
                    <div class="validityDate">{{ convertToCustomDate($validity_date) }}</div>
                </div>
                <div class="licenceAuth">
                    <div class="licenceNo">{{ $license_no }}</div>
                    <div class="authority">{{ $authority }}</div>
                </div>
            </div>

            <div class="position_relative">
                <div class="back">

                    {{-- TOP Code128 barcode — bwipjs API --}}
                    <div class="forBarCode">
                        <img
                                src="https://bwipjs-api.metafloor.com/?bcid=code128&scaleX=3&scaleY=2&text={{ urlencode(json_encode(['LicenseNo' => $license_no])) }}"
                                alt="Code128 Barcode"
                        >
                    </div>

                    <div class="back_licence">{{ $license_no }}</div>

                    <div class="address">{{ $address }}</div>

                    <div class="position_relative">
                        <div class="refNo">{{ $reference_no }}</div>
                        <div class="issueBack">{{ convertToCustomDate($firstIssuDate) }}</div>
                    </div>

                    <div class="driveClass">
                        {{-- SMALL Code128 above driving class — bwipjs API --}}

                        <div id="class_driving">{{ $driving_class }}</div>
                    </div>

                    {{--
                        BOTTOM PDF417 barcode.
                        bwipjs public API — same URL as the reference PHP file.
                        $twoDBarCodeText is the JSON string built in the controller.
                    --}}
                    <div class="barcode">
                        <img
                                src="https://bwipjs-api.metafloor.com/?bcid=pdf417&scaleX=3&scaleY=2&text={{ urlencode($twoDBarCodeText) }}"
                                alt="PDF417 Barcode"
                        >
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ── Print after images are loaded ──
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>