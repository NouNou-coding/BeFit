<?php
require '../auth/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: build-workout.php");
    exit();
}

$planId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM workout_plans WHERE id = ? AND user_id = ?");
$stmt->execute([$planId, $_SESSION['user_id']]);
$plan = $stmt->fetch();

if (!$plan) {
    header("Location: build-workout.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Workout Plan | BeFit</title>
    <link rel="stylesheet" href="../css/styles1.css">
    <style>
        .workout-plan {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .plan-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .plan-details {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #F7FAFC;
            border-radius: 10px;
        }

        .workout-split {
            white-space: pre-wrap;
            line-height: 1.6;
            padding: 1.5rem;
            background: #fff;
            border-radius: 10px;
            border: 2px solid #E2E8F0;
        }
    </style>
</head>
<body class="shared-bg">
    <div class="workout-plan">
        <div class="plan-header">
            <h1>Your Custom Workout Plan</h1>
            <p>Generated on <?= date('M j, Y', strtotime($plan['created_at'])) ?></p>
        </div>

        <div class="plan-details">
            <p><strong>Goal:</strong> <?= ucfirst(str_replace('_', ' ', $plan['goal'])) ?></p>
            <p><strong>Training Days:</strong> <?= $plan['training_days'] ?> days/week</p>
            <p><strong>Equipment:</strong> <?= ucfirst(str_replace(',', ', ', $plan['equipment'])) ?></p>
        </div>

        <div class="workout-split">
            <h2>Your Personalized Routine</h2>
            <?= nl2br(htmlspecialchars($plan['workout_plan'])) ?>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="build-workout.php" class="generate-btn">Create New Plan</a>
            <button onclick="window.print()" class="generate-btn">Print Plan</button>
        </div>
    </div>
</body>
</html>