<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se recibieron los datos de RFC y tipo
if (isset($_POST['rfc']) && isset($_POST['tipoUsuario']) && isset($_POST['id'])) {
  // Obtener los datos del empleado desde la solicitud
  $employeeId = $_POST['id'];
  $rfc = $_POST['rfc'];
  $tipoUsuario = $_POST['tipoUsuario'];

  // Realizar la consulta para actualizar los datos del empleado
  $actualizar = "UPDATE EMPLEADOS SET RFC='$rfc', TIPO='$tipoUsuario' WHERE CUENTA='$employeeId'"; //Este id debería ser el de la cuenta
  $conexion->ejecutarSQL($actualizar);

  //Respuesta de exito
echo "<div class='alert alert-success'>Cambios aplicados exitosamente!</div>";
} else {
  //Nambre mijo no valemos...
  echo "<div class='alert alert-danger'>Algo salio mal (?)</div>";
}

$conexion->desconectarBD();
?>
