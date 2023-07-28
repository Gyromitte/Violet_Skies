var datosUsuarioJSON = {};
var updatePerfilXHR = new XMLHttpRequest();
document.addEventListener('DOMContentLoaded', function() {

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
// Asignar evento de clic al botón
toggleDashboardBtn.addEventListener('click', toggleDashboard);

/*Fecha*/
var currentDate = new Date();
var day = currentDate.getDate();
var month = currentDate.getMonth() + 1; // Los meses en JavaScript comienzan desde 0
var year = currentDate.getFullYear();
// Construir la cadena de la fecha (DD/MM/YYYY)
var formatDate = day + ' / ' + month + ' / ' + year;
document.getElementById('fecha').innerHTML = formatDate;

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
      }, 500);
      break;
    case 'meseros':
      setTimeout(function() {
        btnMeseros.click();
      }, 500);
      break;
    case 'busqueda':
      setTimeout(function() {
        btnBusqueda.click();
      }, 500);
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
        console.log(currentTable);
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
        modalTitle.textContent = "Editar Datos";
        formContent = `
          <form id="formularioEditarDatos">
          <div id="mensajeDiv"></div>
              <div class="form-group">
                  <label for="nombreInput">Nombre:</label>
                  <input type="text" class="form-control" name="nombre" id="nombreInput" required value="${datosUsuario.nombre}">
              </div>
              <div class="form-group">
                  <label for="ap_paternoInput">Apellido Paterno:</label>
                  <input type="text" class="form-control" name="ap_paterno" id="ap_paternoInput" required value="${datosUsuario.ap_paterno}">
              </div>
              <div class="form-group">
                  <label for="ap_maternoInput">Apellido Materno:</label>
                  <input type="text" class="form-control" name="ap_materno" id="ap_maternoInput" required value="${datosUsuario.ap_materno}">
              </div>
              <div class="form-group">
                  <label for="telefonoInput">Teléfono:</label>
                  <input type="tel" class="form-control" name="telefono" id="telefonoInput" required value="${datosUsuario.telefono}">
              </div>
              <div class="form-group">
                  <label for="contrasenaActualInput">Contraseña Actual:</label>
                  <input type="password" class="form-control" name="contrasena_actual" id="contrasenaActualInput" required>
              </div>
              <input type="hidden" name="correo" id="correoInput" value="${datosUsuario.correo}">
              <input type="hidden" name="tipo_cuenta" id="tipo_cuentaInput"><br>
              <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
          </form>`;
        modalForm.innerHTML = formContent;
    
        // Obtener el formulario después de haberlo asignado al DOM
        var formEditarDatos = document.getElementById("formularioEditarDatos");
        var guardarCambiosBtn = document.getElementById("guardarCambios");
    
        guardarCambiosBtn.addEventListener("click", function () {
            var updatePerfilXHR = new XMLHttpRequest();
            // Realizar una nueva solicitud AJAX para actualizar los datos del perfil
            updatePerfilXHR.onreadystatechange = function () {
                if (updatePerfilXHR.readyState === XMLHttpRequest.DONE) {
                    if (updatePerfilXHR.status === 200) {
                        console.log(updatePerfilXHR.responseText); // Agregar esta línea para imprimir la respuesta
                        try {
                            var respuesta = JSON.parse(updatePerfilXHR.responseText);
                            if (respuesta.success) {
                                // Los datos se actualizaron con éxito
                                document.getElementById('mensajeDiv').innerHTML = `<div style="text-align:center;"class="alert alert-success">Cambios guardados exitosamente<br>Tienes que volver a iniciar sesión</div>`;
                                // Actualizar la sesión del usuario con los nuevos datos
                                datosUsuario = respuesta.usuario;
                                // Cerrar sesión y redirigir al usuario a la página index.html después de 1.5 segundos
                                setTimeout(function () {
                                    // Hacer la solicitud de cierre de sesión
                                    var logoutXHR = new XMLHttpRequest();
                                    logoutXHR.onreadystatechange = function () {
                                        if (logoutXHR.readyState === XMLHttpRequest.DONE) {
                                            if (logoutXHR.status === 200) {
                                                // Redirigir al usuario a la página index.html
                                                window.location.href = "/index.html";
                                            } else {
                                                console.error("Error al cerrar sesión");
                                            }
                                        }
                                    };
                                    logoutXHR.open("GET", "logout.php", true);
                                    logoutXHR.send();
                                }, 5000);
                            } else if (respuesta.error === 'badPass') {
                                document.getElementById('mensajeDiv').innerHTML = `<div class="alert alert-danger">Contraseña incorrecta</div>`;
                            } else {
                                // Hubo un error al actualizar los datos
                                document.getElementById('mensajeDiv').innerHTML = `<div style="text-align:center;" class="alert alert-danger">Error al actualizar los datos<br>Contraseña incorrecta</div>`;
                            }
                        } catch (error) {
                            // Si la respuesta no es un JSON válido, manejar el error aquí
                            console.error("Error al analizar la respuesta JSON: " + error.message);
                        }
                    } else {
                        console.error("Error en la solicitud AJAX de actualización");
                    }
                }
            };
    
            // Obtener los valores del formulario
            var formData = new FormData(formEditarDatos);
            // Agregar el campo tipo_cuenta al objeto formData
            formData.append('tipo_cuenta', datosUsuario.tipo_cuenta);
    
            // Configurar la solicitud al script PHP para editar el perfil y pasar los datos actualizados
            updatePerfilXHR.open("POST", "./pruebaComprobación.php", true);
            updatePerfilXHR.send(formData);
        });
        console.log(formType);
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


});

