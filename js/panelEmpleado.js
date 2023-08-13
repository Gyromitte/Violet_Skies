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
    case 'soli':
      setTimeout(function() {
        btnSol.click();
      }, 500);
      break;
  }
}
//Obtener botones para refrescar vistas
var btnPend = document.getElementById('verPend');
var btnSol = document.getElementById('verSolic');
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
                        </i>
                        Asistir
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
                      document.getElementById("mensajeDiv").innerHTML = xhrAceptar.responseText;
                      VerDisp();
                      checkCurrentTable('pend');
                      checkCurrentTable('soli');

                    } 
                    else {
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
                var data = "eventoId=" + encodeURIComponent(idEvento);
      
                xhrAceptar.open("POST", "../viewsEmpleados/asistirEvento.php", true);
                xhrAceptar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhrAceptar.send(data);
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
                  <button type="submit" id="cancelar" class="btn btn-primary btn-modal-warning me-2">
                    <i class="fa-solid fa-user me-2" style="color: #ffffff;">
                    </i>
                    Cancelar Asistencia
                  </button>
                  <br>
                </div>
              </div>
            </form>
              `;
              modalForm.innerHTML = formContent;
              var cancel = document.getElementById("cancelar");

              cancel.addEventListener("click", function (event) {
                event.preventDefault();  
      
                
      
                var xhrCan = new XMLHttpRequest();
                xhrCan.onreadystatechange = function () {
                  if (xhrCan.readyState === XMLHttpRequest.DONE) {
                    if (xhrCan.status === 200) {
                      document.getElementById("mensajeDiv").innerHTML = xhrCan.responseText;
                      checkCurrentTable(currentTable);
                      VerDisp();
                      
                    } 
                    else {
                      checkCurrentTable(currentTable);
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
                var data = "eventoId=" + encodeURIComponent(idEvento);
      
                xhrCan.open("POST", "../viewsEmpleados/cancelarAsist.php", true);
                xhrCan.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhrCan.send(data);
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
        case "@cancelarASIST":
        modalTitle.textContent = "Cancelar solicitud de asistencia a este evento?";
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
                  <button type="submit" id="cancelar" class="btn btn-primary btn-modal-warning me-2">
                    <i class="fa-solid fa-user me-2" style="color: #ffffff;">
                    </i>
                    Cancelar Solicitud
                  </button>
                  <br>
                </div>
              </div>
            </form>
              `;
              modalForm.innerHTML = formContent;
              var cancel = document.getElementById("cancelar");

              cancel.addEventListener("click", function (event) {
                event.preventDefault();  
      
                
      
                var xhrCan = new XMLHttpRequest();
                xhrCan.onreadystatechange = function () {
                  if (xhrCan.readyState === XMLHttpRequest.DONE) {
                    if (xhrCan.status === 200) {
                      document.getElementById("mensajeDiv").innerHTML = xhrCan.responseText;
                      checkCurrentTable(currentTable);
                      VerDisp();
                    } 
                    else {
                      checkCurrentTable(currentTable);
                      console.error("Error en la solicitud AJAX de Aceptar");
                    }
                  }
                };
                var data = "eventoId=" + encodeURIComponent(idEvento);
      
                xhrCan.open("POST", "../viewsEmpleados/cancelarSolic.php", true);
                xhrCan.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhrCan.send(data);
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
    checkCurrentTable(currentTable);
  }
  function updateTable() {
    // Fetch updated table content using AJAX and replace the existing table content
    var xhrTable = new XMLHttpRequest();
    xhrTable.onreadystatechange = function() {
      if (xhrTable.readyState === XMLHttpRequest.DONE) {
        if (xhrTable.status === 200) {
          var updatedTableContent = xhrTable.responseText;
          // Replace the table content with the updated content
          document.getElementById("yourTableId").innerHTML = updatedTableContent;
        } else {
          console.error("Error updating table content");
        }
      }
    };
  
    // Send a GET request to fetch updated table content
    xhrTable.open("GET", "your_table_update_script.php", true);
    xhrTable.send();
  }
// Add a click event listener to the paragraph

