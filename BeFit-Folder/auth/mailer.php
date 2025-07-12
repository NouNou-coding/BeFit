<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer classes
require __DIR__ . '/../vendor/autoload.php';

function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);
    
    try {
        // Debug settings (must be set AFTER instantiating PHPMailer)
        $mail->SMTPDebug = 3; // Enable verbose debug output
        $mail->Debugoutput = function($str, $level) {
            file_put_contents(__DIR__.'/smtp_debug.log', 
                date('Y-m-d H:i:s')." [$level] $str\n", 
                FILE_APPEND
            );
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->Timeout    = 30; // Increase timeout

        // Recipients
        $mail->setFrom(SMTP_USER, 'BeFit AI');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your BeFit Verification Code';
        $mail->Body    = "Your verification code is: <b>$code</b>";
        $mail->AltBody = "Your verification code is: $code";

        // Security settings
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $e->getMessage());
        return false;
    }
}