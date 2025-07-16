<?php
require_once __DIR__ . '/../auth/config.php';
require_once __DIR__ . '/includes/gemini_client.php';

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
    $response = $gemini->chatAboutWorkout($_SESSION['chat_history']);
    
    // Add AI response to history
    $_SESSION['chat_history'][] = [
        'role' => 'ai',
        'content' => $response['response']
    ];
    
    echo json_encode($response);
} catch (Exception $e) {
    error_log("Chat error: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to process your message']);
}
?>