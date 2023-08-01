<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener los datos del formulario mediante una solicitud POST
$rfc = filter_input(INPUT_POST, 'rfc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$tipoUsuario = filter_input(INPUT_POST, 'tipoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Agregar mensajes de depuración para verificar los datos recibidos
echo "<pre>";
echo "Datos recibidos del formulario:\n";
echo "RFC: " . $rfc . "\n";
echo "Correo: " . $correo . "\n";
echo "Tipo de Usuario: " . $tipoUsuario . "\n";
echo "</pre>";

// Checar si la cuenta ya está registrada en la tabla EMPLEADOS
$consultaEmpleado = "SELECT * FROM EMPLEADOS WHERE CUENTA IN 
    (SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO')";
$parametrosEmpleado = array(':correo' => $correo);
$resultadoEmpleado = $db->seleccionarPreparado($consultaEmpleado, $parametrosEmpleado);

if ($resultadoEmpleado) {
    echo "<div class='alert alert-danger'>El empleado ya ha sido dado de alta.</div>";
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