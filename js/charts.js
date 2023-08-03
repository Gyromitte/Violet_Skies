//Cards del home (peticion a countAll.php)
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    // Parsear la respuesta JSON
    var data = JSON.parse(this.responseText);
    // Actualizar el contenido de las cards con los datos recibidos
    document.getElementById("clientesCard").innerHTML = data.count_clientes;
    document.getElementById("empleadosCard").innerHTML = data.count_empleados;
    document.getElementById("eventosCard").innerHTML = data.count_eventos;
    document.getElementById("solicitudesCard").innerHTML = data.count_solicitudes;
  }
}
xhttp.open("GET", "/php/viewsCharts/countAll.php", true);
xhttp.send();

// Realizar la solicitud AJAX para obtener los conteos de eventos finalizados por mes
fetch('/php/viewsCharts/eventosMeses.php') // Ruta de la consulta PHP
  .then(response => response.json())
  .then(data => {
    // data contiene los conteos de eventos finalizados por mes
    console.log(data); // Agregar esta línea para verificar la respuesta

    // Llamar a la función para actualizar el gráfico de puntos
    actualizarGraficoPuntos(data);
  })
  .catch(error => console.error('Error al obtener los conteos de eventos:', error));

// Función para actualizar el gráfico de puntos (scatter)
function actualizarGraficoPuntos(data) {
  Chart.defaults.color = 'white';
  var ctxEventos = document.getElementById('eventosAño').getContext('2d');
  var scatterChart = new Chart(ctxEventos, {
    type: 'line',
    data: {
      datasets: [{
        label: 'Eventos por Mes',
        data: data.map((cantidad, mes) => ({ x: obtenerNombreMes(mes + 1), y: cantidad })),
        backgroundColor: 'transparent',
        borderColor: 'white',
        borderWidth: 2,
        pointRadius: 5,
        pointBackgroundColor: 'white',
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
}

// Función auxiliar para obtener el nombre del mes a partir de su número
function obtenerNombreMes(numeroMes) {
  const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  return nombresMeses[numeroMes - 1];
}
//Doughnout (proporcion empleados)
// JavaScript para la primera instancia de gráficas
var ctxEventos = document.getElementById('eventosAño').getContext('2d');
var ctxProporcion = document.getElementById('proporcionEmpleados').getContext('2d');
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

/* Functionality */
function actualizarGraficoDoughnut(countCocina, countMesero) {
  // Actualizar el gráfico de "doughnut" con los nuevos datos
  doughnutChart.data.datasets[0].data = [countCocina, countMesero];
  doughnutChart.update();
}

function recargarGraficos(){
  //Recargar datos de info cards
  xhttp.open("GET", "/php/viewsCharts/countAll.php", true);
  xhttp.send();
  // JavaScript para la segunda instancia de gráficas
  var ctxProporcion2 = document.getElementById('proporcionEmpleados2').getContext('2d');
  var doughnutChart2 = new Chart(ctxProporcion2, {
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
          labels: {
            fontColor: 'white'
          },
        },
      }
    }
  });


  /* Functionality para la segunda instancia */
  function actualizarGraficoDoughnut2(countCocina, countMesero) {
    // Actualizar el gráfico de "doughnut" con los nuevos datos
    doughnutChart2.data.datasets[0].data = [countCocina, countMesero];
    doughnutChart2.update();
  }

  // Función para actualizar el gráfico de barras
  function actualizarGraficoBarras(nombres, cantidades) {
  // Actualizar los datos de la gráfica de barras con los empleados del ranking
  myBarChart.data.labels = nombres;
  myBarChart.data.datasets[0].data = cantidades;
  myBarChart.update();
  }

  // Realizar la solicitud AJAX para obtener los conteos de empleados
  fetch('/php/viewsCharts/countEmpleados.php') // Ruta de la consulta PHP
    .then(response => response.json())
    .then(data => {
      // data contiene los conteos de empleados de cada tipo
      //console.log(data); // Agregar esta línea para verificar la respuesta

      const countCocina = data.count_cocina;
      const countMesero = data.count_mesero;

      // Llamar a la función para actualizar el gráfico de "doughnut" para la primera instancia
      actualizarGraficoDoughnut(countCocina, countMesero);

      // Llamar a la función para actualizar el gráfico de "doughnut" para la segunda instancia
      actualizarGraficoDoughnut2(countCocina, countMesero);
    })
    .catch(error => console.error('Error al obtener los conteos de empleados:', error));

    // Obtener el elemento canvas y crear el contexto para la gráfica de barras
    const ctx = document.getElementById("participacionEmpleados").getContext("2d");
    // Crear la gráfica de barras
    const myBarChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: [], // Nombres de los empleados en el eje X (se actualizará)
        datasets: [
          {
            label: "Participaciones",
            data: [], // Cantidades de participación en el eje Y (se actualizará)
            backgroundColor: "#454ade", // Color de fondo de las barras
            borderColor: "white", // Color del borde de las barras
            borderWidth: 2, // Ancho del borde de las barras
          },
        ],
      },
      options: {
        plugins: {
          legend: {
            labels: {
              color: "white", // Cambiar el color del texto de la leyenda a blanco
            },
          },
        },
        scales: {
          x: {
            ticks: {
              color: "white", // Cambiar el color del texto del eje X a blanco
            },
          },
          y: {
            ticks: {
              color: "white", // Cambiar el color del texto del eje Y a blanco
            },
            beginAtZero: true, // Empezar el eje Y en cero
          },
        },
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'bottom',
            labels: {
              fontColor: 'white'
            },
          },
        }
      },
    });

    // Realizar la solicitud AJAX para obtener los datos del ranking de empleados y los conteos de empleados
    fetch('/php/viewsCharts/rankingEmpleados.php') 
      .then(response => response.json())
      .then(data => {
        // data contiene los datos del ranking de empleados
        //console.log(data); //Verificar la respuesta

        // Extraer los nombres de los empleados y las cantidades de participación
        const nombres = data.map(empleado => empleado.NOMBRE_EMPLEADO);
        const cantidades = data.map(empleado => empleado.CANTIDAD_EVENTOS_PARTICIPADOS);

        // Actualizar el gráfico de barras con los empleados del ranking
        actualizarGraficoBarras(nombres, cantidades);
      })
      .catch(error => console.error('Error al obtener los datos:', error));
}

//Cargar el segundo grafico una vez al principio del load de la pagina
recargarGraficos();

