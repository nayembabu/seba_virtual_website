<?php
require_once __DIR__ . '/includes/config.php';
requireLogin();

$id = intval($_GET['id'] ?? 0);
$pdo = getDB();
$stmt = $pdo->prepare("SELECT * FROM trade_license_applications WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$app = $stmt->fetch();

if (!$app) {
    setFlash('error', 'ট্রেড লাইসেন্স পাওয়া যায়নি');
    redirect('index.php');
}
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ট্রেড লাইসেন্স - <?= htmlspecialchars($app['license_no']) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
.detail-table { width:100%; border-collapse:collapse; }
.detail-table td { padding:6px 10px; border-bottom:1px solid #eee; font-size:13px; }
.detail-table td:first-child { font-weight:bold; width:220px; color:#555; }
.detail-table td:last-child { font-weight:bold; }
.section-head { background:#e3edf7; padding:8px 10px; font-weight:bold; color:#1a4a8d; font-size:14px; margin-top:15px; border-radius:4px; }
</style>
</head>
<body>
<div class="navbar no-print">
    <div class="brand">ট্রেড লাইসেন্স ব্যবস্থাপনা</div>
    <div><a href="index.php">তালিকা</a><a href="logout.php">লগআউট</a></div>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <span>লাইসেন্স: <?= htmlspecialchars($app['license_no']) ?></span>
            <div>
                <a href="print.php?id=<?= $app['id'] ?>" class="btn btn-print">🖨️ প্রিন্ট</a>
                <a href="index.php" class="btn btn-primary">তালিকা</a>
            </div>
        </div>
        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                <span class="badge badge-<?= $app['status'] ?>" style="font-size:14px;padding:5px 15px;">
                    <?php if ($app['status'] === 'approved'): ?>✅ অনুমোদিত
                    <?php elseif ($app['status'] === 'rejected'): ?>❌ বাতিল
                    <?php else: ?>⏳ বিচারাধীন<?php endif; ?>
                </span>
                <span style="color:#888;font-size:13px;">সিটি: <?= strtoupper($app['city']) ?> | আবেদন: <?= date('d/m/Y', strtotime($app['created_at'])) ?></span>
            </div>

            <?php if ($app['owner_photo']): ?>
            <div style="text-align:right;margin-bottom:10px;">
                <img src="../storage/<?= htmlspecialchars($app['owner_photo']) ?>" style="max-width:100px;max-height:120px;border:2px solid #1a4a8d;border-radius:4px;">
            </div>
            <?php endif; ?>

            <div class="section-head">প্রতিষ্ঠানের তথ্য</div>
            <table class="detail-table">
                <tr><td>লাইসেন্স নং</td><td><?= htmlspecialchars($app['license_no']) ?></td></tr>
                <tr><td>প্রতিষ্ঠানের নাম</td><td><?= htmlspecialchars($app['business_name']) ?></td></tr>
                <tr><td>মালিকের নাম</td><td><?= htmlspecialchars($app['owner_name']) ?></td></tr>
                <tr><td>পিতা / স্বামীর নাম</td><td><?= htmlspecialchars($app['father_husband_name']) ?></td></tr>
                <tr><td>মাতার নাম</td><td><?= htmlspecialchars($app['mother_name']) ?></td></tr>
                <tr><td>ব্যবসার প্রকৃতি</td><td><?= htmlspecialchars($app['business_nature']) ?></td></tr>
                <tr><td>ব্যবসার ধরণ</td><td><?= htmlspecialchars($app['business_type']) ?></td></tr>
            </table>

            <div class="section-head">প্রতিষ্ঠানের ঠিকানা</div>
            <table class="detail-table">
                <tr><td>ঠিকানা</td><td><?php
                    $addr = '';
                    if ($app['business_address_house']) $addr .= 'বাড়ি নং - ' . $app['business_address_house'] . ', ';
                    if ($app['business_address_road']) $addr .= 'রোড - ' . $app['business_address_road'] . ', ';
                    if ($app['business_address_block']) $addr .= 'ব্লক - ' . $app['business_address_block'] . ', ';
                    if ($app['business_address_area']) $addr .= $app['business_address_area'] . ', ';
                    if ($app['business_address_thana']) $addr .= $app['business_address_thana'] . ', ';
                    if ($app['business_address_district']) $addr .= $app['business_address_district'];
                    if ($app['business_address_postcode']) $addr .= ' - ' . $app['business_address_postcode'];
                    echo htmlspecialchars(rtrim($addr, ', '));
                ?></td></tr>
                <tr><td>অঞ্চল / বাজার শাখা</td><td><?= htmlspecialchars($app['business_zone'] ?? '-') ?></td></tr>
                <tr><td>ওয়ার্ড / মার্কেট</td><td><?= htmlspecialchars($app['business_ward_market'] ?? '-') ?></td></tr>
            </table>

            <div class="section-head">ব্যক্তিগত তথ্য</div>
            <table class="detail-table">
                <tr><td>এনআইডি/পাসপোর্ট/জন্ম নিবন্ধন</td><td><?= htmlspecialchars($app['nid_passport_birth_no']) ?></td></tr>
                <tr><td>বিআইএন নং</td><td><?= htmlspecialchars($app['bin_no'] ?? '-') ?></td></tr>
                <tr><td>ফোন</td><td><?= htmlspecialchars($app['phone']) ?></td></tr>
                <tr><td>ই-মেইল</td><td><?= htmlspecialchars($app['email'] ?? '-') ?></td></tr>
                <tr><td>অর্থ বছর</td><td><?= htmlspecialchars($app['financial_year']) ?></td></tr>
                <tr><td>ব্যবসা শুরুর তারিখ</td><td><?= $app['business_start_date'] ? date('d/m/Y', strtotime($app['business_start_date'])) : '-' ?></td></tr>
            </table>

            <div class="section-head">ঠিকানা</div>
            <table class="detail-table">
                <tr><td colspan="2"><strong>বর্তমান ঠিকানা</strong></td></tr>
                <tr><td>হোল্ডিং নং</td><td><?= htmlspecialchars($app['current_address_holding'] ?? '-') ?></td></tr>
                <tr><td>রোড নং</td><td><?= htmlspecialchars($app['current_address_road'] ?? '-') ?></td></tr>
                <tr><td>গ্রাম / মহল্লা</td><td><?= htmlspecialchars($app['current_address_village'] ?? '-') ?></td></tr>
                <tr><td>পোস্ট কোড</td><td><?= htmlspecialchars($app['current_address_postcode'] ?? '-') ?></td></tr>
                <tr><td>থানা</td><td><?= htmlspecialchars($app['current_address_thana'] ?? '-') ?></td></tr>
                <tr><td>জেলা</td><td><?= htmlspecialchars($app['current_address_district'] ?? '-') ?></td></tr>
                <tr><td>বিভাগ</td><td><?= htmlspecialchars($app['current_address_division'] ?? '-') ?></td></tr>
                <?php if (!$app['same_as_current_address']): ?>
                <tr><td colspan="2" style="padding-top:10px;"><strong>স্থায়ী ঠিকানা</strong></td></tr>
                <tr><td>হোল্ডিং নং</td><td><?= htmlspecialchars($app['permanent_address_holding'] ?? '-') ?></td></tr>
                <tr><td>রোড নং</td><td><?= htmlspecialchars($app['permanent_address_road'] ?? '-') ?></td></tr>
                <tr><td>গ্রাম / মহল্লা</td><td><?= htmlspecialchars($app['permanent_address_village'] ?? '-') ?></td></tr>
                <tr><td>পোস্ট কোড</td><td><?= htmlspecialchars($app['permanent_address_postcode'] ?? '-') ?></td></tr>
                <tr><td>থানা</td><td><?= htmlspecialchars($app['permanent_address_thana'] ?? '-') ?></td></tr>
                <tr><td>জেলা</td><td><?= htmlspecialchars($app['permanent_address_district'] ?? '-') ?></td></tr>
                <tr><td>বিভাগ</td><td><?= htmlspecialchars($app['permanent_address_division'] ?? '-') ?></td></tr>
                <?php endif; ?>
            </table>

            <div class="section-head">ফি সংক্রান্ত</div>
            <table class="detail-table">
                <tr><td>লাইসেন্স ফি</td><td>৳ <?= number_format($app['license_fee'], 2) ?></td></tr>
                <tr><td>সারচার্জ</td><td>৳ <?= number_format($app['surcharge'], 2) ?></td></tr>
                <tr><td>আয়কর / উৎসকর</td><td>৳ <?= number_format($app['tax'], 2) ?></td></tr>
                <tr><td>বকেয়া</td><td>৳ <?= number_format($app['due_amount'], 2) ?></td></tr>
                <tr><td>সংশোধনী ফি</td><td>৳ <?= number_format($app['amendment_fee'], 2) ?></td></tr>
                <tr><td>সাইনবোর্ড কর</td><td>৳ <?= number_format($app['signboard_fee'], 2) ?></td></tr>
                <tr><td>ভ্যাট</td><td>৳ <?= number_format($app['vat'], 2) ?></td></tr>
                <tr><td>বই মূল্য</td><td>৳ <?= number_format($app['book_price'], 2) ?></td></tr>
                <tr><td>ফরম ফি</td><td>৳ <?= number_format($app['form_fee'], 2) ?></td></tr>
                <tr><td>অন্যান্য ফি</td><td>৳ <?= number_format($app['other_fee'], 2) ?></td></tr>
                <tr style="border-top:2px solid #1a4a8d;"><td><strong>সর্বমোট</strong></td><td><strong>৳ <?= number_format($app['total_fee'], 2) ?></strong></td></tr>
                <tr><td>লাইসেন্স মেয়াদ</td><td><?= $app['license_validity_date'] ? date('d/m/Y', strtotime($app['license_validity_date'])) : '-' ?></td></tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
