<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit();
}

// Check if user already has a workout plan
$stmt = $pdo->prepare("SELECT * FROM workout_plans WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$existingPlan = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $goal = filter_input(INPUT_POST, 'goal', FILTER_SANITIZE_STRING);
    $trainingDays = filter_input(INPUT_POST, 'training_days', FILTER_SANITIZE_NUMBER_INT);
    $equipment = isset($_POST['equipment']) ? implode(',', $_POST['equipment']) : '';
    
    // Validate inputs
    $errors = [];
    if (empty($weight) || $weight <= 0) $errors[] = "Please enter a valid weight";
    if (empty($height) || $height <= 0) $errors[] = "Please enter a valid height";
    if (empty($age) || $age <= 0) $errors[] = "Please enter a valid age";
    if (empty($goal)) $errors[] = "Please select a fitness goal";
    if (empty($trainingDays) || $trainingDays < 1 || $trainingDays > 7) $errors[] = "Please select between 1-7 training days";
    
    if (empty($errors)) {
        // Store basic info in session while we generate the AI plan
        $_SESSION['workout_data'] = [
            'weight' => $weight,
            'height' => $height,
            'age' => $age,
            'goal' => $goal,
            'training_days' => $trainingDays,
            'equipment' => $equipment
        ];
        
        header("Location: generate_workout.php");
        exit();
    }
}
?>

<div class="workout-builder-container">
    <div class="workout-builder-header">
        <h1>Build Your Custom Workout Plan</h1>
        <p>Answer a few questions to get a personalized AI-generated workout plan</p>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($existingPlan): ?>
        <div class="existing-plan-notice">
            <h3>You already have a workout plan!</h3>
            <p>You can view your current plan or generate a new one below.</p>
            <a href="view_workout.php" class="btn-primary">View Current Plan</a>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="workout-form">
        <div class="form-section">
            <h2>Basic Information</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" step="0.1" min="30" max="300" 
                           value="<?= htmlspecialchars($_POST['weight'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" min="100" max="250" 
                           value="<?= htmlspecialchars($_POST['height'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" min="13" max="120" 
                           value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h2>Fitness Goals</h2>
            <div class="form-group">
                <label>What are your primary fitness goals?</label>
                <div class="goal-options">
                    <label class="goal-option">
                        <input type="radio" name="goal" value="weight_loss" 
                               <?= ($_POST['goal'] ?? '') === 'weight_loss' ? 'checked' : '' ?> required>
                        <div class="goal-card">
                            <i class="fas fa-fire"></i>
                            <span>Weight Loss</span>
                        </div>
                    </label>
                    
                    <label class="goal-option">
                        <input type="radio" name="goal" value="muscle_gain" 
                               <?= ($_POST['goal'] ?? '') === 'muscle_gain' ? 'checked' : '' ?>>
                        <div class="goal-card">
                            <i class="fas fa-dumbbell"></i>
                            <span>Muscle Gain</span>
                        </div>
                    </label>
                    
                    <label class="goal-option">
                        <input type="radio" name="goal" value="strength" 
                               <?= ($_POST['goal'] ?? '') === 'strength' ? 'checked' : '' ?>>
                        <div class="goal-card">
                            <i class="fas fa-bolt"></i>
                            <span>Strength</span>
                        </div>
                    </label>
                    
                    <label class="goal-option">
                        <input type="radio" name="goal" value="endurance" 
                               <?= ($_POST['goal'] ?? '') === 'endurance' ? 'checked' : '' ?>>
                        <div class="goal-card">
                            <i class="fas fa-running"></i>
                            <span>Endurance</span>
                        </div>
                    </label>
                    
                    <label class="goal-option">
                        <input type="radio" name="goal" value="general_fitness" 
                               <?= ($_POST['goal'] ?? '') === 'general_fitness' ? 'checked' : '' ?>>
                        <div class="goal-card">
                            <i class="fas fa-heartbeat"></i>
                            <span>General Fitness</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h2>Training Schedule</h2>
            <div class="form-group">
                <label for="training_days">How many days per week can you train?</label>
                <select id="training_days" name="training_days" required>
                    <option value="">Select days</option>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <option value="<?= $i ?>" <?= ($_POST['training_days'] ?? '') == $i ? 'selected' : '' ?>>
                            <?= $i ?> day<?= $i > 1 ? 's' : '' ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        
        <div class="form-section">
            <h2>Available Equipment</h2>
            <div class="form-group">
                <label>What equipment do you have access to?</label>
                <div class="equipment-options">
                    <label class="equipment-option">
                        <input type="checkbox" name="equipment[]" value="dumbbells" 
                               <?= in_array('dumbbells', $_POST['equipment'] ?? []) ? 'checked' : '' ?>>
                        <span>Dumbbells</span>
                    </label>
                    
                    <label class="equipment-option">
                        <input type="checkbox" name="equipment[]" value="barbell" 
                               <?= in_array('barbell', $_POST['equipment'] ?? []) ? 'checked' : '' ?>>
                        <span>Barbell</span>
                    </label>
                    
                    <label class="equipment-option">
                        <input type="checkbox" name="equipment[]" value="resistance_bands" 
                               <?= in_array('resistance_bands', $_POST['equipment'] ?? []) ? 'checked' : '' ?>>
                        <span>Resistance Bands</span>
                    </label>
                    
                    <label class="equipment-option">
                        <input type="checkbox" name="equipment[]" value="pullup_bar" 
                               <?= in_array('pullup_bar', $_POST['equipment'] ?? []) ? 'checked' : '' ?>>
                        <span>Pull-up Bar</span>
                    </label>
                    
                    <label class="equipment-option">
                        <input type="checkbox" name="equipment[]" value="none" 
                               <?= in_array('none', $_POST['equipment'] ?? []) ? 'checked' : '' ?>>
                        <span>No Equipment</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary btn-large">
                <i class="fas fa-magic"></i> Generate Workout Plan
            </button>
        </div>
    </form>
</div>

<style>
.workout-builder-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.workout-builder-header {
    text-align: center;
    margin-bottom: 2rem;
}

.workout-builder-header h1 {
    font-size: 2.2rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.workout-builder-header p {
    font-size: 1.1rem;
    color: #666;
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.form-section h2 {
    font-size: 1.4rem;
    color: #4A90E2;
    margin-bottom: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #444;
}

input[type="number"],
input[type="text"],
select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

input[type="number"]:focus,
input[type="text"]:focus,
select:focus {
    border-color: #4A90E2;
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
}

.goal-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.goal-option input[type="radio"] {
    display: none;
}

.goal-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1rem;
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    height: 100%;
}

.goal-card i {
    font-size: 2rem;
    margin-bottom: 0.8rem;
    color: #4A90E2;
}

.goal-card span {
    font-weight: 600;
    color: #333;
}

.goal-option input[type="radio"]:checked + .goal-card {
    border-color: #4A90E2;
    background: rgba(74, 144, 226, 0.1);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
}

.equipment-options {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
}

.equipment-option {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    padding: 0.8rem 1.2rem;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid #e0e0e0;
}

.equipment-option:hover {
    background: #e9ecef;
}

.equipment-option input[type="checkbox"] {
    margin-right: 0.5rem;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

.btn-primary {
    background: linear-gradient(135deg, #4A90E2, #357ABD);
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
}

.btn-large {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.error-message {
    background: #FED7D7;
    color: #C53030;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.error-message ul {
    margin: 0;
    padding-left: 1.5rem;
}

.existing-plan-notice {
    background: #E3F2FD;
    border-left: 4px solid #4A90E2;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-radius: 4px;
}

.existing-plan-notice h3 {
    margin-top: 0;
    color: #333;
}

@media (max-width: 768px) {
    .workout-builder-container {
        padding: 1.5rem;
    }
    
    .goal-options {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>
