<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Fitness</title>
    <link rel="stylesheet" href="/BeFit-Folder/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- In header.php -->
<head>
  <!-- Your existing meta tags, title, etc. -->
  
  <?php if (ALLOW_ANALYTICS): ?>
  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GA_TRACKING_ID ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= GA_TRACKING_ID ?>', { 
      anonymize_ip: true,
      cookie_domain: 'auto',
      cookie_flags: 'SameSite=None;Secure'
    });
  </script>
  <?php endif; ?>
  
</head>
</head>
<body class="shared-bg">
    <nav class="page-header">
        <div class="nav-container">
            <div class="logo-nav">
                <a href="/BeFit-Folder/index.php">
                    <img src="/BeFit-Folder/public/photos/logo1.png" alt="BeFit Logo" class="logo">
                </a>
            </div>
            
            <ul class="nav-links">
                <li><a href="/BeFit-Folder/index.php#shop-section">Shop</a></li>
                <li><a href="/BeFit-Folder/about.php">About</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href="/BeFit-Folder/workout_builder/index.php" <?= basename($_SERVER['PHP_SELF']) == 'workout_builder' ? 'class="active"' : '' ?>>Workout Builder</a></li>
                <li><a href="/BeFit-Folder/ecommerce/cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li><a href="/BeFit-Folder/ecommerce/orders.php"><i class="fas fa-history"></i> Orders</a></li>
            </ul>
    
            <div class="nav-buttons">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="welcome-message">
                        Welcome <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                    </span>
                    <a href="/BeFit-Folder/auth/logout.php" class="cta-button nav-cta">Logout</a>
                <?php else: ?>
                    <a href="/BeFit-Folder/auth/signin.php" class="nav-login">Log In</a>
                    <a href="/BeFit-Folder/auth/signup.php" class="cta-button nav-cta">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main>
