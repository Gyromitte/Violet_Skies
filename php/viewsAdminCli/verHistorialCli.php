<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del empleado desde la solicitud (en este caso, a través de la variable $_GET)
$employeeId = $_GET['id'];

// Realizar la consulta para obtener el historial de evenos del cliente segun el ID
$consulta = "SELECT ID, NOMBRE, F_EVENTO, ESTADO
FROM EVENTO
WHERE CLIENTE = $employeeId AND (ESTADO = 'FINALIZADO' OR ESTADO = 'CANCELADO');
";

$tabla = $conexion->seleccionar($consulta);

// Obtener el número de eventos en los que ha participado el empleado
$numEventos = count($tabla);

if($numEventos > 0){
    // Mostrar el número de eventos relacionados al cliente
    echo '<h5>Eventos relacionados al cliente: ' . $numEventos . '</h5>';
}


// Verificar si se encontraron eventos para el empleado con el ID proporcionado
if (is_countable($tabla) && count($tabla) > 0) {
  // Mostrar la tabla con el historial de eventos del empleado
  echo '<table class="table table-hover mt-3">';
  echo '<thead class="thead-purple">';
  echo '<tr>';
  echo '<th>Nombre del Evento</th>';
  echo '<th>Fecha del Evento</th>';
  echo '<th>Estado</th>';
  echo '<th></th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  foreach ($tabla as $evento) {
    echo "<tr>";
    echo "<td> $evento->NOMBRE</td>";
    echo "<td> $evento->F_EVENTO </td>";
    echo "<td> $evento->ESTADO </td>";
    echo "<td>";
    echo '<div class="dropdown">';
    echo "<button class='btn-ver-historial btn-secondary custom-ver-historial' 
    type='button'
    data-bs-whatever='@verDetallesEvento' data-event-id='$evento->ID' >";
    echo '<i class="fa-solid fa-eye"></i>';
    echo '</button>';

    echo '</div>';
    echo "</td>";
    echo "</tr>";
  }

  echo '</tbody>';
  echo '</table>';
} else {
  // No se encontraron eventos para el empleado con el ID proporcionado
  echo '<p>Este cliente no tiene precedentes</p>';
}

$conexion->desconectarBD();
?>
