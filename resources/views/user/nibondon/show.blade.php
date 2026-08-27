<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        });
    </script>
    <title>PDF-{{ $nibondon->district_info_bn }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets/hi/card.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/hi/bn-font.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=REM:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=REM:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
    <style>
        /* print.css */
        @page {
            margin: 0; /* Set the margin to none */
            size: A4;  /* Set the page size to A4 */
        }
    </style>
</head>

<body>
    <div class="a4_page" id="a4_page">
        <div class="main_wrapper">
            <img src="{{ asset('assets/hi/ri_1.png') }}" class="main_logo" alt="">

            <span style="z-index: 10;">
                <div class="mr_header">
                    <div class="left_part_assets/hidden"></div>
                    <div class="left_part">
                                                <img style="height:110px; width:110px;" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://bdris.gov.bd/certificate/verify?key=m5efR1pIXHzNF7p/Jpv9yg+m/QcSP6ATHgKZU5eum/oJSbBisj0GKCwswKf+" alt="">
                        <h2><?php echo chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)); ?></h2>
                    </div>
                    <div class="middle_part">
                        <img src="{{ asset('assets/hi/bd_logo.png') }}" alt="" class="main_logo_r">
                        <img src="{{ asset('assets/hi/bd_logo.png') }}" alt="" style="opacity: 0;">
                        <h2 style="margin-right:-50px" >Government of the People’s Republic of Bangladesh</h2>
                        <p class="office">Office of the Registrar, Birth and Death Registration</p>
                        <p class="address1">{{ $nibondon->district_info_bn }}</p>
                        <p class="address2">{{ $nibondon->union_info_bn }}</p>
                        <p class="rule_y">(Rule 9, 10)</p>
                        <h1><span class="bn">জন্ম নিবন্ধন সনদ /</span> <span class="en" style="font-family: 'Roboto Slab', serif;">Birth Registration Certificate</span></h1>
                    </div>
                    <div class="right_part_assets/hidden"></div>
                    <div class="right_part">
                        <canvas style="height: 26px; width:220px; display: block;" id="barcode"></canvas>
                    </div>
                </div>

                <div class="mr_body">
                    <div class="top_part1">
                        <div class="left">
                            <p>Date of Registration</p>
                            <p>{{ \Carbon\Carbon::parse($nibondon->registration_date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="middle">
                            <h2>Birth Registration Number</h2>
                            <h1 style="font-weight:500 !important;"> {{ $nibondon->registration_no }} </h1>
                        </div>
                        <div class="right">
                            <p>Date of Issuance</p>
                            <p>{{ \Carbon\Carbon::parse($nibondon->issue_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>


                    <div class="middle">


                        <div style="margin-top: 2px;margin-bottom: 5px;" class="new_td_2">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">Date of Birth<span style="margin-left: 39px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ \Carbon\Carbon::parse($nibondon->date_of_birth)->format('d/m/Y') }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p><span style="margin-left: 95px;" class="clone">Sex :</span></p>
                                </div>
                                <div class="part2">
                                    <p><span>{{ $nibondon->gender }}</span></p>
                                </div>
                            </div>
                        </div>


                        <div style="margin-top: 5px;margin-bottom: 24px !important;" class="td">
                            <div class="left">
                                <div style="width: 126px;" class="part1">
                                    <p>In Word<span >:</span></p>
                                </div>
                                <div class="part2" style="width: 400px;">
                                    <p>
                                        <span style="margin-left:5px">
                                            {{ \App\Helpers\NumberToWords::dateToWords($nibondon->date_of_birth) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 7px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">নাম<span style="margin-left: 100px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="name_data_bn">
                                    <p><span  class="bn">{{ $nibondon->name_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Name<span style="margin-left: 95px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->name_en }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div id="mother_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">মাতা<span style="margin-left: 94px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="motherName_data_bn">
                                    <p><span class="bn">{{ $nibondon->mother_name_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Mother<span style="margin-left: 87px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->mother_name_en }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div id="motherNanality_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">মাতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ $nibondon->mother_nationality_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 64px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->mother_nationality_en }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">পিতা<span style="margin-left: 94px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="fatherName_data_bn">
                                    <p><span class="bn">{{ $nibondon->father_name_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Father<span style="margin-left: 91px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->father_name_en }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div id="fatherNanality_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">পিতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ $nibondon->father_nationality_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 65px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->father_nationality_en }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">জন্মস্থান<span style="margin-left: 78px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ $nibondon->birth_place_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="width: 153px; font-weight:500">Place of Birth<span style="margin-left: 46px;margin-right: 0;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ ucwords(strtolower($nibondon->birth_place_en)) }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 30px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p style="width: 146px;" class="bn">স্থায়ী ঠিকানা<span style="margin-left:53px;margin-right: 0;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ $nibondon->permanent_address_bn }}</span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="display:flex; width:154px; font-weight:500">Permanent<br>Address<span style="margin-left: 64px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500">{{ $nibondon->permanent_address_en }}</span></p>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </span>

            <div class="mr_footer">
                <div class="top">
                <div class="left">
                        <h2 style="width:10rem; margin-top: 0px;">Seal & Signature</h2>
                        <p style="margin-top: 0px;">Assistant to Registrar</p>
                        <p style="margin-top: 0px;">(Preparation, Verification)</p>
                    </div>
                    <div class="right">
                      <h2 style="width:10rem" >Seal & Signature<h2>
                        <p>Registrar</p>
                    </div>
                </div>
                <div style="margin-top:8rem"class="bottom">
                    <p>Tassets/his certificate is generated from bdris.gov.bd, and to verify tassets/his certificate, please scan the above QR Code & Bar Code.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        // Generate barcode
        JsBarcode("#barcode", "{{ $nibondon->registration_no }}", {
            format: "CODE128",
            displayValue: false,
            width: 1.5,
            height: 26,
            margin: 0,
            background: "#ffffff"
        });

        // Adjust margins based on content height
        $(document).ready(function() {
            const adjustMargin = (selector, target, threshold) => {
                if ($(selector).height() > threshold) {
                    $(target).css("margin-top", "17px");
                }
            };
            adjustMargin('#name_data_bn', '#mother_content', 23);
            adjustMargin('#motherName_data_bn', '#motherNanality_content', 23);
            adjustMargin('#fatherName_data_bn', '#fatherNanality_content', 23);
        });

        // Trigger print on page load or click
        window.onload = function() {
            window.print();
        };
        window.addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>