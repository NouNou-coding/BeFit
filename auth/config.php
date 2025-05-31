<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// auth/config.php
    
$host = 'localhost';

$db   = 'befit';

$user = 'root';    // Default XAMPP username

$pass = '';        // Default XAMPP password (blank)

$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Prevent direct access
// Prevent direct access
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    die("Direct access forbidden");
}
