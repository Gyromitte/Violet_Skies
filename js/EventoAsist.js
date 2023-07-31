
var forma = document.getElementById('EmpAsist');
var tablaRes = document.getElementById('tablaAsist');
var tipoorde = document.getElementById('tipoorde');

VerAsist();

tipoorde.addEventListener('change', VerAsist);
//Ver los eventos disponibles en tal orden
function VerAsist() {

    var formData = new FormData(forma);
    formData.append('asis', tipoorde.value); 

    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', '../viewsEventos/verEventosAtendiendo.php', true);

    // Configurar la función de callback cuando se reciba la respuesta
    xhr.onload = function() {
        if (xhr.status === 200) {
            tablaRes.innerHTML = xhr.responseText; // Actualizar la tabla de resultados con la respuesta
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
    tipoorde.value = params.get('orden') || 'lejanoevento';
});