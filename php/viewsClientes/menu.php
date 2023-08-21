<?php
    $host = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_zPsBun59otEyJNJBtBv";
    $dbname = "VIOLET";

    try {
        // Establecer la conexión
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obtener los valores del menú
        $consultaMenu = "SELECT ID, NOMBRE, DESCRIPCION, TIPO FROM COMIDAS WHERE COMIDAS.TIPO != 8";
        $resultadosMenu = $pdo->query($consultaMenu);
        $menuItems = $resultadosMenu->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
?>