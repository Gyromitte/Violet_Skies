<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener los datos del formulario mediante una solicitud POST
$rfc = filter_input(INPUT_POST, 'rfc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$tipoUsuario = filter_input(INPUT_POST, 'tipoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Función para mostrar mensajes de error
function mostrarError($mensaje) {
    echo "<div class='alert alert-danger'>$mensaje</div>";
    global $db;
    $db->desconectarBD();
    exit;
}

// Verificar el formato del RFC
$rfc = strtoupper($rfc); // Convertir a mayúsculas para homogeneizar
if (strlen($rfc) < 13) {
    mostrarError("El RFC es demasiado corto, debe tener exactamente 13 caracteres.");
} elseif (strlen($rfc) > 13) {
    mostrarError("El RFC es demasiado largo, debe tener exactamente 13 caracteres.");
} elseif (!preg_match('/^[A-Z0-9]+$/', $rfc)) {
    mostrarError("El RFC solo puede contener letras mayúsculas y dígitos numéricos.");
} elseif (!preg_match('/^[A-Z]{4}\d{6}[A-Z0-9]{3}$/', $rfc)) {
    mostrarError("El formato del RFC es inválido. Debe ser del tipo AAAA123456XXX, donde AAAA son las primeras cuatro letras del apellido, 123456 representa la fecha de nacimiento (YYMMDD) y XXX es la homoclave.");
}

// Checar si la cuenta ya está registrada en la tabla EMPLEADOS
$consultaEmpleado = "SELECT * FROM EMPLEADOS WHERE CUENTA IN 
    (SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO')";
$parametrosEmpleado = array(':correo' => $correo);
$resultadoEmpleado = $db->seleccionarPreparado($consultaEmpleado, $parametrosEmpleado);

if ($resultadoEmpleado) {
    mostrarError("El empleado ya ha sido dado de alta.");
} else {
    // Si el solicitante no ha sido dado de alta, insertarlo en la tabla EMPLEADOS

    // ID de la cuenta asociada al correo con estado ACTIVO
    $consultaCuenta = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO' AND ESTADO = 'ACTIVO'";
    $parametrosCuenta = array(':correo' => $correo);
    $resultadoCuenta = $db->seleccionarPreparado($consultaCuenta, $parametrosCuenta);

    if ($resultadoCuenta) {
        $idCuenta = $resultadoCuenta[0]->ID;

        // Insertar el nuevo registro en la tabla EMPLEADOS
        $consultaInsertar = "INSERT INTO EMPLEADOS (RFC, TIPO, CUENTA) VALUES (:rfc, :tipoUsuario, :idCuenta)";
        $parametrosInsercion = array(
            ':rfc' => $rfc,
            ':tipoUsuario' => $tipoUsuario,
            ':idCuenta' => $idCuenta
        );
        $db->ejecutarPreparado($consultaInsertar, $parametrosInsercion);

        echo "<div class='alert alert-success'>Empleado Registrado!</div>";
    } else {
        echo "<div class='alert alert-danger'>No se encontró una cuenta de tipo empleado activa con ese correo electrónico.</div>";
    }
}

$db->desconectarBD();
?>
