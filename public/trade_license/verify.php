<?php
require_once __DIR__ . '/includes/config.php';

$id = intval($_GET['id'] ?? 0);
$app = null;
$found = false;

if ($id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT id, city, license_no, business_name, owner_name, status, created_at, license_validity_date FROM trade_license_applications WHERE id = ?");
    $stmt->execute([$id]);
    $app = $stmt->fetch();
    $found = (bool)$app;
}
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ট্রেড লাইসেন্স ভেরিফাই</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
.verify-wrap { display:flex; justify-content:center; align-items:center; min-height:100vh; background:#f0f2f5; }
.verify-card { background:#fff; padding:40px; border-radius:10px; box-shadow:0 2px 15px rgba(0,0,0,0.1); max-width:600px; width:100%; text-align:center; }
.verify-card h2 { color:#1a4a8d; margin-bottom:20px; }
.verify-card input[type="number"] { width:100%; padding:12px; border:2px solid #ddd; border-radius:5px; font-size:16px; margin-bottom:15px; }
.verify-card .btn { padding:12px 40px; background:#1a4a8d; color:#fff; border:none; border-radius:5px; font-size:16px; cursor:pointer; }
.verify-card .btn:hover { background:#143a6f; }
.valid { color:#2e7d32; font-weight:bold; font-size:18px; }
.invalid { color:#c62828; font-weight:bold; font-size:18px; }
.info-table { width:100%; text-align:left; margin-top:20px; }
.info-table td { padding:8px 10px; border-bottom:1px solid #eee; }
.info-table td:first-child { font-weight:bold; color:#555; width:180px; }
</style>
</head>
<body>
<div class="verify-wrap">
    <div class="verify-card">
        <img src="../assets/images/<?= rand(0,1) ? 'dncc' : 'dscc' ?>_logo.png" style="max-width:80px;margin-bottom:15px;">
        <h2>ট্রেড লাইসেন্স ভেরিফিকেশন</h2>
        <form method="get">
            <input type="number" name="id" placeholder="লাইসেন্স আইডি নং দিন" value="<?= $id ?: '' ?>" required>
            <button type="submit" class="btn">যাচাই করুন</button>
        </form>

        <?php if ($_GET && $found && $app): ?>
            <div style="margin-top:25px;padding-top:20px;border-top:2px solid #e0e0e0;">
                <div class="valid">✅ বৈধ লাইসেন্স</div>
                <table class="info-table">
                    <tr><td>সিটি কর্পোরেশন</td><td><?= $app['city'] === 'dncc' ? 'ঢাকা উত্তর সিটি কর্পোরেশন' : 'ঢাকা দক্ষিণ সিটি কর্পোরেশন' ?></td></tr>
                    <tr><td>লাইসেন্স নং</td><td><?= htmlspecialchars($app['license_no']) ?></td></tr>
                    <tr><td>প্রতিষ্ঠানের নাম</td><td><?= htmlspecialchars($app['business_name']) ?></td></tr>
                    <tr><td>মালিকের নাম</td><td><?= htmlspecialchars($app['owner_name']) ?></td></tr>
                    <tr><td>স্ট্যাটাস</td><td><span class="badge badge-<?= $app['status'] ?>"><?= $app['status'] ?></span></td></tr>
                    <tr><td>ইস্যুর তারিখ</td><td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td></tr>
                    <tr><td>মেয়াদ</td><td><?= $app['license_validity_date'] ? date('d/m/Y', strtotime($app['license_validity_date'])) : '-' ?></td></tr>
                </table>
            </div>
        <?php elseif ($_GET && !$found): ?>
            <div style="margin-top:25px;">
                <div class="invalid">❌ লাইসেন্স পাওয়া যায়নি</div>
                <p style="color:#666;margin-top:10px;">আইডি নং <?= $id ?> এর কোনো ট্রেড লাইসেন্স নেই।</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
