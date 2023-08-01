<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    extract($_POST);

    $search = isset($_POST['search']) ? $_POST['search'] : '';

    if ($estado === "todo") {
        $consulta = "SELECT E.ID, E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID WHERE (E.NOMBRE LIKE '%$search%' OR CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) LIKE '%$search%') ORDER BY F_EVENTO ASC";
    } else {
        $consulta = "SELECT E.ID, E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID WHERE E.ESTADO='$estado' AND (E.NOMBRE LIKE '%$search%' OR CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) LIKE '%$search%') ORDER BY F_EVENTO ASC";
    }

    $tabla = $conexion->seleccionar($consulta);

    if (count($tabla) > 0) {
        echo '<div class="table-responsive">';
        echo "<table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Creación</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($tabla as $registro) {
            echo "<tr>";
            echo "<td> $registro->NOMBRE</td>";
            echo "<td> $registro->ESTADO</td>";
            echo "<td> $registro->F_CREACION</td>";
            echo "<td> $registro->F_EVENTO</td>";
            echo "<td> $registro->CLIENTE</td>";
            echo "<td>
                <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#mainModal' data-bs-whatever='@verDetallesEvento' data-event-id='$registro->ID'>Ver más</button>
            </td>";
            echo "</tr>";
        }
        echo "</tbody>
            </table>
            </div>
            ";
    } else {
        echo "<p>No se encontraron coincidencias.</p>";
    }
    $conexion->desconectarBD();
}
?>
