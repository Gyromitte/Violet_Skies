/*Dinamic tables*/
//Conseguir los elementos
document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ver-empleados');
    var tableInfo = document.getElementById('table-info');
    var contTable = document.querySelector('.cont-table');
  //Agregar el evento de click a los botones
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

  // JavaScript para abrir y cerrar el dash-board y el overlay
const navButton = document.getElementById('nav-button');
const dashBoard = document.getElementById('dash-board');
const overlay = document.getElementById('overlay');

navButton.addEventListener('click', function() {
  dashBoard.classList.toggle('dashboard-open');
  overlay.classList.toggle('overlay-open');
});

  