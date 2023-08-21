<?php
// procesar_busqueda.php

include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

$consulta = "SELECT E.ID, CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS NOMBRE, E.COMPORTAMIENTO
             FROM EMPLEADOS E JOIN CUENTAS C ON C.ID=E.CUENTA
             WHERE CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) LIKE :busqueda";

$parametros = array(":busqueda" => "%$busqueda%");

$tabla = $conexion->seleccionar($consulta, $parametros);

if (count($tabla) > 0) {
    echo '<div class="table-responsive">';
    echo "<table class='table table-hover'>
            <thead class='thead-purple'>
                <tr>
                    <th>Nombre</th>
                    <th>Comportamiento</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($tabla as $registro) {
        echo "<tr>";
        echo "<td class='text-center'>";
        echo "<button class='btn btn-secondary custom-dropdown' type='button' data-event-id='$registro->ID'>+</button>";
        echo "</td>";
        echo "<td> $registro->NOMBRE</td>";
        echo "<td> $registro->COMPORTAMIENTO</td>";
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
?>
