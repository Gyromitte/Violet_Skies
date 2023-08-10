<?php
session_start();
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID del usuario desde la sesión (asegúrate de que esto sea correcto según tu implementación de inicio de sesión)
    $usuario_id = $_SESSION["ID"];

    // Obtener los valores del formulario
    $nombre_evento = $_POST["nombre_evento"];
    $salon = $_POST["salon"];
    $comida = $_POST["comida"];
    $invitados = intval($_POST["invitados"]); // Convertir a número entero
    $fecha_evento = $_POST["fechaEvento"];

    // Validar el cupo del salón seleccionado
    $cupo_maximo = 0;
    switch ($salon) {
        case 1:
            $cupo_maximo = 20;
            break;
        case 2:
            $cupo_maximo = 50;
            break;
        case 3:
            $cupo_maximo = 80;
            break;
        case 4:
            $cupo_maximo = 120;
            break;
        default:

            break;
    }

    // Verificar el cupo del salón
    if ($invitados > $cupo_maximo) {
        echo "El salón $salon solo tiene cupo para $cupo_maximo invitados.";
        // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
        exit;
    }

    // Conectar a la base de datos (Asegúrate de reemplazar los datos de conexión con los correctos)
    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $usuario = "doadmin";
    $contrasena = "AVNS_zPsBun59otEyJNJBtBv";
    $nombre_base_datos = "VIOLET";

    $conexion = new mysqli($host, $usuario, $contrasena, $nombre_base_datos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }
    // Insertar los datos en la base de datos en dos pasos
    $sql1 = "INSERT INTO EVENTO (NOMBRE, F_EVENTO, CLIENTE) VALUES (?,?,?)";
    $stmt1 = $conexion->prepare($sql1);

    if (!$stmt1) {
        die("Error al preparar la primera consulta: " . $conexion->error);
    }

    // Bind parameters
    $stmt1->bind_param('ssi',$nombre_evento, $fecha_evento, $usuario_id);

    // Execute first query
    if ($stmt1->execute()) {
        // Obtener el ID del evento recién insertado
        $evento_id = $stmt1->insert_id;

        // Cerrar la primera consulta
        $stmt1->close();

        // Realizar la segunda actualización en la tabla DETALLE_EVENTO con el ID del evento
    $sql2 = "UPDATE DETALLE_EVENTO SET INVITADOS = ?, SALON = ?, COMIDA = ? WHERE ID = ?";
    $stmt2 = $conexion->prepare($sql2);

    if (!$stmt2) {
        die("Error al preparar la segunda consulta: " . $conexion->error);
    }

    // Bind parameters
    $stmt2->bind_param("isss", $invitados, $salon, $comida, $evento_id);

    // Execute second query
    if ($stmt2->execute()) {
        $response = array("mensaje" => "Evento agregado exitosamente.");
        echo json_encode($response);
        // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
    } else {
        $response = array("error" => "Error al agregar el evento: " . $stmt2->error);
        echo json_encode($response);
        // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
    }
    
    // Cerrar la segunda consulta
    $stmt2->close();
    } else {
        echo "Error al agregar el evento: " . $stmt1->error;
        // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
