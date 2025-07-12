<?php
require '../auth/config.php';

// Sample equipment products
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
    // Add other equipment products...
];

// Sample supplement products
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
    // Add other supplement products...
];

// Insert equipment
foreach ($equipment as $product) {
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category) 
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $product['name'],
        $product['description'],
        $product['price'],
        $product['image_url'],
        $product['category']
    ]);
}

// Insert supplements
foreach ($supplements as $product) {
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category) 
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $product['name'],
        $product['description'],
        $product['price'],
        $product['image_url'],
        $product['category']
    ]);
}

echo "Products added successfully!";