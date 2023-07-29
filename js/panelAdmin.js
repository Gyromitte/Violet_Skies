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
      setTimeout(function() {
        btnCocineros.click();
      }, 100);
      break;
    case 'meseros':
      setTimeout(function() {
        btnMeseros.click();
      }, 100);
      break;
    case 'busqueda':
      setTimeout(function() {
        btnBusqueda.click();
      }, 100);
      break;
  }
}
//Obtener botones para refrescar vistas
var btnCocineros = document.getElementById('verCocineros');
var btnMeseros = document.getElementById('verMeseros');
var btnBusqueda = document.getElementById('buscarEmpleado');

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
            <input type="text" name="RFC" placeholder="Ingresa el RFC" class="form-control" required>
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
          <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cancelar</button>
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
        setTimeout(function() {
          checkCurrentTable(currentTable);
        }, 500); // 0.5 segundos, si la funcion se ejecuta muy rapido no reflejara los cambios
      });
      break;
    case "@eliminarEmpleado":
        modalTitle.textContent = "Eliminar a un Empleado";
        modalHeader.classList.add('modal-header-warning');
        // Obtener los datos del empleado con una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
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
          }};
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
                      <input type="text" name="rfc" placeholder="Ingresa el RFC" class="form-control" required value="${empleado.RFC}">
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
        console.log("hola");
        modalTitle.textContent ="Editar Datos"
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
        // Realizar una solicitud AJAX para obtener los detalles del evento
        var xhrDetalles = new XMLHttpRequest();
        xhrDetalles.onreadystatechange = function() {
          if (xhrDetalles.readyState === XMLHttpRequest.DONE) {
            if (xhrDetalles.status === 200) {
              // Parsear la respuesta JSON
              var detallesEvento = JSON.parse(xhrDetalles.responseText);
              // Realizar una solicitud AJAX para obtener la lista de salones disponibles
              var xhrSalones = new XMLHttpRequest();
              xhrSalones.onreadystatechange = function() {
                if (xhrSalones.readyState === XMLHttpRequest.DONE) {
                  if (xhrSalones.status === 200) {
                    // Parsear la respuesta JSON
                    var salones = JSON.parse(xhrSalones.responseText);
                    // Obtener el select del salón por su ID
                    var selectSalon = document.getElementById('salon');
                    // Limpiar cualquier opción previa del select
                    selectSalon.innerHTML = "";
              
                    // Agregar la opción predeterminada "Seleccionar salón"
                    var optionSeleccionar = document.createElement('option');
                    optionSeleccionar.value = ""; // Asignar un valor vacío o el que corresponda
                    optionSeleccionar.textContent = "-Seleccionar salón-"; // Texto a mostrar en la opción predeterminada
                    selectSalon.appendChild(optionSeleccionar);
                    // Variable para verificar si el salón del evento está en la lista de salones disponibles
                    var salonEncontrado = false;
                    // Crear una opción para cada salón en la lista de salones disponibles
                    salones.forEach(function(salon) {
                      var option = document.createElement('option');
                      option.value = salon.ID; // Asignar el valor del ID del salón (puedes usar otro campo si lo prefieres)
                      option.textContent = salon.NOMBRE; // Asignar el nombre del salón
                      selectSalon.appendChild(option);
                      // Verificar si el nombre del salón del evento coincide con el salón actual en el bucle
                      if (salon.NOMBRE === detallesEvento.SALON) {
                        // Si se encuentra el salón del evento, seleccionarlo en el select y marcarlo como encontrado
                        option.selected = true;
                        salonEncontrado = true;
                      }
                    });
                    // Si el salón del evento no está en la lista de salones disponibles, agregar un mensaje de error
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
                  // Parsear la respuesta JSON
                  var menu = JSON.parse(xhrComida.responseText);
                  // Obtener el select del menú por su ID
                  var selectMenu = document.getElementById('comida');
                  // Limpiar cualquier opción previa del select
                  selectMenu.innerHTML = "";
                  // Agregar la opción predeterminada "Seleccionar menú"
                  var optionSeleccionar = document.createElement('option');
                  optionSeleccionar.value = ""; // Asignar un valor vacío o el que corresponda
                  optionSeleccionar.textContent = "-Seleccionar menú-"; // Texto a mostrar en la opción predeterminada
                  selectMenu.appendChild(optionSeleccionar);
                  // Variable para verificar si el menú del evento está en la lista de menu disponibles
                  var menuEncontrado = false;
                  // Crear una opción para cada menú en la lista de menu disponibles
                  menu.forEach(function(comida) {
                    var option = document.createElement('option');
                    option.value = comida.ID; // Asignar el valor del ID del menú (puedes usar otro campo si lo prefieres)
                    option.textContent = comida.NOMBRE; // Asignar el nombre del menú
                    selectMenu.appendChild(option);
                    // Verificar si el nombre del menú del evento coincide con el menú actual en el bucle
                    if (comida.NOMBRE === detallesEvento.COMIDA) {
                      // Si se encuentra el menú del evento, seleccionarlo en el select y marcarlo como encontrado
                      option.selected = true;
                      menuEncontrado = true;
                    }
                  });
                  // Si el menú del evento no está en la lista de menu disponibles, agregar un mensaje de error
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

            // Construir el contenido del formulario del modal con los detalles del evento
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
                    <td><input class="form-control" type="text" placeholder="Invitados" id="invitados" value="${detallesEvento.INVITADOS}" disabled></td>
                  </tr>
                  <tr>
                    <td><h6>Menú</h6></td>
                    <td><select class="form-control" id="comida" disabled></select></td>
                  </tr>
                  <tr>
                    <td><h6>Estado</h6></td>
                    <td>${detallesEvento.ESTADO}</td>
                  </tr>
                </table>
                <br>
                <div align="center">
                  ${detallesEvento.ESTADO !== 'CANCELADO' && detallesEvento.ESTADO !== 'FINALIZADO' ? 
                    '<button type="button" class="btn btn-primary" id="btnModify">Modificar Detalles</button>' :''}
                    <button type="button" class="btn btn-primary" id="btnGuardar" style="display: none;">Guardar</button>
                  ${detallesEvento.ESTADO !== 'CANCELADO' && detallesEvento.ESTADO !== 'FINALIZADO'? 
                    '<button type="button" class="btn btn-danger" id="btnCancelarEvento">Cancelar Evento</button>' : ''}
                </div>
              </form>
            `;
            // Asignar el contenido al formulario del modal
            modalForm.innerHTML = formContent;
            // Inicializar el datetimepicker en el campo de fecha
            $(document).ready(function() {
              $('#fechaEvento').datetimepicker({
                format: 'Y-m-d H:i:s', // Formato deseado para la fecha y hora
                step: 15, // Intervalo de minutos para seleccionar la hora
                disabledTimeIntervals: [ // Intervalos de horas deshabilitados, si lo deseas
                  // [0, 8], // Ejemplo: deshabilita desde la medianoche hasta las 8:00 am
                  // [20, 24] // Ejemplo: deshabilita desde las 8:00 pm hasta la medianoche
                ]
              });
            });
            
            var btnModificarGuardar = document.getElementById('btnGuardar');
            btnModificarGuardar.addEventListener('click', function() {
              // Obtener los valores editados de los campos del formulario
              var fecha = document.getElementById('fechaEvento').value;
              var invitados = document.getElementById('invitados').value;
              var salon = document.getElementById('salon').value;
              var comida = document.getElementById('comida').value;
                   
              // Realizar la solicitud AJAX para guardar los cambios en la base de datos
              var xhrGuardarCambios = new XMLHttpRequest();
              xhrGuardarCambios.onreadystatechange = function() {                    
                if (xhrGuardarCambios.readyState === XMLHttpRequest.DONE) {
                  if (xhrGuardarCambios.status === 200) {
                    /// Parsear la respuesta JSON para verificar si hubo un error en el servidor
                    var response = JSON.parse(xhrGuardarCambios.responseText);
                    if (response.success) {
                      // Actualizar el contenido del formulario del modal con un mensaje de éxito
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>
                        Evento modificado exitosamente</div>`;
                      setTimeout(() => {
                        updateModalContent(formType, idEmpleado, idEvento);
                      }, 1000); // Actualizar el modal después de 2000 milisegundos (2 segundos)
                      filtrarEventos();
                      modalForm.innerHTML = formContent;
                    } else {
                      console.error("Error en el servidor:", response.message);
                    }
                  } else {
                    console.error("Error AJAX al guardar cambios en el evento. Código de estado:", xhrGuardarCambios.status);
                  }
                }
              };
              // Hacer la solicitud al script PHP "editarEvento.php" y pasar los datos editados
              var urlEditarEvento = `../viewsEventos/editarDetalles.php?id=${idEvento}&F_EVENTO=${fecha}&INVITADOS=${invitados}&SALON=${salon}&COMIDA=${comida}`;
              xhrGuardarCambios.open("GET", urlEditarEvento, true);
              xhrGuardarCambios.send();
            });

            var btnModificar = document.getElementById('btnModify');
            btnModificar.addEventListener('click', function() {
              var inputs = modalForm.querySelectorAll('input, select');
              for (var i = 0; i < inputs.length; i++) {
                inputs[i].removeAttribute('disabled');
              }
                  
              btnModificar.style.display = "none";
              btnModificarGuardar.style.display = "";
            });

            var btnCancelarEvento = document.getElementById('btnCancelarEvento');
            btnCancelarEvento.addEventListener('click', function() {
              // Mostrar el modal de confirmación
              var confirmarCancelacion = window.confirm("¿Estás seguro que deseas cancelar este evento?");
  
              if (confirmarCancelacion) {
              // Si el usuario hace clic en "Aceptar", ejecutar la solicitud AJAX para cancelar el evento
                var xhrCancelarEvento = new XMLHttpRequest();
                xhrCancelarEvento.onreadystatechange = function() {
                  if (xhrCancelarEvento.readyState === XMLHttpRequest.DONE) {
                    if (xhrCancelarEvento.status === 200) {
                      // Actualizar el contenido del formulario del modal con un mensaje de éxito
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

          } else {
            console.error("Error en la solicitud AJAX");
          }
        }
      };
      // Hacer la solicitud al script PHP y pasar el ID del evento
      xhrDetalles.open("GET", "../viewsEventos/verDetalles.php?id=" + idEvento, true);
      xhrDetalles.send();
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