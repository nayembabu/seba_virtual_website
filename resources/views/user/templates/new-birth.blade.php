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
    <title><?php if(isset($data['brn'])){ echo $data['brn'];}?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ url('assets/new-birth') }}/main.css">
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
            <img src="{{ url('assets/new-birth') }}/img/ri_1.png" class="main_logo" alt="">
            <span style="z-index: 10;">
                <div class="mr_header">
                    <div class="left_part_hidden"></div>
                    <div class="left_part">
                        <?php
                            function generateRandomString_() {
                                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
                                $stringLength = mt_rand(50, 70);
                                $randomString = '';
                                for ($i = 0; $i < $stringLength; $i++) {
                                    $randomChar = $characters[mt_rand(0, strlen($characters) - 1)];
                                    $randomString .= $randomChar;
                                }
                                $randomString = preg_replace('/\//', '', $randomString, 1);
                                $position = mt_rand(0, strlen($randomString));
                                $randomString = substr_replace($randomString, '/', $position, 0);

                                return $randomString;
                            }
                            $randomText = generateRandomString_();

                            function generateRandomString5() {
                                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $randomString = '';
                                for ($i = 1; $i < 6; $i++) {
                                    $randomChar = $characters[mt_rand(0, strlen($characters) - 1)];
                                    $randomString .= $randomChar;
                                }
                                return $randomString;
                            }
                            $randomText5 = generateRandomString5();
                        ?>
                        <img style="height:110px; width:110px;" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://bdris.gov.bd/certificate/verify?key=<?php echo $randomText; ?>" alt="">
                        <h2><?php echo $randomText5;?></h2>
                    </div>
                    <div class="middle_part">
                        <img src="{{ url('assets/new-birth') }}/img/bd_logo.png" alt="" class="main_logo_r">
                        <img src="{{ url('assets/new-birth') }}/img/bd_logo.png" alt="" style="opacity: 0;">
                        <h2>Government of the People’s Republic of Bangladesh</h2>
                        <p class="office">Office of the Registrar, Birth and Death Registration</p>
                        <p class="address1"><?php if(isset($data['address1'])){ echo $data['address1'];}?></p>
                        <p class="address2"><?php if(isset($data['address2'])){ echo $data['address2'];}?></p>
                        <p class="rule_y">(Rule 11, 12)</p>
                        <h2><span class="bn">মৃত্যু নিবন্ধন সনদ /</span> <span class="en">Death Registration Certificate</span></h2>
                    </div>
                    <div class="right_part_hidden"></div>
                    <div class="right_part">
                        <canvas style="height: 26px; width:220px;" id="barcode"></canvas>
                    </div>
                </div>

                <div class="mr_body">
                    <div class="top_part1">
                        <div class="left">
                            <p>Date of Registration</p>
                            <p><?php if(isset($data['dor'])){ echo $data['dor'];}?></p>
                        </div>
                        <div class="middle">
                            <h2>Death Registration Number</h2>
                            <h1><?php if(isset($data['brn'])){ echo $data['brn'];}?></h1>
                        </div>
                        <div class="right">
                            <p>Date of Issuance</p>
                            <p><?php if(isset($data['doi'])){ echo $data['doi'];}?></p>
                        </div>
                    </div>


                    <div class="middle">
 <div style="margin-top: 2px;margin-bottom: 5px;" class="new_td_2">
        <div class="left">
            <div class="part1">
                <p class="bn">Date of Birth<span style="margin-left: 42px;" class="clone">:</span></p>
            </div>
            <div class="part2">
                <p><span class="bn"><?php if(isset($data['dob'])){ echo $data['dob'];}?></span></p>
            </div>
        </div>
    </div>


                        <div style="margin-top: 2px;margin-bottom: 5px;" class="new_td_2">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">Date of Death<span style="margin-left: 35px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span  class="bn"><?php if(isset($data['dod'])){ echo $data['dod'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p><span style="margin-left: 95px;" class="clone">Sex :</span></p>
                                </div>
                                <div class="part2">
                                    <p><span><?php if(isset($data['sex'])){ echo $data['sex'];}?></span></p>
                                </div>
                            </div>
                        </div>


                        <div style="margin-top: 5px;margin-bottom: 24px !important;" class="td">
                            <div class="left">
                                <div style="width: 130px;" class="part1">
                                    <p>In Word<span >:</span></p>
                                </div>
                                <div class="part2" style="width: 400px;">
                                    <?php
                                        function convertDateToEnglish($date) {
                                            $dateParts = explode('/', $date);

                                                      $day = isset($dateParts[0]) ? (int)$dateParts[0] : '';
                                                                        $month = isset($dateParts[1]) ?(int)$dateParts[1] : '';
                                                                        $year = isset($dateParts[2]) ? (int)$dateParts[2] : '';

                                            // months
                                            $months = array(
                                                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
                                                7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                            );
                                            // numbers
                                            $numbers = array(
                                                0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                                                7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                                                13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
                                                18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 21 => 'Twenty One', 22 => 'Twenty Two',
                                                23 => 'Twenty Three', 24 => 'Twenty Four', 25 => 'Twenty Five', 26 => 'Twenty Six', 27 => 'Twenty Seven',
                                                28 => 'Twenty Eight', 29 => 'Twenty Nine', 30 => 'Thirty', 31 => 'Thirty One', 32 => 'Thirty Two',
                                                33 => 'Thirty Three', 34 => 'Thirty Four', 35 => 'Thirty Five', 36 => 'Thirty Six', 37 => 'Thirty Seven',
                                                38 => 'Thirty Eight', 39 => 'Thirty Nine', 40 => 'Forty', 41 => 'Forty One', 42 => 'Forty Two',
                                                43 => 'Forty Three', 44 => 'Forty Four', 45 => 'Forty Five', 46 => 'Forty Six', 47 => 'Forty Seven',
                                                48 => 'Forty Eight', 49 => 'Forty Nine', 50 => 'Fifty', 51 => 'Fifty One', 52 => 'Fifty Two',
                                                53 => 'Fifty Three', 54 => 'Fifty Four', 55 => 'Fifty Five', 56 => 'Fifty Six', 57 => 'Fifty Seven',
                                                58 => 'Fifty Eight', 59 => 'Fifty Nine', 60 => 'Sixty', 61 => 'Sixty One', 62 => 'Sixty Two',
                                                63 => 'Sixty Three', 64 => 'Sixty Four', 65 => 'Sixty Five', 66 => 'Sixty Six', 67 => 'Sixty Seven',
                                                68 => 'Sixty Eight', 69 => 'Sixty Nine', 70 => 'Seventy', 71 => 'Seventy One', 72 => 'Seventy Two',
                                                73 => 'Seventy Three', 74 => 'Seventy Four', 75 => 'Seventy Five', 76 => 'Seventy Six', 77 => 'Seventy Seven',
                                                78 => 'Seventy Eight', 79 => 'Seventy Nine', 80 => 'Eighty', 81 => 'Eighty One', 82 => 'Eighty Two',
                                                83 => 'Eighty Three', 84 => 'Eighty Four', 85 => 'Eighty Five', 86 => 'Eighty Six', 87 => 'Eighty Seven',
                                                88 => 'Eighty Eight', 89 => 'Eighty Nine', 90 => 'Ninety', 91 => 'Ninety One', 92 => 'Ninety Two',
                                                93 => 'Ninety Three', 94 => 'Ninety Four', 95 => 'Ninety Five', 96 => 'Ninety Six', 97 => 'Ninety Seven',
                                                98 => 'Ninety Eight', 99 => 'Ninety Nine', 100 => 'One Hundred'
                                            );
                                            // days
                                            $days = array(
                                                1 => 'First',
                                                2 => 'Second',
                                                3 => 'Third',
                                                4 => 'Fourth',
                                                5 => 'Fifth',
                                                6 => 'Sixth',
                                                7 => 'Seventh',
                                                8 => 'Eighth',
                                                9 => 'Ninth',
                                                10 => 'Tenth',
                                                11 => 'Eleventh',
                                                12 => 'Twelfth',
                                                13 => 'Thirteenth',
                                                14 => 'Fourteenth',
                                                15 => 'Fifteenth',
                                                16 => 'Sixteenth',
                                                17 => 'Seventeenth',
                                                18 => 'Eighteenth',
                                                19 => 'Nineteenth',
                                                20 => 'Twentieth',
                                                21 => 'Twenty first',
                                                22 => 'Twenty second',
                                                23 => 'Twenty third',
                                                24 => 'Twenty fourth',
                                                25 => 'Twenty fifth',
                                                26 => 'Twenty Sixth',
                                                27 => 'Twenty Seventh',
                                                28 => 'Twenty Eighth',
                                                29 => 'Twenty Ninth',
                                                30 => 'Thirtieth',
                                                31 => 'Thirty first',
                                            );

                                            if($year < 2000){
                                                $yers_r = "Nineteen";
                                            }else{
                                                $yers_r = "Two Thousand";
                                            }

                                            $years_date = substr($year, -2);
                                            if($years_date == "00"){
                                                $new_years_date = "0";
                                            }else{
                                                $new_years_date = ltrim($years_date, '0');
                                            }

                                            $convert_date = $days[$day] . " Of " .$months[$month]." ".$yers_r." ".$numbers[$new_years_date];
                                            return $convert_date;
                                        }
                                    ?>

                                    <p><span style="margin-left:5px"><?php if(isset($data['dod'])){echo convertDateToEnglish($data['dod']);} ?></span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 7px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">নাম<span style="margin-left: 103px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="name_data_bn">
                                    <p><span  class="bn"><?php if(isset($data['name_bangla'])){ echo $data['name_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Name<span style="margin-left: 95px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['name_english'])){ echo $data['name_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                        <div id="mother_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">মাতা<span style="margin-left: 98px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="motherName_data_bn">
                                    <p><span class="bn"><?php if(isset($data['mother_bangla'])){ echo $data['mother_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Mother<span style="margin-left: 87px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['mother_english'])){ echo $data['mother_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                        <div id="motherNanality_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">মাতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn"><?php if(isset($data['mother_n_bangla'])){ echo $data['mother_n_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 64px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['mother_n_english'])){ echo $data['mother_n_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">পিতা<span style="margin-left: 96px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="fatherName_data_bn">
                                    <p><span class="bn"><?php if(isset($data['father_bangla'])){ echo $data['father_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Father<span style="margin-left: 91px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['father_english'])){ echo $data['father_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                        <div id="fatherNanality_content" style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">পিতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn"><?php if(isset($data['father_n_bangla'])){ echo $data['father_n_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 65px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['father_n_english'])){ echo $data['father_n_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 17px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">মৃত্যুস্থান<span style="margin-left: 78px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn"><?php if(isset($data['pob_bangla'])){ echo $data['pob_bangla'];}?></span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p style="width: 153px; font-weight:500">Place of Death<span style="margin-left: 37px;margin-right: 0;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500"><?php if(isset($data['pob_english'])){ echo $data['pob_english'];}?></span></p>
                                </div>
                            </div>
                        </div>

                      <div style="margin-top: 30px;" class="new_td">
    <div class="left">
        <div class="part1">
            <p style="width: 146px; font-weight: 500; margin: 0;" class="bn">
                মৃত্যুর কারন<span style="margin-left: 51px;" class="clone">:</span>
                <span style="font-size: 6px; display: block; margin-left: 0; margin-top: 10px;">
                    (আই সি ডি ভার্সন অনুসোর)
                </span>
            </p>
        </div>
        <div class="part2">
            <p>
                <span class="bn">
                    <?php if(isset($data['permanent_bangla'])){ echo $data['permanent_bangla']; }?>
                </span>
            </p>
        </div>
    </div>
    <div class="right">
    <div class="part1" style="margin-top: 0px;">
        <p style="width: 154px; font-weight: 500; margin: 0;" class="en">
            Cause of Death<span style="margin-left: 30px;" class="clone">:</span>
            <span style="font-size: 6px; display: block; margin-left: 0; margin-top: 10px;">
                (As Per ICD Version)
            </span>
        </p>
    </div>


        <div class="part2">
            <p>
                <span style="font-weight: 500">
                    <?php if(isset($data['permanent_english'])){ echo $data['permanent_english']; }?>
                </span>
            </p>
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
                    <p>This certificate is generated from bdris.gov.bd, and to verify this certificate, please scan the above QR Code & Bar Code.</p>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        let dob_n = "<?php echo $data['brn']?>";
        JsBarcode("#barcode", dob_n, {
            format: "CODE128",
            displayValue: false,
        });
    </script>

    <script>
        window.addEventListener('click', function(){
            window.print()
        });

        $(document).ready(function() {
            var elementWidth = $('#name_data_bn').height();
            if(Number(Math.floor(elementWidth)) > 23){
                $('#mother_content').css("margin-top", "0px");
            }

            var elementWidth = $('#motherName_data_bn').height();
            if(Number(Math.floor(elementWidth)) > 23){
                $('#motherNanality_content').css("margin-top", "0px");
            }

            var elementWidth = $('#fatherName_data_bn').height();
            if(Number(Math.floor(elementWidth)) > 23){
                $('#fatherNanality_content').css("margin-top", "0px");
            }
        });
    </script>


</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Style for the container that centers the button */
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Default style for the download button */
        .download-button {
            background-color: #0077cc;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        /* Media query to hide the button when printing */
        @media print {
            .download-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button class="download-button" id="downloadButton">Download as PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadButton').addEventListener('click', function () {
            const element = document.body;
            html2pdf()
                .from(element)
                .save();
        });
    </script>
</body>
</html>
