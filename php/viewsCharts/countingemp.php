<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();
session_start();
$emp=$_SESSION["trabajo"];
$modo=$_SESSION['tipo'];
if($modo=='COCINERO'){
    $modo='COCINA';
}


$consulta = "CALL verEventosDisponibles(?,?)";
$parametros = array($emp,'porcreacion');

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);
$numdisp=count($tabla);
foreach($tabla as $registro){
    $evento=$registro->ID;
    if($registro->MESEROS=='' && $registro->COCINEROS==''){
        $numdisp--;
    }
    else if($modo == 'MESERO' && $registro->MESEROS === "0/0"){
        $numdisp--; // Skip this event if MESEROS are already fulfilled
    }
    else if($modo == 'COCINA' && $registro->COCINEROS === "0/0"){
        $numdisp--;
    } // Skip this event if COCINEROS are already fulfilled
    else{
    $consulta="SELECT COUNT(*) as cant FROM EVENTO_EMPLEADOS WHERE EVENTO = '$evento' AND EMPLEADOS 
    IN (SELECT ID FROM EMPLEADOS WHERE TIPO='$modo')";
    $cant=$conexion->seleccionar($consulta);
    foreach($cant as $many){
        $people=$many->cant;
        $cantm="SELECT MESEROS,COCINEROS FROM DETALLE_EVENTO WHERE ID='$evento'";
        $cantm=$conexion->seleccionar($cantm);
        foreach($cantm as $numdetails){
            if($modo == 'MESERO' && $people == $numdetails->MESEROS){
                $numdisp--; // Skip this event if MESEROS are already fulfilled
            }
            else if($modo == 'COCINA' && $people == $numdetails->COCINEROS){
                $numdisp--;
            }        
        }
    }
    }
}

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