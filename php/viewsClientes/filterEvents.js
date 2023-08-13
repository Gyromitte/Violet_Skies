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
    card.appendChild(menu);
    card.appendChild(invitados);
    card.appendChild(cancelButton);


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
        const passwordInput = document.getElementById("password"); // Agregamos esto
        const modal = document.getElementById("cancelModal");
        cancelMessage.style.visibility = "visible";

        cancelMessage.textContent = message;
        cancelMessage.classList.add("alert", "alert-success", "d-flex", "justify-content-center");
        
        if (message.includes("cancelado correctamente")) {
            setTimeout(() => {
                modal.style.display = "none"; 
                passwordInput.value = "";
                cancelMessage.textContent = ""; 
                filterEvents("PENDIENTE");
            }, 1500);
        }
    })
    .catch(error => {
        console.error("Error al cancelar el evento:", error);
    });
});
filterEvents("PENDIENTE");