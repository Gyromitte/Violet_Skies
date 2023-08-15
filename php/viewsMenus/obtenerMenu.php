<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener el ID del menu desde la solicitud (en este caso, a través de la variable $_GET)
$menuId = $_GET['id'];

// Realizar la consulta para obtener los datos del empleado según el ID
$consulta = "SELECT c.NOMBRE, c.DESCRIPCION, tc.TIPO FROM COMIDAS c 
JOIN TIPO_COMIDAS tc ON c.TIPO = tc.ID WHERE c.ID = $menuId";

$tabla = $conexion->seleccionar($consulta);

// Verificar si se encontró uN MENU con el ID proporcionado
if (is_countable($tabla) && count($tabla) > 0) {
  $menu = (array) $tabla[0];
  // Devolver los datos del MENU en formato JSON
  header('Content-Type: application/json');
  echo json_encode($menu);
} else {
  // No se encontró un MENU con el ID proporcionado
  header('Content-Type: application/json');
  echo json_encode(null);
}
$conexion->desconectarBD();
?>