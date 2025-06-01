let currentStep = 1;

function showStep(step, isEdit = false) {
    if(isEdit) {
        document.querySelectorAll('.step-container').forEach(el => el.style.display = 'none');
        document.querySelector(`[data-step="${step}"]`).style.display = 'block';
        return;
    }

    if(step < currentStep) {
        currentStep = step;
        updateProgress();
        return;
    }

    if(!validateStep(currentStep)) return;

    document.querySelectorAll('.step-container').forEach(el => el.classList.remove('step-active'));
    document.querySelector(`[data-step="${step}"]`).classList.add('step-active');
    document.querySelectorAll('.step-circle').forEach((circle, idx) => {
        circle.classList.toggle('active', idx < step);
    });
    currentStep = step;
}

function validateStep(step) {
    // Add validation logic for each step
    return true;
}

async function saveMeasurements() {
    const formData = new FormData(document.getElementById('measurementForm'));
    const response = await fetch('save-measurements.php', {
        method: 'POST',
        body: formData
    });
    
    if(response.ok) showStep(2);
}

// Equipment card interactions
document.querySelectorAll('.equipment-card').forEach(card => {
    card.addEventListener('click', function() {
        const checkbox = this.querySelector('input');
        checkbox.checked = !checkbox.checked;
        this.classList.toggle('selected', checkbox.checked);
    });
});

// Initialize workout history
async function loadWorkoutHistory() {
    const response = await fetch('fetch-workout-history.php');
    document.getElementById('historyItems').innerHTML = await response.text();
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Initialize equipment cards
    document.querySelectorAll('.equipment-card').forEach(card => {
        card.addEventListener('click', function() {
            const checkbox = this.querySelector('input');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('selected', checkbox.checked);
        });
    });

    // Initialize form validation
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('invalid', () => {
            element.closest('.input-group').classList.add('invalid');
        });
        
        element.addEventListener('input', () => {
            element.closest('.input-group').classList.remove('invalid');
        });
    });

    loadWorkoutHistory();
});

// Step validation logic
function validateStep(step) {
    const forms = {
        1: '#measurementForm',
        2: '#preferencesForm',
        3: '#environmentForm'
    };
    
    const form = document.querySelector(forms[step]);
    if (!form.checkValidity()) {
        form.reportValidity();
        return false;
    }
    return true;
}

// Enhanced form submission
document.querySelector('#environmentForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const loading = document.getElementById('loading');
    loading.style.display = 'block';
    
    try {
        const formData = new FormData(e.target);
        const response = await fetch('', {
            method: 'POST',
            body: formData
        });
        
        if (response.redirected) {
            window.location.href = response.url;
        }
    } catch (error) {
        console.error('Submission error:', error);
        loading.style.display = 'none';
    }
});

// AI Suggestion Handler
async function generateAITips() {
    const prompt = document.getElementById('aiPrompt').value;
    const responseArea = document.getElementById('aiResponse');
    
    responseArea.innerHTML = '<div class="loader"></div>';
    
    try {
        const response = await fetch('../auth/ai-handler.php?action=workout', {
            method: 'POST',
            body: new URLSearchParams({ prompt })
        });
        
        if (!response.ok) throw new Error('AI service error');
        responseArea.innerHTML = await response.text();
        
    } catch (error) {
        responseArea.innerHTML = `
            <div class="ai-error">
                <p>⚠️ AI Service Unavailable</p>
                <small>Local fallback suggestions:</small>
                <ul>
                    <li>Start with bodyweight exercises</li>
                    <li>Focus on compound movements</li>
                    <li>Maintain proper form</li>
                </ul>
            </div>
        `;
    }
}