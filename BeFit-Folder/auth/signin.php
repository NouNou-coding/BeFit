<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
    if (empty($user['verified'])) {
        $_SESSION['verification_email'] = $user['email'];
        $_SESSION['verification_code'] = rand(100000, 999999);
        $error = "Account not verified! Check your email for the code.";
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: ../index.php");
        exit();
    }
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
    <link rel="stylesheet" href="../public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .signup-btn {
            display: inline-block;
            padding: 8px 25px;
            background-color: transparent;
            color: #4A90E2;
            border: 2px solid #4A90E2;
            border-radius: 20px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    
        .signup-btn:hover {
            background-color: #4A90E2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }
    
        .signup-btn:active {
            transform: translateY(1px);
        }
    
        html, body {
            height: 100%;
            overflow-y: hidden;
        }

        .signin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem 5%;
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .welcome-column, .form-container {
            flex: 1;
            max-width: 450px;
            padding: 1.5rem;
            height: fit-content;
        }

        .welcome-column {
            color: white;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            backdrop-filter: blur(5px);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .welcome-column h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #4A90E2;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }

        .logo-signin {
            width: 150px;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #4A90E2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }

        .signin-btn {
            width: 100%;
            padding: 14px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .signin-btn:hover {
            background-color: #357ABD;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .extra-links {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #ddd;
        }

        .forgot-password {
            color: #4A90E2;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error-message {
            background: #FED7D7;
            color: #C53030;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .signin-container {
                flex-direction: column;
                padding: 1rem;
                overflow-y: auto;
            }

            .welcome-column, .form-container {
                width: 100%;
                max-width: none;
                padding: 1.5rem;
            } /* Smooth transitions */
input, button {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

/* Glow effect on focus */
input:focus {
    box-shadow: 0 0 10px rgba(74, 144, 226, 0.5);
}

/* Button hover effects */
.signup-btn:hover, .signin-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
}

/* Modern input styling */
input {
    border: none;
    border-bottom: 2px solid #ddd;
    border-radius: 0;
    padding: 10px 0;
    background: transparent;
}

input:focus {
    border-bottom-color: #4A90E2;
    outline: none;
}

/* Floating labels */
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group input:not(:placeholder-shown) + label {
    transform: translateY(-20px);
    font-size: 0.8rem;
    color: #4A90E2;
}

.form-group label {
    position: absolute;
    left: 0;
    bottom: 10px;
    color: #999;
    transition: all 0.3s;
    pointer-events: none;
}

            html, body {
                overflow-y: auto;
            }
        }
    </style>
</head>
<body class="shared-bg">
    <div class="signin-container">
        <div class="welcome-column">
            <img src="../public/photos/logo1.png" alt="BeFit Logo" class="logo-signin">
            <h2>Welcome Back</h2>
            <p style="font-size: 1.1rem; opacity: 0.9;">Continue your fitness journey with personalized workouts and progress tracking</p>
        </div>

        <div class="form-container">
            <?php if(isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
<?php if(isset($error) && strpos($error, 'Account not verified') !== false): ?>
<div id="verificationModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; display: flex; justify-content: center; align-items: center;">
    <div style="background: white; padding: 2rem; border-radius: 10px; max-width: 400px; width: 100%;">
        <h3 style="color: #4A90E2; margin-bottom: 1rem;">Verify Your Email</h3>
        <p>Enter the 6-digit code sent to your email:</p>
        
        <form method="POST" action="verify_email.php">
            <div style="display: flex; gap: 10px; margin: 1rem 0;">
                <input type="text" name="digit1" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
                <input type="text" name="digit2" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
                <input type="text" name="digit3" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
                <input type="text" name="digit4" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
                <input type="text" name="digit5" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
                <input type="text" name="digit6" maxlength="1" style="width: 40px; text-align: center; font-size: 1.5rem;" required>
            </div>
            <button type="submit" class="signin-btn">Verify Account</button>
        </form>
    </div>
</div>
<?php endif; ?>

            <form method="POST" action="signin.php">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 1rem;">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="signin-btn">Sign In</button>

                <div class="extra-links">
                     <a href="#" class="forgot-password">Forgot Password?</a>
                        <div style="margin-top: 1.5rem;">
                            <p style="color: #666; margin-bottom: 0.5rem;">Don't have an account?</p>
                            <a href="signup.php" class="signup-btn">Sign Up Now</a>
                        </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
