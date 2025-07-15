<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/includes/workout_functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit;
}

$userData = getUserWorkoutData($pdo, $_SESSION['user_id']);
$hasExistingPlan = !empty($userData);

// Set default values for the form
$defaultData = [
    'weight' => $userData['weight'] ?? '',
    'height' => $userData['height'] ?? '',
    'age' => $userData['age'] ?? '',
    'gender' => $userData['gender'] ?? 'male',
    'fitness_level' => $userData['fitness_level'] ?? 'beginner',
    'goal' => $userData['goal'] ?? 'build_muscle',
    'training_days' => $userData['training_days'] ?? 3,
    'equipment' => $userData['equipment'] ?? 'dumbbells,resistance_bands',
    'medical_conditions' => $userData['medical_conditions'] ?? '',
    'preferences' => $userData['preferences'] ?? ''
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeFit - Workout Builder</title>
    <link rel="stylesheet" href="/BeFit-Folder/public/css/styles1.css">
    <link rel="stylesheet" href="/BeFit-Folder/workout_builder/assets/css/workout_builder.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main class="workout-builder-container">
        <div class="workout-header">
            <h1>AI-Powered Workout Builder</h1>
            <p>Get a personalized workout plan tailored to your goals and equipment</p>
        </div>
        
        <?php if ($hasExistingPlan): ?>
        <div class="existing-plan-notice">
            <p>You already have a workout plan. You can update it below or <a href="chat.php">chat with your AI trainer</a>.</p>
        </div>
        <?php endif; ?>
        
        <form id="workoutForm" action="process_form.php" method="post" class="workout-form">
            <div class="form-section">
                <h2>Basic Information</h2>
                
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" value="<?= htmlspecialchars($defaultData['weight']) ?>" required min="30" max="200">
                </div>
                
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" value="<?= htmlspecialchars($defaultData['height']) ?>" required min="100" max="250">
                </div>
                
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?= htmlspecialchars($defaultData['age']) ?>" required min="12" max="100">
                </div>
                
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?= $defaultData['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $defaultData['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $defaultData['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Fitness Details</h2>
                
                <div class="form-group">
                    <label for="fitness_level">Current Fitness Level</label>
                    <select id="fitness_level" name="fitness_level" required>
                        <option value="beginner" <?= $defaultData['fitness_level'] === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                        <option value="intermediate" <?= $defaultData['fitness_level'] === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                        <option value="advanced" <?= $defaultData['fitness_level'] === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="goal">Primary Goal</label>
                    <select id="goal" name="goal" required>
                        <option value="build_muscle" <?= $defaultData['goal'] === 'build_muscle' ? 'selected' : '' ?>>Build Muscle</option>
                        <option value="lose_weight" <?= $defaultData['goal'] === 'lose_weight' ? 'selected' : '' ?>>Lose Weight</option>
                        <option value="strength" <?= $defaultData['goal'] === 'strength' ? 'selected' : '' ?>>Increase Strength</option>
                        <option value="endurance" <?= $defaultData['goal'] === 'endurance' ? 'selected' : '' ?>>Improve Endurance</option>
                        <option value="tone" <?= $defaultData['goal'] === 'tone' ? 'selected' : '' ?>>Tone Body</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="training_days">Days per Week You Can Train</label>
                    <select id="training_days" name="training_days" required>
                        <?php for ($i = 2; $i <= 6; $i++): ?>
                        <option value="<?= $i ?>" <?= $defaultData['training_days'] == $i ? 'selected' : '' ?>><?= $i ?> days</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Equipment & Preferences</h2>
                
                <div class="form-group">
                    <label>Available Equipment</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="equipment[]" value="dumbbells" <?= strpos($defaultData['equipment'], 'dumbbells') !== false ? 'checked' : '' ?>> Dumbbells</label>
                        <label><input type="checkbox" name="equipment[]" value="resistance_bands" <?= strpos($defaultData['equipment'], 'resistance_bands') !== false ? 'checked' : '' ?>> Resistance Bands</label>
                        <label><input type="checkbox" name="equipment[]" value="pullup_bar" <?= strpos($defaultData['equipment'], 'pullup_bar') !== false ? 'checked' : '' ?>> Pull-up Bar</label>
                        <label><input type="checkbox" name="equipment[]" value="weight_bench" <?= strpos($defaultData['equipment'], 'weight_bench') !== false ? 'checked' : '' ?>> Weight Bench</label>
                        <label><input type="checkbox" name="equipment[]" value="none" <?= strpos($defaultData['equipment'], 'none') !== false ? 'checked' : '' ?>> No Equipment</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="medical_conditions">Medical Conditions (if any)</label>
                    <textarea id="medical_conditions" name="medical_conditions"><?= htmlspecialchars($defaultData['medical_conditions']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="preferences">Workout Preferences (e.g., avoid squats, prefer morning workouts)</label>
                    <textarea id="preferences" name="preferences"><?= htmlspecialchars($defaultData['preferences']) ?></textarea>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="cta-button">Generate My Workout Plan</button>
                <?php if ($hasExistingPlan): ?>
                <a href="history.php" class="secondary-button">View Workout History</a>
                <?php endif; ?>
            </div>
        </form>
    </main>
    
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    <script src="/BeFit-Folder/workout_builder/assets/js/workout_builder.js"></script>
</body>
</html>