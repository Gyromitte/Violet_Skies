<?php
if (isset($_GET['evento_id'])) {
    $evento_id = $_GET['evento_id'];

    // Obtener el nombre del evento si se ha pasado como parámetro GET
    $nombre_evento = isset($_GET['nombre_evento']) ? $_GET['nombre_evento'] : "Evento sin nombre";

    // Realiza la conexión a la base de datos y obtén las solicitudes para el evento específico
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    $consulta = "SELECT CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS EMPLEADO, E.TIPO, SE.ACEPTADO
                 FROM SOLICITUDES_EMPLEADO SE JOIN EMPLEADOS E ON SE.EMPLEADO=E.ID
                 JOIN CUENTAS C ON C.ID=E.CUENTA
                 WHERE EVENTO = '$evento_id'";

    $parametros = array(":evento_id" => $evento_id);

    $solicitudes = $conexion->seleccionar($consulta, $parametros);

    // Desconecta de la base de datos
    $conexion->desconectarBD();

    // Muestra el nombre del evento en el título
    echo "<h2>Empleados para $nombre_evento</h2>";

    // Muestra las solicitudes en una tabla si existen, o muestra el mensaje "Aún no hay solicitudes"
    if (count($solicitudes) > 0) {
        echo "<table class='table table-hover'>
        <thead class='thead-purple'>
            <tr>
                <th>Empleado</th>
                <th>Tipo</th>
                <th>Aceptado</th>
            </tr>
        </thead>
        <tbody>";

        foreach ($solicitudes as $solicitud) {
            echo "<tr>
                  <td>$solicitud->EMPLEADO</td>
                  <td>$solicitud->TIPO</td>
                  <td>$solicitud->ACEPTADO</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "Aún no hay solicitudes.";
    }
} else {
    echo "Evento no especificado.";
}
?>
