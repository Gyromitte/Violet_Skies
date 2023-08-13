<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_SESSION["ID"];
    $nombre_evento = $_POST["nombre_evento"];
    $salon = $_POST["salon"];
    $comida = $_POST["comida"];
    $invitados = intval($_POST["invitados"]);
    $fecha_evento = $_POST["fechaEvento"];

    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $dbname = "VIOLET";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validar el cupo del salón seleccionado
        $cupo_maximo = 0;
        switch ($salon) {
            case 1:
                $cupo_maximo = 50;
                break;
            case 2:
                $cupo_maximo = 50;
                break;
            case 3:
                $cupo_maximo = 120;
                break;
            case 4:
                $cupo_maximo = 120;
                break;
            case 5:
                $cupo_maximo = 120;
                break;
            case 6:
                $cupo_maximo = 20;
                break;
            case 7:
                $cupo_maximo = 20;
                break;
            case 8:
                $cupo_maximo = 20;
                break;
            case 9:
                $cupo_maximo = 20;
                break;
            case 10:
                $cupo_maximo = 80;
                break;
            case 11:
                $cupo_maximo = 80;
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

        // Llamar al procedimiento almacenado
        $sql = "CALL solicitarEvento(:nombre, :fecha_evento, :cliente, :invitados, :salon, :comida)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_evento);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->bindParam(':cliente', $usuario_id);
        $stmt->bindParam(':invitados', $invitados);
        $stmt->bindParam(':salon', $salon);
        $stmt->bindParam(':comida', $comida);

        $stmt->execute();

        $response = array("mensaje" => "Evento solicitado exitosamente.");
        echo json_encode($response);
    } catch (PDOException $e) {
        // Capturar y mostrar mensajes de error del procedimiento almacenado
        $errorMessage = $e->getMessage();
        
        if (strpos($errorMessage, "Ya tienes 5 eventos pendientes") !== false) {
            $response = array(
                "error" => true,
                "cupoMaximoExcedido" => true,
                "mensaje" => $errorMessage
            );
        } elseif (strpos($errorMessage, "Lo siento, esta fecha y salón ya están ocupados por otro evento.") !== false) {
            $response = array(
                "error" => true,
                "fechaOcupada" => true,
                "mensaje" => $errorMessage
            );
        } else {
            $response = array(
                "error" => true,
                "mensaje" => $errorMessage
            );
        }
        
        echo json_encode($response);
    }
}
?>