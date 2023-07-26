// Datos para las cards (puedes modificar estos valores)
const cardsData = [
    {
      imageUrl: 'imagen1.jpg',
      cosas: ['cosa 1', 'cosa 2', 'cosa 3', 'cosa 4'],
    },
    {
      imageUrl: 'imagen2.jpg',
      cosas: ['cosa 1', 'cosa 2', 'cosa 3', 'cosa 4'],
    },
    // Puedes agregar más objetos aquí para más cards
  ];
  
  // Función para crear las cards
  function createCard(cardData) {
    const cardDiv = document.createElement('div');
    cardDiv.className = 'card';
  
    const image = document.createElement('img');
    image.src = cardData.imageUrl;
    cardDiv.appendChild(image);
  
    const ul = document.createElement('ul');
    cardData.cosas.forEach(cosa => {
      const li = document.createElement('li');
      li.textContent = cosa;
      ul.appendChild(li);
    });
    cardDiv.appendChild(ul);
  
    return cardDiv;
  }
  
  // Función para mostrar las cards en la página
  function displayCards() {
    const cardContainer = document.getElementById('cardContainer');
    cardsData.forEach(cardData => {
      const card = createCard(cardData);
      cardContainer.appendChild(card);
    });
  }
  
  // Llama a la función para mostrar las cards cuando la página esté cargada
  document.addEventListener('DOMContentLoaded', displayCards);
  