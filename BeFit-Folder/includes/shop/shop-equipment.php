<?php
require realpath(dirname(__FILE__) . '/../../auth/config.php');

// Get equipment products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'equipment'");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="shop-section">
    <h2>Equipment</h2>
    <div class="shop-items">
        <?php foreach ($products as $product): ?>
            <div class="shop-item">
                <img src="/public/<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="item-image">
                <div class="item-name"><?= $product['name'] ?></div>
                <div class="price-container">
                    <?php if(isset($_SESSION['user'])): ?>
                        <?php
                        $discountedPrice = $product['price'] * 0.85;
                        ?>
                        <div class="original-price">$<?= number_format($product['price'], 2) ?></div>
                        <div class="discounted-price">$<?= number_format($discountedPrice, 2) ?> (15% OFF)</div>
                    <?php else: ?>
                        <div class="item-price">$<?= number_format($product['price'], 2) ?></div>
                        <div class="signin-notice">Sign in to unlock 15% discount</div>
                    <?php endif; ?>
                </div>
                <a href="../ecommerce/cart.php?action=add&id=<?= $product['id'] ?>" class="buy-button">Add to Cart</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>