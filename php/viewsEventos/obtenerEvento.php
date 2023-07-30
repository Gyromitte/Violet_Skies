<?php
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    $evento = $_GET['ID'];

    $consulta = "SELECT E.ID, E.NOMBRE FROM EVENTO E WHERE E.ID = '$evento'";

    $tabla = $conexion->seleccionar($consulta);

    if (is_countable($tabla) && count($tabla) > 0) {
        $evento = (array) $tabla[0];
        header('Content-Type: application/json');
        echo json_encode($evento);
    }
    else {
        header('Content-Type: application/json');
        echo json_encode(null);
    }
    $conexion->desconectarBD();
?>