<?php
require_once __DIR__ . '/../auth/config.php';

// Check if user is logged in and has submitted workout data
if (!isset($_SESSION['user_id']) || !isset($_SESSION['workout_data'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit();
}

// Extract workout data from session
$workoutData = $_SESSION['workout_data'];
$userId = $_SESSION['user_id'];

// Function to generate workout plan using AI (simulated for this example)
function generateWorkoutPlan($data) {
    // In a real implementation, you would call an AI API here
    // For this example, we'll simulate different responses based on inputs
    
    $goals = [
        'weight_loss' => [
            'focus' => 'High-intensity interval training (HIIT) and cardio',
            'rep_range' => '12-15 reps for strength exercises, 30-60 seconds for cardio intervals',
            'intensity' => 'Moderate to high intensity with short rest periods (30-60 seconds)'
        ],
        'muscle_gain' => [
            'focus' => 'Progressive overload with compound movements',
            'rep_range' => '6-12 reps with progressive overload',
            'intensity' => 'Moderate to high intensity with 60-90 seconds rest between sets'
        ],
        'strength' => [
            'focus' => 'Heavy compound lifts with accessory work',
            'rep_range' => '3-6 reps for main lifts, 8-12 for accessories',
            'intensity' => 'High intensity with 2-5 minutes rest between heavy sets'
        ],
        'endurance' => [
            'focus' => 'Circuit training and high-repetition work',
            'rep_range' => '15-20+ reps or timed sets (30-60 seconds)',
            'intensity' => 'Moderate intensity with minimal rest (15-30 seconds)'
        ],
        'general_fitness' => [
            'focus' => 'Balanced mix of strength and cardio',
            'rep_range' => '8-15 reps for strength, 20-30 minutes cardio',
            'intensity' => 'Varied intensity based on the day'
        ]
    ];
    
    $equipmentMap = [
        'dumbbells' => ['Dumbbell exercises', 'Can perform most upper body and some lower body exercises'],
        'barbell' => ['Barbell exercises', 'Great for compound lifts like squats and deadlifts'],
        'resistance_bands' => ['Resistance band exercises', 'Good for mobility and accessory work'],
        'pullup_bar' => ['Pull-up bar exercises', 'Excellent for upper body strength'],
        'none' => ['Bodyweight exercises', 'Focus on push-ups, squats, lunges, etc.']
    ];
    
    // Determine split based on training days
    $split = match((int)$data['training_days']) {
        1 => 'Full body workout',
        2 => 'Upper/Lower split',
        3 => 'Push/Pull/Legs',
        4 => 'Upper/Lower split with cardio days',
        5 => 'Bro split (Chest, Back, Legs, Shoulders, Arms)',
        6 => 'Push/Pull/Legs repeated',
        7 => 'Varied split with active recovery days',
        default => 'Custom split'
    };
    
    // Generate workout days
    $workoutDays = [];
    for ($i = 1; $i <= $data['training_days']; $i++) {
        $focus = match($i % $data['training_days']) {
            0 => 'Full body',
            1 => $data['training_days'] > 3 ? 'Chest & Triceps' : 'Upper body',
            2 => $data['training_days'] > 3 ? 'Back & Biceps' : 'Lower body',
            3 => 'Legs',
            4 => 'Shoulders & Arms',
            5 => 'Cardio & Core',
            6 => 'Active Recovery',
            default => 'Full body'
        };
        
        $exercises = [];
        $numExercises = $data['training_days'] <= 3 ? 6 : 4;
        
        for ($j = 1; $j <= $numExercises; $j++) {
            $exercises[] = [
                'name' => "Exercise $j for $focus",
                'sets' => $data['goal'] === 'strength' ? '4-5' : '3-4',
                'reps' => $goals[$data['goal']]['rep_range'],
                'notes' => 'Focus on proper form'
            ];
        }
        
        $workoutDays[] = [
            'day' => $i,
            'focus' => $focus,
            'exercises' => $exercises
        ];
    }
    
    // Generate nutrition advice
    $nutrition = match($data['goal']) {
        'weight_loss' => [
            'Caloric deficit of 300-500 calories per day',
            'High protein (1.6-2.2g per kg of body weight)',
            'Moderate carbs, focus on whole foods',
            'Healthy fats for satiety'
        ],
        'muscle_gain' => [
            'Caloric surplus of 200-500 calories per day',
            'High protein (1.6-2.2g per kg of body weight)',
            'Higher carb intake around workouts',
            'Healthy fats for hormone production'
        ],
        'strength' => [
            'Maintenance calories or slight surplus',
            'High protein (1.6-2.2g per kg of body weight)',
            'Time carbs around workouts',
            'Healthy fats for joint health'
        ],
        'endurance' => [
            'Slight deficit or maintenance calories',
            'Moderate protein (1.2-1.6g per kg of body weight)',
            'Higher carb intake for energy',
            'Healthy fats for sustained energy'
        ],
        'general_fitness' => [
            'Maintenance calories',
            'Balanced macros (30% protein, 40% carbs, 30% fat)',
            'Focus on whole foods',
            'Stay hydrated'
        ]
    };
    
    // Generate equipment notes
    $equipmentNotes = [];
    $equipmentList = explode(',', $data['equipment']);
    foreach ($equipmentList as $item) {
        if (isset($equipmentMap[$item])) {
            $equipmentNotes[] = $equipmentMap[$item][1];
        }
    }
    
    return [
        'split' => $split,
        'focus' => $goals[$data['goal']]['focus'],
        'rep_range' => $goals[$data['goal']]['rep_range'],
        'intensity' => $goals[$data['goal']]['intensity'],
        'workout_days' => $workoutDays,
        'nutrition_advice' => $nutrition,
        'equipment_notes' => $equipmentNotes,
        'created_at' => date('Y-m-d H:i:s')
    ];
}

// Generate the workout plan
$workoutPlan = generateWorkoutPlan($workoutData);

// Store the plan in the database
try {
    $stmt = $pdo->prepare("
        INSERT INTO workout_plans 
        (user_id, weight, height, age, goal, training_days, equipment, workout_plan, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        weight = VALUES(weight),
        height = VALUES(height),
        age = VALUES(age),
        goal = VALUES(goal),
        training_days = VALUES(training_days),
        equipment = VALUES(equipment),
        workout_plan = VALUES(workout_plan),
        created_at = VALUES(created_at)
    ");
    
    $stmt->execute([
        $userId,
        $workoutData['weight'],
        $workoutData['height'],
        $workoutData['age'],
        $workoutData['goal'],
        $workoutData['training_days'],
        $workoutData['equipment'],
        json_encode($workoutPlan),
        $workoutPlan['created_at']
    ]);
    
    // Clear the session data
    unset($_SESSION['workout_data']);
    
    // Redirect to view the plan
    header("Location: view_workout.php");
    exit();
    
} catch (PDOException $e) {
    die("Error saving workout plan: " . $e->getMessage());
}
