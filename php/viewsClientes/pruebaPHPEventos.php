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

    if ($invitados > $cupo_maximo) {
        $response = array(
            "cupoMaximoExcedido" => true,
            "mensaje" => "La cantidad de invitados supera el cupo máximo del salón. Este salón solo tiene cupo para $cupo_maximo invitados."
        );
        echo json_encode($response);
        exit;
    }

    // Conectar a la base de datos (Asegúrate de reemplazar los datos de conexión con los correctos)
    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $dbname = "VIOLET";

    try {
        // Establecer la conexión
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertar los datos en la base de datos en dos pasos
        $sql1 = "INSERT INTO EVENTO (NOMBRE, F_EVENTO, CLIENTE) VALUES (?, ?, ?)";
        $stmt1 = $pdo->prepare($sql1);

        if (!$stmt1) {
            die("Error al preparar la primera consulta: " . $pdo->errorInfo()[2]);
        }

        // Bind parameters
        $stmt1->bindParam(1, $nombre_evento);
        $stmt1->bindParam(2, $fecha_evento);
        $stmt1->bindParam(3, $usuario_id);

        // Execute first query
        if ($stmt1->execute()) {
            // Obtener el ID del evento recién insertado
            $evento_id = $pdo->lastInsertId();

            // Realizar la segunda actualización en la tabla DETALLE_EVENTO con el ID del evento
            $sql2 = "UPDATE DETALLE_EVENTO SET INVITADOS = ?, SALON = ?, COMIDA = ? WHERE ID = ?";
            $stmt2 = $pdo->prepare($sql2);

            if (!$stmt2) {
                die("Error al preparar la segunda consulta: " . $pdo->errorInfo()[2]);
            }

            // Bind parameters
            $stmt2->bindParam(1, $invitados);
            $stmt2->bindParam(2, $salon);
            $stmt2->bindParam(3, $comida);
            $stmt2->bindParam(4, $evento_id);

            // Execute second query
            if ($stmt2->execute()) {
                $response = array("mensaje" => "Evento agregado exitosamente.");
                echo json_encode($response);
                // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
            } else {
                $response = array("error" => "Error al agregar el evento: " . $stmt2->errorInfo()[2]);
                echo json_encode($response);
                // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
            }
        } else {
            echo "Error al agregar el evento: " . $stmt1->errorInfo()[2];
            // Puedes realizar alguna acción adicional aquí, como redirigir al usuario o mostrar un mensaje.
        }
    } catch (PDOException $e) {
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
    }
}
?>