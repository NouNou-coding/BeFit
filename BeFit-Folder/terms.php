<?php
$pageTitle = "Terms & Conditions - BeFit";
require_once __DIR__ . '/auth/config.php';
include __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-4 mb-4 text-center">Terms & Conditions</h1>
            <p class="text-muted text-center mb-5">Last Updated: <?= date('F j, Y') ?></p>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">1. Introduction</h2>
                    <p>Welcome to BeFit ("we," "our," or "us"). These Terms & Conditions govern your use of our:</p>
                    <ul>
                        <li>E-commerce platform for gym equipment and supplements</li>
                        <li>AI-powered workout builder and fitness programs</li>
                        <li>Mobile applications and web services</li>
                    </ul>
                    <p>By accessing or using our services, you agree to be bound by these terms.</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">2. Account Registration</h2>
                    <p>To use our AI workout builder or make purchases:</p>
                    <ul>
                        <li>You must be at least 18 years old</li>
                        <li>Provide accurate and complete information</li>
                        <li>Maintain the security of your credentials</li>
                        <li>Are responsible for all activities under your account</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">3. Product Purchases</h2>
                    <h3 class="h5 mt-3">3.1 Pricing and Payment</h3>
                    <ul>
                        <li>All prices are in USD and subject to change</li>
                        <li>We accept major credit cards and PayPal</li>
                        <li>You authorize us to charge your payment method</li>
                    </ul>

                    <h3 class="h5 mt-4">3.2 Shipping & Returns</h3>
                    <ul>
                        <li>Standard shipping: 3-5 business days</li>
                        <li>Returns accepted within 30 days (unopened supplements)</li>
                        <li>Equipment returns subject to 15% restocking fee</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">4. AI Workout Builder</h2>
                    <ul>
                        <li>Our AI provides suggestions, not medical advice</li>
                        <li>Consult a physician before beginning any program</li>
                        <li>We're not liable for injuries from following workouts</li>
                        <li>Workout plans are for personal use only</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">5. Subscription Services</h2>
                    <ul>
                        <li>Monthly/annual plans available</li>
                        <li>Auto-renewal unless canceled 48 hours before cycle</li>
                        <li>No refunds for partial subscription periods</li>
                        <li>Premium features may change without notice</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">6. Intellectual Property</h2>
                    <p>All content (workouts, designs, software) is owned by BeFit.</p>
                    <p>You may not:</p>
                    <ul>
                        <li>Reverse engineer our AI models</li>
                        <li>Resell or redistribute workout plans</li>
                        <li>Use our branding without permission</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">7. Limitation of Liability</h2>
                    <p>BeFit is not liable for:</p>
                    <ul>
                        <li>Damages from product misuse</li>
                        <li>Injuries from following workout programs</li>
                        <li>Third-party services we integrate with</li>
                        <li>Acts beyond our reasonable control</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">8. Changes to Terms</h2>
                    <p>We may modify these terms at any time. Continued use constitutes acceptance.</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">9. Contact Us</h2>
                    <p>Questions? Contact our support team:</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> legal@befit.com</li>
                        <li><i class="fas fa-phone me-2"></i> (800) 555-FITN</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Fitness Ave, Boston, MA 02115</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>