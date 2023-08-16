var datosUsuarioJSON = {};
var updatePerfilXHR = new XMLHttpRequest();
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
      }, 300);
      break;
    case 'meseros':
      setTimeout(function () {
        btnMeseros.click();
      }, 300);
      break;
    case 'busqueda':
      setTimeout(function () {
        btnBusqueda.click();
      }, 300);
      break;
    case 'solicitud':
      setTimeout(function () {
          btnSolicitud.click();
      }, 300);
      break;
    case 'desayuno':
      setTimeout(function () {
        btnDesayuno.click();
      }, 300);
      break;
    case 'bebidas':
      setTimeout(function () {
        btnBebidas.click();
      }, 300);
      break;
    case 'desBuffet':
      setTimeout(function () {
        btnDesBuffet.click();
      }, 300);
      break;
    case 'comida':
      setTimeout(function () {
        btnComida.click();
      }, 300);
      break;
    case 'comidaBuffet':
      setTimeout(function () {
        btnComidaBuffet.click();
      }, 300);
      break;
    case 'coffee':
      setTimeout(function () {
        btnCoffee.click();
      }, 300);
      break;
    case 'descontinuado':
      setTimeout(function () {
        btnDescontinuado.click();
      }, 300);
      break;     
  }
}
//Obtener botones para refrescar vistas
var btnCocineros = document.getElementById('verCocineros');
var btnMeseros = document.getElementById('verMeseros');
var btnBusqueda = document.getElementById('buscarEmpleado');
var btnSolicitud = document.getElementById('verSolicitudes');

var btnBebidas = document.getElementById('verBebidas');
var btnDesayuno = document.getElementById('verDesayuno');
var btnDesBuffet = document.getElementById('verDesBuffet');
var btnComida = document.getElementById('verComida');
var btnComidaBuffet = document.getElementById('verComidaBuffet');
var btnCoffee = document.getElementById('verCoffee');
var btnDescontinuado = document.getElementById('verDescontinuado');


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
        <form id="formularioEmpleado">
        <div class="mb-3">
          <label class="control-label">Nombre:</label>
          <input type="text" name="nombre" placeholder="Ingresa el nombre" class="form-control" maxlength="30" required>
        </div>
        <div class="mb-3">
          <label class="control-label">Apellido Paterno:</label>
          <input type="text" name="ap_paterno" placeholder="Ingresa su Ap. Paterno" class="form-control" maxlength="30" required>
        </div>
        <div class="mb-3">
          <label class="control-label">Apellido Materno:</label>
          <input type="text" name="ap_materno" placeholder="Ingresa su Ap. Materno" class="form-control" maxlength="30" required>
        </div>
        <div class="mb-3">
            <label class="control-label">Telefono:</label>
            <input type="text" name="telefono" placeholder="Ingresa su telefono" class="form-control" maxlength="10" required>
        </div>
          <div class="mb-3">
            <label class="control-label">RFC:</label>
            <input type="text" maxlength="13" name="RFC" placeholder="Ingresa el RFC" class="form-control" 
            required oninput="this.value = this.value.toUpperCase()"
            required>
          </div>
          <div class="mb-3">
            <label class="control-label">Correo:</label>
            <input type="email" maxlength="35"  name="CORREO" placeholder="Ingresa el correo" class="form-control" required>
          </div>
          <div class="form-group mb-3">
            <label for="tipoUsuario">Tipo de Empleado:</label>
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
        <div id="mensajeDiv" class="mt-10" method="POST"></div>
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

        var nombre = form.elements['nombre'].value;
        var ap_paterno = form.elements['ap_paterno'].value;
        var ap_materno = form.elements['ap_materno'].value;
        var telefono = form.elements['telefono'].value;

        //Como se va enviar la solicitud: un string
        var formData = 'rfc=' + encodeURIComponent(rfc)
         + '&correo=' + (correo) + '&tipoUsuario=' + encodeURIComponent(tipoUsuario)
         + '&nombre=' + (nombre) + '&ap_paterno=' + (ap_paterno) + '&ap_materno=' + (ap_materno)
         + '&telefono=' + (telefono);
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
      case "@re-incorporarEmpleado":
        modalTitle.textContent = "Re-incorporar a un empleado";
        modalHeader.classList.remove('modal-header-warning');
        formContent = `
          <div id="mensajeDiv" method="POST"></div>
          <form id="formularioEmpleado">
            <div class="mb-3">
              Aqui puedes volver a integrar al sistema a un empleado que fue dado de baja.
              <br>
              Ingresa el correo electronico que pertenecia a la cuenta del empleado:
            </div>
            <div class="mb-3">
              <label class="control-label">E-mail</label>
              <input type="email" maxlength="50" name="CORREO" placeholder="Ingresa el E-mail" class="form-control" required>
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
        xhr.open("POST", "re-incorporar.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //Obtener los datos del formulario
        var correo = form.elements['CORREO'].value;
        //Como se va enviar la solicitud: un string
        var formData = 'correo=' + (correo);
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
        checkCurrentTable(currentTable);
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
                    <div class="mb-3">
                    <h6>Correo: </h6>
                    <h6 class="mb-3">${empleado.CORREO}</h6>
                    <label class="control-label">Nombre: </label>
                    <input type="text" maxlength="35" name="nombre" placeholder="" class="form-control" 
                    required value="${empleado.NOMBRE}">
                    </div>
                    <div class="mb-3">
                    <label class="control-label">Ap. Paterno: </label>
                    <input type="text" maxlength="40" name="ap_paterno" placeholder="" class="form-control" 
                    required value="${empleado.AP_PATERNO}">
                    </div>
                    <div class="mb-3">
                    <label class="control-label">Ap. Materno: </label>
                    <input type="text" maxlength="40" name="ap_materno" placeholder="" class="form-control" 
                    required value="${empleado.AP_MATERNO}">
                    </div>
                    <div class="mb-3">
                    <label class="control-label">Telefono: </label>
                    <input type="text" maxlength="15" name="telefono" placeholder="" class="form-control" 
                    required value="${empleado.TELEFONO}">
                    </div>
                    <div class="mb-3">
                      <label class="control-label">RFC</label>
                      <input type="text" maxlength="13" name="rfc" placeholder="Ingresa el RFC" class="form-control" 
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
              var nombre = formEditarEmpleado.elements.nombre.value;
              var ap_paterno = formEditarEmpleado.elements.ap_paterno.value;
              var ap_materno = formEditarEmpleado.elements.ap_materno.value;
              var telefono = formEditarEmpleado.elements.telefono.value;
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
              updateXHR.send(`id=${idEmpleado}&rfc=${rfc}&tipoUsuario=${tipoUsuario}
              &nombre=${nombre}&ap_paterno=${ap_paterno}&ap_materno=${ap_materno}
              &telefono=${telefono}`);
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
                    <input type="text" class="form-control" name="nombre" id="nombreInput" required value="${datosUsuario.nombre}" readonly>
                </div>
                <div class="form-group">
                    <label for="ap_paternoInput">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="ap_paterno" id="ap_paternoInput" required value="${datosUsuario.ap_paterno}" readonly>
                </div>
                <div class="form-group">
                    <label for="ap_maternoInput">Apellido Materno:</label>
                    <input type="text" class="form-control" name="ap_materno" id="ap_maternoInput" required value="${datosUsuario.ap_materno}" readonly>
                </div>
                <div class="form-group">
                    <label for="telefonoInput">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" id="telefonoInput" required value="${datosUsuario.telefono}" pattern="[0-9a-zA-Z]" maxlength="10">
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
    
        var formEditarDatos = document.getElementById("formularioEditarDatos");
        var guardarCambiosBtn = document.getElementById("guardarCambios");
    
        guardarCambiosBtn.addEventListener("click", function () {
            var telefonoInput = document.getElementById("telefonoInput");
            var telefonoValue = telefonoInput.value.trim();
    
            if (!esNumero(telefonoValue)) {
              document.getElementById('mensajeDiv').innerHTML = `<div style="text-align:center;"class="alert alert-success">solo puedes ingresar valores numericos</div>`;
                telefonoInput.focus();
                return;
            }
    
            var updatePerfilXHR = new XMLHttpRequest();
            updatePerfilXHR.onreadystatechange = function () {if (updatePerfilXHR.readyState === XMLHttpRequest.DONE) {
                if (updatePerfilXHR.status === 200) {
                    console.log(updatePerfilXHR.responseText); 
                    try {
                        var respuesta = JSON.parse(updatePerfilXHR.responseText);
                        if (respuesta.success) {
                            document.getElementById('mensajeDiv').innerHTML = `<div style="text-align:center;"class="alert alert-success">Cambios guardados exitosamente<br>Tienes que volver a iniciar sesión</div>`;
                            datosUsuario = respuesta.usuario;
                            setTimeout(function () {
                                var logoutXHR = new XMLHttpRequest();
                                logoutXHR.onreadystatechange = function () {
                                    if (logoutXHR.readyState === XMLHttpRequest.DONE) {
                                        if (logoutXHR.status === 200) {
                                            window.location.href = "/index.html";
                                        } else {
                                            console.error("Error al cerrar sesión");
                                        }
                                    }
                                };
                                logoutXHR.open("GET", "logout.php", true);
                                logoutXHR.send();
                            }, 2500);
                        }else if (respuesta.error === 'badPass') {
                          document.getElementById('mensajeDiv').innerHTML = `<div class="alert alert-danger">Contraseña incorrecta, vuelve a ingresarla por favor</div>`;
                          
                          setTimeout(() => {
                              document.getElementById('mensajeDiv').innerHTML = '';
                          }, 1500); 
                      } else {
                          document.getElementById('mensajeDiv').innerHTML = `<div class="alert alert-danger">Contraseña incorrecta, vuelve a ingresarla por favor</div>`;
                          
                          setTimeout(() => {
                              document.getElementById('mensajeDiv').innerHTML = '';
                          }, 1500); 
                      }
                    } catch (error) {
                        console.error("Error al analizar la respuesta JSON: " + error.message);
                    }
                } else {
                    console.error("Error en la solicitud AJAX de actualización");
                }
              }   
            };
    
            var formData = new FormData(formEditarDatos);
            formData.append('tipo_cuenta', datosUsuario.tipo_cuenta);
    
            updatePerfilXHR.open("POST", "/php/viewsClientes/pruebaComprobación.php", true);
            updatePerfilXHR.send(formData);
        });
    
        function esNumero(valor) {
            return !isNaN(valor) && !isNaN(parseFloat(valor));
        }
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
                    <input maxlength="13" required oninput="this.value = this.value.toUpperCase()"
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
                      console.log(document.getElementById("mensajeDiv").innerHTML);
                      //Si el mensaje es de exito desactivar el boton de rechazar
                      if(document.getElementById("mensajeDiv").innerHTML === '<div class="alert alert-success">Empleado Registrado!</div>')
                      {
                        btnRechazarSolicitud.disabled = true;
                      }
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
                      //Desactivar los botones
                      btnAceptarSolicitud.disabled = true;
                      btnRechazarSolicitud.disabled = true;
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
        case "@cancelarEvento":
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

            formContent = `    <h4 align='center'>${detallesEvento.NOMBRE}</h4>
            <h5 align='center'>${detallesEvento.CLIENTE}</h5><br>
            <ul class="nav nav-pills nav-fill">
  <li class="nav-item">
    <a class="nav-link active tab-link" aria-current="page" href="#" id="detalles">Detalles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link tab-link" href="#" id="meserosRegistrados" >Meseros</a>
  </li>
  <li class="nav-item">
    <a class="nav-link tab-link" href="#" id="cocinaRegistrados">Cocineros</a>
  </li>
</ul>


<div id="detallesContenido">
<br>
<form>
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
    </form>

    </div></div>

  <div id="empleadosTable"><br></div>
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
                  '05:00','06:00','07:00','08:00', '09:00', '10:00', '11:00', '12:00', '13:00',
                  '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00','22:00' 
                ]
              });
            });

            var meserosRegistrados = document.getElementById('meserosRegistrados');
            meserosRegistrados.addEventListener('click', function() {
              detallesContenido.style.display = 'none';
              empleadosTable.style.display = 'block';
                $.ajax({
                  type: "GET",
                  url: `../viewsEventos/verEmpleadosRegistrados.php?id=${idEvento}&tipo=MESERO`,
                  success: function (response) {
                    $("#empleadosTable").html(response);
                  },
                  error: function () {
                    console.error(error);
                  },
                });
            });            
            
            var cocinaRegistrados = document.getElementById('cocinaRegistrados');
            cocinaRegistrados.addEventListener('click', function() {
              detallesContenido.style.display = 'none';
              empleadosTable.style.display = 'block';
                $.ajax({
                  type: "GET",
                  url: `../viewsEventos/verEmpleadosRegistrados.php?id=${idEvento}&tipo=COCINA`,
                  success: function (response) {
                    $("#empleadosTable").html(response);
                  },
                  error: function () {
                    console.error(error);
                  },
                });
            });

            var detalles = document.getElementById('detalles');
            detalles.addEventListener('click', function() {
              detallesContenido.style.display = 'block';
              empleadosTable.style.display = 'none';
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
              var meserosNecesarios;
              if (invitados === 10) {meserosNecesarios = 2;} 
              else {meserosNecesarios = Math.floor(invitados / 15);}
              
              if (!fecha || !salon || !comida) {
                alert('Por favor, llene los campos correctamente');
                return;
              }
              if (!invitados || isNaN(invitados) || parseInt(invitados) < 10) {
                alert('Por favor, llene los campos correctamente\nEl mínimo para invitados son 10');
                return;
              }
              

              var xhrGuardarCambios = new XMLHttpRequest();
              xhrGuardarCambios.onreadystatechange = function(response) {
                if (xhrGuardarCambios.readyState === XMLHttpRequest.DONE) {
                  var response = JSON.parse(xhrGuardarCambios.responseText);
                  if (xhrGuardarCambios.status === 200) {
                    if (response.success) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>Evento modificado exitosamente</div>`;
                      setTimeout(() => {
                        updateModalContent(formType, idEmpleado, idEvento);
                      }, 1000); // Actualizar el modal después de 2000 milisegundos (2 segundos)
                      filtrarEventos();
                      modalForm.innerHTML = formContent;
                    } else {
                      alert('Algo salió mal\nInténtelo de nuevo');
                      console.error("Error en el servidor:", response.message);
                    }
                  } else {
                    alert(response.message);
                    console.error("Error AJAX al guardar cambios en el evento. Código de estado:", xhrGuardarCambios.status);
                  }
                }
              };
              var urlEditarEvento = `../viewsEventos/editarDetalles.php?id=${idEvento}&F_EVENTO=${fecha}&INVITADOS=${invitados}&SALON=${salon}&COMIDA=${comida}&MESEROS=${meserosRequeridos}&COCINEROS=${cocinerosRequeridos}&meserosNecesarios=${meserosNecesarios}`;
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

        // Realizar la segunda solicitud AJAX para obtener los datos del empleado
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
        
        // Esperar a que el modal cargue
        setTimeout(function () {
          // Conseguir todos los botones para ver el historial
          var botonesHistorial = document.querySelectorAll('.btn-ver-historial');
          // Agregar el event listener a cada botón
          botonesHistorial.forEach(function (btn) {
            // Obtener el tipo de formulario correspondiente al botón
            var formType = btn.getAttribute("data-bs-whatever");
            var idEmpleado = btn.getAttribute("data-id");
            var idEvento = btn.getAttribute("data-event-id");

            // Agregar el event listener al botón
            btn.addEventListener("click", function () {
              // Código a ejecutar cuando se hace clic en el botón
              console.log("Se hizo clic en el botón");
              updateModalContent(formType, idEmpleado, idEvento);
            });
          });
        }, 700);
      } else {
        console.error("Error en la solicitud AJAX");
      }
    }
  };
  //console.log(idEmpleado);
  // Hacer la solicitud al script PHP y pasar el ID del empleado
  xhr.open("GET", "obtenerEmpleado.php?id=" + idEmpleado, true);
  xhr.send();
  break;
  case "@editarMenu":
    modalTitle.textContent = "Modificar menu";
    modalHeader.classList.remove('modal-header-warning');
    //Realizar una solicitud AJAX para obtener los datos del empleado
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          //Parsear la respuesta JSON
          var menu = JSON.parse(xhr.responseText);
          console.log(menu);
          //Actualizar el contenido del formulario con los datos obtenidos
          formContent = `
            <form id="formularioMenu">
              <div id="mensajeDiv" method="POST"></div> <!-- Div para mensajes de respuesta -->
              <div class="mb-3">
                <label class="control-label">Nombre: </label>
                <input type="text" name="nombre" placeholder="Nombre del menu" class="form-control" maxlength="45" required
                value='${menu.NOMBRE}'>
              </div>
              <div class="mb-3">
              <label class="control-label">Descripcion:</label>
              <textarea name="descripcion" placeholder="En que consiste el menu" class="form-control descripcion-input" rows="4" maxlength="500" required>
              ${menu.DESCRIPCION}
              </textarea>
              </div>
              <div class="mb-3">
              <div class="form-group mb-3">
                  <label for="tipoMenu">Tipo de menu:</label>
                  <select name="tipoMenu" class="form-control form-select">
                      <option value="1"${menu.TIPO === 'BEBIDAS' ? 'selected' : ''}>Bebidas</option>
                      <option value="2"${menu.TIPO === 'DESAYUNO' ? 'selected' : ''}>Desayuno</option>
                      <option value="3"${menu.TIPO === 'DESAYUNO BUFFET' ? 'selected' : ''}>Desayuno Buffet</option>
                      <option value="4"${menu.TIPO === 'COMIDA' ? 'selected' : ''}>Comida</option>
                      <option value="5"${menu.TIPO === 'COMIDA BUFFET' ? 'selected' : ''}>Comida Buffet</option>
                      <option value="6"${menu.TIPO === 'COFFEE BREAK' ? 'selected' : ''}>Coffee Break</option>
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
          var formEditarMenu = document.getElementById('formularioMenu');
          // Agregar evento de envío al formulario de edición
          formEditarMenu.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe por defecto

            // Obtener los valores del formulario
            var nombre = formEditarMenu.elements.nombre.value;
            var descripcion = formEditarMenu.elements.descripcion.value;
            var tipoMenu = formEditarMenu.elements.tipoMenu.value;

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
            updateXHR.open("POST", "/php/viewsMenus/editarMenu.php", true);
            updateXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            updateXHR.send(`id=${idEmpleado}&tipoMenu=${tipoMenu}
            &nombre=${nombre}&descripcion=${descripcion}`);
            //Ver cual es la tabla activa para refrescar cualquier cambio
            checkCurrentTable(currentTable);
          });
        } else {
          console.error("Error en la solicitud AJAX");
        }
      }
    };
    //Hacer la solicitud al script PHP y pasar el ID del empleado
    xhr.open("GET", "/php/viewsMenus/obtenerMenu.php?id=" + idEmpleado, true);
    xhr.send();
    //Ver cual es la tabla activa para refrescar cualquier cambio
    checkCurrentTable(currentTable);
    break;
    case "@descontinuarMenu":
    modalTitle.textContent = "Descontinuar menu";
    //Realizar una solicitud AJAX para obtener los datos del menu
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          //Parsear la respuesta JSON
          var menu = JSON.parse(xhr.responseText);
          console.log(menu);
          //Actualizar el contenido del formulario con los datos obtenidos
          formContent = `
            <form id="formularioMenu">
              <div id="mensajeDiv" method="POST"></div> <!-- Div para mensajes de respuesta -->
              <div class="mb-3">
                <h5>Nombre del menú: </h5>
                <h6 class="mb-3">${menu.NOMBRE}</h6>
              </div>
              <div class="mb-3">
                <h5>Descripción: </h5>
                <h6 class="mb-3">${menu.DESCRIPCION}</h6>
              </div>
              <div class="mb-3">
              <div class="form-group mb-3">
                <h5>Tipo de menú: </h5>
                <h6 class="mb-3">${menu.TIPO}</h6>
              </div>
              <div class="d-flex justify-content-center">
                  <button id="btnDescMenu" type="submit" class="btn btn-primary btn-modal-warning me-2"><i class="fa-solid fa-circle-minus me-2" style="color: #ffffff;"></i>Descontinuar</button>
                  <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
              `;
          // Asignar el contenido al formulario del modal
          modalForm.innerHTML = formContent;
          
          // Obtener el formulario después de haberlo asignado al DOM
          var formEditarMenu = document.getElementById('formularioMenu');
          var btnDescMenu = document.getElementById('btnDescMenu');
          // Agregar evento de envío al formulario de edición
          formEditarMenu.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe por defecto
            
            //El id de la tupla es la variable idEmpleado
            // Realizar una solicitud AJAX para descontinuar el menú
            var xhrDescontinuar = new XMLHttpRequest();
            xhrDescontinuar.onreadystatechange = function () {
              if (xhrDescontinuar.readyState === XMLHttpRequest.DONE) {
                if (xhrDescontinuar.status === 200) {
                  // Actualizar el mensaje de respuesta en el formulario
                  var mensajeDiv = document.getElementById('mensajeDiv');
                  mensajeDiv.innerHTML = xhrDescontinuar.responseText;
                  if(xhrDescontinuar.responseText == "<div class='alert alert-success'>Menú descontinuado con exito!</div>")
                  {
                    //Desactivar el boton de descontinuar 
                    btnDescMenu.disabled = true;
                  }
                } else {
                  console.error("Error en la solicitud AJAX para descontinuar el menú");
                }
              }
            };
            console.log(idEmpleado);
            // Hacer la solicitud al script PHP para descontinuar el menú y pasar el ID del menú
            xhrDescontinuar.open("POST", "/php/viewsMenus/descontinuarMenu.php", true);
            xhrDescontinuar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            var parametros = "id=" + encodeURIComponent(idEmpleado);
            xhrDescontinuar.send(parametros);
          });
        } else {
          console.error("Error en la solicitud AJAX");
        }
      }
    };
    //Hacer la solicitud al script PHP y pasar el ID del empleado
    xhr.open("GET", "/php/viewsMenus/obtenerMenu.php?id=" + idEmpleado, true);
    console.log(idEmpleado);
    xhr.send();
    //Ver cual es la tabla activa para refrescar cualquier cambio
    checkCurrentTable(currentTable);
    break;
    case "@reincorporarMenu":
    modalTitle.textContent = "Re-Incorporar Menú";
    //Realizar una solicitud AJAX para obtener los datos del menu
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          //Parsear la respuesta JSON
          var menu = JSON.parse(xhr.responseText);
          console.log(menu);
          //Actualizar el contenido del formulario con los datos obtenidos
          formContent = `
            <form id="formularioMenu">
              <div id="mensajeDiv" method="POST"></div> <!-- Div para mensajes de respuesta -->
              <div class="mb-3">
                <h5>Nombre del menú: </h5>
                <h6 class="mb-3">${menu.NOMBRE}</h6>
              </div>
              <div class="mb-3">
                <h5>Descripción: </h5>
                <h6 class="mb-3">${menu.DESCRIPCION}</h6>
              </div>
              <div class="mb-3">
              <div class="form-group mb-3">
                  <label for="tipoMenu">Tipo de menu:</label>
                  <select id="tipoMenuSelect" name="tipoMenu" class="form-control form-select">
                      <option value="1"${menu.TIPO === 'BEBIDAS' ? 'selected' : ''}>Bebidas</option>
                      <option value="2"${menu.TIPO === 'DESAYUNO' ? 'selected' : ''}>Desayuno</option>
                      <option value="3"${menu.TIPO === 'DESAYUNO BUFFET' ? 'selected' : ''}>Desayuno Buffet</option>
                      <option value="4"${menu.TIPO === 'COMIDA' ? 'selected' : ''}>Comida</option>
                      <option value="5"${menu.TIPO === 'COMIDA BUFFET' ? 'selected' : ''}>Comida Buffet</option>
                      <option value="6"${menu.TIPO === 'COFFEE BREAK' ? 'selected' : ''}>Coffee Break</option>
                  </select>
              </div>
              <div class="d-flex justify-content-center">
                  <button id="btnDescMenu" type="submit" class="btn btn-primary btn-modal me-2"><i class="fa-solid fa-rotate-left me-2" style="color: #ffffff;"></i>Re-Incorporar</button>
                  <button type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
              `;
          // Asignar el contenido al formulario del modal
          modalForm.innerHTML = formContent;
          
          // Obtener el formulario después de haberlo asignado al DOM
          var formEditarMenu = document.getElementById('formularioMenu');
          var btnReincorporar = document.getElementById('btnDescMenu');

          // Agregar evento de envío al formulario de edición
          formEditarMenu.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe por defecto
            // Obtén el valor seleccionado del tipo de menú
            var tipoMenuSelect = document.getElementById("tipoMenuSelect");
            var tipoMenuSeleccionado = tipoMenuSelect.value;
            //El id de la tupla es la variable idEmpleado
            // Realizar una solicitud AJAX para descontinuar el menú
            var xhrReIncorporarMenu = new XMLHttpRequest();
            xhrReIncorporarMenu .onreadystatechange = function () {
              if (xhrReIncorporarMenu.readyState === XMLHttpRequest.DONE) {
                if (xhrReIncorporarMenu.status === 200) {
                  // Actualizar el mensaje de respuesta en el formulario
                  var mensajeDiv = document.getElementById('mensajeDiv');
                  mensajeDiv.innerHTML = xhrReIncorporarMenu .responseText;
                  //Desactivar boton en respuesta exitosa
                  if(xhrReIncorporarMenu.responseText == "<div class='alert alert-success'>Menú re-incorporado con exito</div>")
                  {
                    btnReincorporar.disabled = true;
                  }
                } else {
                  console.error("Error en la solicitud AJAX para descontinuar el menú");
                }
              }
            };
            console.log(idEmpleado);
            // Hacer la solicitud al script PHP para re-incorporar el menú y pasar el ID del menú
            xhrReIncorporarMenu.open("POST", "/php/viewsMenus/re-incorporarMenu.php", true);
            xhrReIncorporarMenu.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            var parametros = "id=" + encodeURIComponent(idEmpleado) 
            + "&tipoMenu=" + encodeURIComponent(tipoMenuSeleccionado);
            xhrReIncorporarMenu.send(parametros);
          });
        } else {
          console.error("Error en la solicitud AJAX");
        }
      }
    };
    //Hacer la solicitud al script PHP y pasar el ID del empleado
    xhr.open("GET", "/php/viewsMenus/obtenerMenu.php?id=" + idEmpleado, true);
    console.log(idEmpleado);
    xhr.send();
    //Ver cual es la tabla activa para refrescar cualquier cambio
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
