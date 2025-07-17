<?php

// Improved version with better error handling
$rootDir = dirname(__DIR__);
$autoloader = $rootDir . '/vendor/autoload.php';

if (file_exists($autoloader)) {
    require $autoloader;
} else {
    // Only attempt repair if fix_autoloader exists
    $fixer = $rootDir . '/fix_autoloader.php';
    if (file_exists($fixer)) {
        require $fixer;
        if (function_exists('repairAutoloader')) {
            repairAutoloader();
            if (file_exists($autoloader)) {
                require $autoloader;
            } else {
                die(json_encode(['error' => 'Autoloader repair failed']));
            }
        }
    }
    die(json_encode(['error' => 'Vendor dependencies missing. Run "composer install"']));
}


require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/includes/gemini_client.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['message'])) {
    echo json_encode(['error' => 'No message provided']);
    exit;
}

// Add user message to history
$_SESSION['chat_history'][] = [
    'role' => 'user',
    'content' => $input['message']
];

try {
    $gemini = new GeminiWorkoutClient();
    
    // Include workout plan in context
    $workoutContext = "Current workout plan:\n" . 
        json_encode($_SESSION['workout_plan']) . "\n\n" .
        "Conversation history:\n";
    
    foreach ($_SESSION['chat_history'] as $message) {
        $workoutContext .= "{$message['role']}: {$message['content']}\n";
    }
    
    $response = $gemini->chatAboutWorkout($_SESSION['chat_history'], $workoutContext);
    
    if (isset($response['error'])) {
        throw new Exception($response['error']);
    }
    echo json_encode($response);
    exit;

    echo json_encode([
    'response' => $response,
    'error' => '' // No error
]);
exit;
    
} catch (Exception $e) {
    error_log("Chat error: " . $e->getMessage());
    echo json_encode([
        'error' => 'Failed to process your message: ' . $e->getMessage()
    ]);
    exit;
}

?>