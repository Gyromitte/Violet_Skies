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

$consulta = "CALL verEmpAtendiendo(?)";
$parametros = array($emp);
$tabla = $conexion->seleccionarPreparado($consulta, $parametros);

// Find the closest date from the fetched data
$closestDate = null;
$currentDate = date('Y-m-d'); // Current date
$num=count($tabla);
if($num==0){
    $closestDate="No Tienes";
}
foreach ($tabla as $evento) {
    $eventoDate = $evento->F_EVENTO;
    
    if ($closestDate === null || abs(strtotime($closestDate) - strtotime($currentDate)) > abs(strtotime($eventoDate) - strtotime($currentDate))) {
        $closestDate = $eventoDate;
    }
}

// Now $closestDate holds the closest date





header('Content-Type: application/json');
echo json_encode(array("count_disp" => $numdisp,
    "count_atend" => $numASIST,"count_solic"=>$numSolic,
    "fecha"=>$closestDate));
$conexion->desconectarBD();
?>