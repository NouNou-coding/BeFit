<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data with null coalescing operator
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords don't match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Email already exists!";
        } else {
            // Hash password and create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$name, $email, $hashed_password])) {
                // Auto-login after registration
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Registration failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - Sign Up</title>
    <link rel="stylesheet" href="../css/styles1.css">
    <style>
        html, body {
            height: 100%;
            overflow-y: hidden;
        }

        .signin-container, .signup-container {
            position: relative;
            z-index: 1;
        }

        .form-group.name-group {
            margin-bottom: 1.2rem;
        }

        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem 5%;
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .benefits-column, .form-container {
            flex: 1;
            max-width: 450px;
            padding: 1.5rem;
            height: fit-content;
        }

        .benefits-column {
            color: white;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }

        .benefit-item {
            margin-bottom: 2rem;
        }

        .benefit-item h3 {
            font-size: 1.3rem;
            margin-bottom: 0.6rem;
            color: #4A90E2;
        }

        .benefit-item p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #4A90E2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }

        .terms-checkbox {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #666;
        }

        .terms-checkbox input {
            width: auto;
            margin-right: 0.8rem;
        }

        .terms-checkbox a {
            color: #4A90E2;
            text-decoration: none;
            margin-left: 0.3rem;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
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
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        }


        .account-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #ddd;
        }

        .signin-btn {
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

        .signin-btn:hover {
            background-color: #4A90E2;
            color: white;
             background-color: #357ABD;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .signin-btn:active {
            transform: translateY(1px);
            transition: all 0.1s ease;
        }   

        .signup-btn {
        width: 100%;
        padding: 14px;
        background-color: #4A90E2;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        animation: pulseGlow 2s infinite;
    
        }
        .signup-btn:hover {
            background-color: #357ABD;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .signup-btn:active {
            transform: translateY(1px);
            transition: all 0.1s ease;
        }

        .signup-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: all 0.4s ease;
        }

        .signup-btn:hover::after {
            opacity: 1;
            width: 120%;
            height: 300%;
        }

            @media (max-width: 768px) {
                .signup-container {
                    flex-direction: column;
                    padding: 1rem;
                    overflow-y: auto;
                }

                .benefits-column, .form-container {
                    width: 100%;
                    max-width: none;
                    padding: 1.5rem;
                }

                html, body {
                    overflow-y: auto;
                }
            }
    </style>
</head>
<body class="shared-bg">
    <div class="signup-container">
        
        <div class="benefits-column">
            <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Why Join BeFit?</h2>
            
            <div class="benefit-item">
                <h3>Free AI-Powered Workouts</h3>
                <p>Personalized training plans tailored to your goals and equipment.</p>
            </div>

            <div class="benefit-item">
                <h3>Exclusive Discounts</h3>
                <p>Member-only deals on supplements and gear.</p>
            </div>

            <div class="benefit-item">
                <h3>Smart Progress Tracking</h3>
                <p>Smart monitoring of workouts and nutrition.</p>
            </div>
        </div>

        
        <div class="form-container">
            <h2 style="margin-bottom: 1.5rem; color: #333; text-align: center; font-size: 1.5rem;">Create Account</h2>
            
            <form class="signup-form" method="POST" action="signup.php">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="form-group name-group">
                    <input type="text"  name="name" placeholder="Name" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Create Password" required>
                </div>

                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
                </div>

                <button type="submit" class="signup-btn">Sign Up</button>
            </form>

            <div class="account-section">
                <p style="color: #666; font-size: 0.9rem;">Already have an account?</p>
                <a href="signin.php" class="signin-btn">Sign In Now</a>
            </div>
        </div>
    </div>
</body>
</html>