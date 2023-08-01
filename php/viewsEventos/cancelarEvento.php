<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$eventoId = $_GET['id']; 

// Consulta para actualizar el estado del evento a "CANCELADO"
$consulta = "UPDATE EVENTO SET ESTADO = 'CANCELADO' WHERE ID = $eventoId";
$resultado = $conexion->ejecutarSQL($consulta);

if ($resultado) {
  // Evento cancelado exitosamente
  header('Content-Type: application/json');
  echo json_encode(array('success' => 'Evento cancelado exitosamente'));
} else {
  // Error al cancelar el evento
  header('Content-Type: application/json');
  echo json_encode(array('error' => 'Error al cancelar el evento'));
}

$conexion->desconectarBD();
?>