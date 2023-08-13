$(window).on('load', function() {

var currentDate = new Date();
var oneWeekLater = new Date();
oneWeekLater.setDate(currentDate.getDate()+7);

$('#fechaEvento').datetimepicker({
    format: 'Y-m-d H:i:00',
    step: 15,
    value: oneWeekLater.toISOString().slice(0, 19).replace('T', ' '),
    minDate: oneWeekLater.toISOString().slice(0, 19).replace('T', ' '), // Establece el valor inicial
    allowTimes: [
        '05:00','06:00','07:00','08:00', '09:00', '10:00', '11:00', '12:00', '13:00',
        '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00','22:00'
    ]
});

  $('#evento-form').submit(function(event) {
      event.preventDefault();
      
      const nombreEvento = $('#nombre_evento').val();
      const salon = $('#salon').val();
      const comida = $('#comida').val();
      const invitados = parseInt($('#invitados').val());
      const fechaHora = $('#fechaEvento').val();

      const datosEvento = new URLSearchParams();
      datosEvento.append("nombre_evento", nombreEvento);
      datosEvento.append("salon", salon);
      datosEvento.append("comida", comida);
      datosEvento.append("invitados", invitados);
      datosEvento.append("fechaEvento", fechaHora);

      fetch('pruebaPHPEventos.php', {
          method: 'POST',
          body: datosEvento
      })
      .then(response => {
          return response.text();
      })
      .then(data => {
        console.log('Respuesta del servidor:', data);

        try {
            const jsonData = JSON.parse(data);
            console.log('Datos JSON:', jsonData);
        
            if (jsonData && jsonData.disponibilidad === true) {
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${jsonData.mensaje}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else if (jsonData && jsonData.cupoMaximoExcedido) {
                const msgDiv = document.getElementById('msgDiv');
                const errorMessage = "Ya tienes 5 eventos pendientes.<br> No puedes agregar más por el momento.";
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${errorMessage}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else if (jsonData && jsonData.fechaOcupada) {
                const msgDiv = document.getElementById('msgDiv');
                const errorMessage = "Lo siento, esta fecha ya está apartada.";
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${errorMessage}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else {

                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-success">Evento solicitado con éxito <br>espera a que los administradores lo confirmen</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                    location.reload();
                }, 3000);
                const btnSolicitarEvento = document.getElementById("solicitarEventoBtn");

                btnSolicitarEvento.addEventListener("click", function() {
                btnSolicitarEvento.disabled = true;
                });
            }
        
            if (jsonData && jsonData.eventos) {
                console.log('Lista de eventos actualizada:', jsonData.eventos);
            }
        } catch (error) {
            console.error('Error al analizar la respuesta JSON:', error);
            // Si ocurre un error al analizar la respuesta JSON, muestra un mensaje de error
            const msgDiv = document.getElementById('msgDiv');
            msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">Lo siento, esta fecha ya está apartada.</div>`;
        }      
    })
      .catch(error => console.error('Error en la solicitud:', error));
  });
});

function resetInputs() {
    $('#nombre_evento').val("");
    $('#salon').prop('selectedIndex', 0);
    $('#comida').prop('selectedIndex', 0);
    $('#invitados').val("");
    $('#fechaEvento').val(oneWeekLater.toISOString().slice(0, 19).replace('T', ' '));
}

