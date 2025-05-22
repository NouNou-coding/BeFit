<?php
require '../auth/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$error = '';
$workoutPlan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $goal = $_POST['goal'] ?? '';
    $trainingDays = filter_input(INPUT_POST, 'training_days', FILTER_SANITIZE_NUMBER_INT);
    $equipment = $_POST['equipment'] ?? [];

    // Validate inputs
    if (empty($weight) || empty($height) || empty($age) || empty($goal) || empty($trainingDays) || empty($equipment)) {
        $error = 'All fields are required!';
    } else {
        try {
            // Generate AI workout plan (simulated - integrate your AI API here)
            $workoutPlan = generateWorkoutPlan($_SESSION['user_id'], $weight, $height, $age, $goal, $trainingDays, $equipment);
            
            // Save to database
            $stmt = $pdo->prepare("INSERT INTO workout_plans 
                (user_id, weight, height, age, goal, training_days, equipment, workout_plan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $weight,
                $height,
                $age,
                $goal,
                $trainingDays,
                implode(',', $equipment),
                $workoutPlan
            ]);
            
            header("Location: view-workout.php?id=".$pdo->lastInsertId());
            exit();
        } catch (PDOException $e) {
            $error = "Error saving workout plan: ".$e->getMessage();
        }
    }
}

function generateWorkoutPlan($userId, $weight, $height, $age, $goal, $days, $equipment) {
    // This is a simulation - integrate with AI API (e.g., OpenAI) here
    $equipmentList = implode(', ', $equipment);
    return "Custom {$goal} program for {$days} days/week\n".
           "Equipment: {$equipmentList}\n".
           "Sample workout structure...";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Workout | BeFit</title>
    <link rel="stylesheet" href="../css/styles1.css">
    <style>
        .workout-builder {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2D3748;
            font-weight: 600;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            background: #F7FAFC;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .generate-btn {
            background: linear-gradient(135deg, #4A90E2, #63B3ED);
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .generate-btn:hover {
            transform: translateY(-2px);
        }

        .ai-loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }
    </style>
</head>
<body class="shared-bg">
    <div class="workout-builder">
        <h1 style="text-align: center; margin-bottom: 2rem;">Build Your AI-Powered Workout</h1>
        
        <?php if($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" id="workoutForm">
            <div class="form-grid">
                <div class="input-group">
                    <label>Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" class="input-field" required>
                </div>

                <div class="input-group">
                    <label>Height (cm)</label>
                    <input type="number" name="height" class="input-field" required>
                </div>

                <div class="input-group">
                    <label>Age</label>
                    <input type="number" name="age" class="input-field" required>
                </div>

                <div class="input-group">
                    <label>Primary Goal</label>
                    <select name="goal" class="input-field" required>
                        <option value="muscle">Build Muscle</option>
                        <option value="strength">Build Strength</option>
                        <option value="conditioning">Improve Conditioning</option>
                        <option value="fat_loss">Lose Fat</option>
                        <option value="bulking">Weight Gain (Bulking)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Training Days/Week</label>
                    <select name="training_days" class="input-field" required>
                        <option value="3">3 Days</option>
                        <option value="4">4 Days</option>
                        <option value="5">5 Days</option>
                        <option value="6">6 Days</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Available Equipment</label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="dumbbells"> Dumbbells
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="barbell"> Barbell
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="kettlebells"> Kettlebells
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="resistance_bands"> Resistance Bands
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="machine"> Machine
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="equipment[]" value="bodyweight"> Bodyweight
                        </label>
                    </div>
                </div>
                <!-- Add this after equipment selection -->
                    <div class="ai-section">
                        <h3>AI Workout Assistant</h3>
                        <div class="ai-prompt">
                            <input type="text" id="aiPrompt" 
                                  placeholder="Ex: 'I want a low-impact routine for knee rehab'">
                            <button onclick="generateAITips()">Get AI Suggestions</button>
                        </div>
                        <div id="aiResponse" class="ai-response"></div>
                    </div>

                    <script>
                    async function generateAITips() {
                        const prompt = document.getElementById('aiPrompt').value;
                        const response = await fetch('ai-handler.php?action=workout', {
                            method: 'POST',
                            body: new URLSearchParams({ prompt: prompt })
                        });
                        document.getElementById('aiResponse').innerHTML = await response.text();
                    }
</script>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="generate-btn">
                    Generate Workout Plan
                </button>
            </div>
        </form>

        <div class="ai-loading" id="loading">
            <div class="loader"></div>
            <p>Analyzing your inputs and creating personalized workout...</p>
        </div>
    </div>

    <script>
        document.getElementById('workoutForm').addEventListener('submit', function() {
            document.getElementById('loading').style.display = 'block';
        }
            async function generateAITips() {
        const prompt = document.getElementById('aiPrompt').value;
        const response = await fetch('ai-handler.php?action=workout', {
            method: 'POST',
            body: new URLSearchParams({ prompt: prompt })
    });
    document.getElementById('aiResponse').innerHTML = await response.text();
        });
</script>
</body>
</html>