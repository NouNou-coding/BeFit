<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<form class="signin-form" method="POST" action="signin.php">


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - Sign In</title>
    <link rel="stylesheet" href="../css/styles1.css">
    <style>
        /* Custom styles for signin page */
        html, body {
            height: 100%;
            overflow-y: hidden;
        }
        
        .signup-switch-btn:hover {
            background-color: rgba(255, 255, 255, 0.25);
            border-color: #4A90E2;
            transform: translateY(-2px);
            color: #4A90E2;
        }

        .signup-switch-btn {
            display: inline-block;
            padding: 12px 35px;
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }


        .signin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 5%;
            gap: 4rem;
        }

        .left-column, .right-column {
            flex: 1;
            max-width: 450px;
            padding: 2rem;
        }

        .right-column {
            text-align: center;
            color: white;
        }

        .signin-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #4A90E2;
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
            transition: background-color 0.3s ease;
        }

        .signin-btn:hover {
            background-color: #357ABD;
        }

        .extra-links {
            margin-top: 1.5rem;
            text-align: center;
        }

        .logo-signin {
            width: 180px;
            margin: 2rem 0;
        }

        @media (max-width: 768px) {
            .signin-container {
                flex-direction: column;
                padding: 2rem;
            }
            
            .left-column, .right-column {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="signin-container">
        <!-- Left Column - Signin Form -->
        <div class="left-column">
            <form class="signin-form">
                <h2 style="margin-bottom: 2rem; color: #333;">Sign In to BeFit</h2>
                
                <div class="form-group">
                    <input type="email" placeholder="Email Address" required>
                </div>
                
                <div class="form-group">
                    <input type="password" placeholder="Password" required>
                </div>

                <button type="submit" class="signin-btn">Sign In</button>

                <div class="extra-links">
                    <p style="margin: 1rem 0; color: #666;">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </p>

                        <a href="#" style="color: #4A90E2; text-decoration: none;">Forgot Password?</a>
                </div>
            </form>
        </div>

        <!-- Right Column - Welcome Message -->
        <div class="right-column">
            <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Welcome Back!</h2>
            <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.9;">
                Continue your fitness journey with personalized AI-powered training plans.
            </p>
            <img src="photos/logo1.png" alt="BeFit Logo" class="logo-signin">

             <div style="margin-top: 3rem;">
                <p style="color: white; margin-bottom: 1rem;">Don't have an account?</p>
                <a href="signup.php" class="signup-switch-btn">Create Account</a>
            </div>
        </div>
    </div>
</body>
</html>