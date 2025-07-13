<?php require_once __DIR__ . '/auth/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About BeFit</title>
    <!-- Corrected CSS path -->
    <link rel="stylesheet" href="/BeFit-Folder/public/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reuse your existing styles + add: */
        .about-section {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .about-section h2 {
            color: #4A90E2;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="shared-bg">
    <?php include __DIR__ . '/includes/header.php'; ?>
    
    <main class="main-content">
        <div class="about-section">
            <h2>About BeFit</h2>
            <p>BeFit is your AI-powered fitness companion, offering personalized workout plans tailored to your goals, equipment, and fitness level.</p>
            
            <h3>Our Mission</h3>
            <p>To make fitness accessible and effective for everyone through smart technology.</p>
            
            <h3>Features</h3>
            <ul>
                <li>AI-generated workout plans</li>
                <li>Progress tracking</li>
                <li>Equipment-based exercises</li>
                <li>Supplement recommendations</li>
                <li>Community challenges</li>
            </ul>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <!-- JavaScript -->
    <script src="/BeFit-Folder/public/js/transitions.js"></script>
</body>
</html>