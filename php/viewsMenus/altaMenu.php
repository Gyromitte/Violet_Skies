<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $tipoMenu = $_POST["tipoMenu"];

    $consulta = "INSERT INTO COMIDAS (NOMBRE, DESCRIPCION, TIPO) VALUES (?, ?, ?)";
    $parametros = array($nombre, $descripcion, $tipoMenu);

    $result = $conexion->ejecutarPreparado($consulta, $parametros);

    if ($result) {
        echo "<div class='alert alert-success mt-4'>Menu agregado exitosamente</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Algo salio mal...</div>";
    }
}

$conexion->desconectarBD();
?>