<?php
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    /* Mostrar solo a los empleados que sean cocineros */
    $consulta = "SELECT C.NOMBRE, C.AP_PATERNO, C.AP_MATERNO, E.RFC, C.TELEFONO, C.CORREO, E.TIPO
                 FROM EMPLEADOS E
                 INNER JOIN CUENTAS C ON E.CUENTA = C.ID
                 WHERE E.TIPO = 'COCINA'";

    $tabla = $conexion->seleccionar($consulta);

    echo "<table class='table table-hover mt-3'>
            <thead class='thead-purple'>
                <tr>
                    <th>Nombre</th>
                    <th>Ape. Paterno</th>
                    <th>Ape. Materno</th>
                    <th>RFC</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>";

    foreach($tabla as $registro)
    {
        echo "<tr>";
        echo "<td> $registro->NOMBRE </td>";
        echo "<td> $registro->AP_PATERNO </td>";
        echo "<td> $registro->AP_MATERNO </td>";
        echo "<td> $registro->RFC </td>";
        echo "<td> $registro->TELEFONO </td>";
        echo "<td> $registro->CORREO </td>";
        echo "<td> $registro->TIPO</td>";
        echo "</tr>";
    }

    echo "</tbody>
          </table>";

    $conexion->desconectarBD();
?>
