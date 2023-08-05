<?php
include_once "../dataBase.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $ap_paterno = $_POST["ap_paterno"];
    $ap_materno = $_POST["ap_materno"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $conexion = new Database();
    $conexion->conectarBD();

    $consulta = "SELECT COUNT(*) as cuenta FROM CUENTAS WHERE CORREO = '$correo'";
    $resultadoConsulta = $conexion->seleccionar($consulta);
    if (!$resultadoConsulta) {
        $response = array("mensaje" => "Error al verificar el correo");
        echo json_encode($response);
        exit; // Detener el script
    }

    $fila = $resultadoConsulta[0];

    if (is_object($fila)) {
        $fila = (array) $fila;
    }
    
    if ($fila["cuenta"] > 0) {
        $response = array("Ya existe una cuenta con el mismo correo");
        echo json_encode($response);
    } else {
        $contraseña = $nombre . rand(1000, 99999);
        $passHash = password_hash($contraseña, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO CUENTAS (NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO, CORREO, CONTRASEÑA, TIPO_CUENTA) 
        VALUES ('$nombre', '$ap_paterno', '$ap_materno', '$telefono', '$correo', '$passHash', 'ADMINISTRADOR')";
    
        $resultado = $conexion->ejecutarSQL($sql);
        if ($resultado !== FALSE) {
            $response = array("mensaje" => "El administrador se registró correctamente", "correo" => $correo, "contraseña" => $contraseña);
            echo json_encode($response);
        } else {
            $response = array("mensaje" => "Error al registrar al administrador");
            echo json_encode($response);
        }
    }
    $conexion->desconectarBD();
}
?>