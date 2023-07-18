<?php
include_once 'dataBase.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $currentPassword = $_POST['contraseñaActual'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $database->conectarBD();

    // Obtener el ID del usuario actualmente logueado (puedes adaptar esta parte según tu lógica de autenticación)
    session_start();
    $userId = $_SESSION["id"];

    // Obtener la contraseña actual almacenada en la base de datos para el usuario
    $consulta = "SELECT CONTRASEÑA FROM CUENTAS WHERE ID = $userId";
    $resultados = $database->seleccionar($consulta);
    $contrasenaActual = $resultados[0]->CONTRASEÑA;

    // Verificar si la contraseña actual ingresada coincide con la almacenada en la base de datos
    if ($currentPassword !== $contrasenaActual) {
        echo "La contraseña actual es incorrecta.";
    } else {
        // Actualizar la contraseña en la base de datos
        $nuevaContrasena = password_hash($newPassword, PASSWORD_DEFAULT); // Hashear la nueva contraseña
        $actualizarConsulta = "UPDATE CUENTAS SET CONTRASEÑA = '$nuevaContrasena' WHERE ID = $userId";
        $database->ejecutarSQL($actualizarConsulta);

        echo "¡Contraseña actualizada correctamente!";
    }

    $database->desconectarBD();
}
?>
