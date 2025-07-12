<?php
session_start();
require __DIR__ . '/../auth/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | BeFit</title>
    <link rel="stylesheet" href="../public/css/styles1.css">
    <style>
        .verify-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 2rem;
            background: rgba(255,255,255,0.9);
            border-radius: 15px;
            text-align: center;
        }
        .digit-input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            margin: 0 5px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        .error {
            color: red;
            margin: 1rem 0;
        }
    </style>
</head>
<body class="shared-bg">

<div class="verify-container">
    <h2>Verify Your Email</h2>
    <?php
    // Add session verification
    if (!isset($_SESSION['verification_email'])) {
        die("Verification session expired. Please sign up again.");
    }

    // Show the email being verified
    echo "<p>Enter the 6-digit code sent to ".htmlspecialchars($_SESSION['verification_email'])."</p>";

    // Display errors without redirect
    if (isset($_GET['error'])) {
        echo '<div class="error">'.htmlspecialchars($_GET['error']).'</div>';
    }
    ?>

    <form method="POST">
        <?php // 5. Digit inputs ?>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <input type="text" name="digit<?= $i ?>" class="digit-input" maxlength="1" required>
        <?php endfor; ?>
        
        <button type="submit" class="signup-btn" style="margin-top:1.5rem;">Verify Account</button>
    </form>
</div>

<script>
// Add input auto-focus script
const inputs = document.querySelectorAll('.digit-input');
inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});
</script>

</body>
</html>