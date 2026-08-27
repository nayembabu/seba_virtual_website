<?php
require_once __DIR__ . '/includes/config.php';
requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $city = $data['city'] ?? '';

    if (!in_array($city, ['dncc', 'dscc'])) {
        $error = 'Invalid city';
    } else {
        $prefix = $city === 'dncc' ? 'TRAD/DNCC' : 'TRAD/DSCC';
        $pdo = getDB();

        $last = $pdo->prepare("SELECT license_no FROM trade_license_applications WHERE city = ? AND license_no LIKE ? ORDER BY id DESC LIMIT 1");
        $last->execute([$city, $prefix . '/%']);
        $row = $last->fetch();
        if ($row) {
            $parts = explode('/', $row['license_no']);
            $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $num = 1;
        }
        $license_no = $prefix . '/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');

        $photoPath = null;
        if (isset($_FILES['owner_photo']) && $_FILES['owner_photo']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['owner_photo']['name'], PATHINFO_EXTENSION);
            $photoPath = 'trade-licenses/photos/' . uniqid() . '.' . $ext;
            $fullPath = __DIR__ . '/../../storage/app/public/' . $photoPath;
            $dir = dirname($fullPath);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            move_uploaded_file($_FILES['owner_photo']['tmp_name'], $fullPath);
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO trade_license_applications 
                (user_id, city, license_no, business_name, owner_name, father_husband_name, mother_name,
                 business_nature, business_type, business_address_house, business_address_road,
                 business_address_block, business_address_ward, business_address_thana, business_address_district,
                 business_address_postcode, business_zone, business_ward_market, business_address_area,
                 nid_passport_birth_no, bin_no, phone, email, financial_year, business_start_date,
                 current_address_holding, current_address_road, current_address_village,
                 current_address_thana, current_address_district, current_address_division, current_address_postcode,
                 same_as_current_address, permanent_address_holding, permanent_address_road, permanent_address_village,
                 permanent_address_thana, permanent_address_district, permanent_address_division, permanent_address_postcode,
                 license_fee, surcharge, tax, due_amount, amendment_fee, signboard_fee, vat, book_price, form_fee, other_fee, total_fee,
                 license_validity_date, owner_photo, status)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $same = isset($data['same_as_current_address']) ? 1 : 0;

            $stmt->execute([
                $_SESSION['user_id'], $city, $license_no,
                $data['business_name'], $data['owner_name'], $data['father_husband_name'], $data['mother_name'],
                $data['business_nature'], $data['business_type'],
                $data['business_address_house'] ?? null, $data['business_address_road'] ?? null,
                $data['business_address_block'] ?? null, $data['business_address_ward'] ?? null,
                $data['business_address_thana'] ?? null, $data['business_address_district'] ?? null,
                $data['business_address_postcode'] ?? null,
                $data['business_zone'] ?? null, $data['business_ward_market'] ?? null, $data['business_address_area'] ?? null,
                $data['nid_passport_birth_no'], $data['bin_no'] ?? null, $data['phone'], $data['email'] ?? null,
                $data['financial_year'], $data['business_start_date'],
                $data['current_address_holding'] ?? null, $data['current_address_road'] ?? null,
                $data['current_address_village'] ?? null,
                $data['current_address_thana'] ?? null, $data['current_address_district'] ?? null,
                $data['current_address_division'] ?? null, $data['current_address_postcode'] ?? null,
                $same,
                $data['permanent_address_holding'] ?? null, $data['permanent_address_road'] ?? null,
                $data['permanent_address_village'] ?? null,
                $data['permanent_address_thana'] ?? null, $data['permanent_address_district'] ?? null,
                $data['permanent_address_division'] ?? null, $data['permanent_address_postcode'] ?? null,
                $data['license_fee'] ?? 0, $data['surcharge'] ?? 0, $data['tax'] ?? 0,
                $data['due_amount'] ?? 0, $data['amendment_fee'] ?? 0, $data['signboard_fee'] ?? 0,
                $data['vat'] ?? 0, $data['book_price'] ?? 0, $data['form_fee'] ?? 0,
                $data['other_fee'] ?? 0, $data['total_fee'] ?? 0,
                $data['license_validity_date'], $photoPath, 'pending'
            ]);

            $appId = $pdo->lastInsertId();
            setFlash('success', 'আবেদন সফলভাবে জমা দেওয়া হয়েছে। লাইসেন্স নং: ' . $license_no);
            redirect('view.php?id=' . $appId);
        } catch (Exception $e) {
            $error = 'আবেদন জমা দিতে সমস্যা হয়েছে: ' . $e->getMessage();
        }
    }
}

// Generate next license no for default form
$city = $_GET['city'] ?? 'dncc';
if (!in_array($city, ['dncc', 'dscc'])) $city = 'dncc';
$prefix = $city === 'dncc' ? 'TRAD/DNCC' : 'TRAD/DSCC';
$pdo = getDB();
$last = $pdo->prepare("SELECT license_no FROM trade_license_applications WHERE city = ? AND license_no LIKE ? ORDER BY id DESC LIMIT 1");
$last->execute([$city, $prefix . '/%']);
$row = $last->fetch();
if ($row) { $parts = explode('/', $row['license_no']); $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1; }
else { $num = 1; }
$license_no = $prefix . '/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>নতুন ট্রেড লাইসেন্স আবেদন</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar no-print">
    <div class="brand">ট্রেড লাইসেন্স ব্যবস্থাপনা</div>
    <div><a href="index.php">তালিকা</a><a href="logout.php">লগআউট</a></div>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">নতুন ট্রেড লাইসেন্স আবেদন</div>
        <div class="card-body">
            <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label>সিটি কর্পোরেশন</label>
                        <select name="city" id="citySelect" onchange="this.form.submit()">
                            <option value="dncc" <?= $city === 'dncc' ? 'selected' : '' ?>>DNCC - ঢাকা উত্তর</option>
                            <option value="dscc" <?= $city === 'dscc' ? 'selected' : '' ?>>DSCC - ঢাকা দক্ষিণ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>লাইসেন্স নং</label>
                        <input type="text" value="<?= htmlspecialchars($license_no) ?>" readonly>
                    </div>
                </div>

                <div class="form-section">
                    <h3>প্রতিষ্ঠানের তথ্য</h3>
                    <div class="form-row">
                        <div class="form-group"><label>প্রতিষ্ঠানের নাম *</label><input type="text" name="business_name" required></div>
                        <div class="form-group"><label>মালিকের নাম *</label><input type="text" name="owner_name" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>পিতা / স্বামীর নাম *</label><input type="text" name="father_husband_name" required></div>
                        <div class="form-group"><label>মাতার নাম *</label><input type="text" name="mother_name" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>ব্যবসার প্রকৃতি *</label>
                            <select name="business_nature" required>
                                <option value="">নির্বাচন করুন</option>
                                <option value="একক">একক</option>
                                <option value="সম্মিলিত">সম্মিলিত</option>
                                <option value="প্রাইভেট লিমিটেড">প্রাইভেট লিমিটেড</option>
                                <option value="পাবলিক লিমিটেড">পাবলিক লিমিটেড</option>
                                <option value="সোসাইটি">সোসাইটি</option>
                            </select>
                        </div>
                        <div class="form-group"><label>ব্যবসার ধরণ *</label>
                            <select name="business_type" required>
                                <option value="">নির্বাচন করুন</option>
                                <option value="খুচরা">খুচরা</option>
                                <option value="পাইকারি">পাইকারি</option>
                                <option value="সরবরাহকারী">সরবরাহকারী</option>
                                <option value="উৎপাদন">উৎপাদন</option>
                                <option value="সেবা">সেবা</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>প্রতিষ্ঠানের ঠিকানা</h3>
                    <div class="form-row">
                        <div class="form-group"><label>বাড়ি নং</label><input type="text" name="business_address_house"></div>
                        <div class="form-group"><label>রোড নং</label><input type="text" name="business_address_road"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>ব্লক</label><input type="text" name="business_address_block"></div>
                        <div class="form-group"><label>ওয়ার্ড</label><input type="text" name="business_address_ward"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>এলাকা</label><input type="text" name="business_address_area"></div>
                        <div class="form-group"><label>থানা</label><input type="text" name="business_address_thana"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>জেলা</label><input type="text" name="business_address_district"></div>
                        <div class="form-group"><label>পোস্ট কোড</label><input type="text" name="business_address_postcode"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>অঞ্চল / বাজার শাখা</label><input type="text" name="business_zone"></div>
                        <div class="form-group"><label>ওয়ার্ড / মার্কেট</label><input type="text" name="business_ward_market"></div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>ব্যক্তিগত তথ্য</h3>
                    <div class="form-row">
                        <div class="form-group"><label>এনআইডি/পাসপোর্ট/জন্ম নিবন্ধন *</label><input type="text" name="nid_passport_birth_no" required></div>
                        <div class="form-group"><label>বিআইএন নং</label><input type="text" name="bin_no"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>ফোন *</label><input type="text" name="phone" required></div>
                        <div class="form-group"><label>ই-মেইল</label><input type="email" name="email"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>অর্থ বছর *</label><input type="text" name="financial_year" value="<?= date('Y') . '-' . (date('Y') + 1) ?>" required></div>
                        <div class="form-group"><label>ব্যবসা শুরুর তারিখ *</label><input type="date" name="business_start_date" required></div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>বর্তমান ঠিকানা</h3>
                    <div class="form-row">
                        <div class="form-group"><label>হোল্ডিং নং</label><input type="text" name="current_address_holding"></div>
                        <div class="form-group"><label>রোড নং</label><input type="text" name="current_address_road"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>গ্রাম / মহল্লা</label><input type="text" name="current_address_village"></div>
                        <div class="form-group"><label>পোস্ট কোড</label><input type="text" name="current_address_postcode"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>থানা</label><input type="text" name="current_address_thana"></div>
                        <div class="form-group"><label>জেলা</label><input type="text" name="current_address_district"></div>
                    </div>
                    <div class="form-group"><label>বিভাগ</label><input type="text" name="current_address_division"></div>
                </div>

                <div class="form-section">
                    <h3>স্থায়ী ঠিকানা</h3>
                    <div class="form-group"><label><input type="checkbox" name="same_as_current_address" value="1" onchange="togglePermanent(this)"> বর্তমান ঠিকানা একই</label></div>
                    <div id="permanentAddress">
                        <div class="form-row">
                            <div class="form-group"><label>হোল্ডিং নং</label><input type="text" name="permanent_address_holding"></div>
                            <div class="form-group"><label>রোড নং</label><input type="text" name="permanent_address_road"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>গ্রাম / মহল্লা</label><input type="text" name="permanent_address_village"></div>
                            <div class="form-group"><label>পোস্ট কোড</label><input type="text" name="permanent_address_postcode"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>থানা</label><input type="text" name="permanent_address_thana"></div>
                            <div class="form-group"><label>জেলা</label><input type="text" name="permanent_address_district"></div>
                        </div>
                        <div class="form-group"><label>বিভাগ</label><input type="text" name="permanent_address_division"></div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>ফি সংক্রান্ত</h3>
                    <div class="form-row">
                        <div class="form-group"><label>লাইসেন্স ফি</label><input type="number" step="0.01" name="license_fee" value="0"></div>
                        <div class="form-group"><label>সারচার্জ</label><input type="number" step="0.01" name="surcharge" value="0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>আয়কর / উৎসকর</label><input type="number" step="0.01" name="tax" value="0"></div>
                        <div class="form-group"><label>বকেয়া</label><input type="number" step="0.01" name="due_amount" value="0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>সংশোধনী ফি</label><input type="number" step="0.01" name="amendment_fee" value="0"></div>
                        <div class="form-group"><label>সাইনবোর্ড কর</label><input type="number" step="0.01" name="signboard_fee" value="0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>ভ্যাট</label><input type="number" step="0.01" name="vat" value="0"></div>
                        <div class="form-group"><label>বই মূল্য</label><input type="number" step="0.01" name="book_price" value="0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>ফরম ফি</label><input type="number" step="0.01" name="form_fee" value="0"></div>
                        <div class="form-group"><label>অন্যান্য ফি</label><input type="number" step="0.01" name="other_fee" value="0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>সর্বমোট *</label><input type="number" step="0.01" name="total_fee" required></div>
                        <div class="form-group"><label>লাইসেন্স মেয়াদ *</label><input type="date" name="license_validity_date" required></div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>ছবি ও ডকুমেন্ট</h3>
                    <div class="form-group"><label>মালিকের ছবি</label><input type="file" name="owner_photo" accept="image/*"></div>
                </div>

                <div style="text-align:center;margin-top:20px;">
                    <button type="submit" class="btn btn-primary" style="padding:12px 40px;font-size:16px;">আবেদন জমা দিন</button>
                    <a href="index.php" class="btn" style="padding:12px 40px;font-size:16px;background:#eee;">বাতিল</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePermanent(cb) {
    document.getElementById('permanentAddress').style.display = cb.checked ? 'none' : 'block';
}
// Don't auto-submit on city change (to avoid losing form data)
document.getElementById('citySelect').onchange = function() {
    window.location.href = 'create.php?city=' + this.value;
};
</script>
</body>
</html>
