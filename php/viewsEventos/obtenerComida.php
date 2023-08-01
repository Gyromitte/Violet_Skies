<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$consulta = "SELECT ID, NOMBRE FROM COMIDAS";
$salones = $conexion->seleccionar($consulta);

// Devolver los salones disponibles en formato JSON
header('Content-Type: application/json');
echo json_encode($salones);

$conexion->desconectarBD();
?>
