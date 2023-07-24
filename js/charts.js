// Datos para el gráfico de puntos (scatter)
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
  
  // Crea el gráfico de puntos (scatter)
  var scatterChart = new Chart(ctxEventos, {
    type: 'scatter',
    data: {
      datasets: [{
        label: 'Eventos realizados',
        data: eventosRealizados.map(({ mes, cantidad }) => ({ x: mes, y: cantidad })),
        backgroundColor: 'rgba(75, 192, 192, 0.6)', // Color de los puntos
        borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de los puntos
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      
      scales: {
        x: {
          type: 'category', // Asegura que las etiquetas del eje X se muestren correctamente
          position: 'bottom',
          title: {
            display: true,
            text: 'Meses',
          },
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Cantidad de Eventos',
          },
        }
      }
    }
  });
  
  // Crea el gráfico de proporción de empleados (doughnut)
  var doughnutChart = new Chart(ctxProporcion, {
    type: 'doughnut',
    data: {
      labels: ['Cocineros', 'Meseros'],
      datasets: [{
        data: Object.values(proporcionEmpleados),
        backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)'], // Colores de las secciones
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'], // Colores de los bordes de las secciones
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'bottom', // Puedes ajustar la posición de la leyenda según tus preferencias
        },
      }
    }
  });