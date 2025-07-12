<footer style="
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 2rem 0;
    text-align: center;
    margin-top: auto; /* Pushes footer to bottom */
">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Quick Links -->
        <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 1rem;">
            <a href="index.php" style="color: #4A90E2; text-decoration: none;">Home</a>
            <a href="about.php" style="color: #4A90E2; text-decoration: none;">About</a>
            <a href="contact.php" style="color: #4A90E2; text-decoration: none;">Contact</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" style="color: #4A90E2; text-decoration: none;">Logout</a>
            <?php else: ?>
                <a href="signin.php" style="color: #4A90E2; text-decoration: none;">Login</a>
            <?php endif; ?>
        </div>
        
        <!-- Copyright -->
        <p style="opacity: 0.8; font-size: 0.9rem;">
            &copy; <?= date('Y') ?> BeFit. All rights reserved.
        </p>
    </div>
</footer>
