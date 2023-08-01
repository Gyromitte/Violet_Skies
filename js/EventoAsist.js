document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ver-eventos');
    var tableInfo = document.getElementById('table-info');
    var contTable = document.querySelector('.cont-table');
  
    // Add event listener to the buttons
    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
        buttons.forEach(function(btn) {
          btn.classList.remove('selected');
        });
        this.classList.add('selected');
        var url = this.getAttribute('data-url');
        var buttonId = this.getAttribute('id');

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var message = getMessageByButtonId(buttonId);
            tableInfo.innerHTML = message; // Modificar el innerHTML en lugar de textContent
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
      case 'verPend':
        currentTable = 'pend';
        return 'Pendientes: '; 
        
      case 'verFin':
        currentTable = 'fin';
        return 'Historial: ';
      default:
        return 'Mostrando información:';
    }
  }
  