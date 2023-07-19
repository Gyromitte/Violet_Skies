<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener los datos del formulario de manera segura
$rfc = $_POST['rfc'];
$correo = $_POST['correo'];
$tipo = filter_input(INPUT_POST, 'tipoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

print_r($_POST);


// Checar si el empleado ya está registrado en la tabla (Aqui se necesita checar pero en EMPLEADOS)
$consultaUsuario = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO'";
$parametrosUsuario = array(':correo' => $correo);
$resultadoUsuario = $db->seleccionarPreparado($consultaUsuario, $parametrosUsuario);

if ($resultadoUsuario) {
    $idCuenta = $resultadoUsuario[0]->ID;

    // Insertar el nuevo registro en la tabla empleados
    $cadena = "INSERT INTO EMPLEADOS (RFC, TIPO, CUENTA) VALUES (:rfc, :tipo, :idCuenta)";
    $parametrosInsercion = array(
        ':rfc' => $rfc,
        ':tipo' => $tipo,
        ':idCuenta' => $idCuenta
    );
    $db->ejecutarPreparado($cadena, $parametrosInsercion);

    echo "<div class='alert alert-success'>Empleado Registrado!</div>";
} else {
    echo "<div class='alert alert-danger'>No se encontró una cuenta de tipo empleado con ese correo electrónico</div> Correo: " . $rfc;
}

$db->desconectarBD();
?>

