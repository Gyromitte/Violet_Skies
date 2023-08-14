//Cards del home (peticion a countAll.php)
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
// Parsear la respuesta JSON
var data = JSON.parse(this.responseText);
// Actualizar el contenido de las cards con los datos recibidos
document.getElementById("DispCard").innerHTML = data.count_disp;
document.getElementById("AsistCard").innerHTML = data.count_atend;
document.getElementById("SolicCard").innerHTML = data.count_solic;
document.getElementById("FechaCard").innerHTML = data.fecha;
}
}
xhttp.open("GET", "/php/viewsCharts/countingemp.php", true);
xhttp.send();


  fetch('/php/viewsCharts/EventosFin.php')
  .then(response => response.json())
  .then(eventosPorMes => { 
    EventosFinales(eventosPorMes);
  })
  .catch(error => console.error('Error al obtener los conteos de eventos:', error));

function EventosFinales(eventosPorMes) {
  Chart.defaults.color = 'white';
  var Eventos = document.getElementById('EventosFinaliz').getContext('2d');

  var Finalizados = new Chart(Eventos, {
    type: 'bar', // Use "bar" for horizontal bar chart
    data: {
      labels: eventosPorMes.labels,
      datasets: [
        {
          label: 'Finalizados',
          data: eventosPorMes.map((cantidad, mes) => ({ x: obtenerNombreMes(mes + 1), y: cantidad })),
          backgroundColor: '#4240b8',
          borderColor: 'white',
          borderWidth: 2,
        },
      ],
    },
    options: {
      scales: {
        x: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Meses',
            color: 'white',
          },
          ticks: {
            color: 'white',
          },
        },
        y: {
            title: {
                display: true,
                text: 'Meses',
                color: 'white',
              },
          ticks: {
            color: 'white',
            reverse: true,
            stepSize: 1,
          },
        },
      },
    },
  });
}

function obtenerNombreMes(numeroMes) {
  const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  return nombresMeses[numeroMes - 1];
}