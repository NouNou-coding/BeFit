<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Fitness</title>
    <link rel="stylesheet" href="../public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active nav link
            const currentPage = location.pathname.split('/').pop() || 'index.php';
            document.querySelectorAll('.nav-links a').forEach(link => {
                const linkPage = link.getAttribute('href').split('/').pop();
                if (currentPage === linkPage || (currentPage === 'index.php' && linkPage === '')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</head>
<body class="shared-bg">
    <nav class="page-header">
        <div class="nav-container">
            <div class="logo-nav">
                <a href="../index.php">
                    <img src="../public/photos/logo1.png" alt="BeFit Logo" class="logo">
                </a>
            </div>
            
            <ul class="nav-links">
                <li><a href="../index.php#shop-section">Shop</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="../ecommerce/cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li><a href="../ecommerce/orders.php"><i class="fas fa-history"></i> Orders</a></li>
            </ul>
    
            <div class="nav-buttons">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span style="color: white; margin-right: 15px;">
                        Welcome <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                    </span>
                    <a href="../auth/logout.php" class="cta-button nav-cta">Logout</a>
                <?php else: ?>
                    <a href="../auth/signin.php" class="nav-login">Log In</a>
                    <a href="../auth/signup.php" class="cta-button nav-cta">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main>