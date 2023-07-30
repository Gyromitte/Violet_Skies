/*Funcionamiento de la dashboard*/
// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');

// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open');
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
  // Actualizar el contenido del formulario
  updateModalContent(formType, idEmpleado);
});



// Función para actualizar el contenido del modal según el tipo de formulario
function updateModalContent(formType, idEmpleado) {
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
        //Ver cual es la tabla activa para refrescar cualquier cambio
        checkCurrentTable(currentTable);
        break;
        case "@verSolicitud":
          modalTitle.textContent = "Manejar solicitud";
          modalHeader.classList.remove('modal-header-warning');
          
          // Obtener los datos de la solicitud con una solicitud AJAX
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
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
                      <input type="text" name="RFC" placeholder="Ingresa el RFC" class="form-control" required>
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
                      <button type="btn" class="btn btn-primary btn-modal-warning me-2"><i class="fa-solid fa-ban me-2" style="color: #ffffff;"></i>Rechazar</button>
                    </div>
                  </form>
                `;
                // Asignar el contenido al formulario del modal
                modalForm.innerHTML = formContent;
        
                // Obtener el botón "Aceptar" del formulario después de haberlo asignado al DOM
                var btnAceptarSolicitud = document.getElementById("btn-aceptar-solicitud");
        
                // Agregar evento de clic al botón "Aceptar"
                btnAceptarSolicitud.addEventListener("click", function(event) {
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
                  xhrAceptar.onreadystatechange = function() {
                    if (xhrAceptar.readyState === XMLHttpRequest.DONE) {
                      if (xhrAceptar.status === 200) {
                        // Mostrar la respuesta del servidor en el modal
                        document.getElementById("mensajeDiv").innerHTML = xhrAceptar.responseText;
                      } else {
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
                });
              } else {
                console.error("Error en la solicitud AJAX");
              }
            }
          };
        
          // Hacer la solicitud al script PHP y pasar el ID de la solicitud
          xhr.open("GET", "obtenerSolicitud.php?id=" + idEmpleado, true);
          xhr.send();
          // Ver cual es la tabla activa para refrescar cualquier cambio
          checkCurrentTable(currentTable);
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



