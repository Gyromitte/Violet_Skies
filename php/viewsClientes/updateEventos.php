<?php
session_start();
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_SESSION["ID"];
    $evento_id = $_POST["eventId"];
    $nombre_evento = $_POST["editTitleInput"];
    $salon = $_POST["editSalonInput"];
    $comida = $_POST["editMenuInput"];
    $invitados = intval($_POST["editInvitadosInput"]);
    $fecha_evento = $_POST["editDateInput"];

    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $dbname = "VIOLET";


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validar el cupo del salón seleccionado
        $cupo_maximo = 0;
        $cupo_minimo = 0;
        
        switch ($salon) {
            case 1:
            case 2:
                $cupo_maximo = 50;
                $cupo_minimo = 20;
                break;
            case 3:
            case 4:
            case 5:
                $cupo_maximo = 120;
                $cupo_minimo = 80;
                break;
            case 6:
            case 7:
            case 8:
            case 9:
                $cupo_maximo = 20;
                $cupo_minimo = 10;
                break;
            case 10:
            case 11:
                $cupo_maximo = 80;
                $cupo_minimo = 50;
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
        
        if ($invitados < $cupo_minimo) {
            $response = array(
                "cupoMinimoNoAlcanzado" => true,
                "mensaje" => "La cantidad de invitados no cumple con el cupo mínimo requerido para este salón. El cupo mínimo es de $cupo_minimo invitados."
            );
            echo json_encode($response);
            exit;
        }

        // Llamar al procedimiento almacenado para actualizar el evento
        $sql = "CALL actualizarEvento(:evento_id, :nombre, :fecha_evento, :invitados, :salon, :comida)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':evento_id', $evento_id);
        $stmt->bindParam(':nombre', $nombre_evento);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->bindParam(':invitados', $invitados);
        $stmt->bindParam(':salon', $salon);
        $stmt->bindParam(':comida', $comida);

        $stmt->execute();

        $response = array("mensaje" => "Evento actualizado exitosamente.");
        echo json_encode($response);
    } catch (PDOException $e) {
        // Capturar y mostrar mensajes de error del procedimiento almacenado
        $errorMessage = $e->getMessage();
        
        if (strpos($errorMessage, "Ya tienes 5 eventos pendientes") !== false) {
            $response = array(
                "error" => true,
                "cupoMaximoExcedido" => true,
                "mensaje" => "Ya cuentas con 5 eventos pendientes"
            );
        } elseif (strpos($errorMessage, "Lo siento, esta fecha y salón ya están ocupados por otro evento.") !== false) {
            $response = array(
                "error" => true,
                "fechaOcupada" => true,
                "mensaje" => "Lo sentimos, no podemos agendar <br> más eventos para esa fecha"
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