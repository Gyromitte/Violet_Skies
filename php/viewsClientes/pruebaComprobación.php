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

    try {
        // Establecer la conexión
        $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el hash de la contraseña actual del usuario desde la base de datos
        $sql = "SELECT CONTRASEÑA FROM CUENTAS WHERE CORREO=:correo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row["CONTRASEÑA"];

            // Verificar la contraseña actual utilizando password_verify
            if (password_verify($contrasena_actual, $hashed_password)) {
                // La contraseña es válida, proceder con la actualización de datos
                $sql = "UPDATE CUENTAS SET NOMBRE=:nombre, AP_PATERNO=:apPaterno, AP_MATERNO=:apMaterno, TELEFONO=:telefono WHERE CORREO=:correo";

                // Ejecuta la consulta
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apPaterno', $apPaterno);
                $stmt->bindParam(':apMaterno', $apMaterno);
                $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':correo', $correo);
                $stmt->execute();

                // Actualización exitosa, cerrar la sesión del usuario y redirigirlo a la página de inicio
                session_unset();
                $nuevosDatosUsuario = [
                    'nombre' => $nombre,
                    'ap_paterno' => $apPaterno,
                    'ap_materno' => $apMaterno,
                    'telefono' => $telefono,
                    'correo' => $correo,
                    'tipo_cuenta' => $tipoCuenta
                ];
                $response = ['success' => true, 'usuario' => $nuevosDatosUsuario];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            } else {
                // La contraseña es incorrecta, no se puede realizar la actualización
                $response = ['success' => false, 'badPass' => 'Contraseña incorrecta, no se puede actualizar los datos'];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        } else {
            // No se encontró el usuario con el correo especificado
            $response = ['success' => false, 'error' => 'No se encontró el usuario con el correo especificado'];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'error' => 'Error al conectar con la base de datos: ' . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
} else {
    // Si no se ha enviado un formulario POST, devolver un mensaje de error JSON
    $response = ['success' => false, 'error' => 'No se recibieron datos del formulario'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); 
}
?>