<?php
require 'auth/config.php';
try{
// Insert sample products
$products = [
    // Equipment
    [
        'name' => 'FitRx Smart Adjustable Dumbbells - 1kg to 20kg',
        'description' => 'Adjustable dumbbells with smart tracking',
        'price' => 124.99,
        'image_url' => 'public/photos/dumbell.jpeg',
        'category' => 'equipment'
    ],
    [
        'name' => 'Resistance Band Set 1-5kg',
        'description' => 'Set of resistance bands for full-body workouts',
        'price' => 24.99,
        'image_url' => 'public/photos/resistance.jpg',
        'category' => 'equipment'
    ],
    [
        'name' => '10 mm lever-action belt for weightlifting',
        'description' => 'Premium weightlifting belt for support',
        'price' => 59.99,
        'image_url' => 'public/photos/belt.jpg',
        'category' => 'equipment'
    ],
    [
        'name' => 'Portable Doorway Pull-up Bar',
        'description' => 'Portable pull-up bar for home workouts',
        'price' => 44.99,
        'image_url' => 'public/photos/pullup.jpg',
        'category' => 'equipment'
    ],
    
    // Supplements
    [
        'name' => '2kg Kevin Levrone - Gold Whey Protein',
        'description' => 'Premium whey protein for muscle recovery',
        'price' => 64.99,
        'image_url' => 'public/photos/prot.webp',
        'category' => 'supplement'
    ],
    [
        'name' => '500g Kevin Levrone - Gold Creatine Monohydrate',
        'description' => 'Pure creatine monohydrate for strength gains',
        'price' => 34.99,
        'image_url' => 'public/photos/creatine.jpg',
        'category' => 'supplement'
    ],
    [
        'name' => '500g Kevin Levrone - Gold Preworkout',
        'description' => 'Pre-workout supplement for energy and focus',
        'price' => 34.99,
        'image_url' => 'public/photos/preworkout.jpeg',
        'category' => 'supplement'
    ],
    [
        'name' => '4kg Kevin Levrone - Mass Gainer',
        'description' => 'Mass gainer for weight and muscle gain',
        'price' => 84.99,
        'image_url' => 'public/photos/mass.jpeg',
        'category' => 'supplement'
    ]
];

$stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category) 
                          VALUES (?, ?, ?, ?, ?)");
    
    foreach ($products as $product) {
        $stmt->execute([
            $product['name'],
            $product['description'],
            $product['price'],
            $product['image_url'],
            $product['category']
        ]);
    }

    echo "Database setup completed successfully!";
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}