// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');

// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open');
}

// Asignar evento de clic al botón
toggleDashboardBtn.addEventListener('click', toggleDashboard);

// Agregar evento de clic al documento para cerrar el dashboard cuando se haga clic fuera de él
document.addEventListener('click', function(event) {
  const targetElement = event.target;
  if (!targetElement.closest('#dash-board') && !targetElement.closest('#nav-button')) {
    // Si el clic no es dentro del dashboard ni en el botón de la navbar, cerrar el dashboard
    dashboard.classList.remove('dashboard-open');
    main.classList.remove('main-dash-open');
  }
});

// Agregar evento de scroll al documento para cerrar el dashboard cuando se haga scroll
document.addEventListener('scroll', function() {
  if (dashboard.classList.contains('dashboard-open')) {
    dashboard.classList.remove('dashboard-open');
    main.classList.remove('main-dash-open');
  }
});






