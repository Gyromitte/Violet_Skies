// Variables para controlar el tiempo de espera en la búsqueda en tiempo real
var typingTimer;
var doneTypingInterval = 50;

// Obtener los elementos del DOM
var form = document.getElementById('filtroForm');
var tablaResultados = document.getElementById('tablaResultados');
var peticionesResult = document.getElementById('peticionesResult');
var estadoSelect = document.getElementById('estadoSelect');
var searchInput = document.getElementById('searchInput');
var searchButton = document.getElementById('searchButton');
var eventosPendientes = document.getElementById("eventosPendientes");
var eventosEnProceso = document.getElementById("eventosEnProceso");
var eventosCancelados = document.getElementById("eventosCancelados");
var peticiones = document.getElementById("peticiones");
var eventosFin = document.getElementById("eventosFin");
var fechaInicioInput = document.getElementById('fechaInicioInput');
var fechaFinInput = document.getElementById('fechaFinInput');

// Obtener el div que contiene el contenido de la clase row
var contentRow = document.getElementById('contentRow');

// Ejecutar la función de filtrado al cargar la página
filtrarEventos();

estadoSelect.addEventListener('change', function() {
    if (estadoSelect.value === 'PETICIONES') {
        peticionesFuncion();
    } else {
        filtrarEventos();
    }
});
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
peticiones.addEventListener("click", function() {
    estadoSelect.value = "PETICIONES";
    peticionesFuncion();
});
eventosCancelados.addEventListener("click", function() {
    estadoSelect.value = "CANCELADO";
    filtrarEventos();
});
eventosFin.addEventListener("click", function() {
    estadoSelect.value = "FINALIZADO";
    filtrarEventos();
});
searchButton.addEventListener('click', function() {
    filtrarEventos();
});

// Escuchar eventos de cambio en las fechas
fechaInicioInput.addEventListener('change', filtrarEventos);
fechaFinInput.addEventListener('change', filtrarEventos);

function filtrarEventos() {
    var formData = new FormData(form);
    formData.append('depa', estadoSelect.value);
    formData.append('search', searchInput.value.trim());
    formData.append('fecha_inicio', fechaInicioInput.value);
    formData.append('fecha_fin', fechaFinInput.value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../viewsEventos/verEventos.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            tablaResultados.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);

    if (estadoSelect.value === 'GRAFICOS') {
        contentRow.style.display = 'flex';
        tablaResultados.style.display = 'none';
        searchInput.style.display = 'none';
        searchButton.style.display = 'none';
        fechaInicioInput.style.display = 'none';
        fechaFinInput.style.display = 'none';
        peticionesResult.style.display='none';
    } else if (estadoSelect.value !== 'PETICIONES') {
        contentRow.style.display = 'none';
        tablaResultados.style.display = 'block';
        searchInput.style.display = 'block'; 
        searchButton.style.display = 'block'; 
        fechaInicioInput.style.display = 'block'; 
        fechaFinInput.style.display = 'block'; 
        peticionesResult.style.display='none';
    }

    var params = new URLSearchParams(formData);
    history.replaceState(null, '', '?' + params.toString());
}

function peticionesFuncion() {
    var formData = new FormData(form);
    formData.append('depa', estadoSelect.value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../viewsEventos/peticiones.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            peticionesResult.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);

    if (estadoSelect.value === 'PETICIONES') {
        peticionesResult.style.display = 'block';
        contentRow.style.display = 'none';
        tablaResultados.style.display = 'none';
        searchInput.style.display = 'none';
        searchButton.style.display = 'none';
        fechaInicioInput.style.display = 'none';
        fechaFinInput.style.display = 'none';
    } 
    var params = new URLSearchParams(formData);
    history.replaceState(null, '', '?' + params.toString());
}
function verSolicitudes(eventoId, nombreEvento, faltanMeseros, faltanCocina) {
    var xhr = new XMLHttpRequest();
    var url = '../viewsEventos/solicitudes.php?evento_id=' + eventoId +
              '&nombre_evento=' + encodeURIComponent(nombreEvento) +
              '&FALTAN_MESEROS=' + faltanMeseros +
              '&FALTAN_COCINA=' + faltanCocina;

    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            peticionesResult.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}


window.addEventListener('load', function() {
    var params = new URLSearchParams(window.location.search);
    estadoSelect.value = params.get('depa') || 'GRAFICOS';
    fechaInicioInput.value = params.get('fecha_inicio') || '';
    fechaFinInput.value = params.get('fecha_fin') || '';
});
