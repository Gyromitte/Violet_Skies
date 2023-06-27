// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');

// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  console.log("Clickeado!");
}

// Asignar evento de clic al botón
toggleDashboardBtn.addEventListener('click', toggleDashboard);