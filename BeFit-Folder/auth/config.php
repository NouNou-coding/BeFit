<?php
// At the VERY TOP of config.php (before session_start())
if (!defined('ALLOW_ANALYTICS')) {
    $cookiePath = '/BeFit-Folder/'; // Match your site structure
    $cookieName = 'cookie_consent';
    
    // Check for cookie in the correct path
    $cookieValue = $_COOKIE[$cookieName] ?? '';
    define('ALLOW_ANALYTICS', $cookieValue === 'accepted');
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
    define('SMTP_USER', 'befitcompany.contact@gmail.com');
    define('SMTP_PASS', 'yzqa psik rafu sszd');
    define('SMTP_PORT', 587);
}

try {
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
    $pdo->exec("USE `$dbName`");
    $pdo->exec("
         CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'completed') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
        )
    "); function updateOrderStatuses($pdo) {
    // Get all pending orders older than 10 minutes
    $stmt = $pdo->prepare("
        SELECT id FROM orders 
        WHERE status = 'pending' 
        AND created_at < DATE_SUB(NOW(), INTERVAL 10 MINUTE)
    ");
    $stmt->execute();
    $oldOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($oldOrders)) {
        // Update them to completed
        $ids = array_column($oldOrders, 'id');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $updateStmt = $pdo->prepare("
            UPDATE orders 
            SET status = 'completed', 
                status_updated_at = NOW() 
            WHERE id IN ($placeholders)
        ");
        $updateStmt->execute($ids);
    }
}

// Call this function at the start of any order-related page
updateOrderStatuses($pdo);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
