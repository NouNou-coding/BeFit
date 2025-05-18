<div class="shop-section">
    <h2>Supplements</h2>
    <div class="shop-items">
        <div class="shop-item">
            <img src="photos/prot.webp" alt="protein" class="item-image">
            <div class="item-name">2kg Kevin Levrone - Gold Whey Protein</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$64.99</div>
                    <div class="discounted-price">$55.24 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$64.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <div class="item-description">
                24g protein per serving, low sugar, mixes instantly. Perfect for post-workout recovery.
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>
        
        <!-- Repeat for other supplement items -->

        <div class="shop-item">
            <img src="photos/creatine.jpg" alt="Creatine" class="item-image">
            <div class="item-name">500g Kevin Levrone - Gold Creatine Monohydrate</div>
            <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$34.99</div>
                    <div class="discounted-price">$29.99 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$34.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <div class="item-description">
                Pure micronized creatine for increased strength and muscle gains. Unflavored versatility.
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>

        <div class="shop-item">
            <img src="photos/preworkout.jpeg" alt="Pre-Workout" class="item-image">
            <div class="item-name">500g Kevin Levrone - Gold Preworkout</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$34.99</div>
                    <div class="discounted-price">$29.99 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$34.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <div class="item-description">
                Caffeine-packed formula with beta-alanine for intense focus and endurance.
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>

        <div class="shop-item">
            <img src="photos/mass.jpeg" alt="BCAAs" class="item-image">
            <div class="item-name">4kg Kevin Levrone - Mass Gainer</div>
             <div class="price-container">
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="original-price">$84.99</div>
                    <div class="discounted-price">$72.24 (15% OFF)</div>
                <?php else: ?>
                    <div class="item-price">$84.99</div>
                    <div class="signin-notice">Sign in to unlock 15% discount</div>
                <?php endif; ?>
            </div>
            <div class="item-description">
                A perfect blend to gain weight mass as fast as possible.
            </div>
            <a href="#" class="buy-button">Add to Cart</a>
        </div>
</div>
</div>