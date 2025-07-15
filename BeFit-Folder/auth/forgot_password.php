<?php
require __DIR__ . '/config.php';
require __DIR__ . '/mailer.php';

// Enable detailed error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Get and sanitize email
$email = trim($_POST['email'] ?? '');

// Validate email format
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit();
}

try {
    // Check if user exists (security: don't reveal if user exists)
    $stmt = $pdo->prepare("SELECT id, email, name FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Standard response (same whether user exists or not)
    $response = [
        'success' => true,
        'message' => 'If an account exists with this email, you will receive a password reset link shortly.'
    ];

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
                    dirname($_SERVER['PHP_SELF']) . 
                    "/reset_password.php?token=$token";

        error_log("Password reset link generated for {$user['email']}: $resetLink");

        // Configure PHPMailer with debugging
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP [Level $level]: $str");
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 30;

        // Recipients
        $mail->setFrom(SMTP_USER, 'BeFit Support');
        $mail->addAddress($user['email'], $user['name'] ?? '');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your BeFit Password Reset Link';
        
        $mail->Body = "
            <h2>Password Reset Request</h2>
            <p>Hello " . htmlspecialchars($user['name'] ?? 'User') . ",</p>
            <p>We received a request to reset your password. Click the button below to proceed:</p>
            <p style='text-align: center; margin: 25px 0;'>
                <a href='$resetLink' style='background: #4A90E2; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;'>
                    Reset Password
                </a>
            </p>
            <p>If you didn't request this, please ignore this email.</p>
            <p>This link will expire in 1 hour.</p>
            <p>Thanks,<br>The BeFit Team</p>
        ";

        $mail->AltBody = "Password Reset Request\n\n" .
            "Hello " . ($user['name'] ?? 'User') . ",\n\n" .
            "We received a request to reset your password. Visit this link to proceed:\n" .
            "$resetLink\n\n" .
            "If you didn't request this, please ignore this email.\n" .
            "This link will expire in 1 hour.\n\n" .
            "Thanks,\nThe BeFit Team";

        // Send email
        if ($mail->send()) {
            error_log("Password reset email successfully sent to {$user['email']}");
        } else {
            throw new Exception('Failed to send email, but no exception was thrown');
        }
    }

    // Return success response
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Password reset error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request. Please try again later.'
    ]);
}
