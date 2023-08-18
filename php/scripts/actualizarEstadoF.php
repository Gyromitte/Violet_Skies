<?php
// Conexión a la base de datos utilizando PDO
$host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$dbname = "VIOLET";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener la fecha y hora actual
    $fechaActual = date("Y-m-d H:i:s");

    // Consulta para actualizar eventos en proceso que han finalizado
    $query = "UPDATE EVENTO SET ESTADO = 'FINALIZADO' WHERE F_EVENTO <= :fechaActual AND ESTADO = 'EN PROCESO'";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':fechaActual', $fechaActual);

    if ($stmt->execute()) {
        echo "Actualización de eventos finalizados exitosa.";
    } else {
        echo "Error en la actualización.";
    }
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>