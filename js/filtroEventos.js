var typingTimer;
var doneTypingInterval = 50;

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
var contentRow = document.getElementById('contentRow');

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

function mostrarSolicitudesEmpleados() {
    var solicitDiv = document.getElementById("solicit");
    
    if (solicitDiv.style.display === "none") {
        solicitDiv.style.display = "block";
        
    } else {
        solicitDiv.style.display = "none";

    }
}

function mostrarmeserosIngresados(eventoId) {
    var xhr = new XMLHttpRequest();
    var url = '../viewsEventos/verEmpleadosRegistrados.php?id=' + eventoId + '&tipo=MESERO';
console.log(eventoId);
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var empleadosRegistradosDiv = document.getElementById("empleadosRegistrados");
            empleadosRegistradosDiv.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
function mostrarcocinaIngresados(eventoId) {
    var xhr = new XMLHttpRequest();
    var url = '../viewsEventos/verEmpleadosRegistrados.php?id=' + eventoId + '&tipo=COCINA';
console.log(eventoId);
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var empleadosRegistradosDiv = document.getElementById("empleadosRegistrados");
            empleadosRegistradosDiv.innerHTML = xhr.responseText;
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