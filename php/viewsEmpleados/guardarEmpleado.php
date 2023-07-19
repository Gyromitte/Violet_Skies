<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener los datos del formulario
$rfc = $_POST['rfc'];
$correo = $_POST['correo'];
$tipo = filter_input(INPUT_POST, 'tipoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Checar si el empleado ya está registrado en la tabla EMPLEADOS
$consultaEmpleado = "SELECT * FROM EMPLEADOS WHERE CUENTA IN 
    (SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO')";
$parametrosEmpleado = array(':correo' => $correo);
$resultadoEmpleado = $db->seleccionarPreparado($consultaEmpleado, $parametrosEmpleado);

if ($resultadoEmpleado) {
    echo "<div class='alert alert-danger'>El empleado ya ha sido dado de alta.</div>";
} else {
    // Si el empleado no ha sido dado de alta, insertarlo en la tabla EMPLEADOS

    // ID de la cuenta asociada al correo con estado ACTIVO
    $consultaCuenta = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO' AND ESTADO = 'ACTIVO'";
    $parametrosCuenta = array(':correo' => $correo);
    $resultadoCuenta = $db->seleccionarPreparado($consultaCuenta, $parametrosCuenta);

    if ($resultadoCuenta) {
        $idCuenta = $resultadoCuenta[0]->ID;

        // Insertar el nuevo registro en la tabla EMPLEADOS
        $cadena = "INSERT INTO EMPLEADOS (RFC, TIPO, CUENTA) VALUES (:rfc, :tipo, :idCuenta)";
        $parametrosInsercion = array(
            ':rfc' => $rfc,
            ':tipo' => $tipo,
            ':idCuenta' => $idCuenta
        );
        $db->ejecutarPreparado($cadena, $parametrosInsercion);

        echo "<div class='alert alert-success'>Empleado Registrado!</div>";
    } else {
        echo "<div class='alert alert-danger'>No se encontró una cuenta de tipo empleado activa con ese correo electrónico.</div>";
    }
}

$db->desconectarBD();
?>
