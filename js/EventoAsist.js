document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ver-eventos');
    var tableInfo = document.getElementById('table-info');
    var contTable = document.querySelector('.cont-table');
    var tipoorde = document.getElementById('tipoorde');
  
    // Add event listener to tipoorde select
    tipoorde.addEventListener('change', function() {
      var selectedOrder = tipoorde.value;
      var selectedButtonId = document.querySelector('.ver-eventos.selected').getAttribute('id');
  
      switch (selectedButtonId) {
        case 'verPend':
            currentTable="pend";
          if (selectedOrder === 'lejanoevento') {
            makeAjaxRequest('verEventosAtendiendo.php?orden=lejanoevento', 'Pendientes: <i class="fas fa-utensils" style="color: #ffffff;"></i>');
          } else if (selectedOrder === 'cercasevento') {
            makeAjaxRequest('verEventosAtendiendo.php?orden=cercasevento', 'Pendientes: <i class="fas fa-utensils" style="color: #ffffff;"></i>');
          }
          break;
        case 'verFin':
            currentTable="fin";
          if (selectedOrder === 'lejanoevento') {
            makeAjaxRequest('verFinalizados.php?orden=lejanoevento', 'Historial de Eventos Atendidos: <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>');
          } else if (selectedOrder === 'cercasevento') {
            makeAjaxRequest('verFinalizados.php?orden=cercasevento', 'Historial de Eventos Atendidos: <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>');
          }
          break;
        default:
          tableInfo.innerHTML = 'Mostrando información:';
          contTable.innerHTML = '';
          break;
      }
    });
  
    // Add event listener to the buttons
    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
        buttons.forEach(function(btn) {
          btn.classList.remove('selected');
        });
        this.classList.add('selected');
        var url = this.getAttribute('data-url');
        var buttonId = this.getAttribute('id');
        var selectedOrder = tipoorde.value;
  
        switch (buttonId) {
          case 'verPend':
            currentTable="pend";
            if (selectedOrder === 'lejanoevento') {
              makeAjaxRequest('verEventosAtendiendo.php?orden=lejanoevento', 'Pendientes: <i class="fas fa-utensils" style="color: #ffffff;"></i>');
            } else if (selectedOrder === 'cercasevento') {
              makeAjaxRequest('verEventosAtendiendo.php?orden=cercasevento', 'Pendientes: <i class="fas fa-utensils" style="color: #ffffff;"></i>');
            }
            break;
          case 'verFin':
            currentTable="fin";
            if (selectedOrder === 'lejanoevento') {
              makeAjaxRequest('verFinalizados.php?orden=lejanoevento', 'Historial de Eventos Atendidos: <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>');
            } else if (selectedOrder === 'cercasevento') {
              makeAjaxRequest('verFinalizados.php?orden=cercasevento', 'Historial de Eventos Atendidos: <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>');
            }
            break;
          default:
            tableInfo.innerHTML = 'Mostrando información:';
            contTable.innerHTML = '';
            break;
        }
      });
    });
  });
  
  // Function to make the AJAX request
  function makeAjaxRequest(url, message) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        tableInfo.innerHTML = message;
        contTable.innerHTML = xhr.responseText;
      }
    };
    xhr.open('GET', url, true);
    xhr.send();
  }
  