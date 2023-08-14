<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Ejecutar el procedimiento almacenado
$sql = "CALL ProporcionTiposComida()";
$resultado = $conexion->seleccionar($sql);

// Crear un arreglo para almacenar las cantidades
$cantidades = array();

foreach ($resultado as $fila) {
    $cantidades[] = $fila->Cantidad;
}

$conexion->desconectarBD();

// Enviar los datos como respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($cantidades);
?>

