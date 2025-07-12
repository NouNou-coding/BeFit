<?php
session_start();
require '../auth/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Create orders and order_items tables if not exists
$pdo->exec("CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total DECIMAL(10,2),
    status ENUM('pending','completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
    order_id INT,
    product_id INT,
    quantity INT
)");

// Get products
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Handle cart actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add' && isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id]++;
    }
    elseif ($_GET['action'] == 'remove' && isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    elseif ($_GET['action'] == 'checkout') {
        if (!empty($_SESSION['cart']) && isset($_SESSION['user_id'])) {
            // Calculate total
            $total = 0;
            $product_ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $cart_products = $stmt->fetchAll();
            
            foreach ($cart_products as $product) {
                $total += $product['price'] * $_SESSION['cart'][$product['id']];
            }
            
            // Create order
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $total]);
            $order_id = $pdo->lastInsertId();
            
            // Add order items
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$order_id, $product_id, $quantity]);
            }
            
            // Clear cart
            unset($_SESSION['cart']);
            
            header("Location: orders.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="../public/css/styles1.css">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .product-card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; text-align: center; }
        .cart { border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin-top: 30px; }
        .cart-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" style="max-width: 100%; height: 150px; object-fit: cover;">
                    <?php endif; ?>
                    <h3><?= $product['name'] ?></h3>
                    <p>$<?= number_format($product['price'], 2) ?></p>
                    <a href="shop.php?action=add&id=<?= $product['id'] ?>">Add to Cart</a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cart">
            <h2>Shopping Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php
                $total = 0;
                $product_ids = array_keys($_SESSION['cart']);
                $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
                $stmt->execute($product_ids);
                $cart_products = $stmt->fetchAll();
                
                foreach ($cart_products as $product):
                    $quantity = $_SESSION['cart'][$product['id']];
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                ?>
                    <div class="cart-item">
                        <div>
                            <h4><?= $product['name'] ?></h4>
                            <p>$<?= number_format($product['price'], 2) ?> x <?= $quantity ?></p>
                        </div>
                        <div>
                            <p>$<?= number_format($subtotal, 2) ?></p>
                            <a href="shop.php?action=remove&id=<?= $product['id'] ?>">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 20px; text-align: right;">
                    <h3>Total: $<?= number_format($total, 2) ?></h3>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="shop.php?action=checkout">Checkout</a>
                    <?php else: ?>
                        <p>Please <a href="login.php">login</a> to checkout</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Your cart is empty</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>