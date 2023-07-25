VerDisp();
// Función para filtrar los eventos
function VerDisp() {
    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', '../viewsEventos/verEventosDisponibles.php', true);

    // Configurar la función de callback cuando se reciba la respuesta
    xhr.onload = function() {
        if (xhr.status === 200) {
            tablaResultados.innerHTML = xhr.responseText; // Actualizar la tabla de resultados con la respuesta
        }
    };

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Modificar la URL sin recargar la página
    var params = new URLSearchParams(formData);
    history.replaceState(null, '', '?' + params.toString());
}