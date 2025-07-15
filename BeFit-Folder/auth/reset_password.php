<?php
require __DIR__ . '/config.php';

$token = $_GET['token'] ?? '';

// At the top of reset_password.php
if (empty($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) {
    header("Location: signin.php?error=invalid_token");
    exit();
}

// Check if token is valid and not expired
$stmt = $pdo->prepare("
    SELECT user_id 
    FROM password_resets 
    WHERE token = ? AND expires_at > NOW()
");
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset) {
    header("Location: signin.php?error=invalid_or_expired_token");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if (empty($password) || empty($confirm_password)) {
        $error = "Both password fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords don't match";
    } elseif (strlen($password) < PASSWORD_MIN_LENGTH) {
        $error = "Password must be at least " . PASSWORD_MIN_LENGTH . " characters";
    } elseif (PASSWORD_NEEDS_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
        $error = "Password needs at least one uppercase letter";
    } elseif (PASSWORD_NEEDS_NUMBER && !preg_match('/[0-9]/', $password)) {
        $error = "Password needs at least one number";
    } else {
        // Update password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $reset['user_id']]);
        
        // Delete the used token
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        
        // Redirect to login with success message
        header("Location: signin.php?password_reset=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | BeFit</title>
    <link rel="stylesheet" href="../public/css/styles1.css">
    <style>
        .reset-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .reset-container h2 {
            color: #4A90E2;
            margin-top: 0;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-group input:focus {
            border-color: #4A90E2;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }
        
        .btn-reset {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4A90E2, #357ABD);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }
        
        .error-message {
            color: #d32f2f;
            padding: 12px;
            margin-bottom: 20px;
            background-color: #ffebee;
            border-radius: 4px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="shared-bg">
    <div class="reset-container">
        <h2>Reset Your Password</h2>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn-reset">Reset Password</button>
        </form>
    </div>
</body>
</html>
