<?php
$pageTitle = "Terms & Conditions - BeFit";
$activePage = "terms";
require_once __DIR__ . '/auth/config.php';
include __DIR__ . '/includes/header.php';

?>

<main class="terms-page">
    <section class="terms-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1>BeFit Terms & Conditions</h1>
                <p class="subtitle">Last updated: <?= date('F j, Y') ?></p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="terms-container">
            <article class="terms-content">
                <section class="terms-section">
                    <h2><span class="section-number">1</span> Introduction</h2>
                    <p>Welcome to BeFit. These terms govern your use of our fitness products and AI workout services. By accessing our platform, you agree to these conditions.</p>
                </section>

                <section class="terms-section">
                    <h2><span class="section-number">2</span> Account Registration</h2>
                    <div class="terms-grid">
                        <div class="term-card">
                            <div class="term-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h3>Age Requirement</h3>
                            <p>You must be at least 18 years old to create an account.</p>
                        </div>
                        <div class="term-card">
                            <div class="term-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3>Account Security</h3>
                            <p>You're responsible for maintaining your login credentials.</p>
                        </div>
                    </div>
                </section>

                <section class="terms-section">
                    <h2><span class="section-number">3</span> Product Terms</h2>
                    <div class="terms-table">
                        <div class="table-row header">
                            <div class="table-cell">Category</div>
                            <div class="table-cell">Policy</div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">Shipping</div>
                            <div class="table-cell">3-5 business days</div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">Returns</div>
                            <div class="table-cell">30 days for unopened items</div>
                        </div>
                        <div class="table-row">
                            <div class="table-cell">Warranty</div>
                            <div class="table-cell">1 year on equipment</div>
                        </div>
                    </div>
                </section>

                <section class="terms-section">
                    <h2><span class="section-number">4</span> AI Services</h2>
                    <div class="notice-box important">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Our AI provides fitness suggestions only, not medical advice. Consult a physician before beginning any program.</p>
                    </div>
                    <ul class="styled-list">
                        <li>Workout data is encrypted and secure</li>
                        <li>Personalized recommendations improve over time</li>
                        <li>Plans are for personal use only</li>
                    </ul>
                </section>

                <section class="terms-section">
                    <h2><span class="section-number">5</span> Liability</h2>
                    <p>BeFit is not responsible for injuries resulting from workout programs or product misuse. Equipment warranties cover manufacturer defects only.</p>
                </section>

                <div class="terms-actions">
                    <a href="contact.php" class="btn-primary">Contact Support</a>
                    <a href="#" class="btn-secondary">Download PDF</a>
                </div>
            </article>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

<style>
.terms-page {
    background: #f8f9fa;
    padding-bottom: 80px;
}

.terms-hero {
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    padding: 80px 0;
    color: white;
    text-align: center;
    margin-bottom: 60px;
}

.terms-hero h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.terms-hero .subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.terms-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    padding: 50px;
}

.terms-section {
    margin-bottom: 50px;
    padding-bottom: 50px;
    border-bottom: 1px solid #eee;
}

.terms-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.terms-section h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.section-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #4A90E2;
    color: white;
    border-radius: 50%;
    font-size: 0.9rem;
    margin-right: 15px;
}

.terms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.term-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    transition: transform 0.2s;
}

.term-card:hover {
    transform: translateY(-5px);
}

.term-icon {
    width: 50px;
    height: 50px;
    background: #4A90E2;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.term-card h3 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: #2c3e50;
}

.terms-table {
    margin-top: 30px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 0 1px #eee;
}

.table-row {
    display: flex;
}

.table-row.header {
    background: #4A90E2;
    color: white;
}

.table-row:not(.header) {
    background: white;
}

.table-row:not(.header):nth-child(even) {
    background: #f8f9fa;
}

.table-cell {
    padding: 15px 20px;
    flex: 1;
}

.notice-box {
    padding: 20px;
    border-radius: 8px;
    margin: 25px 0;
    display: flex;
    align-items: flex-start;
}

.notice-box.important {
    background: #fff8e6;
    border-left: 4px solid #ffc107;
}

.notice-box i {
    margin-right: 15px;
    font-size: 1.2rem;
    color: #ffc107;
}

.styled-list {
    list-style: none;
    padding-left: 0;
    margin-top: 20px;
}

.styled-list li {
    padding-left: 30px;
    position: relative;
    margin-bottom: 12px;
}

.styled-list li:before {
    content: "•";
    color: #4A90E2;
    font-size: 1.5rem;
    position: absolute;
    left: 0;
    top: -3px;
}

.terms-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 60px;
}

.btn-primary {
    background: #4A90E2;
    color: white;
    padding: 12px 25px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #357ABD;
}

.btn-secondary {
    background: white;
    color: #4A90E2;
    padding: 12px 25px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    border: 1px solid #4A90E2;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #f8f9fa;
}

@media (max-width: 768px) {
    .terms-container {
        padding: 30px;
    }
    
    .terms-grid {
        grid-template-columns: 1fr;
    }
    
    .terms-actions {
        flex-direction: column;
        gap: 15px;
    }
}
</style>