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

// Prepare conversation history for Gemini
$messagesForGemini = [];
foreach ($input['history'] as $msg) {
    $messagesForGemini[] = [
        'role' => $msg['role'] === 'user' ? 'user' : 'model',
        'content' => $msg['content']
    ];
}

// Add the new user message
$messagesForGemini[] = ['role' => 'user', 'content' => $input['message']];

// Get response from Gemini
$gemini = new GeminiWorkoutClient();
$response = $gemini->chatAboutWorkout($messagesForGemini);

echo json_encode($response);
?>