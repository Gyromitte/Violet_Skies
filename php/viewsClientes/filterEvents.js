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

 



    card.appendChild(title);
    card.appendChild(date);
    card.appendChild(menu);
    card.appendChild(client);
    card.appendChild(state);

    return card;
}

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

filterEvents("PENDIENTE");
