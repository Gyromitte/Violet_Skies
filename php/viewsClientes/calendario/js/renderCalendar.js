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
        
            const nowDate = new Date();
            const selectedDate = info.date;
        
            // Deshabilitar selección de fechas antes del día actual
            if (selectedDate < nowDate) {
                return;
            }
        
            // Deshabilitar selección de fechas en los próximos 7 días
            const nextWeekDate = new Date(nowDate);
            nextWeekDate.setDate(nextWeekDate.getDate() + 7);
            if (selectedDate <= nextWeekDate) {
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
        },
        eventDidMount: function(info) {
            if (info.event.extendedProps.disabled) {
                const dayCell = info.el.closest('.fc-day'); // Encontrar el contenedor del día
                if (dayCell) {
                    dayCell.classList.add('fc-day-disabled', 'fc-day-disabled-default');
                }
            } else if (info.event.start) {
                const fecha = info.event.start.toISOString().split('T')[0];
                const eventosEnFecha = info.view.calendar.getEvents().filter(evento => evento.start.toISOString().split('T')[0] === fecha);
        
                if (eventosEnFecha.length > 1) {
                    info.el.style.backgroundColor = '#ff0000'; // Cambiar el color de fondo a rojo si hay múltiples eventos
                }
            }
        },
        dayCellDidMount: function(info) {
            const nowDate = new Date();
            const nextWeekDate = new Date(nowDate);
            nextWeekDate.setDate(nextWeekDate.getDate() + 7);
        
            if (info.date < nowDate || info.date <= nextWeekDate) {
                const dayCell = info.el;
                dayCell.classList.add('fc-day-disabled', 'fc-day-disabled-default');
            }
        },
        
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
