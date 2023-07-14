<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();
extract($_POST);

//Checar si el empleado ya está registrado en la tabla
$consultaUsuario = "SELECT ID FROM CUENTAS WHERE CORREO = '$correo'";
$resultadoUsuario = $db->seleccionar($consultaUsuario);

if ($resultadoUsuario) {
    echo "<div class='alert alert-danger'>El usuario ya está registrado.</div>";
} else {
    //Obtener el id de la cuenta basado en el correo electrónico y el tipo de cuenta
    $consultaCuenta = "SELECT ID, NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO FROM CUENTAS 
    WHERE CORREO = '$correo' AND TIPO_CUENTA = 'EMPLEADO'";
    $resultadoCuenta = $db->seleccionar($consultaCuenta);

    if ($resultadoCuenta) {
        $idCuenta = $resultadoCuenta[0]->ID;
        // Insertar el nuevo registro en la tabla empleados
        $cadena = "INSERT INTO EMPLEADOS(nombre, apellidoPaterno, apellidoMaterno, rfc, correo, telefono, tipoUsuario, cuentas_id)
        VALUES ('$rfc', '$tipo', '$Cuenta')";
        $db->ejecutarSQL($cadena);

        echo "<div class='alert alert-success'>Empleado Registrado!</div>";
    } else {
        echo "<div class='alert alert-danger'>No se encontró una cuenta de tipo empleado con ese correo electrónico</div>";
    }
}

?>
