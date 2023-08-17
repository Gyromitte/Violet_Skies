document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            right: 'title',
            left: 'prev,next'
        },        
        initialDate: new Date().toISOString().split('T')[0],
        dayMaxEvents: true, // allow "more" link when too many events,
        events: {
            url: '/php/viewsClientes/diasOcupados.php', // URL del archivo PHP para obtener los eventos
            method: 'POST', // Método para realizar la solicitud AJAX (puede ser GET o POST según tu implementación)
            extraParams: {},
            display: 'background',
            color: '',

            failure: function() {
                console.log("Dafaq");
            }
        },
        locale: 'es',
        dateClick: function(info) {
            const fecha_seleccionada = info.date;
            const fecha_actual = new Date();
            fecha_actual.setHours(0, 0, 0, 0);

            // Remove previous selected date
            var fecha_anterior = document.querySelector('.fc-day-selected');
            if (fecha_anterior) {
                fecha_anterior.classList.remove('fc-day-selected');
            }

            // Add new selected date
            var formattedDate = fecha_seleccionada.toISOString().split('T')[0];
            document.getElementById('selected-date').value = formattedDate;
            var dayCell = info.dayEl;
            dayCell.classList.add('fc-day-selected');
        },

        eventDidMount: function(info) {
            // Verificar si hay más de un evento en la misma fecha
            if (info.event.start) {
                const fecha = info.event.start.toISOString().split('T')[0];
                const eventosEnFecha = info.view.calendar.getEvents().filter(evento => evento.start.toISOString().split('T')[0] === fecha);
        
                if (eventosEnFecha.length > 1) {
                    info.el.style.backgroundColor = '#ff0000'; // Cambiar el color de fondo a rojo
                }
            }
        }
        
    });

    calendar.render();
});

//Regex's

//Limitar a que solo se puedan escribir letras
function limitarALetras(input) {
    input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ\s]/g, '');
}

//Limitar a que solo se puedan escribir numeros
function limitarANumeros(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}
