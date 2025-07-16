<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/includes/gemini_client.php';
require_once __DIR__ . '/includes/workout_functions.php';

// Debug: Check if form is submitting
error_log("Form submitted: " . print_r($_POST, true));
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: /BeFit-Folder/auth/signin.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit;
}


// Validate and sanitize input
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
$fitness_level = filter_input(INPUT_POST, 'fitness_level', FILTER_SANITIZE_STRING);
$goal = filter_input(INPUT_POST, 'goal', FILTER_SANITIZE_STRING);
$training_days = filter_input(INPUT_POST, 'training_days', FILTER_VALIDATE_INT);
$equipment = isset($_POST['equipment']) ? implode(',', $_POST['equipment']) : 'none';
$medical_conditions = filter_input(INPUT_POST, 'medical_conditions', FILTER_SANITIZE_STRING);
$preferences = filter_input(INPUT_POST, 'preferences', FILTER_SANITIZE_STRING);

// Basic validation
if (!$weight || !$height || !$age || !$gender || !$fitness_level || !$goal || !$training_days) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header("Location: form.php");
    exit;
}

// Prepare data for Gemini API
$userData = [
    'weight' => $weight,
    'height' => $height,
    'age' => $age,
    'gender' => $gender,
    'fitness_level' => $fitness_level,
    'goal' => $goal,
    'training_days' => $training_days,
    'equipment' => $equipment,
    'medical_conditions' => $medical_conditions,
    'preferences' => $preferences
];

// Save user data to database first
saveUserWorkoutData($pdo, $_SESSION['user_id'], $userData);

// Generate workout plan with Gemini
$gemini = new GeminiWorkoutClient();
$workoutPlan = $gemini->generateWorkoutPlan($userData);

if (!isset($workoutPlan['weekly_plan']) || empty($workoutPlan['weekly_plan'])) {
    $_SESSION['error'] = 'Invalid workout plan structure received';
    header("Location: form.php");
    exit;
}

if (isset($workoutPlan['error'])) {
    $_SESSION['error'] = $workoutPlan['error'];
    header("Location: form.php");
    exit;
}

// Save the generated workout plan
saveWorkoutPlan($pdo, $_SESSION['user_id'], $workoutPlan);

// Store supplement recommendations
if (isset($workoutPlan['supplement_recommendations'])) {
    saveSupplementRecommendations($pdo, $_SESSION['user_id'], $workoutPlan['supplement_recommendations']);
}

// Redirect to view the workout plan
$_SESSION['workout_plan'] = $workoutPlan;
$_SESSION['workout_data'] = $userData; // Store all user data
error_log("Workout plan generated: " . print_r($workoutPlan, true));
header("Location: view_workout.php");
exit;
?>