<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se recibieron los datos de RFC y tipo
if (isset($_POST['rfc']) && isset($_POST['id'])
    && isset($_POST['nombre']) && isset($_POST['ap_paterno']) && isset($_POST['ap_materno'])
    && isset($_POST['telefono']) && isset($_POST['tipoUsuario'])) {
    // Obtener los datos del empleado desde la solicitud
    $nombre = $_POST['nombre'];
    $ap_paterno = $_POST['ap_paterno'];
    $ap_materno = $_POST['ap_materno'];
    $telefono = $_POST['telefono'];
    $employeeId = $_POST['id'];
    $rfc = strtoupper($_POST['rfc']); // Convertir a mayúsculas para homogeneizar
    $tipoUsuario = trim($_POST['tipoUsuario']);

    // Variable para almacenar el mensaje de error
    $errorMessage = "";

    // Verificar longitud
    if (strlen($rfc) < 13) {
        $errorMessage = "El RFC es demasiado -corto- debe tener exactamente 13 caracteres.";
    } elseif (strlen($rfc) > 13) {
        $errorMessage = "El RFC es demasiado -largo- debe tener exactamente 13 caracteres.";
    } else {
        // Verificar caracteres inválidos
        if (!preg_match('/^[A-Z0-9]+$/', $rfc)) {
            $errorMessage = "El RFC solo puede contener letras mayúsculas y dígitos numéricos.";
        } else {
            // Verificar formato
            if (!preg_match('/^[A-Z]{4}\d{6}[A-Z0-9]{3}$/', $rfc)) {
                $errorMessage = "El formato del RFC es inválido. Debe ser del tipo AAAA123456XXX, 
                donde AAAA son las primeras cuatro letras del apellido, 123456 representa la fecha de nacimiento (YYMMDD)
                y XXX es la homoclave.";
            }
        }
    }

    // Mostrar el mensaje de error si existe
    if (!empty($errorMessage)) {
        echo "<div class='alert alert-danger'>$errorMessage</div>";
    } else {
        // El RFC tiene el formato correcto, realizar la consulta para actualizar los datos del empleado
        $actualizar =  "UPDATE EMPLEADOS AS E
        INNER JOIN CUENTAS AS C ON E.CUENTA = C.ID
        SET E.RFC = '$rfc', E.TIPO = '$tipoUsuario',
            C.NOMBRE = '$nombre', C.AP_PATERNO = '$ap_paterno', C.AP_MATERNO = '$ap_materno', C.TELEFONO = '$telefono'
        WHERE E.CUENTA = '$employeeId'"; //Este id debería ser el de la cuenta
        $conexion->ejecutarSQL($actualizar);
        //Respuesta de exito
        echo "<div class='alert alert-success'>Cambios aplicados exitosamente!</div>";
    }
} else {
    // Faltan datos en la solicitud
    echo "<div class='alert alert-danger'>Falta información en la solicitud.</div>";
}

$conexion->desconectarBD();
?>
