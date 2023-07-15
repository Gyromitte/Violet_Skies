/* Dinamic tables */
// Conseguir los elementos
document.addEventListener('DOMContentLoaded', function() {
  var buttons = document.querySelectorAll('.ver-empleados');
  var tableInfo = document.getElementById('table-info');
  var contTable = document.querySelector('.cont-table');
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
          xhr.open('GET', url, true);
          xhr.send();
      });
  });
});

function getMessageByButtonId(buttonId) {
  switch (buttonId) {
      case 'verCocineros':
          return 'Mostrando a los cocineros:';
      case 'verMeseros':
          return 'Mostrando a los meseros:';
      default:
          return 'Mostrando información:';
  }
}

  