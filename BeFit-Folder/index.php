<?php
// Start session only once at the very beginning
session_start();

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
    <!-- Corrected CSS paths for BeFit-Folder -->
    <link rel="stylesheet" href="/BeFit-Folder/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Main Content Styles */
        .main-content {
            min-height: calc(100vh - 120px);
            padding: 2rem 5%;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('/BeFit-Folder/public/photos/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        
        /* Benefits Section */
        .benefits-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .benefit-card {
            background: rgba(255,255,255,0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
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
                <h1>Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></h1>
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
                        <p>Personalized training plans that adapt to your progress and equipment.</p>
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
    </main>
    
    <!-- Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <!-- Corrected JS path -->
    <script src="/BeFit-Folder/public/js/transitions.js"></script>
</body>
</html>