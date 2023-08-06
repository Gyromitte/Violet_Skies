<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del empleado desde la solicitud (en este caso, a través de la variable $_GET)
$employeeId = $_GET['id'];

// Realizar la consulta para obtener el historial de eventos del empleado según el ID
$consulta = "SELECT ev.NAME_EVENTO, ev.FECHA_DEL_EVENTO, ev.ID_EVENTO FROM EVENTO_EMPLEADO_FINALIZADOS AS ev
JOIN EMPLEADOS AS emp ON ev.ID_EMPLEADO = emp.ID WHERE emp.CUENTA = $employeeId";

$tabla = $conexion->seleccionar($consulta);

// Obtener el número de eventos en los que ha participado el empleado
$numEventos = count($tabla);

if($numEventos > 0){
    // Mostrar el número de eventos en los que ha participado el empleado
    echo '<h5>Eventos en los que ha participado: ' . $numEventos . '</h5>';
}


// Verificar si se encontraron eventos para el empleado con el ID proporcionado
if (is_countable($tabla) && count($tabla) > 0) {
  // Mostrar la tabla con el historial de eventos del empleado
  echo '<table class="table table-hover mt-3">';
  echo '<thead class="thead-purple">';
  echo '<tr>';
  echo '<th>Nombre del Evento</th>';
  echo '<th>Fecha del Evento</th>';
  echo '<th></th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  foreach ($tabla as $evento) {
    echo "<tr>";
    echo "<td> $evento->NAME_EVENTO </td>";
    echo "<td> $evento->FECHA_DEL_EVENTO </td>";
    echo "<td>";
    echo '<div class="dropdown">';
    echo "<button class='btn-ver-historial btn-secondary dropdown-toggle custom-dropdown' 
    type='button'
    data-bs-whatever='@verDetallesEvento' data-event-id='$evento->ID_EVENTO' >";
    echo '<i class="fa-solid fa-eye"></i> Ver Detalles';
    echo '</button>';

    echo '</div>';
    echo "</td>";
    echo "</tr>";
  }

  echo '</tbody>';
  echo '</table>';
} else {
  // No se encontraron eventos para el empleado con el ID proporcionado
  echo '<p>Este empleado aún no ha participado en ningún evento</p>';
}

$conexion->desconectarBD();
?>
