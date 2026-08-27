<?php
require_once __DIR__ . '/includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $pdo = getDB();
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('index.php');
        } else {
            $error = 'ভুল ইমেইল বা পাসওয়ার্ড';
        }
    } else {
        $error = 'ইমেইল ও পাসওয়ার্ড দিন';
    }
}
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>লগইন - ট্রেড লাইসেন্স</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
.login-wrap { display:flex; justify-content:center; align-items:center; min-height:100vh; background:#f0f2f5; }
.login-box { background:#fff; padding:40px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); width:400px; }
.login-box h2 { text-align:center; margin-bottom:25px; color:#1a4a8d; }
.login-box .form-group { margin-bottom:15px; }
.login-box label { display:block; margin-bottom:5px; font-weight:bold; font-size:14px; }
.login-box input[type="email"],
.login-box input[type="password"] { width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-size:14px; }
.login-box .btn { width:100%; padding:12px; background:#1a4a8d; color:#fff; border:none; border-radius:5px; font-size:16px; cursor:pointer; }
.login-box .btn:hover { background:#143a6f; }
.error { color:#d32f2f; text-align:center; margin-bottom:15px; font-weight:bold; }
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <h2>ট্রেড লাইসেন্স ব্যবস্থাপনা</h2>
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>ইমেইল</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>পাসওয়ার্ড</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">লগইন</button>
        </form>
    </div>
</div>
</body>
</html>
