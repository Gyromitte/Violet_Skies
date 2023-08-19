document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'title',
            right: 'prev,next'
        },        
        initialDate: new Date().toISOString().split('T')[0],
        dayMaxEvents: true, // allow "more" link when too many events,
        events: {
        url: '../tools/obtain-events.php', // URL del archivo PHP para obtener los eventos
        method: 'POST', // Método para realizar la solicitud AJAX (puede ser GET o POST según tu implementación)
        extraParams: {},
        display:'background',
        color:'',

        failure: function() {
            //window.location.replace(`../maintenance/unexpected.php`);
        }
        },
        locale: 'es',
        dateClick: function(info) {

        const fecha_seleccionada = info.date;
        const fecha_actual = new Date();
        fecha_actual.setHours(0, 0, 0, 0);

        if (fecha_seleccionada <= fecha_actual) {
            let textWarningSchedule = document.getElementById("textWarningSchedule");
            textWarningSchedule.textContent = '*Solo puedes escoger una fecha posterior a este día.';
            return;
        }
        const eventosEnFecha = calendar.getEvents().filter(evento => evento.start.toISOString().split('T')[0] === fecha_seleccionada.toISOString().split('T')[0]);
        if (eventosEnFecha.length > 0) {
            let textWarningSchedule = document.getElementById("textWarningSchedule");
            textWarningSchedule.textContent = '*No puedes escoger una fecha ya ocupada.';
            return;
        }

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
        }
        
    });

    calendar.render();
    });