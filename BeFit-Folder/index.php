<?php
// Start session at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once __DIR__ . '/auth/config.php';

// Check login status
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Fitness</title>
    <!-- CSS -->
    <link rel="stylesheet" href="/BeFit-Folder/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Welcome Message Styling */
        .welcome-message {
            text-align: center;
            margin: 2rem 0;
            color: #4A90E2;
        }
        .welcome-message h1 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
        }
        .username {
            color: #2c3e50;
            font-weight: bold;
        }

        /* Dashboard Options */
        .dashboard-options {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 2rem 0;
            flex-wrap: wrap;
        }
        .dashboard-btn {
            background: #4A90E2;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .dashboard-btn:hover {
            background: #357ABD;
            transform: translateY(-3px);
        }

        /* Shop Section Container */
        .shop-section-container {
            margin: 3rem 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/includes/header.php'; ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <?php if($loggedIn): ?>
            <!-- Dashboard for logged in users -->
            <section class="dashboard-section">
                <div class="welcome-message">
                    <h1>Welcome back, <span class="username"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span></h1>
                </div>
                <div class="dashboard-options">
                    <a href="/BeFit-Folder/options/build-workout.php" class="dashboard-btn">
                        <i class="fas fa-dumbbell"></i> Build Workout
                    </a>
                    <a href="/BeFit-Folder/track-progress.php" class="dashboard-btn">
                        <i class="fas fa-chart-line"></i> Track Progress
                    </a>
                </div>
            </section>
        <?php else: ?>
            <!-- Hero Section -->
            <section class="hero-section">
                <h1 class="hero-title">Transform Your Fitness with BeFit AI Precision</h1>
                <p class="hero-subtitle">
                    "Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated."
                </p>
                <a href="/BeFit-Folder/auth/signup.php" class="cta-button">Get Started Now</a>
            </section>
            
            <!-- Benefits Section -->
            <section class="benefits-section">
                <h2>Unlock Exclusive Benefits</h2>
                <div class="benefits-container">
                    <div class="benefit-card">
                        <h3><i class="fas fa-robot"></i> AI-Powered Workouts</h3>
                        <p>Get personalized training plans that adapt to your progress and equipment.</p>
                    </div>
                    <div class="benefit-card">
                        <h3><i class="fas fa-chart-line"></i> Progress Tracking</h3>
                        <p>Real-time analysis with smart suggestions to optimize results.</p>
                    </div>
                    <div class="benefit-card">
                        <h3><i class="fas fa-percentage"></i> 15% Discount</h3>
                        <p>Exclusive member pricing on all supplements and equipment.</p>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Shop Section -->
        <div class="shop-section-container">
            <hr class="section-separator">
            <h2 class="section-title">Our Products</h2>
            <?php 
            // Include shop section with absolute path
            $shopSectionPath = __DIR__ . '/includes/shop/shop-section.php';
            if (file_exists($shopSectionPath)) {
                include $shopSectionPath;
            } else {
                echo '<p class="error-message">Shop section is currently unavailable. Please check back later.</p>';
            }
            ?>
        </div>
    </main>
    
    <!-- Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <!-- JavaScript -->
    <script src="/BeFit-Folder/public/js/transitions.js"></script>
</body>
</html>