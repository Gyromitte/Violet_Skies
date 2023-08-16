<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();
session_start();
$emp = $_SESSION["trabajo"];
$tipo = $_SESSION["tipo"];
$eventoId = $_POST['eventoId'];

// Get the required number of attendees


// Check if the user has already attended an event on the same day
$consulta = "SELECT DATE_FORMAT(E.F_EVENTO, '%Y-%m-%d') as FECHA FROM EVENTO E WHERE E.ID='$eventoId'";
$evendate = $db->seleccionar($consulta);
foreach ($evendate as $evendates) {
    $date = $evendates->FECHA;

    $checkemp = "SELECT * FROM SOLICITUDES_EMPLEADO EE WHERE EE.EVENTO='$eventoId'
    AND EE.EMPLEADO='$emp'";
    $imin = $db->seleccionar($checkemp);

    $time = "SELECT DATE_FORMAT(E.F_EVENTO, '%Y-%m-%d') as FECHA FROM EVENTO E JOIN 
    EVENTO_EMPLEADOS EE ON E.ID = EE.EVENTO
    WHERE EE.EMPLEADOS = '$emp'";

    $attendedEvents = $db->seleccionar($time);

    // Check if the user has already attended an event on the same day
    $alreadyAttendedEvent = false;
    foreach ($attendedEvents as $attendedEvent) {
        if ($attendedEvent->FECHA == $date) {
            $alreadyAttendedEvent = true;
            break;
        }
    }
    if (count($imin) == 1) {
        echo "<div class='alert alert-danger'> Ya mandaste solicitud para este evento</div>";
        $db->desconectarBD();
        exit;
    } else if ($alreadyAttendedEvent) {
        echo "<div class='alert alert-danger'> Ya tienes evento dentro de este fecha</div>";
        $db->desconectarBD();
        exit;
    } else {
        $enter = "INSERT INTO SOLICITUDES_EMPLEADO(EVENTO,EMPLEADO) VALUES('$eventoId','$emp')";
        $db->ejecutarInsert($enter);
    }
}

$db->desconectarBD();
?>
