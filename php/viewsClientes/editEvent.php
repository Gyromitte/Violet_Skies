<?php
// Configuración de la conexión a la base de datos
$servername = "nombre_del_servidor";
$username = "nombre_de_usuario";
$password = "contraseña";
$dbname = "nombre_de_la_base_de_datos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos enviados desde el formulario
    $eventId = $_POST['eventId'];
    $title = $_POST['editTitleInput'];
    $date = $_POST['editDateInput'];
    $salon = $_POST['editSalonInput'];
    $menu = $_POST['editMenuInput'];
    $invitados = $_POST['editInvitadosInput'];

    // Preparar la consulta para actualizar el evento
    $sql = "UPDATE eventos SET 
            `NOMBRE DEL EVENTO` = :title,
            `FECHA DEL EVENTO` = :date,
            `NOMBRE DEL SALÓN` = :salon,
            `MENÚ` = :menu,
            `INVITADOS` = :invitados
            WHERE ID_EVENTO = :eventId";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':salon', $salon);
    $stmt->bindParam(':menu', $menu);
    $stmt->bindParam(':invitados', $invitados);
    $stmt->bindParam(':eventId', $eventId);

    // Ejecutar la consulta
    $stmt->execute();

    echo "Evento actualizado correctamente";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
