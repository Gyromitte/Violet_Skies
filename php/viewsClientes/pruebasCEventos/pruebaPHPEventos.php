<?php
// Datos de conexión a la base de datos
$servername = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com";
$username = "doadmin";
$password = "AVNS_zPsBun59otEyJNJBtBv";
$port = 25060;
$database = "VIOLET";
include("panelClientes.php");
// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

function verificar_disponibilidad($conn, $salon, $fecha, $invitados) {
    // Consulta para obtener la cantidad de eventos existentes para el salón y fecha especificados
    $sql = "SELECT COUNT(*) as cantidad, SUM(invitados) as invitados_totales FROM eventos WHERE salon = '$salon' AND fecha = '$fecha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cantidad_actual = $row["cantidad"];
        $invitados_totales = $row["invitados_totales"];
        $limite_invitados = 0;

        switch ($salon) {
            case 'Cuatrociénegas 1':
                $limite_invitados = 20;
                break;
            case 'Torreón 1':
                $limite_invitados = 50;
                break;
            case 'Saltillo 1':
                $limite_invitados = 80;
                break;
            case 'Coahuila 1':
                $limite_invitados = 120;
                break;
            default:
                return true; // Salón no especificado o desconocido, permitir siempre
        }

        if ($cantidad_actual < $limite_invitados && ($invitados_totales + $invitados) <= $limite_invitados) {
            return true;
        }

        return false;
    }

    return true; // Si no hay registros, permitir siempre
}

function agregar_evento($conn, $nombre_evento, $salon, $invitados, $fecha) {
    if (verificar_disponibilidad($conn, $salon, $fecha, $invitados)) {
        $id_cliente = $_SESSION["ID"];
        // Insertar el evento en la tabla "eventos"
        $sql1 = "INSERT INTO EVENTO (NOMBRE,F_EVENTO, CLIENTE) VALUES ('$nombre_evento','$fecha','$id_cliente')";
        if ($conn->query($sql1) === TRUE) {
            // Obtener el ID del evento insertado
            $evento_id = $conn->insert_id;

            // Insertar el evento en la tabla "EVENTO"
            $sql2 = "INSERT INTO DETALLE_EVENTO (ID,INVITADOS, F_EVENTO, CLIENTE) VALUES ('$evento_id', '$invitados','$fecha', '')";
            if ($conn->query($sql2) === TRUE) {
                return true;
            } else {
                echo "Error al agregar el evento: " . $conn->error;
                return false;
            }
        } else {
            echo "Error al agregar el evento: " . $conn->error;
            return false;
        }
    }

    return false;
}

function obtener_eventos($conn) {
    $eventos = array();

    $sql = "SELECT * FROM eventos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $evento = array(
                "nombre" => $row["nombre_evento"],
                "salon" => $row["salon"],
                "invitados" => $row["invitados"],
                "fecha" => $row["fecha"]
            );
            $eventos[] = $evento;
        }
    }

    return $eventos;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datos = json_decode(file_get_contents("php://input"), true);
    $nombreEvento = $datos["nombre"];
    $salon = $datos["salon"];
    $invitados = $datos["invitados"];
    $fecha = $datos["fecha"];

    $disponibilidad = agregar_evento($conn, $nombreEvento, $salon, $invitados, $fecha);
    $eventos = obtener_eventos($conn);

    $response = array(
        "disponibilidad" => $disponibilidad,
        "eventos" => $eventos
    );

    echo json_encode($response);
}

$conn->close();
?>
