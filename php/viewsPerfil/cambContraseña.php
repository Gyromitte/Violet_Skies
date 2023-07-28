<?php
// cambContraseña.php

// Incluye el archivo de conexión a la base de datos
include_once "../dataBase.php";

// Verifica si se ha enviado el formulario para cambiar la contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtén los datos del formulario
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Realiza las validaciones necesarias (puedes agregar más validaciones según tus requerimientos)
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $mensaje = "Por favor, complete todos los campos.";
    } elseif ($newPassword !== $confirmPassword) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        // Obtiene el ID del usuario desde la sesión (asegúrate de que se haya iniciado la sesión en tus archivos)
        if (isset($_SESSION["ID"])) {
            $user_id = $_SESSION["ID"];

            try {
                // Crea una instancia de la clase DataBase para usar los identificadores de la clase
                $db = new DataBase();
                // Llama al método conectar() para establecer la conexión a la base de datos
                $conexion = $db->conectarBD();

                // Consulta preparada para buscar los datos del usuario por su ID y contraseña actual
                $query = "SELECT * FROM CUENTAS WHERE ID = :user_id AND CONTRASENA = :currentPassword";
                $parametros = array(':user_id' => $user_id, ':currentPassword' => $currentPassword);
                $result = $db->seleccionarPreparado($query, $parametros);

                if ($result) {
                    // Si la consulta arroja un resultado, significa que la contraseña actual es correcta
                    // Ahora podemos actualizar la contraseña en la base de datos
                    $query = "UPDATE CUENTAS SET CONTRASENA = :newPassword WHERE ID = :user_id";
                    $parametros = array(':newPassword' => $newPassword, ':user_id' => $user_id);
                    $result = $db->actualizarPreparado($query, $parametros);

                    if ($result) {
                        // Los datos se actualizaron correctamente en la base de datos
                        $response = array('success' => true, 'message' => '¡Contraseña cambiada exitosamente!');
                    } else {
                        $response = array('success' => false, 'message' => 'Error al cambiar la contraseña. Por favor, inténtelo de nuevo.');
                    }
                } else {
                    $response = array('success' => false, 'message' => 'La contraseña actual es incorrecta.');
                }

                // Cerrar la conexión
                $db->desconectarBD();
            } catch (PDOException $e) {
                $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
            }
        } else {
            $response = array('success' => false, 'message' => 'No se ha proporcionado un identificador de usuario.');
        }
    }

    // Devuelve la respuesta como un JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
