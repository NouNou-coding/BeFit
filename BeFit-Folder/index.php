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
            margin: 3rem 0;
            color: #4A90E2;
        }
        .welcome-message h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
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
            margin: 3rem 0;
            flex-wrap: wrap;
        }
        .dashboard-btn {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            color: white;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }
        .dashboard-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        .dashboard-btn i {
            font-size: 1.3rem;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf9 100%);
            border-radius: 0 0 20px 20px;
            margin-bottom: 3rem;
        }
        .hero-title {
            font-size: 2.8rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .hero-subtitle {
            font-size: 1.3rem;
            color: #5a6a7d;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        /* Benefits Section */
        .benefits-section {
            padding: 4rem 2rem;
            background: white;
        }
        .benefits-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .benefits-title {
            text-align: center;
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 3rem;
            font-weight: 700;
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .benefit-card {
            background: #f9fbfd;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e1e8ed;
        }
        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .benefit-icon {
            font-size: 2.5rem;
            color: #4A90E2;
            margin-bottom: 1.5rem;
        }
        .benefit-heading {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .benefit-card p {
            color: #5a6a7d;
            line-height: 1.6;
        }

        /* Shop Section */
        .shop-section-container {
            max-width: 1200px;
            margin: 5rem auto;
            padding: 0 2rem;
        }
        .section-separator {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #4A90E2, transparent);
            margin: 3rem 0;
        }
        .section-title {
            text-align: center;
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 3rem;
            font-weight: 700;
            position: relative;
        }
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #4A90E2;
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .benefits-title, .section-title {
                font-size: 1.8rem;
            }
            .dashboard-btn, .cta-button {
                padding: 1rem 2rem;
            }
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
                    <p>Ready for your next workout?</p>
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
                    Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated.
                </p>
                <a href="/BeFit-Folder/auth/signup.php" class="cta-button">Get Started Now</a>
            </section>
            
            <!-- Benefits Section -->
            <section class="benefits-section">
                <div class="benefits-container">
                    <h2 class="benefits-title">Unlock Exclusive Benefits</h2>
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <i class="fas fa-robot benefit-icon"></i>
                            <h3 class="benefit-heading">AI-Powered Workouts</h3>
                            <p>Get personalized training plans that adapt to your progress and available equipment for optimal results.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-chart-line benefit-icon"></i>
                            <h3 class="benefit-heading">Progress Tracking</h3>
                            <p>Real-time analysis with smart suggestions to optimize your fitness journey and celebrate milestones.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-percentage benefit-icon"></i>
                            <h3 class="benefit-heading">15% Discount</h3>
                            <p>Exclusive member pricing on premium supplements and fitness equipment in our store.</p>
                        </div>
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