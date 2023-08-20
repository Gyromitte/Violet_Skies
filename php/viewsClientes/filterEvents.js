const eventCardsContainer = document.getElementById("event-cards");

const salonImageUrls = {
    1: '/images/salones/salon2.jpg',
    2: '/images/salones/salon2.jpg',
    3: '/images/salones/salon5.jpg',
    4: '/images/salones/salon5.jpg',
    5: '/images/salones/salon5.jpg',
    6: '/images/salones/salon1.jpg',
    7: '/images/salones/salon1.jpg',
    8: '/images/salones/salon1.jpg',
    9: '/images/salones/salon1.jpg',
    10: '/images/salones/salon3.jpg',
    11: '/images/salones/salon3.jpg'
}

function createEventCard(event) {
    const card = document.createElement("div");
    card.classList.add("card");

    const salonId = event.ID_SALON;
    if (salonImageUrls.hasOwnProperty(salonId)) {
        const image = document.createElement("img");
        image.src = salonImageUrls[salonId];
        card.appendChild(image);
    }

    const eventId = document.createElement("p");
    eventId.textContent = `ID del evento: ${event.ID_EVENTO}`;
    eventId.classList.add("hidden"); 

    const title = document.createElement("h2");
    title.textContent = event['NOMBRE DEL EVENTO'];

    const date = document.createElement("p");
    date.textContent = `Fecha: ${event['FECHA DEL EVENTO']}`;

    const salon = document.createElement("p");
    salon.textContent =`Salón: ${event['NOMBRE DEL SALÓN']}`;

    const menu = document.createElement("p");
    menu.textContent = `Menú: ${event['MENÚ']}`;

    const invitados = document.createElement("p");
    invitados.textContent = `Invitados: ${event['INVITADOS']}`;

    const client = document.createElement("p");
    client.textContent = `Cliente: ${event['NOMBRE DEL CLIENTE']}`;
    client.classList.add("hidden"); 

    const state = document.createElement("p");
    state.textContent = `Estado: ${event.ESTADO}`;
    state.classList.add("hidden"); 

    const cancelButton = document.createElement("button");
    cancelButton.textContent = "Cancelar Evento";

    const editButton = document.createElement("button");
    editButton.textContent = "Editar Evento";

    if (event.ESTADO === "PENDIENTE" || event.ESTADO === "EN PROCESO") {
        editButton.classList.add("btn-modal-primary");
        editButton.addEventListener("click", () => {
            openEditModal(event);
        });
    } else {
        editButton.style.display = "none";
    }

    //Timer que desactiva el botón de cancelar si falta una semana.
    const eventDateParts = event['FECHA DEL EVENTO'].split(' ')[0].split('-');
    const eventDate = new Date(
        parseInt(eventDateParts[0]),
        parseInt(eventDateParts[1]) - 1,
        parseInt(eventDateParts[2])
    );

    const currentDate = new Date();
    const timeDifferenceInMilliseconds = eventDate.getTime() - currentDate.getTime();

    const ONE_WEEK_IN_MILLISECONDS = 7 * 24 * 60 * 60 * 1000;

    if (event.ESTADO !== "FINALIZADO" && event.ESTADO !== "CANCELADO") {
        cancelButton.classList.add("btn-modal-warning");
        cancelButton.addEventListener("click", () => {
            if (timeDifferenceInMilliseconds <= ONE_WEEK_IN_MILLISECONDS) {
                // Mostrar un mensaje de alerta
                window.alert("Para cancelar el evento, por favor póngase en contacto con un administrador mediante el botón de WhatsApp.");
            } else {
                openCancelModal(event.ID_EVENTO);
            }
        });
    } else {
        cancelButton.style.display = "none";
    }
    card.appendChild(eventId);
    card.appendChild(title);
    card.appendChild(date);
    card.appendChild(salon);
    card.appendChild(menu);
    card.appendChild(invitados);
    card.appendChild(cancelButton);
    card.appendChild(editButton);


    return card;
}

function openCancelModal(eventId) {
    const modal = document.getElementById("cancelModal");
    const eventIDInput = document.getElementById("eventIDInput");
    const passwordInput = document.getElementById("password"); 
    const cancelMessage = document.getElementById("cancelMessage");

    cancelMessage.style.visibility = "hidden";
    eventIDInput.value = eventId;
    modal.style.display = "block";
    passwordInput.value = "";
}

document.querySelector(".close").addEventListener("click", () => {
    const modal = document.getElementById("cancelModal");
    const passwordInput = document.getElementById("password");
    const cancelMessage = document.getElementById("cancelMessage");

    cancelMessage.style.visibility = "hidden";
    modal.style.display = "none";
    passwordInput.value = "";
    cancelMessage.textContent = "";
});
filterEvents("PENDIENTE");
function filterEvents(state) {
    eventCardsContainer.innerHTML = "";

    fetch(`get_events.php?estado=${state}`)
        .then(response => response.json())
        .then(events => {
            if (events.length === 0) {
                const noEventsMessage = document.createElement("p");
                noEventsMessage.textContent = "No hay eventos para mostrar";
                noEventsMessage.style.fontSize = "80px"; 
                noEventsMessage.style.fontWeight = "bold"; 
                noEventsMessage.style.marginTop = "50px";
                noEventsMessage.style.alignContent= "center";
                eventCardsContainer.appendChild(noEventsMessage);
            } else {
                events.forEach(event => {
                    const card = createEventCard(event);
                    eventCardsContainer.appendChild(card);
                });
            }
        })
        .catch(error => console.error('Error al obtener los eventos:', error));
}

document.getElementById("cancelForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch("cancelEvents.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(message => {
        const cancelMessage = document.getElementById("cancelMessage");
        const passwordInput = document.getElementById("password");
        const modal = document.getElementById("cancelModal");
        cancelMessage.style.visibility = "visible";
        cancelMessage.style.height= "fit-content";
        cancelMessage.classList.remove("alert", "alert-success", "alert-danger", "d-flex", "justify-content-center");



        cancelMessage.textContent = message;

        if (message.includes("cancelado correctamente")) {
            cancelMessage.classList.add("alert", "alert-success", "d-flex", "justify-content-center");
            setTimeout(() => {
                modal.style.display = "none"; 
                passwordInput.value = "";
                cancelMessage.textContent = ""; 
                filterEvents("PENDIENTE");
            }, 1500);
        }else
        {
            cancelMessage.classList.add("alert", "alert-danger", "d-flex", "justify-content-center");

            setTimeout(() => {
                cancelMessage.style.visibility = "hidden";
                cancelMessage.textContent = ""; 
                cancelMessage.style.height= 0;
            }, 2000);
        }
    })
    .catch(error => {
        console.error("Error al cancelar el evento:", error);
    });
});
//modal para editar eventos.
function openEditModal(event) {
    const modal = document.getElementById("editModal");
    const titleInput = document.getElementById("editTitleInput");
    const dateInput = document.getElementById("editDateInput");
    const salonInput = document.getElementById("editSalonInput");
    const menuInput = document.getElementById("editMenuInput");
    const invitadosInput = document.getElementById("editInvitadosInput");
    const eventIdInput = document.getElementById("eventId");

    eventIdInput.value = event.ID_EVENTO;
    titleInput.value = event['NOMBRE DEL EVENTO'];
    dateInput.value = event['FECHA DEL EVENTO'];
    salonInput.value = event['ID_SALON']; 
    menuInput.value = event['ID_MENU']; 
    invitadosInput.value = event['INVITADOS'];

    modal.style.display = "block";

    const oneWeekLater = new Date();
    oneWeekLater.setDate(oneWeekLater.getDate() + 6);

    $(dateInput).datetimepicker({
        format: 'Y-m-d H:i:s', // Formato deseado para la fecha y hora
        step: 15, // Intervalo de minutos para seleccionar la hora
        minDate: oneWeekLater.toISOString().slice(0, 19).replace('T', ' '), // Fecha mínima: una semana después de la actual
        allowTimes: [
            '05:00','06:00','07:00','08:00', '09:00', '10:00', '11:00', '12:00', '13:00', // Ejemplo de horas permitidas
            '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00','22:00' // Puedes agregar más horas aquí
        ]
    });
}


// Función para cerrar el modal de edición
function closeEditModal() {
    const modal = document.getElementById("editModal");


    modal.style.display = "none";
}

// Llama a la función closeEditModal cuando se hace clic en el botón de cierre del modal
const closeModalButton = document.querySelector("#editModal .btn-close");
closeModalButton.addEventListener("click", closeEditModal);

$('#editSaveButton').click(function() {
    const eventId = $('#eventId').val();
    const editTitle = $('#editTitleInput').val();
    const editSalon = $('#editSalonInput').val();
    const editMenu = $('#editMenuInput').val();
    const editInvitados = parseInt($('#editInvitadosInput').val());
    const editDate = $('#editDateInput').val();
    
    console.log("Event ID:", eventId);
    console.log("Edited Title:", editTitle);
    console.log("Edited Salon:", editSalon);
    console.log("Edited Menu:", editMenu);
    console.log("Edited Invitados:", editInvitados);
    console.log("Edited Date:", editDate);

    // Combine la fecha y la hora en el formato deseado si es necesario
    // const fechaHora = editDate + ' ' + editTime + ':00';

    const editedData = new URLSearchParams();
    editedData.append("eventId", eventId);
    editedData.append("editTitleInput", editTitle);
    editedData.append("editSalonInput", editSalon);
    editedData.append("editMenuInput", editMenu);
    editedData.append("editInvitadosInput", editInvitados);
    editedData.append("editDateInput", editDate);

    fetch('updateEventos.php', {
        method: 'POST',
        body: editedData
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log('Server Response:', data);
        
        if (data && data.cupoMaximoExcedido) {
            console.error(data.mensaje);
            alert(data.mensaje);
            console.log(mensaje);
        } else if (data && data.cupoMinimoNoAlcanzado) {
            console.error(data.mensaje);
            alert(data.mensaje); 
            console.log(mensaje);
        } else if (data && data.error) {
            console.error(data.mensaje);
            alert(data.mensaje);
            console.log(mensaje);

        } else {
            console.log("Evento editado exitosamente:", data.mensaje);
            alert("Evento editado exitosamente: " + data.mensaje); 
            filterEvents("PENDIENTE");
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });

});



console.log("Estado filtrado:", state);
console.log("Contenedor de tarjetas:", eventCardsContainer);
console.log("URL de solicitud:", `get_events.php?estado=${state}`);     