<?php
$pageTitle = "Terms & Conditions - BeFit";
$activePage = "terms";
require_once __DIR__ . '/auth/config.php';
include __DIR__ . '/includes/header.php';

?>

<section class="terms-hero bg-dark text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">BeFit Terms & Conditions</h1>
                <p class="lead mb-4">The rules that keep our fitness community strong and safe</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#products" class="btn btn-primary btn-lg px-4">Product Terms</a>
                    <a href="#ai" class="btn btn-outline-light btn-lg px-4">AI Program Terms</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="sticky-top pt-3" style="top: 20px;">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Quick Navigation</h5>
                            <ul class="nav flex-column terms-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#introduction">Introduction</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#accounts">Accounts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#products">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#ai">AI Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#subscriptions">Subscriptions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#liability">Liability</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body text-center">
                            <p class="small text-muted">Last Updated</p>
                            <p class="fw-bold mb-0"><?= date('F j, Y') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-lg-5">
                        <article class="terms-content">
                            <section id="introduction" class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-primary text-white me-3">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <h2 class="h3 mb-0">1. Introduction</h2>
                                </div>
                                <p>Welcome to <strong>BeFit</strong> - your complete fitness ecosystem combining premium gym equipment with cutting-edge AI workout technology.</p>
                                <div class="row mt-4 g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded">
                                            <h5 class="h6 text-uppercase text-muted mb-2">E-Commerce</h5>
                                            <p class="mb-0">Shop top-tier supplements, equipment, and fitness gear with confidence.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded">
                                            <h5 class="h6 text-uppercase text-muted mb-2">AI Training</h5>
                                            <p class="mb-0">Personalized workout plans powered by our proprietary AI technology.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="accounts" class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-success text-white me-3">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <h2 class="h3 mb-0">2. Account Terms</h2>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-exclamation-circle me-2"></i> You must be at least 18 years old to create an account.
                                </div>
                                <div class="term-item">
                                    <h5 class="d-flex align-items-center">
                                        <span class="term-badge bg-primary text-white me-2">2.1</span>
                                        Account Security
                                    </h5>
                                    <p>You're responsible for maintaining the confidentiality of your login credentials and all activities under your account.</p>
                                </div>
                                <div class="term-item mt-4">
                                    <h5 class="d-flex align-items-center">
                                        <span class="term-badge bg-primary text-white me-2">2.2</span>
                                        Accuracy
                                    </h5>
                                    <p>All registration information must be current, complete, and accurate to provide you with the best fitness experience.</p>
                                </div>
                            </section>

                            <section id="products" class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-warning text-white me-3">
                                        <i class="fas fa-dumbbell"></i>
                                    </div>
                                    <h2 class="h3 mb-0">3. Product Terms</h2>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-sm bg-primary text-white me-2">
                                                    <i class="fas fa-tag"></i>
                                                </div>
                                                <h5 class="mb-0">Pricing</h5>
                                            </div>
                                            <ul class="list-check">
                                                <li>All prices in USD</li>
                                                <li>Subject to change without notice</li>
                                                <li>Taxes calculated at checkout</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-sm bg-primary text-white me-2">
                                                    <i class="fas fa-truck"></i>
                                                </div>
                                                <h5 class="mb-0">Shipping</h5>
                                            </div>
                                            <ul class="list-check">
                                                <li>3-5 business days processing</li>
                                                <li>Free shipping on orders $99+</li>
                                                <li>International rates apply</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-sm bg-primary text-white me-2">
                                                    <i class="fas fa-undo"></i>
                                                </div>
                                                <h5 class="mb-0">Returns</h5>
                                            </div>
                                            <ul class="list-check">
                                                <li>30-day return policy</li>
                                                <li>Unopened supplements only</li>
                                                <li>15% restocking fee on equipment</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-sm bg-primary text-white me-2">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <h5 class="mb-0">Warranty</h5>
                                            </div>
                                            <ul class="list-check">
                                                <li>1-year equipment warranty</li>
                                                <li>Manufacturer defects only</li>
                                                <li>Proof of purchase required</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="ai" class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-danger text-white me-3">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <h2 class="h3 mb-0">4. AI Services</h2>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i> <strong>Important:</strong> Our AI provides fitness suggestions only, not medical advice.
                                </div>
                                
                                <div class="term-highlight-box bg-light p-4 rounded mb-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <div class="icon-lg bg-white text-danger shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-heartbeat"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <h5 class="mb-2">Health Disclaimer</h5>
                                            <p class="mb-0">Consult with a physician before beginning any exercise program. BeFit is not responsible for any injuries resulting from your workout activities.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-4 mt-3">
                                    <div class="col-md-6">
                                        <div class="p-3 border-start border-3 border-primary bg-light rounded">
                                            <h5 class="d-flex align-items-center">
                                                <i class="fas fa-lock text-primary me-2"></i>
                                                Data Privacy
                                            </h5>
                                            <p class="mb-0">Your workout data is encrypted and never sold to third parties.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border-start border-3 border-primary bg-light rounded">
                                            <h5 class="d-flex align-items-center">
                                                <i class="fas fa-chart-line text-primary me-2"></i>
                                                Continuous Improvement
                                            </h5>
                                            <p class="mb-0">Our AI learns from aggregated, anonymized data to improve recommendations.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="subscriptions" class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-info text-white me-3">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                    <h2 class="h3 mb-0">5. Subscriptions</h2>
                                </div>
                                
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Plan Type</th>
                                                <th>Billing Cycle</th>
                                                <th>Cancellation</th>
                                                <th>Refunds</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Premium</td>
                                                <td>Monthly/Annual</td>
                                                <td>Anytime</td>
                                                <td>No partial refunds</td>
                                            </tr>
                                            <tr>
                                                <td>Pro</td>
                                                <td>Annual Only</td>
                                                <td>Before renewal</td>
                                                <td>Prorated</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="callout-box bg-primary text-white p-4 rounded">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-bell fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-2">Auto-Renewal Notice</h5>
                                            <p class="mb-0">Subscriptions automatically renew unless canceled at least 48 hours before the end of the current period.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="liability" class="mb-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-box bg-secondary text-white me-3">
                                        <i class="fas fa-balance-scale"></i>
                                    </div>
                                    <h2 class="h3 mb-0">6. Liability</h2>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <h5 class="d-flex align-items-center mb-3">
                                                <i class="fas fa-times-circle text-danger me-2"></i>
                                                Not Responsible For
                                            </h5>
                                            <ul class="list-x">
                                                <li>Product misuse or modifications</li>
                                                <li>Workout-related injuries</li>
                                                <li>Third-party service issues</li>
                                                <li>Force majeure events</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 h-100 bg-white shadow-sm rounded">
                                            <h5 class="d-flex align-items-center mb-3">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                Your Protections
                                            </h5>
                                            <ul class="list-check">
                                                <li>Manufacturer warranties</li>
                                                <li>Secure payment processing</li>
                                                <li>Data encryption</li>
                                                <li>Responsive support team</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </article>
                        
                        <div class="text-center mt-5 pt-4 border-top">
                            <h4 class="mb-4">Questions About Our Terms?</h4>
                            <a href="contact.php" class="btn btn-primary btn-lg px-4 me-2">
                                <i class="fas fa-envelope me-2"></i> Contact Us
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-file-download me-2"></i> Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<style>
    .terms-hero {
        background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
        position: relative;
        overflow: hidden;
    }
    
    .terms-hero::after {
        content: "";
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        height: 100px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23f8f9fa"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23f8f9fa"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23f8f9fa"/></svg>');
        background-size: cover;
        transform: rotate(180deg);
    }
    
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .icon-sm {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .icon-lg {
        width: 70px;
        height: 70px;
    }
    
    .term-badge {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    
    .list-check {
        list-style: none;
        padding-left: 0;
    }
    
    .list-check li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 10px;
    }
    
    .list-check li::before {
        content: "\f00c";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #4A90E2;
    }
    
    .list-x {
        list-style: none;
        padding-left: 0;
    }
    
    .list-x li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 10px;
    }
    
    .list-x li::before {
        content: "\f00d";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #dc3545;
    }
    
    .terms-nav .nav-link {
        color: #495057;
        padding: 8px 0;
        border-left: 3px solid transparent;
    }
    
    .terms-nav .nav-link.active {
        color: #4A90E2;
        border-left-color: #4A90E2;
        font-weight: 600;
    }
    
    .term-highlight-box {
        border-left: 4px solid #4A90E2;
    }
    
    .callout-box {
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.2);
    }
    
    @media (max-width: 991.98px) {
        .sticky-top {
            position: static !important;
        }
    }
</style>

<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
            
            // Update active nav item
            document.querySelectorAll('.terms-nav .nav-link').forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Update active nav item on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section[id]');
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (pageYOffset >= sectionTop) {
                current = section.getAttribute('id');
            }
        });
        
        document.querySelectorAll('.terms-nav .nav-link').forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
</script>