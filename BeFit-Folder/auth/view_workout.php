<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit();
}

// Get user's workout plan
$stmt = $pdo->prepare("SELECT * FROM workout_plans WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$plan = $stmt->fetch();

if (!$plan) {
    header("Location: workout_builder.php");
    exit();
}

// Decode the workout plan JSON
$workoutData = json_decode($plan['workout_plan'], true);
?>

<div class="workout-view-container">
    <div class="workout-header">
        <h1>Your Personalized Workout Plan</h1>
        <p>Generated on <?= date('F j, Y', strtotime($plan['created_at'])) ?></p>
        
        <div class="workout-actions">
            <a href="workout_builder.php" class="btn-secondary">
                <i class="fas fa-edit"></i> Regenerate Plan
            </a>
            <button class="btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print Plan
            </button>
        </div>
    </div>
    
    <div class="workout-summary">
        <div class="summary-card">
            <h3>Workout Split</h3>
            <p><?= htmlspecialchars($workoutData['split']) ?></p>
        </div>
        
        <div class="summary-card">
            <h3>Primary Focus</h3>
            <p><?= htmlspecialchars($workoutData['focus']) ?></p>
        </div>
        
        <div class="summary-card">
            <h3>Rep Range</h3>
            <p><?= htmlspecialchars($workoutData['rep_range']) ?></p>
        </div>
        
        <div class="summary-card">
            <h3>Intensity</h3>
            <p><?= htmlspecialchars($workoutData['intensity']) ?></p>
        </div>
    </div>
    
    <div class="workout-days">
        <?php foreach ($workoutData['workout_days'] as $day): ?>
            <div class="workout-day">
                <h2>Day <?= $day['day'] ?>: <?= $day['focus'] ?></h2>
                
                <div class="exercises">
                    <?php foreach ($day['exercises'] as $exercise): ?>
                        <div class="exercise">
                            <h3><?= htmlspecialchars($exercise['name']) ?></h3>
                            <div class="exercise-details">
                                <span><?= $exercise['sets'] ?> sets</span>
                                <span><?= $exercise['reps'] ?> reps</span>
                            </div>
                            <?php if (!empty($exercise['notes'])): ?>
                                <p class="exercise-notes"><?= htmlspecialchars($exercise['notes']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="nutrition-section">
        <h2>Nutrition Advice</h2>
        <ul class="nutrition-list">
            <?php foreach ($workoutData['nutrition_advice'] as $tip): ?>
                <li><?= htmlspecialchars($tip) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <?php if (!empty($workoutData['equipment_notes'])): ?>
        <div class="equipment-notes">
            <h2>Equipment Notes</h2>
            <ul>
                <?php foreach ($workoutData['equipment_notes'] as $note): ?>
                    <li><?= htmlspecialchars($note) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<style>
.workout-view-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.workout-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.workout-header h1 {
    font-size: 2.2rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.workout-header p {
    font-size: 1rem;
    color: #666;
}

.workout-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-secondary {
    background: white;
    color: #4A90E2;
    border: 2px solid #4A90E2;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #f0f7ff;
    transform: translateY(-2px);
}

.workout-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

.summary-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #4A90E2;
}

.summary-card h3 {
    margin-top: 0;
    font-size: 1.1rem;
    color: #4A90E2;
}

.summary-card p {
    margin-bottom: 0;
    color: #333;
}

.workout-days {
    margin-bottom: 3rem;
}

.workout-day {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.workout-day:last-child {
    border-bottom: none;
}

.workout-day h2 {
    font-size: 1.5rem;
    color: #4A90E2;
    margin-bottom: 1.5rem;
}

.exercises {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.exercise {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.exercise:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.exercise h3 {
    margin-top: 0;
    margin-bottom: 1rem;
    color: #333;
}

.exercise-details {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    color: #666;
}

.exercise-notes {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0;
    font-style: italic;
}

.nutrition-section {
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: #f0f7ff;
    border-radius: 8px;
}

.nutrition-section h2 {
    color: #4A90E2;
    margin-top: 0;
}

.nutrition-list {
    padding-left: 1.5rem;
}

.nutrition-list li {
    margin-bottom: 0.5rem;
}

.equipment-notes {
    padding: 1.5rem;
    background: #f5f5f5;
    border-radius: 8px;
}

.equipment-notes h2 {
    color: #4A90E2;
    margin-top: 0;
}

.equipment-notes ul {
    padding-left: 1.5rem;
}

.equipment-notes li {
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .workout-view-container {
        padding: 1.5rem;
    }
    
    .workout-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .exercises {
        grid-template-columns: 1fr;
    }
}

@media print {
    .workout-view-container {
        box-shadow: none;
        padding: 0;
    }
    
    .workout-actions {
        display: none;
    }
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>
