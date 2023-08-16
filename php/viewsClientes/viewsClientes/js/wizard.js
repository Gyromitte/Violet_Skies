document.addEventListener("DOMContentLoaded", function() {
    var currentStep = 1;
    showStep(currentStep);

    document.querySelector(".next-step").addEventListener("click", function(e) {
        e.preventDefault();
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
            clearAdvertencia();
        } else {
            displayAdvertencia("Debes rellenar todos los campos obligatorios antes de avanzar.");
        }
    });

    document.querySelector(".prev-step").addEventListener("click", function(e) {
        e.preventDefault();
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
            clearAdvertencia();
        }
    });

    function showStep(stepNumber) {
        var steps = document.querySelectorAll(".step");
        for (var i = 0; i < steps.length; i++) {
            steps[i].style.display = "none";
        }
        steps[stepNumber - 1].style.display = "block";
        updateExplanation(stepNumber);
    }

    function updateExplanation(stepNumber) {
        var explanations = [
            "Paso 1: Introduce el nombre del evento.",
            "Paso 2: Selecciona el salón para el evento."
            // Agrega más explicaciones según los pasos
        ];
        document.querySelector("#infoAgendar").textContent = explanations[stepNumber - 1];
    }

    function validateStep(stepNumber) {
        var inputs = document.querySelectorAll(".step-" + stepNumber + " input[required], .step-" + stepNumber + " select[required]");
        for (var i = 0; i < inputs.length; i++) {
            if (!inputs[i].value) {
                return false;
            }
        }
        return true;
    }

    function displayAdvertencia(message) {
        var advertenciaDiv = document.querySelector("#infoAdvertencia");
        advertenciaDiv.style.display = "block";
        advertenciaDiv.textContent = message;
    
        setTimeout(function() {
            clearAdvertencia();
        }, 3000); // Ocultar el mensaje después de 3 segundos
    }

    function clearAdvertencia() {
        document.querySelector("#infoAdvertencia").style.display = "none";
    }

    var stepsToHide = document.querySelectorAll(".step:not(.step-1)");
    for (var i = 0; i < stepsToHide.length; i++) {
        stepsToHide[i].style.display = "none";
    }
});