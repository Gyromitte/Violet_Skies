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
    var idEvento = button.getAttribute("data-id");
    // Actualizar el contenido del formulario
    updateModalContent(formType, idEmpleado);
  });
  
  // Función para actualizar el contenido del modal según el tipo de formulario
  function updateModalContent(formType, idEvento) {
    var formContent = "";
    var modalTitle = document.querySelector('#empModal .modal-title');
    var form;
    //Conseguir el modal header para cambiarle el color
    var modalHeader = document.querySelector('.modal-header');
  
    switch (formType) {
      case "@ponerte":
        modalTitle.textContent = "Trabajar en este evento?";
        modalHeader.classList.add('modal-header');
        // Obtener los datos del empleado con una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parsear la respuesta JSON
              // Actualizar el contenido del formulario con los datos obtenidos
              formContent = `
                  <form id="enterEvent">
                    <div id="mensajeDiv" method="POST"></div> 
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary btn-modal-warning me-2">
                        <i class="fa-solid fa-user-slash me-2" style="color: #ffffff;">
                          Asistir
                        </i>
                      </button>
                    </div>
                    </div>
                  </form>
                `;
              // Asignar el contenido al formulario del modal
              modalForm.innerHTML = formContent;

              //Obtener el formulario después de haberlo asignado al DOM
              form = document.querySelector('#enterEvent');

              //Agregar evento de envio al formulario
              form.addEventListener('submit', function (event) {
                event.preventDefault(); //Para que la pagina no de refresh al dar submit

                var updateXHR = new XMLHttpRequest();
                updateXHR.onreadystatechange = function () {
                  if (updateXHR.readyState === XMLHttpRequest.DONE) {
                    if (updateXHR.status === 200) {
                      // Estilos al div de mensajes según la respuesta
                      var respuesta = updateXHR.responseText;
                      document.getElementById('mensajeDiv').innerHTML = respuesta;
                    } 
                    else {
                      console.error("Error en la solicitud AJAX de actualización");
                    }
                  }
                };

                updateXHR.open("POST", "asistirEvento.php", true);
                updateXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                updateXHR.send(`id=${idEvento}`);
                //Ver cual es la tabla activa para refrescar cualquier cambio
                checkCurrentTable(currentTable);
              });
            }}}
            break;
          }
  }