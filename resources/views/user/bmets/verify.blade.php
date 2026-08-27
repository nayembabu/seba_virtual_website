<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
    <style>
        @import  url('https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap');
        * {
            margin: 0;
        }

        body {
            background-image: url('{{ url('/assets/pdo') }}/img/certificate_bg.png');
            /* background-size: cover; */
            background-size: content;
            background-repeat: no-repeat;
            background-position: bottom;
            height: 533px;
        }

        .pto_top {
            text-align: center;
            padding: 20px 0;
        }

        .pto_top img {
            height: 80px;
            margin-bottom: 10px;
        }

        .pto_top h4 {
            font-size: 20px;
            text-transform: uppercase;
        }

        .pto_top p {
            margin-top: 5px;
        }

        .main_heading {
            font-family: 'Charm', cursive;
            font-size: 40px;
            color: #385C6B;
            margin: 15px 0;
            border-bottom: 1px dotted #385C6B;
            display: inline-block;
            padding: 10px 20%;
        }

        .pdo_main_content {
            text-align: justify;
            padding: 0 15%;
            font-size: 18px;
        }

        .pdo_main_content span {
            font-family: 'Charm', cursive;
        }

        .director_ {
            text-align: right;
            margin-top: 20px;
        }

        @media(max-width: 500px) {
            .pto_top img {
                height: 50px;
            }
            .pto_top h4 {
                font-size: 9px;
                text-transform: uppercase;
                line-height: 20px;
            }
            .pto_top p {
                font-size: 14px;
            }
            .main_heading {
                font-size: 24px;
                padding: 0 10px;
            }
            .pdo_main_content {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="pto_top">
    <img src="{{ url('/assets/pdo') }}/img/govt.png" alt="">
    <h4>government of the people's republic of bangladesh</h4>
    <h4>ministry of expatriates' welfare and overseas employment</h4>
    <h4>BUREAU OF MANPOWER EMPLOYMENT AND TRAINING</h4>
    <p>89/2 Kakrail, Dhaka-1000 <br> www.bmet.gov.bd</p>
    <h1 class="main_heading">To Whom It May Concern</h1>
    <?php
    // course date
    $c_date = str_replace('/', '-', $data['course_date']);
    $course_date = date('d F Y', strtotime($c_date));
    // issue date
    $i_date = str_replace('/', '-', $data['issue_date']);
    $issue_date = date('d F Y', strtotime($i_date));
    ?>
</div>
<div class="pdo_main_content">
    <p>
        <span>This is to validate that Mr./Mrs/Ms </span> <b><?php echo $data['full_name'];?></b> , <span>Passport No:</span> <b><?php if($data['nid_no'] == 'N/A'){ echo $data['passport_no']; } if($data['passport_no'] == 'N/A'){ echo $data['nid_no']; } ?></b> <span>has successfully completed the</span> <b>“<?php if($data['course_name'] == 'Pre-Departure Orientation'){echo 'Pre-departure Orientation (PDO)'; }else{echo $data['course_name']; }?>”</b> <span>from</span> <b><?php echo $data['connected_by'];?> </b><span>for the destination country</span> <b><?php echo $data['destination_country'];?></b> <span>during</span> <b><?php echo $course_date; ?></b> <span>to</span> <b><?php echo $issue_date; ?></b>
    </p>
    <p class="director_">Director General, BMET</p>
</div>
</body>
</html>
