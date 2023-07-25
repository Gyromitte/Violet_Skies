// Datos para el gráfico de puntos (scatter)
Chart.defaults.color = 'white';
const eventosRealizados = [
    { mes: 'Enero', cantidad: 10 },
    { mes: 'Febrero', cantidad: 15 },
    { mes: 'Marzo', cantidad: 11 },
    { mes: 'Abril', cantidad: 13 },
    { mes: 'Mayo', cantidad: 20 },
    { mes: 'Junio', cantidad: 18 },
    { mes: 'Julio', cantidad: 25 },
    { mes: 'Agosto', cantidad: 23 },
    { mes: 'Septiembre', cantidad: 19 },
  ];
  
  // Obtiene el contexto de los canvas
  var ctxEventos = document.getElementById('eventosAño').getContext('2d');
  var ctxProporcion = document.getElementById('proporcionEmpleados').getContext('2d');
  var scatterChart = new Chart(ctxEventos, {
    type: 'line', // Cambiamos el tipo de gráfico a 'line'
    data: {
      datasets: [{
        label: 'Eventos por Mes',
        data: eventosRealizados.map(({ mes, cantidad }) => ({ x: mes, y: cantidad })),
        backgroundColor: 'transparent', // Color de fondo transparente para los puntos
        borderColor: 'white', // Color de las líneas de conexión
        borderWidth: 2,
        pointRadius: 5, // Tamaño de los puntos
        pointBackgroundColor: 'white', // Color de los puntos
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          type: 'category',
          position: 'bottom',
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
          beginAtZero: true,
          title: {
            display: true,
            text: 'Eventos',
            color: 'white',
          },
          ticks: {
            color: 'white',
          },
        }
      }
    }
  });
  
  // Define el gráfico de "doughnut" sin datos iniciales
var doughnutChart = new Chart(ctxProporcion, {
  type: 'doughnut',
  data: {
    labels: ['Cocineros', 'Meseros'],
    datasets: [{
      data: [], // Sin datos iniciales
      backgroundColor: ['#5603ad', '#8367c7'], // Colores de las secciones
      borderColor: ['white', 'white'], // Colores de los bordes de las secciones
      borderWidth: 1,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
          display: true,
          position: 'bottom',
          labels:{
              fontColor: 'white'
          },
      },
    }
  }
});

/*Functionality*/
function actualizarGraficoDoughnut(countCocina, countMesero) {
  // Actualizar el gráfico de "doughnut" con los nuevos datos
  doughnutChart.data.datasets[0].data = [countCocina, countMesero];
  doughnutChart.update();
}

// Realizar la solicitud AJAX para obtener los conteos de empleados
fetch('/php/viewsCharts/countEmpleados.php') // Ruta de la consulta PHP
  .then(response => response.json())
  .then(data => {
    // data contiene los conteos de empleados de cada tipo
    console.log(data); // Agregar esta línea para verificar la respuesta

    const countCocina = data.count_cocina;
    const countMesero = data.count_mesero;

    // Llamar a la función para actualizar el gráfico de "doughnut"
    actualizarGraficoDoughnut(countCocina, countMesero);
  })
  .catch(error => console.error('Error al obtener los conteos de empleados:', error));

