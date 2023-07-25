<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--StyleSheets-->
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/panelAdmin.css">
        <!--Referencias a fuentes-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <title>cambContraseña</title>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
</head>
<body>
<?php
// Inicializar la variable de mensaje
$mensaje = "";
include_once "../dataBase.php";
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    session_start();

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        // Crear una instancia de la clase Database
        $database = new Database();
        $database->conectarBD();

        // Obtener el ID del usuario actualmente logueado
        $correo=$_SESSION['correo'];
        $consulta="SELECT ID FROM CUENTAS WHERE CORREO = '$correo'";
        $userId = $database->seleccionar($consulta);
        
        // Obtener la contraseña actual almacenada en la base de datos para el usuario
        $consulta = "SELECT CONTRASEÑA FROM CUENTAS WHERE CORREO = '$correo'";
        $resultados = $database->seleccionar($consulta);

        if (!empty($resultados)) {
            $contraseñaActual = $resultados[0]->CONTRASEÑA;

            // Verificar si la contraseña actual ingresada coincide con la almacenada en la base de datos
            if (!password_verify($currentPassword, $contraseñaActual)) {
                $mensaje = "La contraseña actual es incorrecta.";
            } else {
                // Actualizar la contraseña en la base de datos
                $hashNuevaContraseña = password_hash($newPassword, PASSWORD_DEFAULT); // Hashear la nueva contraseña
                $consulta = "UPDATE CUENTAS SET CONTRASEÑA = :newPassword WHERE ID = :id";
                $actualizar = $database->PDO_local->prepare($consulta);
                $actualizar->bindParam(':newPassword', $hashNuevaContraseña);
                $actualizar->bindParam(':id', $userId); // Reemplaza $userId por el identificador del usuario
                $actualizar->execute();

                if ($actualizar->rowCount() === 0) {
                    $mensaje = "Error al actualizar la contraseña.";
                    // Manejo del error y redirección si es necesario

                }

                $mensaje = "Contraseña actualizada exitosamente.";
                header("Location: verPerfil.php");
                // Redirección a la página de perfil o cualquier otra página
            }
        } else {
            $mensaje = "No se encontró el usuario.";
        }
        $database->desconectarBD();
    }
}
?>

<div class="modal fade" id="modalCambiarContrasena" tabindex="-1" aria-labelledby="modalCambiarContrasenaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCambiarContrasenaLabel">Cambiar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Contraseña actual:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nueva contraseña:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <?php if (!empty($mensaje)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
