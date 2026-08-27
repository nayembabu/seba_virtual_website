<!DOCTYPE html>
<html>
<head>
    <title>Land Blades Template</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" integrity="sha512-veQGuV8mWvF5mbojnqKenPM6mZD2gm3Xf3mRibCAW+nJzJ5VwOOemTr9IDeskqzPb2uKIYDXPot9HsrIuWGHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bn-text {
            font-family: 'SolaimanLipi', Arial, sans-serif !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
            <div class="card-body">
                <center>
                    <h3 class="text-info">
                        Charge : 0
                    </h3>
                </center>

                <h3 class="text-center bn-text">ভূমি তথ্য</h3>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $sl_no = $_POST["sl_no"];
                    $chalan_no = $_POST["chalan_no"];
                    $office_name = $_POST["office_name"];
                    $muja_no = $_POST["muja_no"];
                    $upazila_name = $_POST["upazila_name"];
                    $zila_name = $_POST["zila_name"];
                    $holding_no = $_POST["holding_no"];
                    $khotiyan_no = $_POST["khotiyan_no"];
                    $porishud = $_POST["porishud"];
                    $publish_date = $_POST["publish_date"];
                    $din = $_POST["din"];
                    $mas = $_POST["mas"];
                    $bochor = $_POST["bochor"];
                ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bn-text">ক্রমিক নং:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $sl_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bn-text">চালান নং:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $chalan_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">সিটি কর্পোরেশন / পৌর / ইউনিয়ন ভূমি অফিসের নাম:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $office_name; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">মৌজার ও জে. এল. নং:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $muja_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">উপজেলা / থানা:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $upazila_name; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">জেলা:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $zila_name; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">২ নং রেজিস্টার অনুযায়ী হোল্ডিং নম্বর:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $holding_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bn-text">খতিয়ান নং:</label>
                            <input type="text" class="form-control bn-input" value="<?php echo $khotiyan_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bn-text">পরিশোধের সাল: (BN)</label>
                                    <input type="text" class="form-control bn-input" value="<?php echo $porishud; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bn-text">তারিখ (EN):</label>
                                    <input type="text" class="form-control bn-input" value="<?php echo $publish_date; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bn-text">দিন:</label>
                                    <input type="text" class="form-control bn-input" value="<?php echo $din; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bn-text">মাস:</label>
                                    <input type="text" class="form-control bn-input" value="<?php echo $mas; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bn-text">বছর:</label>
                                    <input type="text" class="form-control bn-input" value="<?php echo $bochor; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
