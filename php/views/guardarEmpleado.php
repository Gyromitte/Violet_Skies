<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();
extract($_POST);

// Verificar si el empleado ya está registrado en la tabla de usuarios
$consultaUsuario = "SELECT id FROM usuarios WHERE correo = '$correo'";
$resultadoUsuario = $db->seleccionar($consultaUsuario);

if ($resultadoUsuario) {
    echo "<div class='alert alert-danger'>El usuario ya está registrado.</div>";
} else {
    //Obtener el id de la cuenta basado en el correo electrónico y el tipo de cuenta
    $consultaCuenta = "SELECT id, nombre, apellidoPaterno, apellidoMaterno, telefono FROM cuentas WHERE correo = '$correo' AND tipo = 'trabajador'";
    $resultadoCuenta = $db->seleccionar($consultaCuenta);

    if ($resultadoCuenta) {
        $idCuenta = $resultadoCuenta[0]->id;
        //Pasar valores de la tabla cuentas a la tabla usuarios
        $nombre = $resultadoCuenta[0]->nombre;
        $apellidoPaterno = $resultadoCuenta[0]->apellidoPaterno;
        $apellidoMaterno = $resultadoCuenta[0]->apellidoMaterno;
        $telefono = $resultadoCuenta[0]->telefono;

        // Insertar el nuevo registro en la tabla usuarios, incluyendo los valores de cuenta
        $cadena = "INSERT INTO usuarios(nombre, apellidoPaterno, apellidoMaterno, rfc, correo, telefono, tipoUsuario, cuentas_id)
        VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$rfc', '$correo', '$telefono', '$tipoUsuario', '$idCuenta')";
        $db->ejecutarSQL($cadena);

        echo "<div class='alert alert-success'>Empleado Registrado!</div>";
    } else {
        echo "<div class='alert alert-danger'>No se encontró una cuenta de tipo trabajador con ese correo electrónico</div>";
    }
}

?>
