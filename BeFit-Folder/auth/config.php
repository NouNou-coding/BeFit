<?php
$dbHost = 'localhost';
$dbName = 'befit_db';
$dbUser = 'root';      // Replace if needed
$dbPass = '';          // Replace if MySQL has a password

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