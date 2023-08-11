<?php
session_start();
$servername = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$dbname = "VIOLET";

$usuario_id = $_SESSION["ID"];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $states = array("CANCELADO", "PENDIENTE", "EN PROCESO", "FINALIZADO");

    $selectedState = isset($_GET['estado']) ? $_GET['estado'] : 'PENDIENTE';

    if (!in_array($selectedState, $states)) {
        echo "Estado seleccionado no válido";
        exit;
    }

    $sql = "SELECT EVENTO.ID AS 'ID EVENTO', EVENTO.NOMBRE AS 'NOMBRE DEL EVENTO', CUENTAS.NOMBRE AS 'NOMBRE DEL CLIENTE', SALONES.NOMBRE AS 'NOMBRE DEL SALÓN', COMIDAS.NOMBRE AS 'MENÚ', EVENTO.ESTADO,
    EVENTO.F_EVENTO AS 'FECHA DEL EVENTO', DETALLE_EVENTO.SALON AS 'ID_SALON'
    FROM 
    (SELECT * FROM EVENTO WHERE CLIENTE = :usuario_id AND ESTADO = :selectedState) AS EVENTO
    INNER JOIN DETALLE_EVENTO ON EVENTO.ID = DETALLE_EVENTO.ID
    LEFT JOIN COMIDAS ON DETALLE_EVENTO.COMIDA = COMIDAS.ID
    INNER JOIN CUENTAS ON EVENTO.CLIENTE = CUENTAS.ID
    INNER JOIN SALONES ON DETALLE_EVENTO.SALON = SALONES.ID";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':selectedState', $selectedState);
    $stmt->execute();

    $events = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $events[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($events);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
