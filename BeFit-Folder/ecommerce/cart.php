<?php
session_start();
require '../auth/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle cart actions
if (isset($_GET['action'])) {
    // Add to cart
    if ($_GET['action'] == 'add' && isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
    }
    // Remove from cart
    elseif ($_GET['action'] == 'remove' && isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];
        unset($_SESSION['cart'][$product_id]);
    }
    // Checkout
    elseif ($_GET['action'] == 'checkout') {
        if (!empty($_SESSION['cart'])) {
            // Calculate total
            $total = 0;
            $product_ids = array_keys($_SESSION['cart']);
            
            if (!empty($product_ids)) {
                $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
                $stmt->execute($product_ids);
                $cart_products = $stmt->fetchAll();
                
                foreach ($cart_products as $product) {
                    $price = $product['price'];
                    // Apply discount for logged-in users
                    if (isset($_SESSION['user_id'])) {
                        $price = $price * 0.85;
                    }
                    $total += $price * $_SESSION['cart'][$product['id']];
                }
                
                // Create order
                $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
                $stmt->execute([$_SESSION['user_id'] ?? null, $total]);
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
}

// Display cart
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="public/css/styles1.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container">
        <h1>Your Shopping Cart</h1>
        
        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    $product_ids = array_keys($_SESSION['cart']);
                    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
                    $stmt->execute($product_ids);
                    $cart_products = $stmt->fetchAll();
                    
                    foreach ($cart_products as $product):
                        $quantity = $_SESSION['cart'][$product['id']];
                        $price = $product['price'];
                        // Apply discount for logged-in users
                        if (isset($_SESSION['user_id'])) {
                            $price = $price * 0.85;
                        }
                        $subtotal = $price * $quantity;
                        $grand_total += $subtotal;
                    ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td>$<?= number_format($price, 2) ?></td>
                            <td><?= $quantity ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td><a href="cart.php?action=remove&id=<?= $product['id'] ?>">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="cart-summary">
                <h3>Grand Total: $<?= number_format($grand_total, 2) ?></h3>
                <a href="cart.php?action=checkout" class="checkout-btn">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>