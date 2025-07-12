<?php
session_start();
require '../auth/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$orders = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$orders->execute([$_SESSION['user_id']]);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="../public/css/styles1.css">
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .order { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .order-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .order-items { margin-top: 10px; }
        .order-item { display: flex; justify-content: space-between; padding: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order History</h1>
        
        <?php if (empty($orders)): ?>
            <p>You have no orders yet.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <div class="order-header">
                        <div>
                            <h3>Order #<?= $order['id'] ?></h3>
                            <p>Date: <?= $order['created_at'] ?></p>
                        </div>
                        <div>
                            <p>Status: <?= ucfirst($order['status']) ?></p>
                            <p>Total: $<?= number_format($order['total'], 2) ?></p>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <h4>Items:</h4>
                        <?php
                        $stmt = $pdo->prepare("
                            SELECT p.name, p.price, oi.quantity 
                            FROM order_items oi
                            JOIN products p ON p.id = oi.product_id
                            WHERE oi.order_id = ?
                        ");
                        $stmt->execute([$order['id']]);
                        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($items as $item):
                        ?>
                            <div class="order-item">
                                <div><?= $item['name'] ?></div>
                                <div>
                                    $<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?> 
                                    = $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <p><a href="shop.php">Continue Shopping</a></p>
    </div>
</body>
</html>