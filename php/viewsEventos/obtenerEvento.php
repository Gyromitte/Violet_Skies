<?php
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    $evento = $_GET['id'];

    $consulta = "SELECT E.ID, E.NOMBRE,E.F_EVENTO FROM EVENTO E WHERE E.ID = '$evento'";

    $tabla = $conexion->seleccionar($consulta);

    if (count($tabla) > 0) {
        $evento = (array) $tabla[0];
        echo json_encode($evento);
    }
    else {
        echo json_encode(array('error' => 'Evento no encontrado'));
    }
    header('Content-Type: application/json');
    $conexion->desconectarBD();
?>
