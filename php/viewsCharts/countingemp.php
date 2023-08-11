<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();
session_start();
$emp=$_SESSION["trabajo"];


$consulta = "CALL verEventosDisponibles(?,?)";
$parametros = array($emp,'porcreacion');

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);

$numdisp=count($tabla);

$consulta = "CALL verEmpAtendiendo(?)";
$parametros = array($emp);

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);

$numASIST=count($tabla);

$consulta = "CALL verSolicitudAsist(?)";
$parametros = array($emp);

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);

$numSolic=count($tabla);



header('Content-Type: application/json');
echo json_encode(array("count_disp" => $numdisp,
    "count_atend" => $numASIST,"count_solic"=>$numSolic));
$conexion->desconectarBD();
?>