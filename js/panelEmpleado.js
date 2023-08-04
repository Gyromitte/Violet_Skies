/*Funcionamiento de la dashboard*/

const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');



function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open')
}

toggleDashboardBtn.addEventListener('click', toggleDashboard);
document.addEventListener('click', function (event) {
  const targetElement = event.target;
  if (!targetElement.closest('#dash-board') && !targetElement.closest('#nav-button')) {
    dashboard.classList.remove('dashboard-open');
    main.classList.remove('main-dash-open');
  }
});

/*Main content*/
var tabs = document.querySelectorAll('.dash-button');
var tabContents = document.querySelectorAll('.tab-content');

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
var modal = document.getElementById("empModal");
var modalForm = document.getElementById("modal-form");

modal.addEventListener("show.bs.modal", function (event) {
    var button = event.relatedTarget;
  
    
    var formType = button.getAttribute("data-bs-whatever");
    var idEvento = button.getAttribute("data-id");

    
    updateModalContent(formType, idEvento);
  });
  
  // Función para actualizar el contenido del modal según el tipo de formulario
  function updateModalContent(formType, idEvento) {
    var formContent = "";
    var modalTitle = document.querySelector('#empModal .modal-title');
    //Conseguir el modal header para cambiarle el color
    var modalHeader = document.querySelector('.modal-header');
  
    switch (formType) {
      case "@asist":
        modalTitle.textContent = "Trabajar en este evento?";
        modalHeader.classList.remove('modal-header-warning');
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parsear la respuesta JSON
              var evento = JSON.parse(xhr.responseText);
              // Actualizar el contenido del formulario con los datos obtenido
              formContent = `
                <form>
                  <div id="mensajeDiv" method="POST"></div> 
                  <div>
                    <div class="d-flex justify-content-center">
                      <h4>
                      ${evento.NOMBRE}
                      </h4>
                      <br>
                      <h6>
                      Fecha de evento: ${evento.F_EVENTO}
                      </h6>
                      </div>
                      <br>
                    <div class="d-flex justify-content-center">
                      <button type="submit" id="asist" class="btn btn-primary btn-modal-warning me-2">
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
              var asistir = document.getElementById("asist");

              asistir.addEventListener("click", function (event) {
                event.preventDefault();  
      
                var xhrAceptar = new XMLHttpRequest();
                xhrAceptar.onreadystatechange = function () {
                  if (xhrAceptar.readyState === XMLHttpRequest.DONE) {
                    if (xhrAceptar.status === 200) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>Evento aceptado</div>`;

                    } 
                    else {
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
      
                xhrAceptar.open("POST", "../viewsEmpleados/asistirEvento.php", true);
                xhrAceptar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              });
            }
            else {
              console.error("Error en la solicitud AJAX");
            }
          }
        };

        xhr.open("GET", "../viewsEventos/obtenerEvento.php?id=" + idEvento, true);
        xhr.send();
        //Ver cual es la tabla activa para refrescar cualquier cambio
      break;
      
      case "@cancelar":
        modalTitle.textContent = "No asistir este evento?";
        modalHeader.classList.remove('modal-header-warning');
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parsear la respuesta JSON
              var evento = JSON.parse(xhr.responseText);
              // Actualizar el contenido del formulario con los datos obtenido
              formContent = `
                <form>
                  <div id="mensajeDiv" method="POST"></div> 
                  <div>
                    <div class="d-flex justify-content-center">
                      <h4>
                      ${evento.NOMBRE}
                      </h4>
                      <br>
                      <h6>
                      Fecha de evento: ${evento.F_EVENTO}
                      </h6>
                      </div>
                      <br>
                    <div class="d-flex justify-content-center">
                      <button type="submit" id="asist" class="btn btn-primary btn-modal-warning me-2">
                        <i class="fa-solid fa-user me-2" style="color: #ffffff;">
                            Cancelar Asistencia
                        </i>
                      </button>
                      <br>
                    </div>
                  </div>
                </form>
              `;
              modalForm.innerHTML = formContent;
              var asistir = document.getElementById("asist");

              asistir.addEventListener("click", function (event) {
                event.preventDefault();  
      
                var xhrAceptar = new XMLHttpRequest();
                xhrAceptar.onreadystatechange = function () {
                  if (xhrAceptar.readyState === XMLHttpRequest.DONE) {
                    if (xhrAceptar.status === 200) {
                      formContent += `<br><div class="alert alert-success" role="alert" align='center'>Evento aceptado</div>`;

                    } 
                    else {
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
      
                xhrAceptar.open("POST", "../viewsEmpleados/asistirEvento.php", true);
                xhrAceptar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              });
            }
            else {
              console.error("Error en la solicitud AJAX");
            }
          }
        };

        xhr.open("GET", "../viewsEventos/obtenerEvento.php?id=" + idEvento, true);
        xhr.send();

        break;
    };
    modalForm.innerHTML = formContent;
  }

  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Add a click event listener to the paragraph

