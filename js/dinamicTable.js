//Variable para saber que tabla esta activa
var currentTable;

// Conseguir los elementos para las vitas de empleados
document.addEventListener('DOMContentLoaded', function() {
  var buttons = document.querySelectorAll('.ver-empleados');
  var tableInfo = document.getElementById('table-info');
  var contTable = document.querySelector('.cont-table');
  var loadingSpinner = document.getElementById('loadingSpinner');

  var busquedaInput = document.getElementById('busqueda');
  // Agregar el evento de click a los botones
  buttons.forEach(function(button) {
    button.addEventListener('click', function() {
      var url = this.getAttribute('data-url');
      var buttonId = this.getAttribute('id');
      contTable.style.display = 'none';
      tableInfo.innerHTML = '';

      if (buttonId === 'buscarEmpleado') {
        var busquedaValor = busquedaInput.value.trim(); // Obtener el valor de la barra de búsqueda y eliminar los espacios en blanco al inicio y al final

        if (busquedaValor === '') {
          loadingSpinner.style.display = 'block';
          ('La barra de búsqueda está vacía. Por favor, ingrese un correo o nombre');
          return; // Detener la ejecución si la barra de búsqueda está vacía
        }
        // Realizar la búsqueda con el valor ingresado en la barra de búsqueda
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var message = getMessageByButtonId(buttonId);
            tableInfo.innerHTML = message; // Modificar el innerHTML en lugar de textContent
            contTable.innerHTML = xhr.responseText;
            contTable.style.display = 'block';

            loadingSpinner.style.display = 'none';
            // Limpiar la barra de búsqueda después de una búsqueda exitosa
            //Bug donde al querer eliminar o editar el warning salia por que la barra estaba vacia
            //busquedaInput.value = '';
          }
        };
        xhr.open('GET', "buscarEmpleado.php?busqueda=" + busquedaValor, true);
        xhr.send();
      } else {
        if(buttonId == "verGraficos")
        { 
          loadingSpinner.style.display = 'block';
          //Re-insertar el grafico
          contTable.innerHTML = `
          <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                      <div class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                          <i class="fa-solid fa-business-time" style="color: #ffffff;"></i>
                              Solicitudes Pendientes: 
                        </h3>
                        <h2 id="solicitudesCard"></h2>
                      </div>
                        <div class="col-md-12">
                            <canvas id="proporcionEmpleados2" style="height: 200px;"></canvas>
                        </div>
                    </div>
                    <div class="info-card col-md-7">
                      <canvas id="participacionEmpleados"></canvas>
                    </div>
                </div>
            </div>
          `;
          //Volver a ejecutar el codigo de la grafica para actualizar datos:
          recargarGraficos(); //Llamado desde chart.js
          // Manejar el redimensionamiento del canvas
          const canvas = document.getElementById("proporcionEmpleados2");
          if (canvas) {
            const context = canvas.getContext("2d");
            context.canvas.width = canvas.offsetWidth;
            context.canvas.height = canvas.offsetHeight;
          }
          tableInfo.innerHTML = '';
        }else{
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var message = getMessageByButtonId(buttonId);
              tableInfo.innerHTML = message; // Modificar el innerHTML en lugar de textContent
              contTable.innerHTML = xhr.responseText;
              contTable.style.display = 'block';

              loadingSpinner.style.display = 'none';
            }
          };
          xhr.open('GET', url, true);
          xhr.send();
        }
      }
    });
  });
});



//Funcion para las vistas de menus
document.addEventListener('DOMContentLoaded', function() {
  var buttons = document.querySelectorAll('.ver-menus');
  var tableInfo = document.getElementById('table-info-menus');
  var contTable = document.getElementById('cont-table-menus');

  var busquedaInput = document.getElementById('busqueda');
  // Agregar el evento de click a los botones
  buttons.forEach(function(button) {
    button.addEventListener('click', function() {
      var url = '/php/viewsMenus/verMenus.php';
      var buttonId = this.getAttribute('id');
      var vista = this.getAttribute('data-vista');

      if (buttonId === 'buscarEmpleado') {
        var busquedaValor = busquedaInput.value.trim(); // Obtener el valor de la barra de búsqueda y eliminar los espacios en blanco al inicio y al final

        if (busquedaValor === '') {
          ('La barra de búsqueda está vacía. Por favor, ingrese un correo o nombre');
          return; // Detener la ejecución si la barra de búsqueda está vacía
        }
        // Realizar la búsqueda con el valor ingresado en la barra de búsqueda
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var message = getMessageByButtonId(buttonId);
            tableInfo.innerHTML = message; // Modificar el innerHTML en lugar de textContent
            contTable.innerHTML = xhr.responseText;
            // Limpiar la barra de búsqueda después de una búsqueda exitosa
            //Bug donde al querer eliminar o editar el warning salia por que la barra estaba vacia
            //busquedaInput.value = '';
          }
        };
        xhr.open('GET', "buscarEmpleado.php?busqueda=" + busquedaValor, true);
        xhr.send();
      } else {
        if(buttonId == "verGraficosMenus")
        { 
          contTable.innerHTML = '';
          tableInfo.innerHTML = '';
          //Re-insertar el grafico
          contTable.innerHTML = `
          <div id="cont-table-menus">
          <!--Contenido Default-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Contenido de la izquierda -->
                    <div class="col-md-5 pieMenus">
                        <canvas id="pieTipoMenus" style="height: 60%; width: 100%; margin-right: 0px !important;"></canvas>
                    </div>
                    <!-- Canvas a la derecha -->
                    <div class="info-card col-md-7" style="margin-right: 0px !important;">
                        <canvas id="menuChart2" style="height: 70%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
          </div>
          `;
          //Volver a ejecutar el codigo de la grafica para actualizar datos:
          recargarGraficos(); //Llamado desde chart.js
          // Manejar el redimensionamiento del canvas
          const canvas = document.getElementById("proporcionEmpleados2");
          if (canvas) {
            const context = canvas.getContext("2d");
            context.canvas.width = canvas.offsetWidth;
            context.canvas.height = canvas.offsetHeight;
          }
          tableInfo.innerHTML = '';
        }else{
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var message = getMessageByButtonId(buttonId);
              tableInfo.innerHTML = message; // Modificar el innerHTML en lugar de textContent
              contTable.innerHTML = xhr.responseText;
            }
          };
          xhr.open('GET', url + '?vista=' + vista, true);
          xhr.send();
        }
      }
    });
  });
});


//Cambiar el mensaje de información
function getMessageByButtonId(buttonId) {
  switch (buttonId) {
    case 'verCocineros':
      currentTable = 'cocineros';
      return 'Mostrando a los cocineros: <i class="fas fa-utensils" style="color: #343434;"></i>'; 
    case 'verMeseros':
      currentTable = 'meseros';
      return 'Mostrando a los meseros: <i class="fa-solid fa-bell-concierge" style="color: #343434;"></i>';
    case 'buscarEmpleado':
      currentTable = 'busqueda';
      return 'Resultados de búsqueda: <i class="fa-solid fa-magnifying-glass" style="color: #343434;"></i>';
    case 'verSolicitudes':
      currentTable = 'solicitud';
      return 'Éstas son tus solicitudes pendientes: <i class="fa-solid fa-business-time" style="color: #343434;"></i>';
    case 'verBebidas':
      currentTable = 'bebidas';
      return 'Menús del tipo bebidas: <i class="fa-solid fa-wine-glass" style="color: #343434;"></i>';
    case 'verDesayuno':
      currentTable = 'desayuno';
      return 'Menús del tipo desayuno: <i class="fa-solid fa-egg" style="color: #343434;"></i>';  
    case 'verDesBuffet':
      currentTable = 'desBuffet';
      return 'Menús del tipo desayuno buffet: <i class="fa-solid fa-bacon" style="color: #343434;"></i>';
    case 'verComida':
      currentTable = 'comida';
      return 'Menús del tipo comida: <i class="fa-solid fa-burger" style="color: #343434;"></i>';
    case 'verComidaBuffet':
      currentTable = 'comidaBuffet';
      return 'Menús del tipo comida buffet: <i class="fa-solid fa-drumstick-bite" style="color: #343434;"></i>';
    case 'verCoffee':
      currentTable = 'coffee';
      return 'Menús del tipo coffee break: <i class="fa-solid fa-mug-saucer" style="color: #343434;"></i>';
    case 'verDescontinuado':
      currentTable = 'descontinuado';
      return 'Menús que han sido descontinuados: <i class="fa-solid fa-circle-minus" style="color: #343434;"></i>';
    default:
      return 'Mostrando información:';
  }
}


  

  