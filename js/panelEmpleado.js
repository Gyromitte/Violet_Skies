/*Funcionamiento de la dashboard*/

const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');
var currentTable = "";

// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open')
}
// Asignar evento de clic al botón
toggleDashboardBtn.addEventListener('click', toggleDashboard);
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

function checkCurrentTable(currentTable) {
  switch (currentTable) { //Simular un click para refrescar los cambios
    case 'pend':
      setTimeout(function() {
        btnPend.click();
      }, 500);
      break;
    case 'fin':
      setTimeout(function() {
        btnFin.click();
      }, 500);
      break;
  }
}
//Obtener botones para refrescar vistas
var btnPend = document.getElementById('verPend');
var btnFin = document.getElementById('verFin');

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
    updateModalContent(formType, idEvento);
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
        modalHeader.classList.add('modal-header-warning');
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parsear la respuesta JSON
              var evento = JSON.parse(xhr.responseText);
              // Actualizar el contenido del formulario con los datos obtenido
              formContent = `
                <form onsubmit="return asistirEvento(${idEvento})">
                  <div id="mensajeDiv" method="POST"></div> 
                    <div class="d-flex justify-content-center">
                      <h4>
                        ${evento.NOMBRE}
                      </h4>
                      <br>
                      <button type="submit" class="btn btn-primary btn-modal-warning me-2">
                        <i class="fa-solid fa-user me-2" style="color: #ffffff;">
                            Asistir
                        </i>
                      </button>
                      <br>
                    </div>
                  </div>
                </form>
              `;
              modalForm.innerHTML = formContent;
            }
            else {
              console.error("Error en la solicitud AJAX");
            }
          }
        };
        xhr.open("GET", "obtenerEvento.php?id=" + idEvento, true);
        xhr.send();
        //Ver cual es la tabla activa para refrescar cualquier cambio
        checkCurrentTable(currentTable);
      break;
    };
  }