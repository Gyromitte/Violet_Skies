<?php
include_once "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$telefono = $_POST['telefono'];

$rfc = $_POST['rfc'];
$correo = $_POST['correo'];
$tipo = filter_input(INPUT_POST, 'tipoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



// Variable para almacenar el mensaje de error
$errorMessage = "";

// Validar el formato del RFC con una expresión regular
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
            $errorMessage = "El formato del RFC es inválido. Debe ser del tipo AAAA123456XXX, donde AAAA son las primeras cuatro letras del apellido, 123456 representa la fecha de nacimiento (YYMMDD) y XXX es la homoclave.";
        }
    }
}

// Mostrar el mensaje de error si existe
if (!empty($errorMessage)) {
    echo "<div class='alert alert-danger'>$errorMessage</div>";
} else {
    // Checar si la cuenta  ya esta registrada en la tabla EMPLEADOS
    $consultaEmpleado = "SELECT * FROM EMPLEADOS WHERE CUENTA IN 
        (SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO')";
    $parametrosEmpleado = array(':correo' => $correo);
    $resultadoEmpleado = $db->seleccionarPreparado($consultaEmpleado, $parametrosEmpleado);

    if ($resultadoEmpleado) {
        echo "<div class='alert alert-danger'>El empleado ya ha sido dado de alta.</div>";
    } else {
        // Si el solicitante no ha sido dado de alta, insertarlo en la tabla EMPLEADOS
        //Generar contrasena temporal
        $contraseña = $nombre . rand(1000, 99999);
        $passHash = password_hash($contraseña, PASSWORD_DEFAULT);
        
        //Insertar primero en la tabla de CUENTAS
        $cadena = "INSERT INTO CUENTAS (NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO, CORREO, CONTRASEÑA, TIPO_CUENTA)
                    VALUES (:nombre, :ap_paterno, :ap_materno, :telefono, :correo, '$passHash', 'EMPLEADO')";
        $parametrosInsercion = array(
        ':nombre' => $nombre,
        ':ap_paterno' => $ap_paterno,
        ':ap_materno' => $ap_materno,
        ':telefono' => $telefono,
        ':correo' => $correo,
        );
        $db->ejecutarPreparado($cadena, $parametrosInsercion);

        //Sacar el id de la cuenta que se acaba de dar de alta atraves del correo
        $consultaCuenta = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO' AND ESTADO = 'ACTIVO'";
        $parametrosCuenta = array(':correo' => $correo);
        $resultadoCuenta = $db->seleccionarPreparado($consultaCuenta, $parametrosCuenta);
        $idCuenta = $resultadoCuenta[0]->ID;
        
        // Insertar el nuevo registro en la tabla EMPLEADOS
        $cadena = "INSERT INTO EMPLEADOS (RFC, TIPO, CUENTA) VALUES (:rfc, :tipo, :idCuenta)";
        $parametrosInsercion = array(
        ':rfc' => $rfc,
        ':tipo' => $tipo,
        ':idCuenta' => $idCuenta
        );
        $db->ejecutarPreparado($cadena, $parametrosInsercion);
        echo "<div class='alert alert-success mt-10'>Empleado Registrado!</div>";
        echo "<div class='alert alert-success mt-10'>La contraseña provisional de este empleado es: $contraseña</div>";
    }
}

$db->desconectarBD();
?>
