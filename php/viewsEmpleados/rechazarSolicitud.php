<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener el correo del formulario mediante una solicitud POST
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

/* Agregar mensajes de depuración para verificar el correo recibido
echo "<pre>";
echo "Correo recibido del formulario:\n";
echo "Correo: " . $correo . "\n";
echo "</pre>";*/

// Actualizar el estado de la cuenta a INACTIVO en la tabla CUENTAS
$consultaActualizar = "UPDATE CUENTAS SET ESTADO = 'INACTIVO' WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO'";
$parametrosActualizar = array(':correo' => $correo);
$resultadoActualizar = $db->ejecutarPreparado($consultaActualizar, $parametrosActualizar);

//var_dump($resultadoActualizar);

if ($resultadoActualizar) {
    echo "<div class='alert alert-success'>Solicitud rechazada correctamente</div>";
} else {
    echo "<div class='alert alert-danger'>Error al rechazar la cuenta de empleado.</div>";
}

$db->desconectarBD();
?>