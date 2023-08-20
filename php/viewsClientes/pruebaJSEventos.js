$(window).on('load', function() {

  $('#evento-form').submit(function(event) {
      event.preventDefault();
      
      const nombreEvento = $('#nombre_evento').val();
      const salon = $('#salon').val();
      const comida = $('#comida').val();
      const invitados = parseInt($('#invitados').val());
      const fecha = $('#selected-date').val();
      const hora = $('#hora_evento').val();
      
      console.log("Nombre del evento:", nombreEvento);
      console.log("Salón:", salon);
      console.log("Comida:", comida);
      console.log("Invitados:", invitados);
      console.log("Fecha:", fecha);
      console.log("Hora:", hora);

      // Combina la fecha y la hora en el formato deseado
      const fechaHora = fecha + ' ' + hora + ':00';

      console.log("Fecha y Hora Combinadas:", fechaHora);

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
                const errorMessage = "Ya tienes 5 eventos pendientes.<br> No puedes agregar más por el momento.";
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${errorMessage}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else if (jsonData && jsonData.cupoMaximoExcedido) {
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${jsonData.mensaje}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else if (jsonData && jsonData.fechaOcupada) {
                const msgDiv = document.getElementById('msgDiv');
                const errorMessage = "Lo siento, esta fecha ya está apartada<br>para este salón.";
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${errorMessage}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            } else if (jsonData && jsonData.cupoMinimoNoAlcanzado) {
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">${jsonData.mensaje}</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                }, 3000);
            }else{
                const msgDiv = document.getElementById('msgDiv');
                msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-success">Evento solicitado con éxito <br>espera a que los administradores lo confirmen</div>`;
                setTimeout(() => {
                    msgDiv.innerHTML = ''; 
                    location.reload();
                }, 3000);
                const btnSolicitarEvento = document.getElementById("accept-button");

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
            msgDiv.innerHTML = `<div style="text-align:center;" class="alert alert-danger">Lo siento, esta fecha ya está apartada <br>para este salón.</div>`;
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


