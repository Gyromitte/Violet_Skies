<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$empleadoID = $_GET['id']; 
$eventoId = $_GET['eventoId']; 

$consulta = "UPDATE SOLICITUDES_EMPLEADO SET ACEPTADO = 0 WHERE EVENTO = $eventoId AND EMPLEADO = $empleadoID; CALL ProcesoActualizarTablaEventoEmpleados();";
$resultado = $conexion->ejecutarSQL($consulta);

if ($resultado) {
  $conexion->ejecutarSQL('CALL actualizar_estado_detalle_evento();');
  header('Content-Type: application/json');
  echo json_encode(array('success' => 'Empleado retirado del evento'));
} else {
  header('Content-Type: application/json');
  echo json_encode(array('error' => 'Error al retirar empleado'));
}

$conexion->desconectarBD();
?>