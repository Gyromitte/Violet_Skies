<?php
session_start();

$servername = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$dbname = "VIOLET";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["eventID"]) && isset($_POST["password"])) {
            $eventId = $_POST["eventID"];
            $password = $_POST["password"];

            // Obtener el hash de la contraseña actual del usuario desde la base de datos
            $correo = $_SESSION["correo"];
            $sql = "SELECT CONTRASEÑA FROM CUENTAS WHERE CORREO=:correo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashedPasswordFromDatabase = $row["CONTRASEÑA"];

                // Verificar la contraseña con password_verify y la contraseña almacenada
                if (password_verify($password, $hashedPasswordFromDatabase)) {
                    try {
                        $sql = "UPDATE EVENTO SET ESTADO = 'CANCELADO' WHERE EVENTO.ID = :event_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":event_id", $eventId, PDO::PARAM_INT);
                        $stmt->execute();

                        echo "Evento cancelado correctamente.";
                    } catch (PDOException $e) {
                        echo "Error al cancelar el evento: " . $e->getMessage();
                    }
                } else {
                    echo "Contraseña incorrecta. El evento no ha sido cancelado.";
                }
            } else {
                echo "Usuario no encontrado.";
            }
        }
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>