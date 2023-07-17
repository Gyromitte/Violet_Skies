/* Dinamic tables */
// Conseguir los elementos
document.addEventListener('DOMContentLoaded', function() {
  var buttons = document.querySelectorAll('.ver-empleados');
  var tableInfo = document.getElementById('table-info');
  var contTable = document.querySelector('.cont-table');

  var busquedaInput = document.getElementById('busqueda');
  // Agregar el evento de click a los botones
  buttons.forEach(function(button) {
      button.addEventListener('click', function() {
          var url = this.getAttribute('data-url');
          var buttonId = this.getAttribute('id');

          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  var message = getMessageByButtonId(buttonId);
                  tableInfo.textContent = message;
                  contTable.innerHTML = xhr.responseText;
              }
          };
          //Si la peticion es de busqueda de empleado se necesita pasar que es lo que busco el usuario
          if(buttonId == 'buscarEmpleado')
          {
            //Conseguir lo que el usuario ingreso
            busquedaValor = busquedaInput.value;
            xhr.open('GET', "buscarEmpleado.php?busqueda=" + busquedaValor, true);
            xhr.send();
          }else{
            xhr.open('GET', url, true);
            xhr.send();
          }

      });
  });
});

//Cambiar el mensaje de informacion
function getMessageByButtonId(buttonId) {
  switch (buttonId) {
      case 'verCocineros':
          return 'Mostrando a los cocineros:';
      case 'verMeseros':
          return 'Mostrando a los meseros:';
      case 'buscarEmpleado':
        return 'Se encontro: ';
      default:
          return 'Mostrando información:';
  }
}

  