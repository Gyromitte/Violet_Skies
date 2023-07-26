<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $apPaterno = $_POST["ap_paterno"];
    $apMaterno = $_POST["ap_materno"];
    $telefono = $_POST["telefono"];
    $contrasena_actual = $_POST["contrasena_actual"]; // Contraseña actual ingresada por el usuario
    $correo = $_POST["correo"];
    $tipoCuenta = $_POST["tipo_cuenta"];

    // Datos de conexión a la base de datos
    $servername = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $port = 25060;
    $database = "VIOLET";

    // Establecer la conexión
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error al conectar con la base de datos: " . $conn->connect_error);
    }

    // Obtener el hash de la contraseña actual del usuario desde la base de datos
    $sql = "SELECT CONTRASEÑA FROM CUENTAS WHERE CORREO='$correo'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["CONTRASEÑA"];

        // Verificar la contraseña actual utilizando password_verify
        if (password_verify($contrasena_actual, $hashed_password)) {
            // La contraseña es válida, proceder con la actualización de datos
            $sql = "UPDATE CUENTAS SET NOMBRE='$nombre', AP_PATERNO='$apPaterno', AP_MATERNO='$apMaterno', TELEFONO='$telefono' WHERE CORREO='$correo'";

            // Ejecuta la consulta
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al actualizar los datos: ' . $conn->error]);
            }
        } else {
            // La contraseña es incorrecta, no se puede realizar la actualización
            echo json_encode(['success' => false, 'error' => 'Contraseña incorrecta']);
        }
    } else {
        // No se encontró el usuario con el correo especificado
        echo json_encode(['success' => false, 'error' => 'No se encontró el usuario']);
    }

    $conn->close();
} else {
    // Si no se ha enviado un formulario POST, devolver un mensaje de error JSON
    echo json_encode(['success' => false, 'error' => 'No se recibieron datos del formulario']);
}
?>
