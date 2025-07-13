<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}// Cookie consent check
define('ALLOW_ANALYTICS', 
    isset($_COOKIE['cookie_consent']) && 
    $_COOKIE['cookie_consent'] === 'accepted'
);

// Example usage (later in your HTML head):
if (ALLOW_ANALYTICS) {
    define('GA_TRACKING_ID', 'UA-XXXXX-Y'); // Replace with your ID
}

// Your existing code...
$dbHost = 'localhost';
$dbHost = 'localhost';
$dbName = 'befit_db';
$dbUser = 'root';      // Replace if needed
$dbPass = '';          // Replace if MySQL has a password

if (!defined('PASSWORD_MIN_LENGTH')) {
    define('PASSWORD_MIN_LENGTH', 8);
    define('PASSWORD_NEEDS_UPPERCASE', true);
    define('PASSWORD_NEEDS_NUMBER', true);
   
}
if(!defined('SMTP_HOST')){
    //email configurations
    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_USER', 'yorgobekaiiprofessional@gmail.com');
    define('SMTP_PASS', 'fyji vqld hnth zgxi'); // NOT your regular password
    define('SMTP_PORT', 587);

}
try {
    // Connect to MySQL server (without selecting DB)
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
    $pdo->exec("USE `$dbName`");

    // Create tables (if not exists)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Add other tables (products, orders, etc.) here
    // Or rely on dump.sql for full schema

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


?>
