/*Funcionamiento de la dashboard*/
// Obtener elementos
const toggleDashboardBtn = document.getElementById('nav-button');
const dashboard = document.getElementById('dash-board');
const main = document.getElementById('main');
// Función para abrir o cerrar el dashboard
function toggleDashboard() {
  dashboard.classList.toggle('dashboard-open');
  main.classList.toggle('main-dash-open')
}
// Asignar evento de clic al botón
toggleDashboardBtn.addEventListener('click', toggleDashboard);

/*Fecha*/
var currentDate = new Date();
var day = currentDate.getDate();
var month = currentDate.getMonth() + 1; // Los meses en JavaScript comienzan desde 0
var year = currentDate.getFullYear();
// Construir la cadena de la fecha (DD/MM/YYYY)
var formatDate = day + ' / ' + month + ' / ' + year;
document.getElementById('fecha').innerHTML = formatDate;

