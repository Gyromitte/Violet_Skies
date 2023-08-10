// Variables para controlar el tiempo de espera en la búsqueda en tiempo real
var typingTimer;
var doneTypingInterval = 50; // Tiempo de espera en milisegundos antes de realizar la búsqueda

// Obtener el formulario, el campo de búsqueda y el div de la tabla de resultados
var form = document.getElementById('filtroForm');
var tablaResultados = document.getElementById('tablaResultados');
var estadoSelect = document.getElementById('estadoSelect');
var searchInput = document.getElementById('searchInput');
var searchButton = document.getElementById('searchButton');
var eventosPendientes = document.getElementById("eventosPendientes");
var eventosEnProceso = document.getElementById("eventosEnProceso");
var eventosCancelados = document.getElementById("eventosCancelados");
var eventosFin = document.getElementById("eventosFin");

// Obtener el div que contiene el contenido de la clase row
var contentRow = document.getElementById('contentRow');

// Ejecutar la función de filtrado al cargar la página
filtrarEventos();

// Escuchar el evento change del campo de selección de estado
estadoSelect.addEventListener('change', filtrarEventos);

// Escuchar el evento input del campo de búsqueda
searchInput.addEventListener('input', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(filtrarEventos, doneTypingInterval);
});

searchInput.addEventListener('keydown', function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        filtrarEventos();
    }
});
eventosPendientes.addEventListener("click", function() {
    estadoSelect.value = "PENDIENTE";
    filtrarEventos();
});
eventosEnProceso.addEventListener("click", function() {
    estadoSelect.value = "EN PROCESO";
    filtrarEventos();
});
eventosCancelados.addEventListener("click", function() {
    estadoSelect.value = "CANCELADO";
    filtrarEventos();
});
eventosFin.addEventListener("click", function() {
    estadoSelect.value = "FINALIZADO";
    filtrarEventos();
});

// Escuchar el evento click del botón de búsqueda
searchButton.addEventListener('click', function() {
    filtrarEventos();
});

// Función para filtrar los eventos
function filtrarEventos() {
    // Obtener los datos del formulario
    var formData = new FormData(form);
    formData.append('depa', estadoSelect.value);
    formData.append('search', searchInput.value.trim());

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
    if (estadoSelect.value === 'GRAFICOS') {
                contentRow.style.display = 'flex';
                tablaResultados.style.display = 'none';
                searchInput.style.display = 'none';
                searchButton.style.display = 'none';
            } else {
                contentRow.style.display = 'none';
                tablaResultados.style.display = 'block';
                searchInput.style.display = 'block'; 
                searchButton.style.display = 'block'; 
            }
    // Modificar la URL sin recargar la página
    var params = new URLSearchParams(formData);
    history.replaceState(null, '', '?' + params.toString());
}

// Restaurar el estado del formulario al cargar la página
window.addEventListener('load', function() {
    var params = new URLSearchParams(window.location.search);
    estadoSelect.value = params.get('depa') || 'todo';
});
