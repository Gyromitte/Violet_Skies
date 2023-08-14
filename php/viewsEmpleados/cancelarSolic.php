<?php
    include "../dataBase.php";
    $db = new Database();
    $db->conectarBD();
    session_start();
    $emp=$_SESSION["trabajo"];
    $tipo=$_SESSION["tipo"];
    $eventoId = $_POST['eventoId'];
    $cantResult = null;

    $currentDate = date('Y-m-d');

    $currentDateTime = new DateTime($currentDate);

    $consulta="SELECT DATE_FORMAT(E.F_EVENTO, '%Y-%m-%d') AS FECHA FROM EVENTO E WHERE 
    E.ID= '$eventoId'";
    $fechaevento=$db->seleccionar($consulta);

    foreach($fechaevento as $fecha){
        $eventoDate= new datetime($fecha->FECHA);

        $threeMonthsAgo = $eventoDate->modify('-2 days');
        $currentDateStr = $currentDateTime->format('Y-m-d');
        $threeMonthsAgoStr = $threeMonthsAgo->format('Y-m-d');
    
        
    if ($currentDate > $threeMonthsAgoStr) {
        echo"<div class='alert alert-danger'>No se puede cancelar, ya faltan menos de 2 dias para el evento</div>";
    } 
    else {
        $enter="DELETE FROM SOLICITUDES_EMPLEADO WHERE EVENTO='$eventoId' AND EMPLEADO='$emp'";
        $db->ejecutarSQL($enter);
        echo"<div class='alert alert-success'>Cancelado!</div>";
    }
    }

$db->desconectarBD();