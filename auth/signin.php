<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - Sign In</title>
    <link rel="stylesheet" href="../css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #4A90E2;
            --dark-blue: #2B6CB0;
            --gradient-start: #4A90E2;
            --gradient-end: #63B3ED;
        }

        .signin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        }

        .signin-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 440px;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo {
            width: 120px;
            margin-bottom: 1.5rem;
        }

        .signin-title {
            text-align: center;
            color: #2D3748;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .input-field {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #F7FAFC;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }

        .input-label {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-field:focus + .input-label,
        .input-field:not(:placeholder-shown) + .input-label {
            top: -10px;
            left: 10px;
            font-size: 0.85rem;
            color: var(--primary-blue);
            background: white;
            padding: 0 5px;
        }

        .signin-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
            font-size: 1rem;
        }

        .signin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
        }

        .extra-links {
            margin-top: 1.8rem;
            text-align: center;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .forgot-password {
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .social-login {
            margin-top: 2rem;
            text-align: center;
        }

        .social-text {
            color: #718096;
            margin-bottom: 1rem;
            position: relative;
        }

        .social-text::before,
        .social-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E2E8F0;
            margin: auto;
        }

        .social-text span {
            padding: 0 1rem;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin-top: 1.5rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #EDF2F7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 480px) {
            .signin-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .logo {
                width: 100px;
            }
        }

        /* Error Message Styling */
        .error-message {
            background: #FED7D7;
            color: #C53030;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="shared-bg">
    <div class="signin-container">
        <div class="signin-card">
            <div class="logo-container">
                <img src="../photos/logo1.png" alt="BeFit Logo" class="logo">
            </div>

            <?php if(isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <h1 class="signin-title">Welcome Back</h1>
            
            <form method="POST" action="signin.php">
                <div class="form-group">
                    <input type="email" name="email" class="input-field" placeholder=" " required>
                    <label class="input-label">Email Address</label>
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="input-field" placeholder=" " required>
                    <label class="input-label">Password</label>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="signin-btn">Sign In</button>

                <div class="social-login">
                    <div class="social-text">
                        <span>Or continue with</span>
                    </div>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-apple"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <div class="extra-links">
                    <p>Don't have an account? <a href="signup.php" class="forgot-password">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>