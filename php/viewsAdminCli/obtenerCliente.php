<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del menu desde la solicitud (en este caso, a través de la variable $_GET)
$clienteId = $_GET['id'];

// Realizar la consulta para obtener los datos del cliente según el ID
$consulta = "SELECT c.NOMBRE, c.AP_PATERNO, c.AP_MATERNO, c.CORREO, c.TELEFONO FROM CUENTAS c 
WHERE c.ID = $clienteId";

$tabla = $conexion->seleccionar($consulta);

// Verificar si se encontró un CLIENTE con el ID proporcionado
if (is_countable($tabla) && count($tabla) > 0) {
  $cliente = (array) $tabla[0];
  // Devolver los datos del CLIENTE en formato JSON
  header('Content-Type: application/json');
  echo json_encode($cliente);
} else {
  // No se encontró un CLIENTE con el ID proporcionado
  header('Content-Type: application/json');
  echo json_encode(null);
}
$conexion->desconectarBD();
?>