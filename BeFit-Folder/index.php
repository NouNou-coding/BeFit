<?php
// Start session at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once __DIR__ . '/auth/config.php';

// Check login status
$loggedIn = isset($_SESSION['user_id']);

// Handle cart actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add' && isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id]++;
        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    }
}
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles remain unchanged */
        
        /* New cart notification styles */
        .cart-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            transform: translateY(-100px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .cart-notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/includes/header.php'; ?>
    
    <!-- Cart Notification -->
    <?php if (isset($_GET['action']) && $_GET['action'] == 'add'): ?>
    <div class="cart-notification" id="cartNotification">
        <i class="fas fa-check-circle"></i>
        <span>Item added to cart!</span>
    </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <?php if($loggedIn): ?>
            <!-- Dashboard for logged in users -->
            <section class="dashboard-section">
                <div class="welcome-message">
                    <h1>Welcome back, <span class="username"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span></h1>
                    <p>Ready to crush your fitness goals today?</p>
                </div>
                <div class="dashboard-options">
                    <a href="/BeFit-Folder/options/build-workout.php" class="dashboard-btn">
                        <i class="fas fa-dumbbell"></i> Build Workout
                    </a>
                    <a href="/BeFit-Folder/track-progress.php" class="dashboard-btn">
                        <i class="fas fa-chart-line"></i> Track Progress
                    </a>
                    <a href="/BeFit-Folder/ecommerce/cart.php" class="dashboard-btn">
                        <i class="fas fa-shopping-cart"></i> View Cart
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <span class="cart-count"><?= array_sum($_SESSION['cart']) ?></span>
                        <?php endif; ?>
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
                    <h2 class="benefits-title">Why Choose BeFit?</h2>
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <i class="fas fa-robot benefit-icon"></i>
                            <h3 class="benefit-heading">AI-Powered Workouts</h3>
                            <p>Smart algorithms create the perfect workout plan based on your goals, fitness level, and available equipment.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-chart-line benefit-icon"></i>
                            <h3 class="benefit-heading">Real-Time Tracking</h3>
                            <p>Monitor your progress with detailed analytics and get adaptive recommendations to maximize results.</p>
                        </div>
                        <div class="benefit-card">
                            <i class="fas fa-tags benefit-icon"></i>
                            <h3 class="benefit-heading">Exclusive Discounts</h3>
                            <p>Members get special pricing on premium supplements and fitness gear in our curated store.</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Shop Section -->
        <div class="shop-section-container">
            <hr class="section-separator">
            <h2 class="section-title">Premium Products</h2>
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
    <script>
        // Show cart notification
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('cartNotification');
            if (notification) {
                setTimeout(() => {
                    notification.classList.add('show');
                    
                    // Hide after 3 seconds
                    setTimeout(() => {
                        notification.classList.remove('show');
                    }, 3000);
                }, 100);
            }
            
            // Update cart count in header
            function updateCartCount() {
                const cartLinks = document.querySelectorAll('.cart-link');
                const cartCount = <?= !empty($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>;
                
                cartLinks.forEach(link => {
                    let countBadge = link.querySelector('.cart-count');
                    if (!countBadge && cartCount > 0) {
                        countBadge = document.createElement('span');
                        countBadge.className = 'cart-count';
                        link.appendChild(countBadge);
                    }
                    
                    if (countBadge) {
                        countBadge.textContent = cartCount;
                        if (cartCount === 0) {
                            countBadge.remove();
                        }
                    }
                });
            }
            
            updateCartCount();
        });
    </script>
</body>
</html>