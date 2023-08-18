<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del empleado desde la solicitud (en este caso, a través de la variable $_GET)
$employeeId = $_GET['id'];

// Realizar la consulta para obtener los datos del empleado según el ID
$consulta = "SELECT E.ID, C.NOMBRE, C.AP_PATERNO, C.AP_MATERNO, E.RFC, C.TELEFONO, C.CORREO, E.TIPO, E.CUENTA
             FROM EMPLEADOS E
             INNER JOIN CUENTAS C ON E.CUENTA = C.ID
             WHERE E.CUENTA = '$employeeId'";

$tabla = $conexion->seleccionar($consulta);

// Verificar si se encontró un empleado con el ID proporcionado
if (is_countable($tabla) && count($tabla) > 0) {
  $empleado = (array) $tabla[0];
  // Devolver los datos del empleado en formato JSON
  header('Content-Type: application/json');
  echo json_encode($empleado);
} else {
  // No se encontró un empleado con el ID proporcionado
  header('Content-Type: application/json');
  echo json_encode(null);
}
$conexion->desconectarBD();
?>

