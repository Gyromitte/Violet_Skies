/*Dinamic tables*/
/*Mostrar Cocineros*/
document.addEventListener('DOMContentLoaded', function() {
    /*Boton que llamara la tabla*/
    var buttonCocineros = document.getElementById('verCocineros');
    /*Container odnde se generara la tabla*/
    var contTable = document.querySelector('.cont-table');
    /*Titulo o informacion de la tabla*/
    var tableInfo = document.getElementById('table-info');
    buttonCocineros.addEventListener('click', function() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            tableInfo.textContent = 'Mostrando Cocineros: ';
            contTable.innerHTML = xhr.responseText;
        }
      };
      xhr.open('GET', 'verCocineros.php', true);
      xhr.send();
    });
  });
  