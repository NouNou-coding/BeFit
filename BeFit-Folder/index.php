<?php
// Start session only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration and header
require_once __DIR__ . '/auth/config.php';
require_once __DIR__ . '/includes/header.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Training Plans</title>
    <link rel="stylesheet" href="/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-content, .dashboard-content {
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

    <?php if($loggedIn): ?>
        <!-- Logged-in Content -->
        <div class="dashboard-content">
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
            <div class="dashboard-options">
                <a href="/options/build-workout.php" class="dashboard-btn">
                    <i class="fas fa-dumbbell"></i>
                    Build Your Workout
                </a>
                <a href="/track-progress.php" class="dashboard-btn">
                    <i class="fas fa-chart-line"></i>
                    Track Your Progress
                </a>
            </div>
            <hr class="section-separator">
            <?php include(__DIR__ . '/includes/shop/shop-section.php'); ?>
        </div>
    <?php else: ?>
        <!-- Guest Content -->
        <div class="hero-content">
            <div class="hero-left">
                <h1>Transform Your Fitness with 
                    <span class="highlight"><br>BeFit AI Precision.</span>
                </h1>
                <h3>"Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated."</h3>
                <div class="cta-container">
                    <a href="/auth/signup.php" class="cta-button">Get Started Now</a>
                </div>
            </div> 
        </div>
        <hr class="section-separator">
        <?php include(__DIR__ . '/benefits.php'); ?>
        <?php include(__DIR__ . '/includes/shop/shop-section.php'); ?>
    <?php endif; ?>

    <?php include(__DIR__ . '/includes/footer.php'); ?>
    <script src="/public/js/transitions.js"></script>
</body>
</html>