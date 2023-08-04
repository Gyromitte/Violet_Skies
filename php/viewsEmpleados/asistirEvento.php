<?php
    include "../dataBase.php";
    $db = new Database();
    $db->conectarBD();
    session_start();
    $emp=$_SESSION["trabajo"];
    $tipo=$_SESSION["tipo"];
    $eventoId = $_POST['eventoId'];
    $cantResult = null;

    if($tipo=="MESERO"){
        $cant="SELECT DE.MESEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
        $type=$tipo;
    }
    else if($tipo=="COCINERO"){
        $cant="SELECT DE.COCINEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
        $type='COCINA';
    }
    $cantResult=$db->seleccionar($cant);

    

    if ($type=='MESERO'){
        if (!$cantResult || count($cantResult) === 0 || !isset($cantResult[0]->MESEROS)) {
            echo "<div class='alert alert-danger'>Error al obtener el número de asistentes requeridos</div>";
            $db->desconectarBD();
            exit;
        }
        $cant = $cantResult[0]->MESEROS;
    }
    else{
        if (!$cantResult || count($cantResult) === 0 || !isset($cantResult[0]->COCINEROS)) {
            echo "<div class='alert alert-danger'>Error al obtener el número de asistentes requeridos</div>";
            $db->desconectarBD();
            exit;
        }
        $cant = $cantResult[0]->COCINEROS;
    }
    $numQuery = "SELECT COUNT(EE.ID) AS count FROM EVENTO_EMPLEADOS EE 
    JOIN EMPLEADOS EMP ON EE.EMPLEADOS=EMP.ID
    WHERE EE.EVENTO='$eventoId' AND EMP.TIPO='$type'";
    $countResult = $db->seleccionar($numQuery);
    $count = $countResult[0]->count;

    if ($count >= $cant) {
        echo "<div class='alert alert-danger'>Cupo lleno</div>";
    }
    else{
        $consulta="SELECT E.F_EVENTO FROM EVENTO E WHERE E.ID='$eventoId'";
        $evendate=$db->seleccionar($consulta);
        $date = $evendate[0]->F_EVENTO;

        $time = "SELECT F_EVENTO FROM EVENTO E JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EVENTO
        WHERE EE.EMPLEADOS = '$emp'";

        $attendedEvents = $db->seleccionar($time);

// Check if the user has already attended an event on the same day as the event they want to attend
        $alreadyAttendedEvent = false;
        foreach ($attendedEvents as $attendedEvent) {
            if ($attendedEvent->F_EVENTO == $date) {
                $alreadyAttendedEvent = true;
                break;
            }
        }
        if ($alreadyAttendedEvent) {
            echo "<div class='alert alert-danger'> Ya tienes evento dentro de este fecha</div>";
            exit;
        }
        $enter="INSERT INTO EVENTO_EMPLEADOS(EVENTO,EMPLEADOS) VALUES('$eventoId','$emp')";
        $db->ejecutarSQL($enter);       
        echo"<div class='alert alert-success'>Asistiendo!</div>";

    }


$db->desconectarBD();
?>
