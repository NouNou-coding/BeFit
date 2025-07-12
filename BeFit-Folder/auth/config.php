<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constants only if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/BeFit-Folder/');
}

if (!defined('HF_API_KEY')) {
    define('HF_API_KEY', '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'); 
}

    
$host = 'localhost';
$db   = 'befit_db';
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
    
    // Create tables with MariaDB-compatible syntax
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image_url VARCHAR(255),
        category VARCHAR(20) NOT NULL
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL
    )");
    
    // Add workout_plans table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS workout_plans (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        weight DECIMAL(5,2),
        height INT,
        age INT,
        goal VARCHAR(255),
        training_days INT,
        equipment VARCHAR(255),
        workout_plan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}