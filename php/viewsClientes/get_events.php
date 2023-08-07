<?php
session_start();
$servername = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$dbname = "VIOLET";

$usuario_id = 6;
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT EVENTO.*, DETALLE_EVENTO.* FROM EVENTO INNER JOIN DETALLE_EVENTO ON EVENTO.ID = DETALLE_EVENTO.ID WHERE EVENTO.CLIENTE = $usuario_id AND EVENTO.ESTADO = 'PENDIENTE'";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
        
    }
}
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();

?>
