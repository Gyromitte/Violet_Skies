<?php
$host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$dbname = "VIOLET";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT
                DATE_FORMAT(F_EVENTO, '%Y-%m-%d') AS fecha,
                COUNT(*) AS cantidad_eventos
            FROM
                EVENTO
            WHERE
                estado = 'EN PROCESO'
            GROUP BY
                DATE_FORMAT(F_EVENTO, '%Y-%m-%d')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;

?>
