<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se recibieron los datos de RFC y tipo
if (isset($_POST['nombre']) && isset($_POST['id'])
    && isset($_POST['descripcion']) && isset($_POST['tipoMenu'])) {
    // Obtener los datos del empleado desde la solicitud
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $tipoMenu = $_POST['telefono'];
    $menuId = $_POST['id'];
    // Variable para almacenar el mensaje de error
    $errorMessage = "";

    echo "<div class='alert alert-success'>Cambios aplicados exitosamente!</div>";
} else {
    // Faltan datos en la solicitud
    echo "<div class='alert alert-danger'>Falta información en la solicitud.</div>";
}

$conexion->desconectarBD();
?>