<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About BeFit - Contact & Support</title>
    <link rel="stylesheet" href="css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .about-section {
            background: #0a0a0a;
            color: #ffffff;
            padding: 4rem 0;
            min-height: 100vh;
        }
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        .contact-card {
            background: #1a1a1a;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
        }
        .support-button {
            background: #4A90E2;
            color: white !important;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }
        .support-button:hover {
            background: #357ABD;
            transform: translateY(-2px);
        }
        .contact-icon {
            font-size: 2rem;
            color: #4A90E2;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="page-header">
        <!-- Copy the same navigation from index.php -->
        <div class="nav-container">
            <div class="logo-nav">
                <a href="index.php">
                <img src="photos/logo1.png" alt="BeFit Logo" class="logo">
                </a>
            </div>
                
            <ul class="nav-links">
                <li><a href="index.php#shop-section">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#support">Support</a></li>
            </ul>
    
            <div class="nav-buttons">
                <a href="auth/signin.php" class="nav-login">Log In</a>
                <a href="auth/signup.php" class="cta-button nav-cta">Get Started</a>
            </div>
        </div>
    </nav>

    <section class="about-section">
        <div class="about-container">
            <h2 class="benefits-title">Contact & Support</h2>
            
            <div class="about-grid">
                <div class="contact-card">
                    <i class="fas fa-envelope contact-icon"></i>
                    <h3>Email Support</h3>
                    <p>General Inquiries<br>
                    <a href="mailto:info@befit.com" class="contact-link">info@befit.com</a></p>
                    
                    <p>Technical Support<br>
                    <a href="mailto:support@befit.com" class="contact-link">support@befit.com</a></p>
                </div>

                <div class="contact-card">
                    <i class="fas fa-map-marker-alt contact-icon"></i>
                    <h3>Headquarters</h3>
                    <p>BeFit AI Center<br>
                    123 Fitness Street<br>
                    London, UK<br>
                    EC2A 4ST</p>
                </div>

                <div class="contact-card">
                    <i class="fas fa-phone-volume contact-icon"></i>
                    <h3>Phone Support</h3>
                    <p>Mon-Fri: 9AM - 6PM GMT<br>
                    +44 20 7123 4567</p>
                    <a href="#support" class="support-button">
                        <i class="fas fa-headset"></i> Live Chat
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script src="transitions.js"></script>
</body>
</html>