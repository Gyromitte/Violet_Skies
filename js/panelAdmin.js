/*Funcionamiento de la dashboard*/
// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');
// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open')
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
  tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
      var tabId = this.getAttribute('data-tab');

      tabs.forEach(function(tab) {
        tab.classList.remove('active');
      });
      tabContents.forEach(function(content) {
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

// Evento para los botones
modal.addEventListener("show.bs.modal", function(event) {
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

  switch (formType) {
    case "@registrarEmpleado":
      modalTitle.textContent = "Registrar un Empleado";
      formContent = `
        <form action="/php/viewsEmpleados/guardarEmpleado.php" method="POST">
          <div class="mb-3">
            <label class="control-label">RFC</label>
            <input type="text" name="rfc" placeholder="Ingresa el RFC" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="control-label">E-mail</label>
            <input type="email" name="correo" placeholder="Ingresa el E-mail" class="form-control" required>
          </div>
          <div class="form-group mb-3">
            <label for="tipoUsuario">Tipo de Trabajador</label>
            <select name="tipoUsuario" class="form-control form-select" id="tipoUsuario">
              <option value="mesero">Mesero</option>
              <option value="cocina">Cocinero</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-modal">Registrar</button>
          <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">Cancelar</button>
        </form>
      `;
      break;
    case "@eliminarEmpleado":
      modalTitle.textContent = "Eliminar a un Empleado";
      formContent = "<h5>CUIDADO! Esta acción no es reversible</h5>";
      break;
    case "@editarEmpleado":
      modalTitle.textContent = "Modificar datos";
      //Realizar una solicitud AJAX para obtener los datos del empleado
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            //Parsear la respuesta JSON
            var empleado = JSON.parse(xhr.responseText);
            console.log(empleado);
            //Actualizar el contenido del formulario con los datos obtenidos
            formContent = `
              <form>
                <h5>Empleado: </h5>
                <h6 class="mb-3">${empleado.NOMBRE} ${empleado.AP_PATERNO} ${empleado.AP_MATERNO}</h6>
                <h5>Telefono: </h5>
                <h6 class="mb-3">${empleado.TELEFONO}</h6>
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
                <button type="submit" class="btn btn-primary btn-modal">Modificar</button>
                <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">Cancelar</button>
              </form>
            `;
            // Asignar el contenido al formulario del modal
            modalForm.innerHTML = formContent;
          } else {
            console.error("Error en la solicitud AJAX");
          }
        }
      };
      //Hacer la solicitud al script PHP y pasar el ID del empleado
      xhr.open("GET", "obtenerEmpleado.php?id=" + idEmpleado, true);
      console.log(idEmpleado);
      xhr.send();
      break;
  }
  // Asignar el contenido al formulario del modal
  modalForm.innerHTML = formContent;
}