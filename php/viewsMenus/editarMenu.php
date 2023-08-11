<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se recibieron los datos
if (isset($_POST['nombre']) && isset($_POST['id'])
    && isset($_POST['descripcion']) && isset($_POST['tipoMenu'])) {
    // Obtener los datos del empleado desde la solicitud
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $tipoMenu = $_POST['tipoMenu'];
    $menuId = $_POST['id'];
    // Variable para almacenar el mensaje de error
    $errorMessage = "";

    $actualizar =  "UPDATE COMIDAS AS c SET c.NOMBRE = '$nombre', c.TIPO = '$tipoMenu', c.DESCRIPCION = '$descripcion' 
        WHERE c.ID = '$menuId'";
        $conexion->ejecutarSQL($actualizar);

    echo "<div class='alert alert-success'>Cambios aplicados exitosamente!</div>";
} else {
    // Faltan datos en la solicitud
    echo "<div class='alert alert-danger'>Falta información en la solicitud.</div>";
}

$conexion->desconectarBD();
?>