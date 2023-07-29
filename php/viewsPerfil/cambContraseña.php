<?php
include_once "../dataBase.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    session_start();

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        $mensaje = "Las contraseñas no coinciden";
        $response = array('success' => false, 'message' => $mensaje);
                    header('Content-Type: application/json');
                    echo json_encode($response);
    } else {
        try {
            $database = new Database();
            $database->conectarBD();

            // Obtener la contraseña actual almacenada en la base de datos para el usuario
            $consulta = "SELECT CONTRASEÑA FROM CUENTAS WHERE ID = :cuenta";
            $parametros = array(':cuenta' => $cuenta);
            $resultados = $database->seleccionarPreparado($consulta, $parametros);

            if (!empty($resultados)) {
                $contraseñaActual = $resultados[0]->CONTRASEÑA;

                // Verificar si la contraseña actual ingresada coincide con la almacenada en la base de datos
                if (!password_verify($currentPassword, $contraseñaActual)) {
                    $mensaje = "La contraseña actual es incorrecta";
                    $response = array('success' => false, 'message' => $mensaje);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                } else {
                    // Actualizar la contraseña en la base de datos
                    $hashNuevaContraseña = password_hash($newPassword, PASSWORD_DEFAULT); // Hashear la nueva contraseña
                    $consulta = "UPDATE CUENTAS SET CONTRASEÑA = :newPassword WHERE ID = :cuenta";
                    $actualizar = $database->getPDO()->prepare($consulta);
                    $actualizar->bindParam(':newPassword', $hashNuevaContraseña);
                    $actualizar->bindParam(':cuenta', $cuenta);
                    $actualizar->execute();

                    if ($actualizar->rowCount() === 0) {
                        $mensaje = "Error al actualizar la contraseña";
                        // Manejo del error y redirección si es necesario
                        $response = array('success' => false, 'message' => $mensaje);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    } else {
                        $mensaje = "Contraseña actualizada exitosamente";
                        // Envía una respuesta JSON con éxito
                        $response = array('success' => true, 'message' => $mensaje);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    }
                }
            } else {
                $mensaje = "No se encontró el usuario";
                // Envía una respuesta JSON con error
                $response = array('success' => false, 'message' => $mensaje);
                exit;
            }
        } catch (PDOException $e) {
            $mensaje = "Error en la base de datos: " . $e->getMessage();
            // Envía una respuesta JSON con error
            $response = array('success' => false, 'message' => $mensaje);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $database->desconectarBD();
    }
}
?>
