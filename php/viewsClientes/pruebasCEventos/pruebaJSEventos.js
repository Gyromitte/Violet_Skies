$(document).ready(function() {
    // Utiliza el datetimepicker para el campo de fecha y hora del evento
    $('#fechaEvento').datetimepicker({
        format: 'Y-m-d H:i:s', // Formato deseado para la fecha y hora
        step: 15, // Intervalo de minutos para seleccionar la hora
        // Puedes agregar más opciones según tus necesidades
    });

    // Agregar el evento al formulario
    $('#evento-form').submit(function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        const nombreEvento = $('#nombre_evento').val();
        const salon = $('#salon').val();
        const invitados = parseInt($('#invitados').val());
        const fechaHora = $('#fechaEvento').val();

        // Crear el objeto con los datos a enviar al servidor
        const datosEvento = {
            nombre: nombreEvento,
            salon: salon,
            invitados: invitados,
            fechaHora: fechaHora
        };

        // Realizar la solicitud al servidor con los datos del evento
        fetch('pruebaPHPEventos.php', {
            method: 'POST',
            body: JSON.stringify(datosEvento),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar la lista de eventos con la respuesta del servidor
            // (código para actualizar la lista aquí)
        })
        .catch(error => console.error('Error:', error));
    });
});
