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
    loadWorkoutHistory();
});