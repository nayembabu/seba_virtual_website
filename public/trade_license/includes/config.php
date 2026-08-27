<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'mokaddes');
define('DB_PASS', 'Mkds@6652');
define('DB_NAME', 'eserviceportal');
define('BASE_URL', 'https://e-serviceportal.com/trade_license');
define('UPLOAD_DIR', __DIR__ . '/../../storage/app/public/trade-licenses');

function getDB() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getUser() {
    if (!isLoggedIn()) return null;
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT id, name, email, phone FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function old($key) {
    return isset($_SESSION['old'][$key]) ? htmlspecialchars($_SESSION['old'][$key]) : '';
}

function flash($key = null) {
    if ($key === null) return isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    $msg = isset($_SESSION['flash'][$key]) ? $_SESSION['flash'][$key] : '';
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function setFlash($key, $value) {
    $_SESSION['flash'][$key] = $value;
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function asset_path($path) {
    return __DIR__ . '/../' . $path;
}
