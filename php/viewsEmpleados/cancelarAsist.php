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


    $threeMonthsAgo = $currentDateTime->modify('-3 months');

    $currentDateStr = $currentDateTime->format('Y-m-d');
    $threeMonthsAgoStr = $threeMonthsAgo->format('Y-m-d');

    $consulta="SELECT E.F_EVENTO FROM EVENTO E WHERE E.ID= '$eventoID'";
    
if ($currentDate > $threeMonthsAgoStr) {
    echo "The current date is after 3 months ago.";
} else {
    echo "The current date is on or before 3 months ago.";
}


if($tipo=="MESERO"){
    $cant="SELECT DE.MESEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    $type=$tipo;
}
else if($tipo=="COCINERO"){
    $cant="SELECT DE.COCINEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    $type='COCINA';
}
$cantResult=$db->seleccionar($cant);
    
    $num= "SELECT COUNT(EE.ID) FROM EVENTO_EMPLEADOS EE JOIN EMPLEADOS EMP ON EE.EMPLEADOS=EMP.ID
    WHERE EE.EVENTO='$eventoId' AND EMP.TIPO='$tipo'";

    if($num==$cant){
        echo"<div class='alert alert-danger'>Cupo lleno</div>";
    }
    else{
        $consulta="SELECT E.F_EVENTO FROM EVENTO";
        $enter="DELETE FROM EVENTO_EMPLEADOS WHERE EVENTO='$eventoID' AND 
        EMPLEADO='$emp'";
        echo"<div class='alert alert-success'>Asistiendo!</div>";
    }
?>
   

