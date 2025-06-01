<?php
require '../auth/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$userData = $pdo->prepare("SELECT weight, height, age, workout_experience, training_days, goals, workout_location, equipment 
                         FROM users WHERE id = ?");
$userData->execute([$_SESSION['user_id']]);
$user = $userData->fetch(PDO::FETCH_ASSOC);

// Handle form submission

function generateWorkoutPlan($userId, $weight, $height, $age, $goals, $days, $equipment) {
    // Basic workout template - replace with real AI integration
    $equipmentList = implode(', ', $equipment);
    $goalsList = implode(', ', $goals);
    
    return "Custom $days-day program for:\n" .
           "Goals: $goalsList\n" .
           "Equipment: $equipmentList\n\n" .
           "Sample Workout:\n" .
           "- Warmup: 10min dynamic stretches\n" .
           "- Strength Circuit (3x12): Squats, Pushups, Rows\n" .
           "- Conditioning: 20min interval training";
}

    // Validate required fields
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    
    // Validate goals - must be an array with at least one selection
    if (!isset($_POST['goals']) || !is_array($_POST['goals']) || empty($_POST['goals'])) {
        $error = 'Please select at least one fitness goal';
    }
    
    // Validate equipment - must be an array with at least one selection
    if (!isset($_POST['equipment']) || !is_array($_POST['equipment']) || empty($_POST['equipment'])) {
        $error = 'Please select at least one equipment type';
    }

    if (empty($error)) {
        // Process valid form data
        try {
            // Your database operations here
        } catch (PDOException $e) {
            // Handle database errors
        }
    } else {
        // Show error to user
        echo '<div class="error">' . htmlspecialchars($error) . '</div>';
    }
}



            // 2. Generate workout plan
            $workoutPlan = generateWorkoutPlan(
                $_SESSION['user_id'],
                $user['weight'],
                $user['height'],
                $user['age'],
                $_POST['goals'],
                $_POST['training_days'],
                $_POST['equipment']
            );

            // 3. Save workout plan
            $stmt = $pdo->prepare("INSERT INTO workout_plans 
                (user_id, weight, height, age, goal, training_days, equipment, workout_plan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $_SESSION['user_id'],
                $user['weight'],
                $user['height'],
                $user['age'],
                implode(',', $_POST['goals']),  // Store goals as comma-separated string
                $_POST['training_days'],
                implode(',', $_POST['equipment']),
                $workoutPlan
            ]);

            $pdo->commit();
            header("Location: view-workout.php?id=".$pdo->lastInsertId());
            exit();

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Workout Builder | BeFit</title>
    <link rel="stylesheet" href="../css/workout-steps.css">
    <link rel="stylesheet" href="../css/styles1.css">
</head>
<body class="shared-bg">
    <div class="workout-builder">
        <div class="step-progress">
            <div class="step-circle active">1</div>
            <div class="step-circle">2</div>
            <div class="step-circle">3</div>
        </div>

        <!-- Step 1: Measurements -->
        <div class="step-container step-active" data-step="1">
            <div class="step-header">
                <h2>Your Basic Measurements</h2>
                <?php if($user['weight']): ?>
                <div class="measurement-card">
                    <div>
                        <p>Weight: <?= $user['weight'] ?>kg</p>
                        <p>Height: <?= $user['height'] ?>cm</p>
                        <p>Age: <?= $user['age'] ?></p>
                    </div>
                    <button class="btn-secondary" onclick="showStep(1, true)">Change</button>
                </div>
                <button class="btn-primary" onclick="showStep(2)">Continue</button>
                <?php else: ?>
                <form id="measurementForm">
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" required>
                        </div>
                        <div class="input-group">
                            <label>Height (cm)</label>
                            <input type="number" name="height" required>
                        </div>
                        <div class="input-group">
                            <label>Age</label>
                            <input type="number" name="age" required>
                        </div>
                    </div>
                    <button type="button" class="btn-primary" onclick="saveMeasurements()">Save & Continue</button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Step 2: Goals & Experience -->
        <div class="step-container" data-step="2">
            <div class="step-header">
                <h2>Training Preferences</h2>
                <form id="preferencesForm">
                    <div class="input-group">
                        <label>Workout Experience</label>
                        <div class="radio-group">
                            <?php foreach(['beginner', 'intermediate', 'advanced'] as $level): ?>
                            <label class="radio-card <?= $user['workout_experience'] === $level ? 'selected' : '' ?>">
                                <input type="radio" name="experience" value="<?= $level ?>" 
                                    <?= $user['workout_experience'] === $level ? 'checked' : '' ?>>
                                <?= ucfirst($level) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Training Days/Week</label>
                        <select name="training_days" class="input-field" required>
                            <?php foreach(range(3, 6) as $days): ?>
                            <option value="<?= $days ?>" <?= $user['training_days'] == $days ? 'selected' : '' ?>>
                                <?= $days ?> Days
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Primary Goals</label>
                        <div class="checkbox-grid">
                            <?php $selectedGoals = explode(',', $user['goals']); ?>
                            <?php foreach(['fat_loss','strength','conditioning','muscle_gain'] as $goal): ?>
                            <label class="checkbox-card <?= in_array($goal, $selectedGoals) ? 'selected' : '' ?>">
                                <input type="checkbox" name="goals[]" value="<?= $goal ?>"
                                    <?= in_array($goal, $selectedGoals) ? 'checked' : '' ?>>
                                <?= ucfirst(str_replace('_', ' ', $goal)) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="button" class="btn-primary" onclick="showStep(3)">Next</button>
                </form>
            </div>
        </div>

        <!-- Step 3: Location & Equipment -->
        <div class="step-container" data-step="3">
            <div class="step-header">
                <h2>Workout Environment</h2>
                <form id="environmentForm">
                    <div class="input-group">
                        <label>Where do you workout?</label>
                        <div class="radio-group">
                            <?php foreach(['gym','home','both'] as $location): ?>
                            <label class="radio-card <?= $user['workout_location'] === $location ? 'selected' : '' ?>">
                                <input type="radio" name="location" value="<?= $location ?>"
                                    <?= $user['workout_location'] === $location ? 'checked' : '' ?>>
                                <?= ucfirst($location) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Available Equipment</label>
                        <div class="equipment-grid" id="equipmentGrid">
                            <?php $selectedEquipment = explode(',', $user['equipment']); ?>
                            <?php foreach(['dumbbells','barbell','kettlebells','resistance_bands','machine','bodyweight'] as $eq): ?>
                            <label class="equipment-card <?= in_array($eq, $selectedEquipment) ? 'selected' : '' ?>">
                                <input type="checkbox" name="equipment[]" value="<?= $eq ?>"
                                    <?= in_array($eq, $selectedEquipment) ? 'checked' : '' ?>>
                                <?= ucfirst(str_replace('_', ' ', $eq)) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary generate-btn">
                        Generate Workout Plan
                    </button>
                </form>
            </div>
        </div>

        <div class="ai-loading" id="loading">
            <div class="loader"></div>
            <p>Analyzing your profile...</p>
        </div>
    </div>

    <!-- Workout History Sidebar -->
    <div class="workout-history">
        <div class="history-header">
            <h4>Workout History</h4>
        </div>
        <div id="historyItems">
            <?php include 'fetch-workout-history.php'; ?>
        </div>
    </div>

    <script src="../js/workout-builder.js"></script>
                            </body>
</html>