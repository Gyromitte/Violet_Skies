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
        };

        function createEventCard(event) {
            const card = document.createElement("div");
            card.classList.add("card");

            const salonId = event.ID_SALON;
            if (salonImageUrls.hasOwnProperty(salonId)) {
                const image = document.createElement("img");
                image.src = salonImageUrls[salonId];
                card.appendChild(image);
            }

            card.innerHTML += `
                <p class="event-id">${event.ID_EVENTO}</p>
                <h2>${event['NOMBRE DEL EVENTO']}</h2>
                <p>Fecha: ${event['FECHA DEL EVENTO']}</p>
                <p>Menú: ${event['MENÚ']}</p>
                <p>Cliente: ${event['NOMBRE DEL CLIENTE']}</p>
                <p>Estado: ${event.ESTADO}</p>
            `;

            return card;
        }

        window.onload = function() {
            const state = "PENDIENTE";

            fetch(`get_events.php?estado=${state}`)
                .then(response => response.json())
                .then(events => {
                    events.forEach(event => {
                        const card = createEventCard(event);
                        eventCardsContainer.appendChild(card);
                    });
                })
                .catch(error => console.error('Error al obtener los eventos:', error));
        };