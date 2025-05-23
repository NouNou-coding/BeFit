<?php
require '../auth/config.php';

if (!isset($_SESSION['user_id'])) {
    die('Unauthorized');
}

try {
    $stmt = $pdo->prepare("
        SELECT id, created_at, goal, training_days 
        FROM workout_plans 
        WHERE user_id = ?
        ORDER BY created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($workouts)) {
        echo '<div class="history-item">No workouts found</div>';
        exit;
    }

    foreach ($workouts as $workout) {
        $date = date('M j, Y', strtotime($workout['created_at']));
        echo '
        <div class="history-item" onclick="loadWorkout('.$workout['id'].')">
            <div class="history-date">'.$date.'</div>
            <div class="history-goal">'.ucfirst($workout['goal']).' Program</div>
            <div class="history-days">'.$workout['training_days'].' days/week</div>
        </div>';
    }
} catch (PDOException $e) {
    error_log("History fetch error: ".$e->getMessage());
    echo '<div class="history-item">Error loading history</div>';
}
?>