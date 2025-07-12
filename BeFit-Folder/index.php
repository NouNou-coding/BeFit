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
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF3D57; /* Energetic coral */
            --primary-dark: #E5354B;
            --dark: #0A0A0A;
            --light: #FDFDFD;
            --accent: #00C2FF; /* Bright teal */
            --bg-gradient: linear-gradient(135deg, #0F0F15 0%, #1E1E2A 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: var(--light);
            overflow-x: hidden;
        }
        
        h1, h2, h3 {
            font-family: 'Archivo', sans-serif;
            font-weight: 800;
            letter-spacing: -0.03em;
        }
        
        /* Welcome Message */
        .welcome-message {
            text-align: center;
            margin: 6rem 0 4rem;
            position: relative;
        }
        .welcome-message h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            color: var(--primary);
            margin-bottom: 0.5rem;
            line-height: 1.1;
        }
        .username {
            color: var(--dark);
            position: relative;
            display: inline-block;
        }
        .username::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent);
            transform: skewX(-15deg);
        }
        .welcome-message p {
            font-size: 1.3rem;
            color: var(--dark);
            opacity: 0.8;
            max-width: 600px;
            margin: 1rem auto 0;
        }

        /* Dashboard Options */
        .dashboard-options {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 3rem 0 6rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }
        .dashboard-btn {
            background: var(--dark);
            color: white;
            padding: 1.3rem 2.2rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid var(--dark);
            position: relative;
            overflow: hidden;
        }
        .dashboard-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary);
            transition: all 0.4s ease;
            z-index: -1;
        }
        .dashboard-btn:hover {
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 61, 87, 0.3);
        }
        .dashboard-btn:hover::before {
            left: 0;
        }
        .dashboard-btn i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }
        .dashboard-btn:hover i {
            transform: scale(1.2);
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 8rem 2rem 10rem;
            position: relative;
            background: var(--bg-gradient);
            color: white;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            margin-bottom: -5rem;
        }
        .hero-title {
            font-size: clamp(2.8rem, 6vw, 4.5rem);
            margin-bottom: 1.5rem;
            line-height: 1.1;
            background: linear-gradient(90deg, #FF3D57 0%, #00C2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        .hero-subtitle {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            max-width: 700px;
            margin: 0 auto 3rem;
            opacity: 0.9;
            font-weight: 400;
        }
        .cta-button {
            display: inline-block;
            background: transparent;
            color: white;
            padding: 1.1rem 2.8rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary);
            z-index: -1;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }
        .cta-button:hover {
            color: white;
        }
        .cta-button:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Benefits Section */
        .benefits-section {
            padding: 8rem 2rem 6rem;
            position: relative;
            background: white;
        }
        .benefits-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }
        .benefits-title {
            text-align: center;
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 5rem;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }
        .benefits-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 20%;
            width: 60%;
            height: 4px;
            background: var(--accent);
            transform: skewX(-15deg);
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            position: relative;
            z-index: 2;
        }
        .benefit-card {
            background: white;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 0;
            background: var(--primary);
            transition: all 0.4s ease;
        }
        .benefit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .benefit-card:hover::before {
            height: 100%;
        }
        .benefit-icon {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .benefit-heading {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        .benefit-card p {
            color: var(--dark);
            opacity: 0.8;
        }

        /* Shop Section */
        .shop-section-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 6rem 2rem;
            position: relative;
        }
        .section-title {
            text-align: center;
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 5rem;
            position: relative;
        }
        .section-title span {
            position: relative;
            display: inline-block;
        }
        .section-title span::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary);
            transform: skewX(-15deg);
        }

        /* Decorative Elements */
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 194, 255, 0.1);
            z-index: 1;
        }
        .circle-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
        }
        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: 100px;
            left: -100px;
            background: rgba(255, 61, 87, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 6rem 1.5rem 8rem;
                clip-path: polygon(0 0, 100% 0, 100% 95%, 0 100%);
            }
            .dashboard-options {
                flex-direction: column;
                align-items: center;
            }
            .dashboard-btn {
                width: 100%;
                max-width: 280px;
            }
            .benefits-grid {
                grid-template-columns: 1fr;
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
                    <p>Ready to push your limits?</p>
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
                <div class="floating-circle circle-1"></div>
                <h1 class="hero-title">Transform Your Fitness with BeFit AI</h1>
                <p class="hero-subtitle">
                    Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated.
                </p>
                <a href="/BeFit-Folder/auth/signup.php" class="cta-button">Get Started Now</a>
            </section>
            
            <!-- Benefits Section -->
            <section class="benefits-section">
                <div class="floating-circle circle-2"></div>
                <div class="benefits-container">
                    <h2 class="benefits-title">Why BeFit Stands Out</h2>
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <i class="fas fa-bolt benefit-icon"></i>
                            <h3 class="benefit-heading">Adaptive AI</h3>
                            <p>Our algorithms evolve with you, constantly optimizing workouts based on your performance.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-brain benefit-icon"></i>
                            <h3 class="benefit-heading">Smart Analysis</h3>
                            <p>Real-time feedback and predictive insights to maximize every session.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-gem benefit-icon"></i>
                            <h3 class="benefit-heading">Premium Access</h3>
                            <p>Exclusive member benefits including discounts on top-tier supplements.</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Shop Section -->
        <div class="shop-section-container">
            <h2 class="section-title"><span>Curated Excellence</span></h2>
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