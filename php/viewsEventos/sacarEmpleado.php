<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$empleadoID = $_GET['id']; 
$eventoId = $_GET['eventoId']; 

// Consulta para actualizar el estado del evento a "CANCELADO"
$consulta = "UPDATE SOLICITUDES_EMPLEADO SET ACEPTADO = 0 WHERE EVENTO = $eventoId AND EMPLEADO = $empleadoID";
$resultado = $conexion->ejecutarSQL($consulta);

if ($resultado) {
  // Evento cancelado exitosamente
  header('Content-Type: application/json');
  echo json_encode(array('success' => 'Empleado retirado del evento'));
} else {
  // Error al cancelar el evento
  header('Content-Type: application/json');
  echo json_encode(array('error' => 'Error al retirar empleado'));
}

$conexion->desconectarBD();
?>