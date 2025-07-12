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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;  /* Deep blue */
            --primary-light: #3B82F6;
            --dark: #111827;    /* Near-black */
            --light: #F9FAFB;   /* Off-white */
            --gray: #6B7280;    /* Medium gray */
            --border-radius: 8px;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background: var(--light);
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0;
        }

        /* Welcome Message (Logged In) */
        .welcome-message {
            text-align: center;
            margin: 5rem 0 3rem;
        }
        .welcome-message h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        .username {
            color: var(--primary);
            position: relative;
        }
        .welcome-message p {
            font-size: 1.25rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Dashboard Buttons */
        .dashboard-options {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 3rem 0 5rem;
            flex-wrap: wrap;
        }
        .dashboard-btn {
            background: var(--dark);
            color: white;
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: 2px solid var(--dark);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dashboard-btn:hover {
            background: transparent;
            color: var(--dark);
        }
        .dashboard-btn i {
            font-size: 1.1rem;
        }

        /* Hero Section (Logged Out) */
        .hero-section {
            text-align: center;
            padding: 8rem 2rem;
            background: var(--dark);
            color: white;
            margin-bottom: 4rem;
        }
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            margin-bottom: 1.5rem;
            color: white;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 700px;
            margin: 0 auto 2.5rem;
            font-weight: 400;
        }
        .cta-button {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: 2px solid var(--primary);
        }
        .cta-button:hover {
            background: transparent;
            color: var(--primary);
        }

        /* Benefits Section */
        .benefits-section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .benefits-title {
            text-align: center;
            font-size: clamp(2rem, 5vw, 2.5rem);
            margin-bottom: 4rem;
            color: var(--dark);
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .benefit-card {
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        .benefit-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        .benefit-heading {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .benefit-card p {
            color: var(--gray);
            margin: 0;
        }

        /* Shop Section */
        .shop-section {
            padding: 5rem 2rem;
            background: var(--dark);
            color: white;
            margin-top: 4rem;
        }
        .section-title {
            text-align: center;
            font-size: clamp(2rem, 5vw, 2.5rem);
            margin-bottom: 3rem;
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-options {
                flex-direction: column;
                align-items: center;
            }
            .dashboard-btn, .cta-button {
                width: 100%;
                max-width: 280px;
                justify-content: center;
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
            <section>
                <div class="welcome-message">
                    <h1>Welcome back, <span class="username"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span></h1>
                    <p>Ready to push your limits today?</p>
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
                <h1 class="hero-title">Transform Your Fitness with BeFit AI</h1>
                <p class="hero-subtitle">
                    Workouts tailored to your goals, level, and equipment. Strength simplified.
                </p>
                <a href="/BeFit-Folder/auth/signup.php" class="cta-button">Get Started Now</a>
            </section>
            
            <!-- Benefits Section -->
            <section class="benefits-section">
                <h2 class="benefits-title">Why Choose BeFit?</h2>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <i class="fas fa-robot benefit-icon"></i>
                        <h3 class="benefit-heading">AI-Powered</h3>
                        <p>Adaptive workouts that evolve with your progress.</p>
                    </div>
                    <div class="benefit-card">
                        <i class="fas fa-bolt benefit-icon"></i>
                        <h3 class="benefit-heading">Efficient</h3>
                        <p>Maximize results with optimized training plans.</p>
                    </div>
                    <div class="benefit-card">
                        <i class="fas fa-tag benefit-icon"></i>
                        <h3 class="benefit-heading">Member Discounts</h3>
                        <p>Exclusive pricing on premium supplements.</p>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Shop Section -->
        <section class="shop-section">
            <h2 class="section-title">Premium Products</h2>
            <?php 
            $shopSectionPath = __DIR__ . '/includes/shop/shop-section.php';
            if (file_exists($shopSectionPath)) {
                include $shopSectionPath;
            } else {
                echo '<p style="text-align: center;">Shop section coming soon.</p>';
            }
            ?>
        </section>
    </main>
    
    <!-- Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <!-- JavaScript -->
    <script src="/BeFit-Folder/public/js/transitions.js"></script>
</body>
</html>