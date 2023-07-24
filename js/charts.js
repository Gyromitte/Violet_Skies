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
  
  // Datos para el gráfico de proporción de empleados (doughnut)
  const proporcionEmpleados = {
    cocineros: 35,
    meseros: 65,
  };
  
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
  
  
  
  //(doughnut)
  var doughnutChart = new Chart(ctxProporcion, {
    type: 'doughnut',
    data: {
      labels: ['Cocineros', 'Meseros'],
      datasets: [{
        data: Object.values(proporcionEmpleados),
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