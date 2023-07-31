<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    extract($_POST);

    $evento=$_POST('id');

     $consulta = "SELECT E.TIPO, CONCAT(C.NOMBRE, ' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS NOMBRE, C.TELEFONO
     FROM CUENTAS C JOIN EMPLEADOS E ON C.ID=E.CUENTA JOIN EVENTO_EMPLEADOS EE ON E.ID=EE.EMPLEADOS
     WHERE EE.EVENTO=$evento";

    $tabla = $conexion->seleccionar($consulta);
    echo '<div id="empleadosTable">';
    echo "<table class='table table-hover'>
            <thead class='thead-purple'>
                <tr>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";

    foreach ($tabla as $registro) {
        echo "<tr>";
        echo "<td> $registro->TIPO</td>";
        echo "<td> $registro->NOMBRE</td>";
        echo "<td> $registro->TELEFONO</td>";
        echo "</tr>";
    }

    echo "</tbody>
        </table>";
        echo '</div>';
    $conexion->desconectarBD();
}
?>
