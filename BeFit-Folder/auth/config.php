<?php
// At the VERY TOP of config.php (before session_start())
if (!defined('ALLOW_ANALYTICS')) {
    define('ALLOW_ANALYTICS', 
        isset($_COOKIE['cookie_consent']) && 
        $_COOKIE['cookie_consent'] === 'accepted'
    );
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (ALLOW_ANALYTICS && !defined('GA_TRACKING_ID')) {
    define('GA_TRACKING_ID', 'UA-XXXXX-Y'); // Replace with your actual ID
}

// Your existing database configuration...
$dbHost = 'localhost';
$dbName = 'befit_db';
$dbUser = 'root';
$dbPass = '';

if (!defined('PASSWORD_MIN_LENGTH')) {
    define('PASSWORD_MIN_LENGTH', 8);
    define('PASSWORD_NEEDS_UPPERCASE', true);
    define('PASSWORD_NEEDS_NUMBER', true);
}

if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_USER', 'yorgobekaiiprofessional@gmail.com');
    define('SMTP_PASS', 'fyji vqld hnth zgxi');
    define('SMTP_PORT', 587);
}

try {
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
    $pdo->exec("USE `$dbName`");
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
