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
var modal = document.getElementById("empModal");
var modalForm = document.getElementById("modal-form");

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
    var modalTitle = document.querySelector('#empModal .modal-title');
    var form;
    //Conseguir el modal header para cambiarle el color
    var modalHeader = document.querySelector('.modal-header');
  
    switch (formType) {
      case "@ponerte":
        modalTitle.textContent = "Trabajar en este evento?";
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
    }
  }