<?php
include_once "../dataBase.php";
// Verificar si se recibieron los datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos enviados desde el formulario
    $nombre = $_POST["nombre"];
    $ap_paterno = $_POST["ap_paterno"];
    $ap_materno = $_POST["ap_materno"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    //contraseña
    $contraseña = $_POST["rfc"];
    $passHash = password_hash($contraseña, PASSWORD_DEFAULT);
    //tipo_cuenta

    $conexion = new Database();
    $conexion->conectarBD();

    // Preparar la consulta SQL para insertar al nuevo administrador en la tabla
    $sql = "INSERT INTO CUENTAS (NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO, CORREO, CONTRASEÑA, TIPO_CUENTA) 
    VALUES ('$nombre', '$ap_paterno', '$ap_materno', '$telefono', '$correo', '$passHash', 'ADMINISTRADOR')";

    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($conexion->ejecutarSQL($sql) === TRUE) {
        echo "El administrador se registró correctamente";
    } else {
        echo "Error al registrar al administrador" ;
    }

    // Cerrar la conexión a la base de datos
    $conexion->desconectarBD();
}
?>
