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
            $data['equipment'], $data['medical_conditions'] ?? '', $data['preferences'] ?? '',
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
            $data['equipment'], $data['medical_conditions'] ?? '', $data['preferences'] ?? ''
        ]);
    }
}

function saveWorkoutPlan(PDO $pdo, int $userId, array $plan): bool {
    $jsonPlan = json_encode($plan, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
    // Save to workout_plans
    $stmt = $pdo->prepare("UPDATE workout_plans SET 
        workout_plan = ?, last_updated = NOW() 
        WHERE user_id = ? ORDER BY last_updated DESC LIMIT 1");
    $success = $stmt->execute([$jsonPlan, $userId]);
    
    // Also log to history
    if ($success) {
        logWorkoutSession($pdo, $userId, [
            'workout_data' => $plan,
            'completed' => 0, // Explicitly set to not completed
            'notes' => 'Workout plan generated'
        ]);
    }
    
    return $success;
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
            $stmt->execute([
                $userId, 
                $productId, 
                $rec['reason'] ?? 'Recommended for your fitness goals'
            ]);
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
        json_encode($data['workout_data'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        isset($data['completed']) ? (int)$data['completed'] : 0,
        $data['notes'] ?? ''
    ]);
}

function getHistoricalWorkout(PDO $pdo, int $workoutId, int $userId): array {
    $stmt = $pdo->prepare("SELECT * FROM user_workout_history 
                          WHERE id = ? AND user_id = ?");
    $stmt->execute([$workoutId, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

function logWorkoutCompletion(PDO $pdo, int $workoutId, int $userId): bool {
    $stmt = $pdo->prepare("UPDATE user_workout_history 
                          SET completed = 1, workout_date = CURRENT_DATE()
                          WHERE id = ? AND user_id = ?");
    return $stmt->execute([$workoutId, $userId]);
}

function getWorkoutStats(PDO $pdo, int $userId): array {
    $stats = [];
    
    // Total workouts
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_workout_history 
                          WHERE user_id = ?");
    $stmt->execute([$userId]);
    $stats['total_workouts'] = (int)$stmt->fetchColumn();
    
    // Completed workouts
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_workout_history 
                          WHERE user_id = ? AND completed = 1");
    $stmt->execute([$userId]);
    $stats['completed_workouts'] = (int)$stmt->fetchColumn();
    
    // Recent activity
    $stmt = $pdo->prepare("SELECT workout_date FROM user_workout_history 
                          WHERE user_id = ? 
                          ORDER BY workout_date DESC LIMIT 1");
    $stmt->execute([$userId]);
    $stats['last_workout'] = $stmt->fetchColumn() ?? 'Never';
    
    return $stats;
}
?>