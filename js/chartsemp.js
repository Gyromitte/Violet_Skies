//Cards del home (peticion a countAll.php)
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
// Parsear la respuesta JSON
var data = JSON.parse(this.responseText);
// Actualizar el contenido de las cards con los datos recibidos
document.getElementById("DispCard").innerHTML = data.count_disp;
document.getElementById("AsistCard").innerHTML = data.count_atend;
}
}
xhttp.open("GET", "/php/viewsCharts/countingemp.php", true);
xhttp.send();