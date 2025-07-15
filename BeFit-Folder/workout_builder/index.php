<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/includes/workout_functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit;
}

// Get user's existing workout data
$userData = getUserWorkoutData($pdo, $_SESSION['user_id']);

// Redirect based on whether user has an existing plan
if (empty($userData) || empty($userData['workout_plan'])) {
    // No existing plan - go to form
    header("Location: form.php");
} else {
    // Has existing plan - view it
    $_SESSION['workout_plan'] = json_decode($userData['workout_plan'], true);
    header("Location: view_workout.php");
}
exit;
?>