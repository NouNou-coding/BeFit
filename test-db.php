<?php
require 'auth/config.php';

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();
    echo "<h2>Database Connection Successful!</h2>";
    echo "<pre>" . print_r($users, true) . "</pre>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}