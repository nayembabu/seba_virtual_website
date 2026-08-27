<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>উত্তরাধিকার সনদ</title>
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('fonts/SolaimanLipi.ttf') format('truetype');
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
            z-index: 1000;
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
                transform: scale(1); /* Adjust scale if needed for print */
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
    <div class="certificate-container">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $certificate_year = htmlspecialchars($_POST['certificate_year'] ?? '');
                $union_name = htmlspecialchars($_POST['union_name'] ?? '');
                $union_address = htmlspecialchars($_POST['union_address'] ?? '');
                $ward_no = htmlspecialchars($_POST['ward_no'] ?? '');
                $village_name = htmlspecialchars($_POST['village_name'] ?? '');
                $post_office = htmlspecialchars($_POST['post_office'] ?? '');
                $thana = htmlspecialchars($_POST['thana'] ?? '');
                $upozila = htmlspecialchars($_POST['upozila'] ?? '');
                $zila = htmlspecialchars($_POST['zila'] ?? '');
                $gender = htmlspecialchars($_POST['gender'] ?? '');
                $he_she_is = htmlspecialchars($_POST['he_she_is'] ?? '');
                $death_certificates_id = htmlspecialchars($_POST['death_certificates_id'] ?? '');
                $dod = htmlspecialchars($_POST['dod'] ?? '');
                $person_bn = htmlspecialchars($_POST['person_bn'] ?? '');
                $guardian_bn = htmlspecialchars($_POST['guardian_bn'] ?? '');

                $relatives_names = $_POST['name_bn'] ?? [];
                $relatives_relations = $_POST['Relatives'] ?? [];

                $relatives = [];
                for ($i = 0; $i < count($relatives_names); $i++) {
                    if (!empty($relatives_names[$i])) {
                        $relatives[] = [
                            'name_bn' => htmlspecialchars($relatives_names[$i]),
                            'relation' => htmlspecialchars($relatives_relations[$i] ?? '')
                        ];
                    }
                }

                // Function to convert English numerals to Bengali numerals
                function convertToBengaliNumerals($number) {
                    $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                    $bengali_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
                    return str_replace($english_digits, $bengali_digits, $number);
                }

                // Generate a 16-digit certificate number: first 4 digits from selected year, rest are random/unique
                $certificate_full_number = $certificate_year . str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);

                // QR Code data
                $qr_data = "Person: $person_bn\nGuardian: $guardian_bn\nCertificate No: $certificate_full_number";
                $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=" . urlencode($qr_data) . "&color=000&format=svg";
        ?>
        <img class="certificate-bg" src="assets/uttoradhikar-sonod/bg-image.jpg" alt="Certificate">
        <div class="text-overlay">
            <div class="header-text" style="top: 7.71%; left: 26.55%; font-size: 36px;"><?php echo $union_name; ?></div>
            <div class="header-text" style="top: 11.90%; left: 34.61%; font-size: 14px;"><?php echo $union_address; ?></div>
            <div class="certificate-text" style="top: 23.70%; left: 28.1%; font-size: 25px; letter-spacing: 6.7px; text-align: center;">
                <?php echo convertToBengaliNumerals($certificate_full_number); ?>
            </div>
            <div class="certificate-text" style="top: 31.52%; left: 11.29%; font-size: 14px; line-height: 1.8; max-width: 86%;">
                এই মর্মে ওয়ারিশ সনদ প্রদান করা যাচ্ছে যে, <?php echo $person_bn; ?>,
                পিতা/স্বামী: <?php echo $guardian_bn; ?>,
                ওয়ার্ড নাম্বার: <?php echo convertToBengaliNumerals($ward_no); ?>,
                গ্রাম: <?php echo $village_name; ?>,
                ডাকঘর: <?php echo $post_office; ?>,
                থানা: <?php echo $thana; ?>,
                উপজেলা: <?php echo $upozila; ?>,
                জেলা: <?php echo $zila; ?>
                <?php if($he_she_is === 'death'): ?>
                    <br>মৃত্যুকালীন তিনি নিম্নলিখিত ওয়ারিশগণকে রেখে যান।
                <?php endif; ?>
            </div>

            <?php if(!empty($relatives)): ?>
            <div class="certificate-text" style="top: 42%; left: 14.29%; font-size: 14px; width: 75%; max-height: 25%;">
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">ক্রমিক নং</th>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">নাম</th>
                            <th style="border: 1px solid #000; padding: 5px; text-align: center;">সম্পর্ক</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($relatives as $index => $relative): ?>
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?php echo convertToBengaliNumerals($index + 1); ?></td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?php echo $relative['name_bn']; ?></td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?php echo $relative['relation']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            
            <div class="qr-code" style="position: absolute; left: 60px; bottom: 160px; width: 90px; height: 90px; background: white;">
                <img src="<?php echo $qr_code_url; ?>" alt="QR Code" style="width: 100%; height: 100%;">
            </div>
           
        </div>
        <?php
            } else {
                echo "<p style='text-align: center; margin-top: 50px; color: red;'>ফর্ম জমা দেওয়া হয়নি।</p>";
            }
        ?>
    </div>
</body>
</html>
