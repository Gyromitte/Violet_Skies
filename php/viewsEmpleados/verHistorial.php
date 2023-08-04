<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del empleado desde la solicitud (en este caso, a través de la variable $_GET)
$employeeId = $_GET['id'];

// Realizar la consulta para obtener el historial de eventos del empleado según el ID
$consulta = "SELECT NAME_EVENTO, FECHA_DEL_EVENTO FROM EVENTO_EMPLEADO_FINALIZADOS WHERE ID_EMPLEADO = $employeeId";

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
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  foreach ($tabla as $evento) {
    echo "<tr>";
    echo "<td> $evento->NAME_EVENTO </td>";
    echo "<td> $evento->FECHA_DEL_EVENTO </td>";
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
