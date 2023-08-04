<?php
include_once "../dataBase.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $ap_paterno = $_POST["ap_paterno"];
    $ap_materno = $_POST["ap_materno"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $contraseña = $nombre . rand(1000, 99999);
    $passHash = password_hash($contraseña, PASSWORD_DEFAULT);

    $conexion = new Database();
    $conexion->conectarBD();

    $sql = "INSERT INTO CUENTAS (NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO, CORREO, CONTRASEÑA, TIPO_CUENTA) 
    VALUES ('$nombre', '$ap_paterno', '$ap_materno', '$telefono', '$correo', '$passHash', 'ADMINISTRADOR')";

    $resultado = $conexion->ejecutarSQL($sql);
    if ($resultado === TRUE) {
        echo "El administrador se registró correctamente";
    } else {
        echo "Error al registrar al administrador" . mysqli_error();
    }

    $conexion->desconectarBD();
}
?>
