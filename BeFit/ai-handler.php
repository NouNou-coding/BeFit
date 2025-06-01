<?php
require 'config.php';

header('Content-Type: text/html; charset=utf-8');

// Rate limiting
session_start();
$_SESSION['ai_requests'] = ($_SESSION['ai_requests'] ?? 0) + 1;
if ($_SESSION['ai_requests'] > 30) die("AI usage limit reached (30/day).");

$action = $_GET['action'] ?? '';
$prompt = filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_STRING);

try {
    switch($action) {
        case 'workout':
            $model = "microsoft/DialoGPT-medium";
            $response = queryHuggingFace($model, [
                "inputs" => "As a fitness expert, suggest a workout for: $prompt",
                "parameters" => ["max_length" => 500]
            ]);
            echo nl2br($response[0]['generated_text']);
            break;
            
        default:
            echo "Invalid AI action";
    }
} catch (Exception $e) {
    echo "AI Service Error: " . $e->getMessage();
}

function queryHuggingFace($model, $data) {
    $url = "https://api-inference.huggingface.co/models/$model";
    $headers = [
        "Authorization: Bearer " . HF_API_KEY,
        "Content-Type: application/json"
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
    ]);
    
    $response = curl_exec($ch);
    if(curl_errno($ch)) throw new Exception(curl_error($ch));
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) throw new Exception("API Error: Code $httpCode");
    
    return json_decode($response, true);
}
?>
<?php
require 'config.php';

header('Content-Type: text/html; charset=utf-8');

// Local development check
$isLocal = $_SERVER['SERVER_NAME'] === 'localhost';

try {
    if ($isLocal) {
        // Local mock response
        $mockWorkouts = [
            "3-day full body routine focusing on compound movements",
            "Beginner-friendly bodyweight circuit training",
            "HIIT workout for fat loss with minimal equipment"
        ];
        echo nl2br($mockWorkouts[array_rand($mockWorkouts)]);
        exit;
    }

    // Original Hugging Face integration
    $response = queryHuggingFace($model, $data);
    echo nl2br($response[0]['generated_text']);

} catch (Exception $e) {
    echo "Our AI trainer is currently unavailable. Suggested routine:\n\n";
    echo "1. Bodyweight squats 3x15\n2. Push-ups 3x12\n3. Plank 3x30sec";
}
?>