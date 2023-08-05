/*Funcionamiento de la dashboard*/
// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');

// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  const modal = document.querySelector('.modal.show');
  if (!modal) { // Si no hay ningún modal abierto
    dashboard.classList.toggle('dashboard-open');
    main.classList.toggle('main-dash-open');
  }
}

// Asignar evento de clic al botón para abrir/cerrar la dashboard
toggleDashboardBtn.addEventListener('click', toggleDashboard);

// Agregar evento de clic al documento para cerrar el dashboard cuando se haga clic fuera de él
document.addEventListener('click', function (event) {
  const targetElement = event.target;
  if (!targetElement.closest('#dash-board') && !targetElement.closest('#nav-button')) {
    // Si el clic no es dentro del dashboard ni en el botón de la navbar, cerrar el dashboard
    dashboard.classList.remove('dashboard-open');
    main.classList.remove('main-dash-open');
  }
});

// Agregar evento de scroll al documento para cerrar el dashboard cuando se haga scroll
document.addEventListener('scroll', function () {
  if (dashboard.classList.contains('dashboard-open')) {
    dashboard.classList.remove('dashboard-open');
    main.classList.remove('main-dash-open');
  }
});


/*Main content*/
// Obtener las pestañas y el contenido 
var tabs = document.querySelectorAll('.dash-button');
var tabContents = document.querySelectorAll('.tab-content');
//Asignar evento de click a cada boton y relacionarlo con el id del contenido
tabs.forEach(function (tab) {
  tab.addEventListener('click', function () {
    var tabId = this.getAttribute('data-tab');

    tabs.forEach(function (tab) {
      tab.classList.remove('active');
    });
    tabContents.forEach(function (content) {
      content.classList.remove('active');
    });

    this.classList.add('active');
    document.getElementById(tabId).classList.add('active');
  });
});

/*Modal functionality*/
// Obtener el modal y el formulario
var modal = document.getElementById("mainModal");
var modalForm = document.getElementById("modal-form");

//Checar cual tabla es la que se esta mostrando actualmente
function checkCurrentTable(currentTable) {
  switch (currentTable) { //Simular un click para refrescar los cambios
    case 'cocineros':
      setTimeout(function () {
        btnCocineros.click();
      }, 100);
      break;
    case 'meseros':
      setTimeout(function () {
        btnMeseros.click();
      }, 100);
      break;
    case 'busqueda':
      setTimeout(function () {
        btnBusqueda.click();
      }, 100);
      break;
    case 'solicitud':
      setTimeout(function () {
          btnSolicitud.click();
      }, 100);
      break;  
  }
}
//Obtener botones para refrescar vistas
var btnCocineros = document.getElementById('verCocineros');
var btnMeseros = document.getElementById('verMeseros');
var btnBusqueda = document.getElementById('buscarEmpleado');
var btnSolicitud = document.getElementById('verSolicitudes');
// Evento para los botones
modal.addEventListener("show.bs.modal", function (event) {
  // Botón que activó el modal
  var button = event.relatedTarget;

  // Obtener el tipo de formulario correspondiente al botón
  var formType = button.getAttribute("data-bs-whatever");
  var idEmpleado = button.getAttribute("data-id");
  var idEvento = button.getAttribute("data-event-id");
  // Actualizar el contenido del formulario
  updateModalContent(formType, idEmpleado, idEvento);
});


// Función para actualizar el contenido del modal según el tipo de formulario
function updateModalContent(formType, idEmpleado, idEvento) {
  var formContent = "";
  var modalTitle = document.querySelector('#mainModal .modal-title');
  var form;
  //Conseguir el modal header para cambiarle el color
  var modalHeader = document.querySelector('.modal-header');

  switch (formType) {
    case "@registrarEmpleado":
      modalTitle.textContent = "Registrar un Empleado";
      modalHeader.classList.remove('modal-header-warning');
      formContent = `
        <div id="mensajeDiv" method="POST"></div>
        <form id="formularioEmpleado">
          <div class="mb-3">
            <label class="control-label">RFC</label>
            <input type="text" name="RFC" placeholder="Ingresa el RFC" class="form-control" 
            required oninput="this.value = this.value.toUpperCase()"
            required>
          </div>
          <div class="mb-3">
            <label class="control-label">E-mail</label>
            <input type="email" name="CORREO" placeholder="Ingresa el E-mail" class="form-control" required>
          </div>
          <div class="form-group mb-3">
            <label for="tipoUsuario">Tipo de Trabajador</label>
            <select name="tipoUsuario" class="form-control form-select" id="tipoUsuario">
              <option value="mesero">Mesero</option>
              <option value="cocina">Cocinero</option>
            </select>
          </div>
          <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary btn-modal me-2"><i class="fa-solid fa-address-card me-2" style="color: #ffffff;"></i>Registrar</button>
          <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      `;
      //Asignar el contenido al formulario del modal
      modalForm.innerHTML = formContent;

      //Obtener el formulario después de haberlo asignado al DOM
      form = document.querySelector('#formularioEmpleado');

      //Agregar evento de envio al formulario
      form.addEventListener('submit', function (event) {
        event.preventDefault(); //Para que la pagina no de refresh al dar submit

        //Solicitud AJAX
        var xhr = new XMLHttpRequest();
        //Configurar la solicitud
        xhr.open("POST", "guardarEmpleado.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //Obtener los datos del formulario
        var rfc = form.elements['RFC'].value;
        var correo = form.elements['CORREO'].value;
        var tipoUsuario = form.elements['tipoUsuario'].value;
        //Como se va enviar la solicitud: un string
        var formData = 'rfc=' + encodeURIComponent(rfc) + '&correo=' + (correo) + '&tipoUsuario=' + encodeURIComponent(tipoUsuario);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            //Manejo de la respuesta:
            var respuesta = xhr.responseText;
            document.getElementById('mensajeDiv').innerHTML = respuesta;
          }
        };
        //Enviar el formulario
        xhr.send(formData);
        //Ver cual es la tabla activa para refrescar cualquier cambio
        //console.log(currentTable);
        setTimeout(function () {
          checkCurrentTable(currentTable);
        }, 500); // 0.5 segundos, si la funcion se ejecuta muy rapido no reflejara los cambios
      });
      break;
    case "@eliminarEmpleado":
      modalTitle.textContent = "Eliminar a un Empleado";
      modalHeader.classList.add('modal-header-warning');
      // Obtener los datos del empleado con una solicitud AJAX
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Parsear la respuesta JSON
            var empleado = JSON.parse(xhr.responseText);
            // Actualizar el contenido del formulario con los datos obtenidos
            formContent = `
                <form onsubmit="return eliminarEmpleado(${idEmpleado})">
                  <div id="mensajeDiv" method="POST"></div> 
                  <h5>Empleado: </h5>
                  <h6 class="mb-3">${empleado.NOMBRE} ${empleado.AP_PATERNO} ${empleado.AP_MATERNO}</h6>
                  <h5>Telefono: </h5>
                  <h6 class="mb-3">${empleado.TELEFONO}</h6>
                  <h5>Correo: </h5>
                  <h6 class="mb-3">${empleado.CORREO}</h6>
                  <h5>RFC: </h5>
                  <h6 class="mb-3">${empleado.RFC}</h6>
                  <h5>Tipo: </h5>
                  <h6 class="mb-3">${empleado.TIPO}</h6>
                  <h4><strong>¿Seguro de que quieres eliminar este empleado?</strong></h4>
                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-modal-warning me-2"><i class="fa-solid fa-user-slash me-2" style="color: #ffffff;"></i>Eliminar</button>
                    <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              `;
            // Asignar el contenido al formulario del modal
            modalForm.innerHTML = formContent;
          } else {
            console.error("Error en la solicitud AJAX");
          }
        }
      };
      // Hacer la solicitud al script PHP y pasar el ID del empleado
      xhr.open("GET", "obtenerEmpleado.php?id=" + idEmpleado, true);
      xhr.send();
      //Ver cual es la tabla activa para refrescar cualquier cambio
      checkCurrentTable(currentTable);
      break;
    case "@editarEmpleado":
      modalTitle.textContent = "Modificar datos";
      modalHeader.classList.remove('modal-header-warning');
      //Realizar una solicitud AJAX para obtener los datos del empleado
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            //Parsear la respuesta JSON
            var empleado = JSON.parse(xhr.responseText);
            console.log(empleado);
            //Actualizar el contenido del formulario con los datos obtenidos
            formContent = `
                  <form id="formularioEditarEmpleado">
                    <div id="mensajeDiv" method="POST"></div> <!-- Div para mensajes de respuesta -->
                    <h5>Empleado: </h5>
                    <h6 class="mb-3">${empleado.NOMBRE} ${empleado.AP_PATERNO} ${empleado.AP_MATERNO}</h6>
                    <h5>Telefono: </h5>
                    <h6 class="mb-3">${empleado.TELEFONO}</h6>
                    <h5>Correo: </h5>
                    <h6 class="mb-3">${empleado.CORREO}</h6>
                    <div class="mb-3">
                      <label class="control-label">RFC</label>
                      <input type="text" name="rfc" placeholder="Ingresa el RFC" class="form-control" 
                      required oninput="this.value = this.value.toUpperCase()"
                      required value="${empleado.RFC}">
                    </div>
                    <div class="form-group mb-3">
                      <label for="tipoUsuario">Tipo de Trabajador</label>
                      <select name="tipoUsuario" class="form-control form-select" id="tipoUsuario">
                        <option value="mesero" ${empleado.TIPO === 'MESERO' ? 'selected' : ''}>Mesero</option>
                        <option value="cocina" ${empleado.TIPO === 'COCINA' ? 'selected' : ''}>Cocinero</option>
                      </select>
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-modal me-2"><i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Modificar</button>
                    <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </form>
                `;
            // Asignar el contenido al formulario del modal
            modalForm.innerHTML = formContent;
            // Obtener el formulario después de haberlo asignado al DOM
            var formEditarEmpleado = document.querySelector('#formularioEditarEmpleado');
            // Agregar evento de envío al formulario de edición
            formEditarEmpleado.addEventListener('submit', function (event) {
              event.preventDefault(); // Evitar que el formulario se envíe por defecto

              // Obtener los valores del formulario
              var rfc = formEditarEmpleado.elements.rfc.value;
              var tipoUsuario = formEditarEmpleado.elements.tipoUsuario.value;

              // Realizar una nueva solicitud AJAX para actualizar los datos
              var updateXHR = new XMLHttpRequest();
              updateXHR.onreadystatechange = function () {
                if (updateXHR.readyState === XMLHttpRequest.DONE) {
                  if (updateXHR.status === 200) {
                    // Estilos al div de mensajes según la respuesta
                    var respuesta = updateXHR.responseText;
                    document.getElementById('mensajeDiv').innerHTML = respuesta;

                  } else {
                    console.error("Error en la solicitud AJAX de actualización");
                  }
                }
              };
              // Hacer la solicitud al script PHP para editar al empleado y pasar los datos actualizados
              updateXHR.open("POST", "editarEmpleado.php", true);
              updateXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
              updateXHR.send(`id=${idEmpleado}&rfc=${rfc}&tipoUsuario=${tipoUsuario}`);
              //Ver cual es la tabla activa para refrescar cualquier cambio
              checkCurrentTable(currentTable);
            });

          } else {
            console.error("Error en la solicitud AJAX");
          }
        }
      };
      //Hacer la solicitud al script PHP y pasar el ID del empleado
      xhr.open("GET", "obtenerEmpleado.php?id=" + idEmpleado, true);
      console.log(idEmpleado);
      xhr.send();
      //Ver cual es la tabla activa para refrescar cualquier cambio
      checkCurrentTable(currentTable);
      break;
    case "@editarPerfil":
      //Ver cual es la tabla activa para refrescar cualquier cambio
      checkCurrentTable(currentTable);
      break;
    case "@verSolicitud":
        modalTitle.textContent = "Manejar solicitud";
        modalHeader.classList.remove('modal-header-warning');
        // Obtener los datos de la solicitud con una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parsear la respuesta JSON
              var solicitud = JSON.parse(xhr.responseText);
              // Actualizar el contenido del formulario con los datos obtenidos
              formContent = `
                <form>
                  <div id="mensajeDiv" method="POST"></div> 
                  <h5>Solicitante: </h5>
                  <h6 class="mb-3">${solicitud.NOMBRE} ${solicitud.AP_PATERNO} ${solicitud.AP_MATERNO}</h6>
                  <h5>Telefono: </h5>
                  <h6 class="mb-3">${solicitud.TELEFONO}</h6>
                  <h5>Correo: </h5>
                  <h6 class="mb-3">${solicitud.CORREO}</h6>
                  <div class="mb-3">
                    <label class="control-label">RFC</label>
                    <input required oninput="this.value = this.value.toUpperCase()"
                    type="text" name="RFC" placeholder="Ingresa el RFC" class="form-control" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="tipoUsuario">Tipo de Trabajador</label>
                    <select name="tipoUsuario" class="form-control form-select" id="tipoUsuario">
                      <option value="mesero">Mesero</option>
                      <option value="cocina">Cocinero</option>
                    </select>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button id="btn-aceptar-solicitud" type="button" class="btn btn-primary btn-modal me-2"><i class="fa-solid fa-circle-check me-2" style="color: #ffffff;"></i>Aceptar</button>
                    <button id="btn-rechazar-solicitud" type="button" class="btn btn-primary btn-modal-warning me-2"><i class="fa-solid fa-ban me-2" style="color: #ffffff;"></i>Rechazar</button>
                  </div>
                </form>
              `;
              // Asignar el contenido al formulario del modal
              modalForm.innerHTML = formContent;
      
              // Obtener el botón "Aceptar" del formulario después de haberlo asignado al DOM
              var btnAceptarSolicitud = document.getElementById("btn-aceptar-solicitud");
              // Obtener el botón "Rechazar" del formulario después de haberlo asignado al DOM
              var btnRechazarSolicitud = document.getElementById("btn-rechazar-solicitud");
      
              // Agregar evento de clic al botón "Aceptar"
              btnAceptarSolicitud.addEventListener("click", function (event) {
                event.preventDefault(); // Evitar que el formulario se envíe automáticamente
      
                // Obtener el valor del campo RFC
                var rfcInput = document.getElementsByName("RFC")[0];
                var rfc = rfcInput.value.trim(); // Eliminar espacios en blanco al inicio y final
      
                // Verificar si el campo RFC está vacío
                if (rfc === "") {
                  // Mostrar un mensaje de error en el modal o donde consideres apropiado
                  document.getElementById("mensajeDiv").innerHTML = "<div class='alert alert-danger'>Debes ingresar el RFC</div>";
                  return; // Detener la ejecución del evento click
                }
      
                // Obtener los valores del formulario
                var correo = solicitud.CORREO; // Aquí asumo que ya tienes disponible la variable solicitud con los datos del empleado
                var tipoUsuario = document.getElementById("tipoUsuario").value;
      
                // Crear un objeto con los datos del formulario para enviar en la solicitud AJAX
                var datosFormulario = {
                  rfc: rfc,
                  correo: correo,
                  tipoUsuario: tipoUsuario
                };
      
                // Realizar la solicitud AJAX al archivo PHP encargado de aceptar la solicitud
                var xhrAceptar = new XMLHttpRequest();
                xhrAceptar.onreadystatechange = function () {
                  if (xhrAceptar.readyState === XMLHttpRequest.DONE) {
                    if (xhrAceptar.status === 200) {
                      // Mostrar la respuesta del servidor en el modal
                      document.getElementById("mensajeDiv").innerHTML = xhrAceptar.responseText;
                      //Ver cual es la tabla activa para refrescar cualquier cambio
                      checkCurrentTable(currentTable);
                    } else {
                      //Ver cual es la tabla activa para refrescar cualquier cambio
                      checkCurrentTable(currentTable);
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
      
                // Hacer la solicitud al script PHP para aceptar la solicitud
                xhrAceptar.open("POST", "aceptarSolicitud.php", true);
                xhrAceptar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                // Instead of sending JSON, create a query string from the data
                var formData = new URLSearchParams(datosFormulario).toString();
                xhrAceptar.send(formData);
                //Ver cual es la tabla activa para refrescar cualquier cambio
                checkCurrentTable(currentTable);
              });
      
              // Agregar evento de clic al botón "Rechazar"
              btnRechazarSolicitud.addEventListener("click", function (event) {
                event.preventDefault(); // Evitar que el formulario se envíe automáticamente
      
                // Obtener el valor del correo
                var correo = solicitud.CORREO; 
      
                // Crear un objeto con los datos del formulario para enviar en la solicitud AJAX
                var datosFormulario = {
                  correo: correo
                };
      
                // Realizar la solicitud AJAX al archivo PHP encargado de rechazar la solicitud
                var xhrRechazar = new XMLHttpRequest();
                xhrRechazar.onreadystatechange = function () {
                  if (xhrRechazar.readyState === XMLHttpRequest.DONE) {
                    if (xhrRechazar.status === 200) {
                      // Mostrar la respuesta del servidor en el modal
                      document.getElementById("mensajeDiv").innerHTML = xhrRechazar.responseText;
                      // Ver cual es la tabla activa para refrescar cualquier cambio
                      checkCurrentTable(currentTable);
                    } else {
                      // Ver cual es la tabla activa para refrescar cualquier cambio
                      checkCurrentTable(currentTable);
                      console.error("Error en la solicitud AJAX de Rechazar");
                    }
                  }
                };
      
                // Hacer la solicitud al script PHP para rechazar la solicitud
                xhrRechazar.open("POST", "rechazarSolicitud.php", true);
                xhrRechazar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                // Instead of sending JSON, create a query string from the data
                var formData = new URLSearchParams(datosFormulario).toString();
                xhrRechazar.send(formData);
                // Ver cual es la tabla activa para refrescar cualquier cambio
                checkCurrentTable(currentTable);
              });
            } else {
              console.error("Error en la solicitud AJAX");
              //Ver cual es la tabla activa para refrescar cualquier cambio
              checkCurrentTable(currentTable);
            }
          }
        };
      
        // Hacer la solicitud al script PHP y pasar el ID de la solicitud
        xhr.open("GET", "obtenerSolicitud.php?id=" + idEmpleado, true);
        xhr.send();
        // Ver cual es la tabla activa para refrescar cualquier cambio
        //console.log("hola");
        modalTitle.textContent ="Manejar Solicitud"
        formContent=`<form id="formularioEditarDatos" method="post" action="pruebaComprobación.php">
        <div class="form-group">
            <label for="nombreInput">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombreInput" required>
        </div>
        <div class="form-group">
            <label for="ap_paternoInput">Apellido Paterno:</label>
            <input type="text" class="form-control" name="ap_paterno" id="ap_paternoInput" required>
        </div>
        <div class="form-group">
            <label for="ap_maternoInput">Apellido Materno:</label>
            <input type="text" class="form-control" name="ap_materno" id="ap_maternoInput" required>
        </div>
        <div class="form-group">
            <label for="telefonoInput">Teléfono:</label>
            <input type="tel" class="form-control" name="telefono" id="telefonoInput" required>
        </div>
        <div class="form-group">
            <label for="contrasenaActualInput">Contraseña Actual:</label>
            <input type="password" class="form-control" name="contrasena_actual" id="contrasenaActualInput" required>
        </div>

        </div>
        <br>
        <input type="hidden" name="correo" id="correoInput">
        <input type="hidden" name="tipo_cuenta" id="tipo_cuentaInput">
        <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
        </form>`;
        modalForm.innerHTML = formContent;
        //Ver cual es la tabla activa para refrescar cualquier cambio
        checkCurrentTable(currentTable);
        break;

    case "@verDetallesEvento":
      modalTitle.textContent = "Detalles del Evento";
      var xhrDetalles = new XMLHttpRequest();
      xhrDetalles.onreadystatechange = function() {
        if (xhrDetalles.readyState === XMLHttpRequest.DONE) {
          if (xhrDetalles.status === 200) {
            var detallesEvento = JSON.parse(xhrDetalles.responseText);
            // Realizar una solicitud AJAX para obtener la lista de salones disponibles
            var xhrSalones = new XMLHttpRequest();
            xhrSalones.onreadystatechange = function() {
              if (xhrSalones.readyState === XMLHttpRequest.DONE) {
                if (xhrSalones.status === 200) {
                  var salones = JSON.parse(xhrSalones.responseText);
                  var selectSalon = document.getElementById('salon');
                  selectSalon.innerHTML = "";
                  var optionSeleccionar = document.createElement('option');
                  optionSeleccionar.value = ""; // Asignar un valor vacío o el que corresponda
                  optionSeleccionar.textContent = "-Seleccionar salón-"; // Texto a mostrar en la opción predeterminada
                  selectSalon.appendChild(optionSeleccionar);
                  var salonEncontrado = false;
                    salones.forEach(function(salon) {
                    var option = document.createElement('option');
                    option.value = salon.ID; // Asignar el valor del ID del salón
                    option.textContent = salon.NOMBRE; // Asignar el nombre del salón
                    selectSalon.appendChild(option);
                    // Verificar si el nombre del salón del evento coincide con el salón actual en el bucle
                    if (salon.NOMBRE === detallesEvento.SALON) {
                      // Si se encuentra el salón del evento, seleccionarlo en el select y marcarlo como encontrado
                      option.selected = true;
                      salonEncontrado = true;
                    }
                  });
                  if (!salonEncontrado) {
                    console.error("El salón del evento no se encuentra en la lista de salones disponibles:", detallesEvento.SALON);
                  }
                } else {
                  console.error("Error AJAX al obtener la lista de salones");
                }
              }
            };
            // Hacer la solicitud al script PHP "obtenerSalones.php" para obtener la lista de salones
            xhrSalones.open("GET", "../viewsEventos/obtenerSalones.php", true);
            xhrSalones.send();

            var xhrComida = new XMLHttpRequest();
            xhrComida.onreadystatechange = function() {
              if (xhrComida.readyState === XMLHttpRequest.DONE) {
                if (xhrComida.status === 200) {
                  var menu = JSON.parse(xhrComida.responseText);
                  var selectMenu = document.getElementById('comida');
                  selectMenu.innerHTML = "";
                  var optionSeleccionar = document.createElement('option');
                  optionSeleccionar.value = ""; // Asignar un valor vacío o el que corresponda
                  optionSeleccionar.textContent = "-Seleccionar menú-"; // Texto a mostrar en la opción predeterminada
                  selectMenu.appendChild(optionSeleccionar);
                  var menuEncontrado = false;
                  // Crear una opción para cada menú en la lista de menu disponibles
                  menu.forEach(function(comida) {
                    var option = document.createElement('option');
                    option.value = comida.ID; // Asignar el valor del ID del menú
                    option.textContent = comida.NOMBRE; // Asignar el nombre del menú
                    selectMenu.appendChild(option);
                    if (comida.NOMBRE === detallesEvento.COMIDA) {
                      // Si se encuentra el menú del evento, seleccionarlo en el select y marcarlo como encontrado
                      option.selected = true;
                      menuEncontrado = true;
                    }
                  });
                  if (!menuEncontrado) {
                    console.error("El menú del evento no se encuentra en la lista de menu disponibles:", detallesEvento.COMIDA);
                  }
                } else {
                  console.error("Error AJAX al obtener la lista de menu");
                }
              }
            };
            xhrComida.open("GET", "../viewsEventos/obtenerComida.php", true);
            xhrComida.send();

            formContent = `
            <form>
              <h4 align='center'>${detallesEvento.NOMBRE}</h4>
              <h5 align='center'>${detallesEvento.CLIENTE}</h5><br>
              <table align='center' cellspacing="20" cellpadding="5">
                <tr>
                  <td><h6>Fecha</h6></td>
                  <td><input class="form-control" type="text" placeholder="Fecha y hora" id="fechaEvento" value="${detallesEvento.F_EVENTO}" disabled></td>
                </tr>
                <tr>
                  <td><h6>Salón</h6></td>
                  <td><select class="form-control" id="salon" disabled></select></td>
                </tr>
                <tr>
                  <td><h6>Invitados</h6></td>
                  <td><input class="form-control" type="number" placeholder="Invitados" id="invitados" value="${detallesEvento.INVITADOS}" disabled></td>
                </tr>
                <tr>
                  <td><h6>Menú</h6></td>
                  <td><select class="form-control" id="comida" disabled></select></td>
                </tr>
                <tr id="trMeseros" style="display: ${detallesEvento.ESTADO === 'EN PROCESO' ? 'table-row' : 'none'}">
                  <td><h6>Meseros</h6></td>
                  <td><input class="form-control" type="number" placeholder="Meseros requeridos" id="meserosRequeridos" value="${detallesEvento.MESEROS || ''}" disabled></td>
                </tr>
                <tr id="trCocineros" style="display: ${detallesEvento.ESTADO === 'EN PROCESO' ? 'table-row' : 'none'}">
                  <td><h6>Cocineros</h6></td>
                  <td><input class="form-control" type="number" placeholder="Cocineros requeridos" id="cocinerosRequeridos" value="${detallesEvento.COCINEROS || ''}" disabled></td>
                </tr>
                <tr>
                  <td><h6>Estado</h6></td>
                  <td>${detallesEvento.ESTADO}</td>
                </tr>
              </table>
              <br>
              <div align="center">
              <button type="button" class="btn btn-primary" id="btnModify"
                  ${detallesEvento.ESTADO === 'CANCELADO' || detallesEvento.ESTADO === 'FINALIZADO' ? 'style="display: none;"' : ''}>
                  <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Modificar Detalles</button>
                <button type="button" class="btn btn-success" id="btnAceptarEvento" 
                  ${detallesEvento.ESTADO === 'PENDIENTE' ? '' : 'style="display: none;"'}>
                  <i class="fa-solid fa-check me-2" style="color: #ffffff;"></i>Aceptar Evento</button>
                <button type="button" class="btn btn-primary" id="btnSaveChanges" style="display: none;">
                <i class="fa-solid fa-floppy-disk me-2" style="color: #ffffff;"></i>Guardar</button>            
                <button type="button" class="btn btn-danger" id="btnCancelarEvento" 
                  ${detallesEvento.ESTADO === 'CANCELADO' || detallesEvento.ESTADO === 'FINALIZADO' ? 'style="display: none;"' : ''}>
                  <i class="fa-solid fa-ban me-2" style="color: #ffffff;"></i>Cancelar Evento</button>            
                <button type="button" class="btn btn-info" id="btnEmpleadosRegistrados"
                  ${detallesEvento.ESTADO === 'CANCELADO' || detallesEvento.ESTADO === 'PENDIENTE' ? 'style="display: none;"' : ''}>
                  <i class="fa-solid fa-briefcase me-2" style="color: #ffffff;"></i>Empleados</button>
              </form>
              <div id="empleadosTable"></div>
            `;              
            
            modalForm.innerHTML = formContent;
            $(document).ready(function() {
              // Obtenemos la fecha actual
              var currentDate = new Date();
            
              // Calculamos la fecha 1 semana después de la actual
              var oneWeekLater = new Date();
              oneWeekLater.setDate(currentDate.getDate() + 6);
            
              $('#fechaEvento').datetimepicker({
                format: 'Y-m-d H:i:s', // Formato deseado para la fecha y hora
                step: 15, // Intervalo de minutos para seleccionar la hora
                minDate: oneWeekLater.toISOString().slice(0, 19).replace('T', ' '), // Fecha mínima: una semana después de la actual
                allowTimes: [
                  '05:00','06:00','07:00','08:00', '09:00', '10:00', '11:00', '12:00', '13:00', // Ejemplo de horas permitidas
                  '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00','22:00' // Puedes agregar más horas aquí
                ]
              });
            });

            var tablaVisible = false;
            var btnEmpleadosRegistrados = document.getElementById('btnEmpleadosRegistrados');
            btnEmpleadosRegistrados.addEventListener('click', function() {
              if (!tablaVisible) {
                $.ajax({
                  type: "GET",
                  url: `../viewsEventos/verEmpleadosRegistrados.php?id=${idEvento}`,
                  success: function (response) {
                    $("#empleadosTable").html(response);
                    tablaVisible = true; // La tabla está visible
                  },
                  error: function () {
                    console.error(error);
                  },
                });
              } else {
                // Si la tabla está visible, ocultarla
                $("#empleadosTable").html("");
                tablaVisible = false; // La tabla está oculta
              }
            });


            var btnModificar = document.getElementById('btnModify');
            btnModificar.addEventListener('click', function() {
              var inputs = modalForm.querySelectorAll('input, select');
              for (var i = 0; i < inputs.length; i++) {
                inputs[i].removeAttribute('disabled');
              }
              btnModificar.style.display = "none";
              btnAceptarEvento.style.display = "none";
              btnModificarGuardar.style.display = "";
            });

            var btnModificarGuardar = document.getElementById('btnSaveChanges');
            btnModificarGuardar.addEventListener('click', function() {
              
              var fecha = document.getElementById('fechaEvento').value;
              var invitados = document.getElementById('invitados').value;
              var salon = document.getElementById('salon').value;
              var comida = document.getElementById('comida').value;
              var meserosRequeridos = document.getElementById('meserosRequeridos').value;
              var cocinerosRequeridos = document.getElementById('cocinerosRequeridos').value;
  
              if (!fecha || !salon || !comida) {
                alert('Por favor, llene los campos correctamente');
                return;
              }
              if (!invitados || isNaN(invitados) || parseInt(invitados) < 10) {
                alert('Por favor, llene los campos correctamente\nEl mínimo para invitados son 10');
                return;
              }
              if (parseInt(cocinerosRequeridos) < 0 || parseInt(meserosRequeridos) < 0) {
                alert('Por favor, llene los campos correctamente\nInserte valores válidos');
                return;
              }

              var xhrGuardarCambios = new XMLHttpRequest();
              xhrGuardarCambios.onreadystatechange = function() {
                if (xhrGuardarCambios.readyState === XMLHttpRequest.DONE) {
                  if (xhrGuardarCambios.status === 200) {
                    var response = JSON.parse(xhrGuardarCambios.responseText);
                    if (response.success) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>Evento modificado exitosamente</div>`;
                      setTimeout(() => {
                        updateModalContent(formType, idEmpleado, idEvento);
                      }, 1000); // Actualizar el modal después de 2000 milisegundos (2 segundos)
                      filtrarEventos();
                      modalForm.innerHTML = formContent;
                    } else {
                      console.error("Error en el servidor:", response.message);
                    }
                  } else {
                    alert('No existen suficientes empleados registrados y/o disponibles para cubrir la solicitud en esa fecha');
                    console.error("Error AJAX al guardar cambios en el evento. Código de estado:", xhrGuardarCambios.status);
                  }
                }
              };
              var urlEditarEvento = `../viewsEventos/editarDetalles.php?id=${idEvento}&F_EVENTO=${fecha}&INVITADOS=${invitados}&SALON=${salon}&COMIDA=${comida}&MESEROS=${meserosRequeridos}&COCINEROS=${cocinerosRequeridos}`;
              xhrGuardarCambios.open("GET", urlEditarEvento, true);
              xhrGuardarCambios.send();
            });

            var btnCancelarEvento = document.getElementById('btnCancelarEvento');
            btnCancelarEvento.addEventListener('click', function() {
              // Mostrar el modal de confirmación
              var confirmarCancelacion = window.confirm("¿Estás seguro que deseas cancelar este evento?");
              if (confirmarCancelacion) {
                var xhrCancelarEvento = new XMLHttpRequest();
                xhrCancelarEvento.onreadystatechange = function() {
                  if (xhrCancelarEvento.readyState === XMLHttpRequest.DONE) {
                    if (xhrCancelarEvento.status === 200) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>
                        Evento cancelado</div>`;
                      setTimeout(() => {
                        updateModalContent(formType, idEmpleado, idEvento);
                      }, 500); // Actualizar el modal después de 2000 milisegundos (2 segundos)  
                      filtrarEventos();
                      modalForm.innerHTML = formContent;
                    } else {
                      console.error("Error AJAX para cancelar el evento");
                    }
                  }
                };
                // Hacer la solicitud al script PHP y pasar el ID del evento para cancelar
                xhrCancelarEvento.open("GET", "../viewsEventos/cancelarEvento.php?id=" + idEvento, true);
                xhrCancelarEvento.send();
              } else {
                // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
                console.log("Cancelación del evento cancelada por el usuario");
              }
            });

            var btnAceptarEvento = document.getElementById('btnAceptarEvento');
            btnAceptarEvento.addEventListener('click', function() {
              var confirmarAceptar = window.confirm("¿Estás seguro que deseas aceptar este evento?");
              if (confirmarAceptar) {
                var xhrAceptarEvento = new XMLHttpRequest();
                xhrAceptarEvento.onreadystatechange = function() {
                  if (xhrAceptarEvento.readyState === XMLHttpRequest.DONE) {
                    if (xhrAceptarEvento.status === 200) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>Evento aceptado</div>`;
                      setTimeout(() => {updateModalContent(formType, idEmpleado, idEvento);}, 500); // Actualizar el modal después de 2000 milisegundos (2 segundos)  
                      filtrarEventos();
                      modalForm.innerHTML = formContent;
                    } else {
                      console.error("Error AJAX para aceptar el evento");
                    }
                  }
                };
                xhrAceptarEvento.open("GET", "../viewsEventos/aceptarEvento.php?id=" + idEvento, true);
                xhrAceptarEvento.send();
              } else {
                console.log("Aceptación del evento cancelada por el usuario");
              }
            });
            
          } else {
            console.error("Error en la solicitud AJAX");
          }
        }
      };
      xhrDetalles.open("GET", "../viewsEventos/verDetalles.php?id=" + idEvento, true);
      xhrDetalles.send();
      break;
      case "@verHistorial":
  modalTitle.textContent = "Historial de empleado";
  // Obtener los datos del empleado con una solicitud AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Parsear la respuesta JSON del primer AJAX
        var empleado = JSON.parse(xhr.responseText);
        // Actualizar el contenido del formulario con los datos obtenidos
        formContent = `
          <form">
            <div id="mensajeDiv" method="POST"></div>
            <h5>Empleado:  </h5>
            <h6 class="mb-3">${empleado.NOMBRE} ${empleado.AP_PATERNO} ${empleado.AP_MATERNO}</h6> 
            <!-- Div para mostrar el historial de eventos -->
            <div id="historialDiv"></div>
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </form>
        `;
        // Asignar el contenido al formulario del modal
        modalForm.innerHTML = formContent;

        // Realizar la segunda solicitud AJAX para obtener el historial de eventos del empleado
        var xhrHistorial = new XMLHttpRequest();
        xhrHistorial.onreadystatechange = function () {
          if (xhrHistorial.readyState === XMLHttpRequest.DONE) {
            if (xhrHistorial.status === 200) {
              // No es necesario parsear la respuesta como JSON, ya que es HTML
              // Mostrar la tabla con el historial en el div correspondiente
              document.getElementById("historialDiv").innerHTML = xhrHistorial.responseText;
            } else {
              console.error("Error en la solicitud AJAX para obtener el historial");
            }
          }
        };
        // Hacer la segunda solicitud al script PHP para obtener el historial
        xhrHistorial.open("GET", "verHistorial.php?id=" + idEmpleado, true);
        xhrHistorial.send();
      } else {
        console.error("Error en la solicitud AJAX");
      }
    }
  };
  // Hacer la solicitud al script PHP y pasar el ID del empleado
  xhr.open("GET", "obtenerEmpleado.php?id=" + idEmpleado, true);
  xhr.send();
  break;

    }
  }
  
  // Función para eliminar al empleado
  function eliminarEmpleado(id) {
    var xhrEliminar = new XMLHttpRequest();
    xhrEliminar.onreadystatechange = function () {
      if (xhrEliminar.readyState === XMLHttpRequest.DONE) {
        if (xhrEliminar.status === 200) {
          // Manejo de la respuesta:
          var respuesta = xhrEliminar.responseText;
          document.getElementById('mensajeDiv').innerHTML = respuesta; // Mostrar el mensaje de respuesta en el div 'mensajeDiv'
  
          // Cerrar el modal después de eliminar al empleado después de 1.5 segundos
          setTimeout(function () {
            // Simular clic en el botón "Cancelar" para cerrar el modal
            var cancelButton = document.querySelector('#mainModal .btn-modal[data-bs-dismiss="modal"]');
            cancelButton.click();
  
            document.getElementById('modalForm').innerHTML = formContent;
          }, 1500); //(1.5 segundos)
  
        } else {
          console.error("Error al eliminar al empleado");
        }
      }
    };
    xhrEliminar.open("POST", "eliminarEmpleado.php", true);
    xhrEliminar.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhrEliminar.send("id=" + id); // Asegurarse de que el ID se pase correctamente en la solicitud AJAX
    //Ver cual es la tabla activa para refrescar cualquier cambio
    checkCurrentTable(currentTable);
    // Retornar false para evitar que el formulario se recargue la página
    return false;
  }
