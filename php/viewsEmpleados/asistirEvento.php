<?php
    include "../dataBase.php";
    $db = new Database();
    $db->conectarBD();
    session_start();
    $emp=$_SESSION["trabajo"];
    $tipo=$_SESSION["tipo"];
    $eventoId = $_GET['id'];

    if($tipo=="MESERO"){
        $cant="SELECT DE.MESEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    }
    else if($tipo=="COCINERO"){
        $cant="SELECT DE.COCINEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    }
    $consulta=$db->seleccionar($cant);
    if($consulta){
        if($tipo=="MESERO"){
    $num= "SELECT COUNT(EE.ID) FROM EVENTO_EMPLEADOS EE JOIN EMPLEADOS EMP ON EE.EMPLEADOS=EMP.ID
    WHERE EE.EVENTO='$eventoId' AND EMP.TIPO='$tipo'";
        }
        else{
            $num= "SELECT COUNT(EE.ID) FROM EVENTO_EMPLEADOS EE JOIN EMPLEADOS EMP ON EE.EMPLEADOS=EMP.ID
            WHERE EE.EVENTO='$eventoId' AND EMP.TIPO='COCINA'";
        }
    $consulta=$db->seleccionar($num);
    $large=count($consulta);
    if($tipo=="MESERO"){
    if($large==$consulta[0]->MESEROS){
        echo"<div class='alert alert-danger'>Cupo lleno</div>";
        }
    }
    else if($tipo=="COCINERO"){
        if($large==$consulta[0]->COCINEROS){
            echo"<div class='alert alert-danger'>Cupo lleno</div>";
            }
    }
    else{
        $consulta="SELECT E.F_EVENTO FROM EVENTO E WHERE E.ID='$eventoId'";
        $evendate=$db->seleccionar($consulta);
        foreach($evendate as $other){
            $date=$other[0]->F_EVENTO;
        $time = "SELECT F_EVENTO FROM EVENTO E JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EVENTO
        WHERE EE.EMPLEADOS = '$emp'";

        $attendedEvents = $conexion->seleccionar($time);

// Check if the user has already attended an event on the same day as the event they want to attend
        $alreadyAttendedEvent = false;
        foreach ($attendedEvents as $attendedEvent) {
            if ($attendedEvent[0]->F_EVENTO == $date) {
                $alreadyAttendedEvent = true;
                break;
            }
        }
        }

// If the user has already attended an event on the same day, display an error message
        if ($alreadyAttendedEvent) {
            echo "<div class='alert alert-danger'> Ya tienes evento dentro de este fecha</div>";
    // For example: header("Location: some_other_page.php");
        exit;
    }

        $enter="INSERT INTO EVENTO_EMPLEADO(EVENTO,EMPLEADOS) VALUES('$eventoId','$emp')";
        echo"<div class='alert alert-success'>Asistiendo!</div>";
    }
}
$db->desconectarBD();
?>
