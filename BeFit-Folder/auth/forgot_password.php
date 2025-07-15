<?php
require __DIR__ . '/config.php';
require __DIR__ . '/mailer.php';

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Please enter your email address']);
    exit();
}

// Check if email exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'No account found with that email']);
    exit();
}

// Generate a unique token
$token = bin2hex(random_bytes(32));
$expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration

// Store token in database
$stmt = $pdo->prepare("
    INSERT INTO password_resets (user_id, token, expires_at) 
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
");
$stmt->execute([$user['id'], $token, $expires]);

// Create reset link
$resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/BeFit-Folder/auth/reset_password.php?token=$token";

// Send email
$subject = "Password Reset Request";
$body = "
    <h2>Password Reset Request</h2>
    <p>We received a request to reset your password. Click the link below to proceed:</p>
    <p><a href='$resetLink' style='background: #4A90E2; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
    <p>If you didn't request this, please ignore this email.</p>
    <p>This link will expire in 1 hour.</p>
";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;
    
    $mail->setFrom(SMTP_USER, 'BeFit Support');
    $mail->addAddress($email);
    
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
    
    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Password reset link sent to your email']);
} catch (Exception $e) {
    error_log("Mail Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to send reset email. Please try again.']);
}
