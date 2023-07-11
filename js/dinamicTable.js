/*Dinamic tables*/
document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ver-empleados');
    var tableInfo = document.getElementById('table-info');
    var contTable = document.querySelector('.cont-table');
  
    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        var buttonText = this.textContent;
  
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            tableInfo.textContent = 'Mostrando ' + buttonText + ':';
            contTable.innerHTML = xhr.responseText;
          }
        };
        xhr.open('GET', url, true);
        xhr.send();
      });
    });
  });
  