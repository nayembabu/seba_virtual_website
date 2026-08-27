<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "landpaper_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate random values for sl_no and chalan_no
$sl_no = str_pad(mt_rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
$chalan_no = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

// Function to convert English numbers to Bengali
function bn_number($number) {
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $number_str = (string) $number;
    $output = '';
    
    for ($i = 0; $i < strlen($number_str); $i++) {
        if (is_numeric($number_str[$i])) {
            $output .= $bn_digits[$number_str[$i]];
        } else {
            $output .= $number_str[$i];
        }
    }
    
    return $output;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic form data
    $sl_no = $_POST['sl_no'];
    $chalan_no = $_POST['chalan_no'];
    $office_name = $_POST['office_name'];
    $muja_no = $_POST['muja_no'];
    $upazila_name = $_POST['upazila_name'];
    $zila_name = $_POST['zila_name'];
    $holding_no = $_POST['holding_no'];
    $khotiyan_no = $_POST['khotiyan_no'];
    $porishud = $_POST['porishud'];
    $publish_date = $_POST['publish_date'];
    $din = $_POST['din'];
    $mas = $_POST['mas'];
    $bochor = $_POST['bochor'];
    
    // Payment details
    $tin_bokaya = $_POST['tin_bokaya'];
    $goto_bokaya = $_POST['goto_bokaya'];
    $bokayar_khoti = $_POST['bokayar_khoti'];
    $hall_dabi = $_POST['hall_dabi'];
    $mot_dabi = $_POST['mot_dabi'];
    $mot_aday = $_POST['mot_aday'];
    $mot_bokaya = $_POST['mot_bokaya'];
    $montobo = $_POST['montobo'];
    
    // Generate a UUID
    $uid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
    
    // Insert main land record
    $sql = "INSERT INTO lands (uid, sl_no, chalan_no, office_name, muja_no, upazila_name, zila_name, 
                            holding_no, khotiyan_no, porishud, publish_date, din, mas, bochor,
                            tin_bokaya, goto_bokaya, bokayar_khoti, hall_dabi, mot_dabi, mot_aday, mot_bokaya, montobo, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssss", $uid, $sl_no, $chalan_no, $office_name, $muja_no, $upazila_name, $zila_name, 
                     $holding_no, $khotiyan_no, $porishud, $publish_date, $din, $mas, $bochor,
                     $tin_bokaya, $goto_bokaya, $bokayar_khoti, $hall_dabi, $mot_dabi, $mot_aday, $mot_bokaya, $montobo);
    
    $success = $stmt->execute();
    
    // Insert owner details
    if ($success && isset($_POST['m_name']) && is_array($_POST['m_name'])) {
        $m_names = $_POST['m_name'];
        $m_totals = $_POST['m_total'];
        
        for ($i = 0; $i < count($m_names); $i++) {
            if (!empty($m_names[$i])) {
                $owner_sql = "INSERT INTO land_owners (land_uid, owner_name, owner_share, created_at)
                             VALUES (?, ?, ?, NOW())";
                $owner_stmt = $conn->prepare($owner_sql);
                $owner_stmt->bind_param("sss", $uid, $m_names[$i], $m_totals[$i]);
                $owner_stmt->execute();
            }
        }
    }
    
    // Insert land plot details
    if ($success && isset($_POST['dag_no']) && is_array($_POST['dag_no'])) {
        $dag_nos = $_POST['dag_no'];
        $jomi_types = $_POST['jomi_type'];
        $jomi_porimans = $_POST['jomi_poriman'];
        
        for ($i = 0; $i < count($dag_nos); $i++) {
            if (!empty($dag_nos[$i])) {
                $plot_sql = "INSERT INTO land_plots (land_uid, dag_no, jomi_type, jomi_poriman, created_at)
                            VALUES (?, ?, ?, ?, NOW())";
                $plot_stmt = $conn->prepare($plot_sql);
                $plot_stmt->bind_param("ssss", $uid, $dag_nos[$i], $jomi_types[$i], $jomi_porimans[$i]);
                $plot_stmt->execute();
            }
        }
    }
    
    if ($success) {
        $success_message = "Land data saved successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

// Get land fee settings (adjust as needed)
$land_fee = 100; // Default value if not available in database
$fee_query = "SELECT value FROM settings WHERE name = 'land_fee' LIMIT 1";
$fee_result = $conn->query($fee_query);
if ($fee_result && $fee_result->num_rows > 0) {
    $fee_row = $fee_result->fetch_assoc();
    $land_fee = $fee_row['value'];
}

// Function to show formatted number
function inum($number) {
    return number_format($number, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Paper Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .bn-text, .bn-input {
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .bn-layout {
            direction: ltr;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
            <div class="card-body">
                <center>
                    <h3 class="text-info"> 
                    Charge : <?php echo inum($land_fee); ?>
                    </h3>
                </center>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <form action="" method="post" class="bn-layout">
                    <h3 class="text-center"> ভূমি তথ্য </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="bn-text">ক্রমিক নং:</label>
                                <input class="form-control" type="text" name="sl_no" value="<?php echo $sl_no; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="bn-text">চালান নং:</label>
                                <input class="form-control" type="text" name="chalan_no" value="<?php echo $chalan_no; ?>" required>
                            </div>
                        </div>
                            
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">সিটি কর্পোরেশন / পৌর / ইউনিয়ন ভূমি অফিসের নাম:</label>
                                <input class="form-control" type="text" name="office_name" value="" required>
                            </div>
                        </div>
                            
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">মৌজার ও জে. এল. নং:</label>
                                <input class="form-control bn-input" type="text" name="muja_no" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">উপজেলা / থানা:</label>
                                <input class="form-control bn-input" type="text" name="upazila_name" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">জেলা:</label>
                                <input class="form-control bn-input" type="text" name="zila_name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">২ নং রেজিস্টার অনুযায়ী হোল্ডিং নম্বর:</label>
                                <input class="form-control bn-input" type="text" name="holding_no" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="bn-text">খতিয়ান নং:</label>
                                <input class="form-control bn-input" type="text" name="khotiyan_no" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="bn-text">পরিশোধের সাল: (BN)</label>
                                        <input class="form-control input" type="text" name="porishud" placeholder="2024-2025 (অর্থবছর)" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="bn-text">তারিখ (EN):</label>
                                        <input maxlength="10" class="form-control bn-input datetime" type="text" name="publish_date" placeholder="dd-mm-yyyy" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="bn-text">দিন:</label>
                                        <select class="form-control bn-input" name="din" required>
                                            <option value="">--নির্বাচন--</option>
                                            <?php
                                            for ($din = 1; $din <= 31; $din++) {
                                                echo '<option value="'.bn_number($din).'">'.bn_number($din).'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="bn-text">মাস:</label>
                                        <select class="form-control bn-input" name="mas" required>
                                            <option value="">--নির্বাচন--</option>
                                            <?php
                                            $mas_bn = [
                                                'বৈশাখ',
                                                'জ্যৈষ্ঠ',
                                                'আষাঢ়',
                                                'শ্রাবণ',
                                                'ভাদ্র',
                                                'আশ্বিন',
                                                'কার্তিক',
                                                'অগ্রহায়ণ',
                                                'পৌষ',
                                                'মাঘ',
                                                'ফাল্গুন',
                                                'চৈত্র',
                                            ];
                                            for($mas = 0;$mas < count($mas_bn);$mas++){
                                                echo '<option value="'.$mas_bn[$mas].'">'.$mas_bn[$mas].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="bn-text">বছর:</label>
                                        <select class="form-control bn-input" name="bochor" required>
                                            <option value="">--নির্বাচন--</option>
                                            <?php
                                            for ($din = 1400; $din <= 1490; $din++) {
                                                echo '<option value="'.bn_number($din).'">'.bn_number($din).'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="bn-text">ক্রম</th>
                                            <th class="bn-text">মালিকের নাম</th>
                                            <th class="bn-text">মালিকের অংশ </th>
                                            <th class="bn-text">আরও</th>
                                        </tr>
                                    </thead>
                                    <tbody class="malik_wrapper">
                                        <tr>
                                            <td width="1%">
                                                <div class="form-group">
                                                    <label class="bn-text mcromik">১</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="মালিকের নাম" class="form-control bn-input" type="text" name="m_name[]" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" name="m_total[]" >
                                                </div>
                                            </td>
                                            <td width="1%">
                                                <a href="javascript:void(0);" class="malik_plus malik_add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="bn-text">ক্রম</th>
                                            <th class="bn-text">দাগ নং</th>
                                            <th class="bn-text">জমির শ্রেণী</th>
                                            <th class="bn-text">জমির পরিমাণ (EN)</th>
                                            <th class="bn-text">আরও</th>
                                        </tr>
                                    </thead>
                                    <tbody class="field_wrapper">
                                        <tr>
                                            <td width="1%">
                                                <div class="form-group">
                                                    <label class="bn-text" id="cromik">১</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="৬২৮৫" class="form-control bn-input" type="text" name="dag_no[]" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="পুকুর( কৃষি ২)" class="form-control bn-input" type="text" name="jomi_type[]" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="জমির পরিমাণ (শতক) শুধুমাত্র ইংলিশ লিখা যাবে! যেমন: 12.00000" class="form-control bn-input" type="text" name="jomi_poriman[]" required>
                                                </div>
                                            </td>
                                            <td width="1%">
                                                <a href="javascript:void(0);" class="plus add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <h1 class="bn-text" style="text-align: center;font-size: 18px !important;color: #000;margin-bottom: 15px;">আদায়ের বিবরণ</h1>
                                        <tr>
                                            <th class="bn-text">তিন বৎসরের ঊর্ধ্বের বকেয়া (EN)</th>
                                            <th class="bn-text">গত তিন বৎসরের বকেয়া (EN)</th>
                                            <th class="bn-text">বকেয়ার সুদ ও ক্ষতিপূরণ (EN)</th>
                                            <th class="bn-text">হাল দাবি (EN)</th>
                                            <th class="bn-text">মোট দাবি (EN)</th>
                                            <th class="bn-text">মোট আদায় (EN)</th>
                                            <th class="bn-text">মোট বকেয়া (EN)</th>
                                            <th class="bn-text">মন্তব্য</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="tin_bokaya" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="goto_bokaya" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="bokayar_khoti" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="hall_dabi" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="mot_dabi" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="mot_aday" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="০" class="form-control bn-input" type="text" name="mot_bokaya" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input placeholder="" class="form-control bn-input" type="text" name="montobo">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary bn-text" name="submit" style="margin: 0 auto; display: block;"><i class="fa fa-check"></i> সাবমিট</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        var maxField = 1000; // Input fields increment limitation
        var addButton = $('.add_button'); // Add button selector
        var wrapper = $('.field_wrapper'); // Input field wrapper
        var fieldHTML = '<tr class="minus"><td width="1%"><div class="form-group"><label class="bn-text">+</label></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="dag_no[]" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="jomi_type[]" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="jomi_poriman[]" required></div></td><td width="1%"><a href="javascript:void(0);" class="minus remove_button btn btn-warning btn-sm"><i class="fa fa-minus"></i></a></td></tr>'; // New input field html 
        var x = $('.field_wrapper tr').length; // Get initial count of fields

        // Once add button is clicked
        $(addButton).click(function() {
            // Check maximum number of input fields
            if (x < maxField) {
                x++; // Increase field counter
                document.getElementById("cromik").innerHTML = x;
                $(wrapper).append(fieldHTML); // Add field html
            } else {
                alert('A maximum of ' + maxField + ' fields are allowed to be added.');
            }
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove(); // Remove field html
            x--; // Decrease field counter
            document.getElementById("cromik").innerHTML = x;
        });

        // For malik_wrapper
        let thtml = '<tr><td width="1%"><div class="form-group"><label class="bn-text mcromik1">+</label></div></td><td><div class="form-group"><input placeholder="মালিকের নাম" class="form-control bn-input" type="text" name="m_name[]" required></div></td><td><div class="form-group"><input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" name="m_total[]"></div></td><td width="1%"><a href="javascript:void(0);" class="malik_remove btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td></tr>';
        let l = $('.malik_wrapper tr').length; // Get initial count of malik fields

        $('.malik_add_button').click(function() {
            if (l < maxField) {
                l++;
                $('.mcromik').html(l);
                $('.malik_wrapper').append(thtml);
            } else {
                alert('A maximum of ' + maxField + ' fields are allowed to be added.');
            }
        });

        $('.malik_wrapper').on('click', '.malik_remove', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove(); // Remove field html
            l--; // Decrease field counter
            $('.mcromik').html(l);
        });
    });
    </script>
</body>
</html>