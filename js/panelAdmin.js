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
//Obtener modal y form
var modal = document.getElementById("mainModal");
var modalForm = document.getElementById("modal-form");

//Evento para los botones
modal.addEventListener("show.bs.modal", function(event) {
  //Boton que activo el modal
  var button = event.relatedTarget;
  
  //Obtener el form correspondiente al boton
  var formType = button.getAttribute("data-bs-whatever");

  //Actualizar el contenido del form
  updateModalContent(formType);
});

//Funcion para actualizar el contenido del modal segun el boton correspondiente
function updateModalContent(formType) {
  var formContent = "";
  var modalTitle = document.querySelector('#mainModal .modal-title');
  switch(formType)
  {
    case "@registrarEmpleado":
      modalTitle.textContent = "Registrar un Empleado";
      formContent = `
      <form action="/php/views/guardarEmpleado.php" method="POST">
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
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </form>
      `;
    break;
    case "@eliminarEmpleado":
      modalTitle.textContent = "Eliminar a un Empleado"
      formContent =
      "<h3>CUIDADO! Esta accion no es reversible</h3>"
    break;
  }

  // Actualiza el contenido del formulario en el modal
  modalForm.innerHTML = formContent;
}

  
