<?php
require 'auth/config.php';

try {
    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            image_url VARCHAR(255),
            category ENUM('equipment', 'supplement') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS order_items (
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )
    ");
    
    // Insert equipment products
    $equipment = [
        [
            'name' => 'FitRx Smart Adjustable Dumbbells - 1kg to 20kg',
            'description' => 'Adjustable dumbbells with smart tracking',
            'price' => 124.99,
            'image_url' => 'photos/dumbell.jpeg',
            'category' => 'equipment'
        ],
        [
            'name' => 'Resistance Band Set 1-5kg',
            'description' => 'Set of resistance bands for full-body workouts',
            'price' => 24.99,
            'image_url' => 'photos/resistance.jpg',
            'category' => 'equipment'
        ],
        [
            'name' => '10 mm lever-action belt for weightlifting',
            'description' => 'Premium weightlifting belt for support',
            'price' => 59.99,
            'image_url' => 'photos/belt.jpg',
            'category' => 'equipment'
        ],
        [
            'name' => 'Portable Doorway Pull-up Bar',
            'description' => 'Portable pull-up bar for home workouts',
            'price' => 44.99,
            'image_url' => 'photos/pullup.jpg',
            'category' => 'equipment'
        ]
    ];
    
    // Insert supplement products
    $supplements = [
        [
            'name' => '2kg Kevin Levrone - Gold Whey Protein',
            'description' => 'Premium whey protein for muscle recovery',
            'price' => 64.99,
            'image_url' => 'photos/prot.webp',
            'category' => 'supplement'
        ],
        [
            'name' => '500g Kevin Levrone - Gold Creatine Monohydrate',
            'description' => 'Pure creatine monohydrate for strength gains',
            'price' => 34.99,
            'image_url' => 'photos/creatine.jpg',
            'category' => 'supplement'
        ],
        [
            'name' => '500g Kevin Levrone - Gold Preworkout',
            'description' => 'Pre-workout supplement for energy and focus',
            'price' => 34.99,
            'image_url' => 'photos/preworkout.jpeg',
            'category' => 'supplement'
        ],
        [
            'name' => '4kg Kevin Levrone - Mass Gainer',
            'description' => 'Mass gainer for weight and muscle gain',
            'price' => 84.99,
            'image_url' => 'photos/mass.jpeg',
            'category' => 'supplement'
        ]
    ];
    
    // Insert all products
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category) 
                          VALUES (:name, :description, :price, :image_url, :category)");
    
    foreach (array_merge($equipment, $supplements) as $product) {
        $stmt->execute($product);
    }
    
    echo "Database setup completed successfully!";
    
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}