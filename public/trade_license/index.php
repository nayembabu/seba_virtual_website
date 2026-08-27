<?php
require_once __DIR__ . '/includes/config.php';
requireLogin();

$pdo = getDB();
$city = isset($_GET['city']) && in_array($_GET['city'], ['dncc', 'dscc']) ? $_GET['city'] : 'all';
$search = trim($_GET['search'] ?? '');

$where = "WHERE user_id = ?";
$params = [$_SESSION['user_id']];

if ($city !== 'all') {
    $where .= " AND city = ?";
    $params[] = $city;
}
if ($search) {
    $where .= " AND (license_no LIKE ? OR business_name LIKE ? OR owner_name LIKE ?)";
    $s = "%$search%";
    $params[] = $s; $params[] = $s; $params[] = $s;
}

$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM trade_license_applications $where");
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM trade_license_applications $where ORDER BY id DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$apps = $stmt->fetchAll();
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ট্রেড লাইসেন্স তালিকা</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar no-print">
    <div class="brand">ট্রেড লাইসেন্স ব্যবস্থাপনা</div>
    <div>
        <a href="create.php">+ নতুন আবেদন</a>
        <a href="logout.php">লগআউট</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <span>আমার ট্রেড লাইসেন্স সমূহ</span>
            <div>
                <a href="create.php" class="btn btn-success">+ নতুন আবেদন</a>
            </div>
        </div>
        <div class="card-body">
            <?php if ($msg = flash('success')): ?>
                <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
            <?php if ($msg = flash('error')): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form method="get" style="margin-bottom:15px;display:flex;gap:10px;">
                <select name="city" style="padding:7px;border:1px solid #ddd;border-radius:4px;">
                    <option value="all" <?= $city === 'all' ? 'selected' : '' ?>>সব সিটি</option>
                    <option value="dncc" <?= $city === 'dncc' ? 'selected' : '' ?>>DNCC</option>
                    <option value="dscc" <?= $city === 'dscc' ? 'selected' : '' ?>>DSCC</option>
                </select>
                <input type="text" name="search" placeholder="লাইসেন্স নং / প্রতিষ্ঠান / মালিক" value="<?= htmlspecialchars($search) ?>" style="flex:1;padding:7px;border:1px solid #ddd;border-radius:4px;">
                <button type="submit" class="btn btn-primary">খুঁজুন</button>
            </form>

            <?php if (count($apps) > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>লাইসেন্স নং</th>
                        <th>প্রতিষ্ঠান</th>
                        <th>মালিক</th>
                        <th>সিটি</th>
                        <th>স্ট্যাটাস</th>
                        <th>কাজ</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($apps as $i => $app): ?>
                    <tr>
                        <td><?= $offset + $i + 1 ?></td>
                        <td><?= htmlspecialchars($app['license_no']) ?></td>
                        <td><?= htmlspecialchars($app['business_name']) ?></td>
                        <td><?= htmlspecialchars($app['owner_name']) ?></td>
                        <td><?= strtoupper($app['city']) ?></td>
                        <td><span class="badge badge-<?= $app['status'] ?>"><?= $app['status'] ?></span></td>
                        <td>
                            <a href="view.php?id=<?= $app['id'] ?>" class="btn btn-primary btn-sm">দেখুন</a>
                            <a href="print.php?id=<?= $app['id'] ?>" class="btn btn-print btn-sm">প্রিন্ট</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
            <div style="margin-top:15px;text-align:center;">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <a href="?page=<?= $p ?>&city=<?= $city ?>&search=<?= urlencode($search) ?>" style="display:inline-block;padding:5px 10px;margin:0 2px;background:<?= $p === $page ? '#1a4a8d' : '#eee' ?>;color:<?= $p === $page ? '#fff' : '#333' ?>;border-radius:3px;text-decoration:none;"><?= $p ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <p style="text-align:center;color:#888;padding:40px 0;">কোনো ট্রেড লাইসেন্স পাওয়া যায়নি।</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
