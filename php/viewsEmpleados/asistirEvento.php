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
    foreach($countResult as $res){
    $count = $res->count;

    if ($count >= $cant) {
        echo "<div class='alert alert-danger'>Cupo lleno</div>";
    }
    else{
        $consulta="SELECT DATE_FORMAT(E.F_EVENTO, '%Y-%m-%d') as FECHA FROM EVENTO E WHERE E.ID='$eventoId'";
        $evendate=$db->seleccionar($consulta);
        foreach($evendate as $evendates){
        $date = $evendates->FECHA;

        $checkemp="SELECT * FROM EVENTO_EMPLEADOS EE WHERE EE.EVENTO='$eventoId'
        AND EE.EMPLEADOS='$emp'";
        $imin=$db->seleccionar($checkemp);

        $time = "SELECT DATE_FORMAT(E.F_EVENTO, '%Y-%m-%d') as FECHA FROM EVENTO E JOIN 
        EVENTO_EMPLEADOS EE ON E.ID = EE.EVENTO
        WHERE EE.EMPLEADOS = '$emp'";

        $attendedEvents = $db->seleccionar($time);

// Check if the user has already attended an event on the same day as the event they want to attend
        $alreadyAttendedEvent = false;
        foreach ($attendedEvents as $attendedEvent) {
            if ($attendedEvent->FECHA == $date) {
                $alreadyAttendedEvent = true;
                break;
            }
        }
        if(count($imin) == 1){
            echo "<div class='alert alert-danger'> Ya estas dentro de este evento</div>";
            exit;
        }
        else if ($alreadyAttendedEvent) {
            echo "<div class='alert alert-danger'> Ya tienes evento dentro de este fecha</div>";
            exit;
        }
        else{
            
        $enter="INSERT INTO EVENTO_EMPLEADOS(EVENTO,EMPLEADOS) VALUES('$eventoId','$emp')";
        $db->ejecutarInsert($enter);
        }
    }
    }
    }


$db->desconectarBD();
?>
