<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        try {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

            $evento = $_GET['id'];
            $tipo = $_GET['tipo'];

            $consulta = "SELECT E.TIPO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS NOMBRE, C.TELEFONO
                FROM CUENTAS C JOIN EMPLEADOS E ON C.ID = E.CUENTA JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EMPLEADOS
                WHERE EE.EVENTO = $evento AND E.TIPO = '$tipo'
                ORDER BY E.TIPO, NOMBRE ASC";

            $tabla = $conexion->seleccionar($consulta);

            if (count($tabla) > 0) {
                echo "<br><table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                    <th></th><th>NOMBRE</th><th>TELÉFONO</th>
                    </tr>
                </thead>
                <tbody>";

                foreach ($tabla as $registro) {
                    echo "<tr>";
                    echo "<td class='text-center'>";
                    echo "<button class='btn btn-danger' type='button'>-</button>";
                    echo "</td>";
                    echo "<td> $registro->NOMBRE </td>";
                    echo "<td> $registro->TELEFONO </td>";
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
            } else {
                if($tipo === 'MESERO')
                {
                    echo "<br><p>No hay meseros por mostrar</p>";

                } else{
                    echo "<br><p>No hay cocineros por mostrar</p>";
                }
            }
            $conexion->desconectarBD();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("error" => "El parámetro 'id' no fue proporcionado."));
    }
}
?>
