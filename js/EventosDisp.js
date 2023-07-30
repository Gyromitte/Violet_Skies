
var form = document.getElementById('EmpDisp');
var tablaResultados = document.getElementById('tablaResultados');
var tipoorden = document.getElementById('tipoorden');

VerDisp();

tipoorden.addEventListener('change', VerDisp);
//Ver los eventos disponibles en tal orden
function VerDisp() {

    var formData = new FormData(form);
    formData.append('tipo', tipoorden.value); 

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
window.addEventListener('load', function() {
    var params = new URLSearchParams(window.location.search);
    estadoSelect.value = params.get('tipo') || 'porcreacion';
});