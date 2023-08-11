const eventCardsContainer = document.getElementById("event-cards");

const salonImageUrls = {
    1: '/images/salones/salon1.jpg',
    2: '/images/salones/salon1.jpg',
    3: '/images/salones/salon2.jpg',
    4: '/images/salones/salon2.jpg',
    5: '/images/salones/salon2.jpg',
    6: '/images/salones/salon3.jpg',
    7: '/images/salones/salon3.jpg',
    8: '/images/salones/salon3.jpg',
    9: '/images/salones/salon3.jpg',
    10: '/images/salones/salon5.jpg',
    11: '/images/salones/salon5.jpg'
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
    eventId.classList.add("hidden"); // Agregar una clase para ocultar el elemento

    const title = document.createElement("h2");
    title.textContent = event['NOMBRE DEL EVENTO'];

    const date = document.createElement("p");
    date.textContent = `Fecha: ${event['FECHA DEL EVENTO']}`;

    const menu = document.createElement("p");
    menu.textContent = `Menú: ${event['MENÚ']}`;

    const client = document.createElement("p");
    client.textContent = `Cliente: ${event['NOMBRE DEL CLIENTE']}`;

    const state = document.createElement("p");
    state.textContent = `Estado: ${event.ESTADO}`;

    const cancelButton = document.createElement("button");
    cancelButton.textContent = "Cancelar Evento";
    if (event.ESTADO !== "FINALIZADO" && event.ESTADO !== "CANCELADO") {
        cancelButton.classList.add("btn-modal-warning");
        cancelButton.addEventListener("click", () => openCancelModal(event.ID_EVENTO));
        card.appendChild(cancelButton);
    } else {
        cancelButton.style.display = "none"; // Ocultar el botón en caso de estados "FINALIZADO" o "CANCELADO"
    }

    card.appendChild(eventId);
    card.appendChild(title);
    card.appendChild(date);
    card.appendChild(menu);
    card.appendChild(client);
    card.appendChild(state);
    card.appendChild(cancelButton);


    return card;
}

function openCancelModal(eventId) {
    const modal = document.getElementById("cancelModal");
    const eventIDInput = document.getElementById("eventIDInput");

    eventIDInput.value = eventId;
    modal.style.display = "block";
    passwordInput.value = "";
}
document.querySelector(".close").addEventListener("click", () => {
    const modal = document.getElementById("cancelModal");
    modal.style.display = "none";
    
});

function filterEvents(state) {
    eventCardsContainer.innerHTML = "";

    fetch(`get_events.php?estado=${state}`)
        .then(response => response.json())
        .then(events => {
            events.forEach(event => {
                const card = createEventCard(event);
                eventCardsContainer.appendChild(card);
            });
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
        cancelMessage.textContent = message;

        const modal = document.getElementById("cancelModal");

        if (message.includes("cancelado correctamente")) {
            setTimeout(() => {
                modal.style.display = "none"; 
                location.reload();
            }, 3000);
        }
    })
    .catch(error => {
        console.error("Error al cancelar el evento:", error);
    });
});
filterEvents("PENDIENTE");