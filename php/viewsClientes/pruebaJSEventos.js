$(window).on('load', function() {

  var currentDate = new Date();
  var oneWeekLater = new Date();
  oneWeekLater.setDate(currentDate.getDate() + 6);

  $('#fechaEvento').datetimepicker({
      format: 'Y-m-d H:i:s',
      step: 15,
      minDate: oneWeekLater.toISOString().slice(0, 19).replace('T', ' '),
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

        // Intentar analizar la respuesta como JSON
        try {
            const jsonData = JSON.parse(data);
            // Aquí puedes realizar las acciones necesarias con la respuesta JSON
            console.log('Datos JSON:', jsonData);

            // Ejemplo de cómo manejar la disponibilidad:
            if (jsonData && jsonData.disponibilidad === true) {
                // Hubo un problema con la disponibilidad del salón o el número de invitados
                // Muestra un mensaje de error en lugar de un mensaje de éxito
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">Error: No se pudo agregar el evento.</div>`;
            } else {
                // El evento se pudo agregar correctamente
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-success">Evento solicitado con éxito <br>espera a que los administradores lo confirmen</div>`;
            }
            if (jsonData && jsonData.cupoMaximoExcedido) {
                // Mostrar un mensaje de error en lugar del mensaje de éxito
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${jsonData.mensaje}</div>`;
            }

            // Ejemplo de cómo manejar la lista de eventos:
            if (jsonData && jsonData.eventos) {
                // Actualizar la lista de eventos en la página con los datos del servidor
                console.log('Lista de eventos actualizada:', jsonData.eventos);
            }
        } catch (error) {
            console.error('Error al analizar la respuesta JSON:', error);
            // Si ocurre un error al analizar la respuesta JSON, muestra un mensaje de error
            const msgDiv = document.getElementById('msgDiv');
            msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">Lo siento, esa fecha ya está apartada</div>`;
        }
      })
      .catch(error => console.error('Error en la solicitud:', error));
  });
});


