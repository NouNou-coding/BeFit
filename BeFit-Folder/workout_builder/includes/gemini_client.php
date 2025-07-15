<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../auth/config.php';

use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Resources\Content;
use GeminiAPI\Requests\GenerateContentRequest;
use GeminiAPI\Enums\Role;


class GeminiWorkoutClient {
    private $client;
    private $model = 'gemini-pro';

    public function __construct() {
        $this->client = new GeminiAPI\Client(GEMINI_API_KEY);
    }

    public function generateWorkoutPlan(array $userData): array {
        $promptText = $this->buildWorkoutPrompt($userData);

        try {
            $textPart = new TextPart($promptText, 'text/plain');
            $content = new Content([$textPart], Role::User);
            $request = new GenerateContentRequest($this->model, [$content]);
            $response = $this->client->generateContent($request);

            $responseText = '';
            foreach ($response->candidates as $candidate) {
                if (isset($candidate->content->parts[0]->text)) {
                    $responseText .= $candidate->content->parts[0]->text;
                }
            }

            return $this->parseWorkoutResponse($responseText);
        } catch (Exception $e) {
            error_log("Gemini API Error: " . $e->getMessage());
            return ['error' => 'Failed to generate workout plan. Please try again.'];
        }
    }

    public function chatAboutWorkout(array $conversationHistory): array {
        $promptText = "You are a professional fitness trainer. Continue this conversation about workout plans:\n\n";
        foreach ($conversationHistory as $message) {
            $promptText .= "{$message['role']}: {$message['content']}\n";
        }

        try {
            $textPart = new TextPart($promptText, 'text/plain');
            $content = new Content([$textPart], Role::User);
            $request = new GenerateContentRequest($this->model, [$content]);

            $response = $this->client->generateContent($request);

            $responseText = '';
            foreach ($response->candidates as $candidate) {
                if (isset($candidate->content->parts[0]->text)) {
                    $responseText .= $candidate->content->parts[0]->text;
                }
            }

            return ['response' => $responseText];
        } catch (Exception $e) {
            error_log("Gemini Chat Error: " . $e->getMessage());
            return ['error' => 'Failed to process your message. Please try again.'];
        }
    }

    private function buildWorkoutPrompt(array $userData): string {
        return sprintf(
            "Create a personalized %s workout plan for a %s year old %s, %scm tall, weighing %skg. " .
            "Fitness level: %s. Goal: %s. Available equipment: %s. " .
            "Medical considerations: %s. Preferences: %s. " .
            "Provide a detailed weekly plan with exercises, sets, reps, rest periods, and notes. " .
            "Also recommend 2-3 supplements from this list that would help with their goals: " .
            "1. FitRx Smart Adjustable Dumbbells, 2. Resistance Band Set, 3. Weightlifting Belt, " .
            "4. Whey Protein, 5. Creatine Monohydrate, 6. Preworkout, 7. Mass Gainer. " .
            "Format the response as JSON with these keys: 'weekly_plan', 'supplement_recommendations', 'general_advice'.",
            $userData['training_days'],
            $userData['age'],
            $userData['gender'],
            $userData['height'],
            $userData['weight'],
            $userData['fitness_level'],
            $userData['goal'],
            $userData['equipment'],
            $userData['medical_conditions'] ?? 'none',
            $userData['preferences'] ?? 'none'
        );
    }

    private function parseWorkoutResponse(string $response): array {
        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            preg_match('/\{.*\}/s', $response, $matches);
            if ($matches) {
                $decoded = json_decode($matches[0], true);
            }
        }

        return $decoded ?? ['error' => 'Could not parse the workout plan response.'];
    }
}
