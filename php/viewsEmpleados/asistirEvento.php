<?php
    include "../dataBase.php";
    $db = new Database();
    $db->conectarBD();
    session_start();
    $emp=$_SESSION["trabajo"];
    $tipo=$_SESSION["tipo"];
    $eventoId = $_GET['id'];

    if($emp=="MESERO"){
        $cant="SELECT DE.MESEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    }
    else{
        $cant="SELECT DE.COCINEROS FROM DETALLE_EVENTO DE WHERE ID='$eventoId'";
    }
    $num= "SELECT COUNT(EE.ID) FROM EVENTO_EMPLEADOS JOIN EMPLEADOS EMP ON EE.EMPLEADOS=EMP.ID
    WHERE EVENTO='$eventoId' AND EMP.TIPO='$tipo'";

    if($num==$cant){
        echo"<div class='alert alert-danger'>Cupo lleno</div>";
    }
    else{
        $enter="INSERT INTO EVENTO_EMPLEADO(EVENTO,EMPLEADOS) VALUES('$eventoId','$emp')";
        echo"<div class='alert alert-success'>Asistiendo!</div>";
    }
    