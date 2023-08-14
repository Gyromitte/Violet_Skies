<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();
session_start();
$emp=$_SESSION["trabajo"];

$consulta = "CALL verEventosFinalizados(?)";
$parametros = array($emp);

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);
$eventosPorMes = array_fill(0, 12, 0); 
foreach ($tabla as $finales) {
    $eventoDate = new DateTime($finales->F_EVENTO);
    $monthNumber = intval($eventoDate->format('m'));
    $eventosPorMes[$monthNumber - 1] += 1;

}

header('Content-Type: application/json');
echo json_encode($eventosPorMes);
$conexion->desconectarBD();
?>