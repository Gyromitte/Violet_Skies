
   // Obtener los botones por su ID
const homeButton = document.getElementById('home-button');
const eventosButton = document.getElementById('eventos-button');
const empleadosButton = document.getElementById('empleados-button');
const perfilButton = document.getElementById('perfil-button');
const configuracionButton = document.getElementById('configuracion-button');

// Agregar event listeners a los botones para escuchar el clic y redirigir al usuario
homeButton.addEventListener('click', function() {
  window.location.href = '/index.html'; // Redirigir a la página "index.html"
});

eventosButton.addEventListener('click', function() {
  window.location.href = '/nosotros.html'; // Redirigir a la página "nosotros.html"
});

empleadosButton.addEventListener('click', function() {
  window.location.href = '/empleados.html'; // Redirigir a la página "empleados.html"
});

perfilButton.addEventListener('click', function() {
  window.location.href = '/acceder.html'; // Redirigir a la página "acceder.html"
});

configuracionButton.addEventListener('click', function() {
  window.location.href = '/registrarse.html'; // Redirigir a la página "registrarse.html"
});

// Agregar un event listener al botón para escuchar el clic
eventosButton.addEventListener('click', function() {
  // Redirigir a la página destino cuando se haga clic en el botón
  window.location.href = 'ruta_de_la_pagina_destino';
});