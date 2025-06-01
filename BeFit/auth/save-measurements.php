<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

$stmt = $pdo->prepare("UPDATE users SET 
    weight = ?, 
    height = ?, 
    age = ? 
    WHERE id = ?");

$stmt->execute([
    $_POST['weight'],
    $_POST['height'],
    $_POST['age'],
    $_SESSION['user_id']
]);

echo json_encode(['success' => true]);