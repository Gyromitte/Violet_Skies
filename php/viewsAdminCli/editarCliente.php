<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se recibieron los datos
if (isset($_POST['nombre']) && isset($_POST['id'])
    && isset($_POST['telefono']) && isset($_POST['ap_paterno']) && isset($_POST['ap_materno'])) {
    // Obtener los datos del empleado desde la solicitud
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $ap_paterno = $_POST['ap_paterno'];
    $ap_materno = $_POST['ap_materno'];
    $clienteId = $_POST['id'];
    // Variable para almacenar el mensaje de error
    $errorMessage = "";

    $actualizar =  "UPDATE CUENTAS AS c SET c.NOMBRE = '$nombre', c.TELEFONO= '$telefono', c.AP_PATERNO= '$ap_paterno',
        c.AP_MATERNO= '$ap_materno' 
        WHERE c.ID = '$clienteId'";
        $conexion->ejecutarSQL($actualizar);

    echo "<div class='alert alert-success'>Cambios aplicados exitosamente!</div>";
} else {
    // Faltan datos en la solicitud
    echo "<div class='alert alert-danger'>Falta información en la solicitud.</div>";
}

$conexion->desconectarBD();
?>