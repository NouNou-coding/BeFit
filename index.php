<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - AI-Powered Training Plans</title>
    <link rel="stylesheet" href="css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-content {
            background-attachment: fixed;
        }
        .section-separator {
            margin: 50px auto;
            width: 80%;
            border: 0;
            border-top: 2px solid #ddd;
        }
    </style>
</head>
<body>
    
    <nav class="page-header">
    <div class="nav-container">
        <div class="logo-nav">
            <a href="index1.html">
            <img src="photos/logo1.png" alt="BeFit Logo" class="logo">
            </a>
        </div>
            
            <ul class="nav-links">
                <li><a href="#shop-section">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#">Support</a></li>
            </ul>
    
            <div class="nav-buttons">
                <a href="/auth/signin.php" class="nav-login">Log In</a>
                <a href="/auth/signup.php" class="cta-button nav-cta">Get Started</a>
            </div>
        </div>
    </nav>
    

    <div class="hero-content">
        <div class="hero-left">
            <h1>Transform Your Fitness with 
                <span class="highlight"><br>BeFit AI Precision.</span>
            </h1>
            <h3>"Workouts Tailored to You—Powered by Goals, Level & Equipment. Strength Simplified, Supplements Curated."
            </h3>
            <div class="cta-container">
                <a href="signup3.html" class="cta-button">Get Started Now</a>
            </div>
        </div>  
    </div>

    <hr class="section-separator">

    <?php include('benefits.php'); ?>


    <!-- Shop Section -->
    <?php 
    session_start();
    include('includes/shop-section.php');
     ?>


    <?php include('includes/footer.php'); ?>
    <script src="transitions.js"></script>
</body>
</html>