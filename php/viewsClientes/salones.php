<?php
    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $dbname = "VIOLET";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $consultaSalon = "SELECT ID, NOMBRE, CUPO FROM SALONES";
        $resultadosSalon = $pdo->query($consultaSalon);
        $salonItems = $resultadosSalon->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
?>