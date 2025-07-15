<?php
require __DIR__ . '/config.php';
require __DIR__ . '/mailer.php';

header('Content-Type: application/json');

// Only respond to POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$email = trim($_POST['email'] ?? '');

// Validate email format
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit();
}

try {
    // Check if email exists in database
    $stmt = $pdo->prepare("SELECT id, email, name FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // For security, always return the same message whether user exists or not
    $responseMessage = 'If an account exists with this email, you will receive a password reset link shortly.';

    if ($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration

        // Store token in database
        $stmt = $pdo->prepare("
            INSERT INTO password_resets (user_id, token, expires_at) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                token = VALUES(token), 
                expires_at = VALUES(expires_at),
                created_at = NOW()
        ");
        $stmt->execute([$user['id'], $token, $expiresAt]);

        // Create reset link
        $resetLink = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . 
                    $_SERVER['HTTP_HOST'] . 
                    "/BeFit-Folder/auth/reset_password.php?token=$token";

        // Prepare email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';
        
        $mail->setFrom(SMTP_USER, 'BeFit Support');
        $mail->addAddress($user['email'], $user['name'] ?? '');
        
        $mail->isHTML(true);
        $mail->Subject = 'Your BeFit Password Reset Request';
        
        // Email body
        $mail->Body = "
            <h2>Password Reset Request</h2>
            <p>Hello " . htmlspecialchars($user['name'] ?? 'User') . ",</p>
            <p>We received a request to reset your BeFit account password.</p>
            <p>Click this link to reset your password:</p>
            <p><a href=\"$resetLink\" style=\"background: #4A90E2; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;\">Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
            <p>If you didn't request this, please ignore this email.</p>
            <p>Thanks,<br>The BeFit Team</p>
        ";
        
        $mail->AltBody = "Password Reset Request\n\n" .
            "Hello " . ($user['name'] ?? 'User') . ",\n\n" .
            "We received a request to reset your BeFit account password.\n\n" .
            "Copy and paste this link to reset your password:\n" .
            "$resetLink\n\n" .
            "This link will expire in 1 hour.\n\n" .
            "If you didn't request this, please ignore this email.\n\n" .
            "Thanks,\nThe BeFit Team";
        
        // Send email
        $mail->send();
    }

    // Return success response (even if user doesn't exist, for security)
    echo json_encode(['success' => true, 'message' => $responseMessage]);

} catch (Exception $e) {
    error_log("Password reset error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'An error occurred while processing your request. Please try again later.'
    ]);
}
