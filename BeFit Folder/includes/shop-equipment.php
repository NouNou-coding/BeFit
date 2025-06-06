<div class="shop-section">
    <h2>Equipment</h2>
    <div class="scroll-container">

    <div class="shop-items">

        <div class="shop-item">
        <img src="photos/dumbell.jpeg" alt="Dumbbells" class="item-image">
            <div class="item-name">FitRx Smart Adjustable Dumbbells - 1kg to 20kg</div>
            <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$124.99</div>
                    <div class="discounted-price">$104.99 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$124.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>
        
        <div class="shop-item">
            <img src="photos/resistance.jpg" alt="Resistance Bands" class="item-image">
            <div class="item-name">Resistance Band Set 1-5kg</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$24.99</div>
                    <div class="discounted-price">$20.99 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$24.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>
        
        <div class="shop-item">
            <img src="photos/belt.jpg" alt="belt" class="item-image">
            <div class="item-name">10 mm lever-action belt for weightlifting</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$59.99</div>
                    <div class="discounted-price">$50.99 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$59.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>
        
        <div class="shop-item">
            <img src="photos/pullup.jpg" alt="pullup" class="item-image">
            <div class="item-name">Portable Doorway Pull-up Bar</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$44.99</div>
                    <div class="discounted-price">$38.25(15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$44.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>

    </div>
</div>
</div>