<?php
session_start();
require 'auth/config.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
define('BASE_PATH', __DIR__);

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Training Plans</title>
    <link rel="stylesheet" href="public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nav-container, .hero-content, .dashboard-content {
            position: relative;
            z-index: 1;
        }

        .hero-content {
            background-attachment: fixed;
        }
        .section-separator {
            margin: 50px auto;
            width: 80%;
            border: 0;
            border-top: 2px solid #ddd;
        }
        .dashboard-content {
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }

        .dashboard-options {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 3rem;
        }

        .dashboard-btn {
            background: rgba(255, 255, 255, 0.15);
            padding: 2rem 3rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .dashboard-btn i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .dashboard-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="body-index shared-bg">
    <nav class="page-header">
    <div class="nav-container">
        <div class="logo-nav">
            <a href="index.php">
            <img src="public/photos/logo1.png" alt="BeFit Logo" class="logo">
            </a>
        </div>
            
            <ul class="nav-links">
                <li><a href="#shop-section">Shop</a></li>
                <li><a href="ecommerce/cart.php">Cart</a></li>
                <li><a href="ecommerce/orders.php">My Orders</a></li>
                <li><a href="about.php">About</a></li>  
            </ul>
    
            <div class="nav-buttons">
                <?php if($loggedIn): ?>
                    <span style="color: white; margin-right: 15px;">Welcome <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <a href="auth/logout.php" class="cta-button nav-cta">Logout</a>
                <?php else: ?>
                    <a href="auth/signin.php" class="nav-login">Log In</a>
                    <a href="auth/signup.php" class="cta-button nav-cta">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if($loggedIn): ?>
        <!-- Logged-in Content -->
        <div class="dashboard-content">
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
            <div class="dashboard-options">
                <a href="../options/build-workout.php" class="dashboard-btn">
                    <i class="fas fa-dumbbell"></i>
                    Build Your Workout
                </a>
                <a href="../track-progress.php" class="dashboard-btn">
                    <i class="fas fa-chart-line"></i>
                    Track Your Progress
                </a>
            </div>
             <hr class="section-separator">
            <?php include('includes/shop/shop-section.php'); ?>
        </div>
    <?php else: ?>

        <div class="hero-content">
        <div class="hero-left">
            <h1>Transform Your Fitness with 
                <span class="highlight"><br>BeFit AI Precision.</span>
            </h1>
            <h3>"Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated."
            </h3>
            <div class="cta-container">
                <a href="auth/signup.html" class="cta-button">Get Started Now</a>
            </div>
        </div> 
    </div>
        <hr class="section-separator">
        <?php include('benefits.php'); ?>
        <?php include('includes/shop/shop-section.php'); ?>
   <?php endif; ?> 
        </div>

    <?php include('includes/footer.php'); ?>
    <script src="transitions.js"></script>
</body>
</html>