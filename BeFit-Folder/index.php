<?php
// Start session only once at the beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration and header
require_once __DIR__ . '/auth/config.php';
require_once __DIR__ . '/includes/header.php';

// Check login status
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Training Plans</title>
    <!-- Fixed CSS paths -->
    <link rel="stylesheet" href="/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="body-index shared-bg">
    <!-- Content Area -->
    <main>
        <?php if($loggedIn): ?>
            <!-- Dashboard for logged-in users -->
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
            <!-- Hero section for guests -->
            <section class="hero-content">
                <div class="hero-left">
                    <h1>Transform Your Fitness with 
                        <span class="highlight">BeFit AI Precision.</span>
                    </h1>
                    <p class="hero-subtitle">"Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated."</p>
                    <div class="cta-container">
                        <a href="/auth/signup.php" class="cta-button">Get Started Now</a>
                    </div>
                </div>
            </section>

            <!-- Benefits section -->
            <section class="benefits-section">
                <h2>Unlock Exclusive Benefits When You Join BeFit AI</h2>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">+</div>
                        <h3>AI-Powered Workouts</h3>
                        <p>Get personalized training plans that adapt to your progress, goals, and available equipment.</p>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon">▼</div>
                        <h3>Progress Tracking & AI Coaching</h3>
                        <p>Real-time performance analysis with smart suggestions to optimize your results.</p>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon">●</div>
                        <h3>15% Permanent Discount</h3>
                        <p>Exclusive member pricing on all supplements and equipment.</p>
                    </div>
                </div>
            </section>

            <hr class="section-separator">
            <?php include(__DIR__ . '/includes/shop/shop-section.php'); ?>
        <?php endif; ?>
    </main>

    <?php include(__DIR__ . '/includes/footer.php'); ?>
    
    <!-- Fixed JS path -->
    <script src="/public/js/transitions.js"></script>
</body>
</html>