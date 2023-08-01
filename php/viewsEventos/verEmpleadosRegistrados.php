<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        try {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

            // Obtener el ID del evento desde la consulta GET
            $evento = $_GET['id'];

            $consulta = "SELECT E.TIPO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS NOMBRE, C.TELEFONO
                         FROM CUENTAS C
                         JOIN EMPLEADOS E ON C.ID = E.CUENTA
                         JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EMPLEADOS
                         WHERE EE.EVENTO = $evento
                         ORDER BY E.TIPO, NOMBRE ASC";

            $tabla = $conexion->seleccionar($consulta);
            echo "<table class='table table-hover'>
            <thead class='thead-purple'>
                <tr>
                  <th>TIPO</th><th>NOMBRE</th><th>TELÉFONO</th>
                  </tr>
                  </thead>
                  <tbody>";

            foreach($tabla as $registro)
            {
              echo "<tr>";
              echo "<td> $registro->TIPO </td>";
              echo "<td> $registro->NOMBRE </td>";
              echo "<td> $registro->TELEFONO </td>";
              echo "</tr>";
            }

            echo "</tbody>
                  </table>";

            $conexion->desconectarBD();
        } catch (Exception $e) {
            // En caso de error, devolver una respuesta JSON con el mensaje de error
            header('Content-Type: application/json');
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        // Enviar una respuesta de error si no se proporciona el parámetro "id"
        header('Content-Type: application/json');
        echo json_encode(array("error" => "El parámetro 'id' no fue proporcionado."));
    }
}
?>
