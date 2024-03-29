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

    var opcionMenu = document.querySelector("#comida");
    opcionMenu.addEventListener("change", function() {
        showStep(currentStep);
    });

    function showStep(stepNumber) {
        var steps = document.querySelectorAll(".step");
        for (var i = 0; i < steps.length; i++) {
            steps[i].style.display = "none";
        }
        
        var descripcionComida = document.querySelector("#descripcionComida");
        var opcionMenu = document.querySelector("#comida");
        
        if (stepNumber === 4 && opcionMenu.value) {
            descripcionComida.style.display = "block";
        } else {
            descripcionComida.style.display = "none";
        }
        
        steps[stepNumber - 1].style.display = "block";
        updateExplanation(stepNumber);
        
        // Desactivar botón "Anterior" si está en el primer paso
        var prevButton = document.querySelector(".prev-step");
        prevButton.disabled = stepNumber === 1;
        
        // Desactivar botón "Siguiente" si está en el último paso
        var nextButton = document.querySelector(".next-step");
        nextButton.disabled = stepNumber === steps.length;
    
        // Habilitar o deshabilitar la interacción con el calendario según el paso
        updateCalendarInteractivity(stepNumber === 1); // Solo permitir interacción si stepNumber es igual a 1

        //Mostrar la confirmacion
        if (stepNumber === 5) {
            var confirmFecha = document.getElementById("confirm-fecha");
            var confirmHora = document.getElementById("confirm-hora");
            var confirmInvitados = document.getElementById("confirm-invitados");
            var confirmNombre = document.getElementById("confirm-nombre");
            var confirmSalon = document.getElementById("confirm-salon");
            var confirmMenu = document.getElementById("confirm-menu");

            // Obtener el valor seleccionado del salón y del menú
            var salonSelect = document.getElementById("salon");
            var menuSelect = document.getElementById("comida");
        
            var salonSeleccionado = salonSelect.options[salonSelect.selectedIndex].text;
            var menuSeleccionado = menuSelect.options[menuSelect.selectedIndex].text;
        
            // Mostrar los nombres en lugar de los IDs
            confirmSalon.textContent = salonSeleccionado;
            confirmMenu.textContent = menuSeleccionado;

            // Aquí actualiza los elementos con los datos ingresados por el usuario
            confirmFecha.textContent = document.getElementById("selected-date").value;
            confirmHora.textContent = document.getElementById("hora_evento").value;
            confirmInvitados.textContent = document.getElementById("invitados").value;
            confirmNombre.textContent = document.getElementById("nombre_evento").value;

        }
    }
    

    function updateExplanation(stepNumber) {
        var explanations = [
            "Selecciona una fecha disponible dentro del <strong>calendario</strong>, <br>hora del evento y cantidad de invitados <br> <strong>Por favor toma en cuenta que el mínimo de invitados <br> es 10 y el máximo es 120</strong>",
            "Ingresa el nombre del evento",
            "Selecciona el salón del evento <br> <strong>Si no encuentras un salón disponible por favor <br> selecciona otra fecha o  revisa la cantidad de invitados</strong>",
            "Escoge una opción de nuestros menús",
            "Confirmación de datos:"
            // Agrega más explicaciones según los pasos
        ];
        document.querySelector("#infoAgendar").innerHTML = explanations[stepNumber - 1];
    }

    function validateStep(stepNumber) {
        if (stepNumber === 1) {
            // Validar si la hora del evento y la cantidad de invitados han sido ingresados en el primer paso
            var horaEvento = document.querySelector("#hora_evento").value;
            var cantidadInvitados = document.querySelector("#invitados").value;
            var fechaEvento = document.querySelector("#selected-date").value;
            if (!horaEvento || !cantidadInvitados || !fechaEvento) {
                return false;
            }
        } else {
            // Validar campos requeridos en los otros pasos
            var inputs = document.querySelectorAll(".step-" + stepNumber + " input[required], .step-" + stepNumber + " select[required]");
            for (var i = 0; i < inputs.length; i++) {
                if (!inputs[i].value) {
                    return false;
                }
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

    function updateCalendarInteractivity(isClickable) {
        var calendarElement = document.getElementById("calendar");

        if (isClickable) {
            calendarElement.classList.remove("non-clickable"); // Quiar estilo de no click al primer paso
        } else {
            calendarElement.classList.add("non-clickable"); // Agregar estilo de click a todos los demas pasos
        }
    }

    function handleCalendarClick(event) {
        // Aquí puedes poner el código para manejar el clic en el calendario
    }
});
