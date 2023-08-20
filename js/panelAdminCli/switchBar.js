// Botones vistas empleados
var btnCocineros = document.getElementById('verCocineros');
var btnMeseros = document.getElementById('verMeseros');
var btnBusqueda = document.getElementById('buscarEmpleado');
var btnSolicitud = document.getElementById('verSolicitudes');
var btnGraficos = document.getElementById('verGraficos');

// Botones vistas clientes
var btnVerEve3 = document.getElementById('verEve3');
var btnVerEve1 = document.getElementById('verEve1');
var btnSinPrece = document.getElementById('verSinPrece');

//Container de search-bar
var searchContainer = document.getElementById('search-container');

// Obtener search bars
var searchEmp = document.getElementById('search');
var searchCli = document.getElementById('searchCliente');

// Funciones para manejar el clic en los botones de empleados y clientes
function handleClickEmpleados() {
    searchContainer.innerHTML = `
        <div class="input-group mb-3 search-bar" id="search">
            <input type="text" id="busqueda" class="form-control" placeholder="Buscar a un empleado"
                onkeyup="searchEmployee()"
            aria-label="" aria-describedby="button-addon2">
            <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
            <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
        </div>
    `;
}

function handleClickClientes() {
    searchContainer.innerHTML = 
    ` 
    <div class="input-group mb-3 search-bar" id="search-cliente">
        <input type="text" id="busquedaCliente" class="form-control" placeholder="Buscar a un cliente"
            onkeyup="searchCliente()"
        aria-label="" aria-describedby="button-addon2">
        <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
        <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
    </div>
    `;
}

// Agregar manejadores de eventos para los botones de empleados
btnCocineros.addEventListener('click', handleClickEmpleados);
btnMeseros.addEventListener('click', handleClickEmpleados);
btnBusqueda.addEventListener('click', handleClickEmpleados);
btnSolicitud.addEventListener('click', handleClickEmpleados);
btnGraficos.addEventListener('click', handleClickEmpleados);

// Agregar manejadores de eventos para los botones de clientes
btnVerEve3.addEventListener('click', handleClickClientes);
btnVerEve1.addEventListener('click', handleClickClientes);
btnSinPrece.addEventListener('click', handleClickClientes);
