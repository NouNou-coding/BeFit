<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

// Log SMTP activity and error handling (delete?)
file_put_contents(__DIR__.'/smtp_debug.log', 
    date('Y-m-d H:i:s')." - Attempting to send to: $email\n", 
    FILE_APPEND
);

$mail->SMTPDebug = 3; // Full debug output
$mail->Debugoutput = function($str, $level) {
    file_put_contents(__DIR__.'/smtp_debug.log', "$level: $str\n", FILE_APPEND);
};
/////////
function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_USER, 'BeFit AI');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your BeFit Verification Code';
        $mail->Body    = "Your verification code is: <b>$code</b>";
        
        $mail->SMTPDebug = 3;//enable verbose debugging
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        return false;
    }
}