<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_code = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . 
                 $_POST['digit4'] . $_POST['digit5'] . $_POST['digit6'];
    
    if ($user_code == $_SESSION['verification_code']) {
        $stmt = $pdo->prepare("UPDATE users SET verified = 1 WHERE email = ?");
        $stmt->execute([$_SESSION['verification_email']]);
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$_SESSION['verification_email']]);
        $user = $stmt->fetch();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        
        unset($_SESSION['verification_email']);
        unset($_SESSION['verification_code']);
        
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: signup.php?error=Invalid verification code");
        exit();
    }
}
?>
