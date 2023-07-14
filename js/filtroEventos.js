// Obtener el formulario y el div de la tabla de resultados
var form = document.getElementById('filtroForm');
var tablaResultados = document.getElementById('tablaResultados');
var estadoSelect = document.getElementById('estadoSelect');

// Ejecutar la función de filtrado al cargar la página
filtrarEventos();

// Escuchar el evento change del campo de selección de estado
estadoSelect.addEventListener('change', filtrarEventos);

// Función para filtrar los eventos
function filtrarEventos() {
    // Obtener los datos del formulario
    var formData = new FormData(form);
    formData.append('depa', estadoSelect.value);

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', '../viewsEventos/verEventos.php', true);

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

// Restaurar el estado del formulario al cargar la página
window.addEventListener('load', function() {
    var params = new URLSearchParams(window.location.search);
    estadoSelect.value = params.get('depa') || 'todo';
});
