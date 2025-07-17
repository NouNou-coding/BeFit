<?php

// Auto-repair vendor dependencies on Windows
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $vendorDir = __DIR__.'/../../vendor';
    $autoloader = $vendorDir.'/autoload.php';
    
    // Check if autoloader is broken
    if (file_exists($autoloader) && !@include($autoloader)) {
        // Regenerate autoloader
        $composerLock = __DIR__.'/../../composer.lock';
        if (file_exists($composerLock)) {
            // Backup original vendor
            rename($vendorDir, $vendorDir.'_backup_'.time());
            
            // Reinstall dependencies
            exec('cd "'.__DIR__.'/../.." && composer install --no-dev --no-interaction --quiet');
            
            // Verify new autoloader works
            if (!file_exists($autoloader) || !@include($autoloader)) {
                die(json_encode(['error' => 'Failed to repair dependencies automatically']));
            }
        }
    }
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
    
} catch (Exception $e) {
    error_log("Chat error: " . $e->getMessage());
    echo json_encode([
        'error' => 'Failed to process your message: ' . $e->getMessage()
    ]);
    exit;
}

?>