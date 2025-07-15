<?php
function getUserWorkoutData(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare("SELECT * FROM workout_plans WHERE user_id = ? ORDER BY last_updated DESC LIMIT 1");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

function saveUserWorkoutData(PDO $pdo, int $userId, array $data): bool {
    $existing = getUserWorkoutData($pdo, $userId);
    
    if ($existing) {
        // Update existing plan
        $stmt = $pdo->prepare("UPDATE workout_plans SET 
            weight = ?, height = ?, age = ?, gender = ?, fitness_level = ?, 
            goal = ?, training_days = ?, equipment = ?, medical_conditions = ?, 
            preferences = ?, last_updated = NOW() 
            WHERE user_id = ? AND id = ?");
        
        return $stmt->execute([
            $data['weight'], $data['height'], $data['age'], $data['gender'], 
            $data['fitness_level'], $data['goal'], $data['training_days'], 
            $data['equipment'], $data['medical_conditions'], $data['preferences'],
            $userId, $existing['id']
        ]);
    } else {
        // Create new plan
        $stmt = $pdo->prepare("INSERT INTO workout_plans (
            user_id, weight, height, age, gender, fitness_level, goal, 
            training_days, equipment, medical_conditions, preferences
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        return $stmt->execute([
            $userId, $data['weight'], $data['height'], $data['age'], $data['gender'], 
            $data['fitness_level'], $data['goal'], $data['training_days'], 
            $data['equipment'], $data['medical_conditions'], $data['preferences']
        ]);
    }
}

function saveWorkoutPlan(PDO $pdo, int $userId, array $plan): bool {
    $jsonPlan = json_encode($plan);
    
    $stmt = $pdo->prepare("UPDATE workout_plans SET 
        workout_plan = ?, last_updated = NOW() 
        WHERE user_id = ? ORDER BY last_updated DESC LIMIT 1");
    
    return $stmt->execute([$jsonPlan, $userId]);
}

function saveSupplementRecommendations(PDO $pdo, int $userId, array $recommendations): bool {
    // First clear any existing recommendations
    $pdo->prepare("DELETE FROM recommended_supplements WHERE user_id = ?")->execute([$userId]);
    
    // Map product names to IDs (this should be enhanced with a proper lookup)
    $productMap = [
        'FitRx Smart Adjustable Dumbbells' => 1,
        'Resistance Band Set' => 2,
        'Weightlifting Belt' => 3,
        'Whey Protein' => 5,
        'Creatine Monohydrate' => 6,
        'Preworkout' => 7,
        'Mass Gainer' => 8
    ];
    
    // Save each recommendation
    foreach ($recommendations as $rec) {
        $productId = $productMap[$rec['name']] ?? null;
        if ($productId) {
            $stmt = $pdo->prepare("INSERT INTO recommended_supplements 
                (user_id, product_id, reason) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $productId, $rec['reason']]);
        }
    }
    
    return true;
}

function getWorkoutHistory(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare("SELECT * FROM user_workout_history 
        WHERE user_id = ? ORDER BY workout_date DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function logWorkoutSession(PDO $pdo, int $userId, array $data): bool {
    $stmt = $pdo->prepare("INSERT INTO user_workout_history 
        (user_id, workout_date, workout_data, completed, notes) 
        VALUES (?, ?, ?, ?, ?)");
    
    return $stmt->execute([
        $userId,
        $data['workout_date'] ?? date('Y-m-d'),
        json_encode($data['workout_data'] ?? []),
        $data['completed'] ?? false,
        $data['notes'] ?? ''
    ]);
}
?>