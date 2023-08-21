<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$salon = $_POST['salon'];

$consulta = "SELECT CUPO, MINIMO FROM SALONES WHERE ID = '$salon'";
$salones = $conexion->seleccionar($consulta);

if (!$salones) {
    echo json_encode(array('error' => 'Error en la consulta'));
} else {
    $rows = $salones[0];
    echo json_encode($rows);
}
$conexion->desconectarBD();
?>
