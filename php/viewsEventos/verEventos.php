<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

          extract($_POST);


            if($estado === "todo") {$consulta = "SELECT E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID";}
            else {$consulta = "SELECT E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID WHERE E.ESTADO='$estado'";}

          $tabla = $conexion->seleccionar($consulta);

            echo "<table class='table table-hover'>
            <thead class='thead-purple'>
            <tr>
            <th>Nombre</th>
            <th>estado</th>
            <th>creacion</th>
            <th>fecha</th>
            <th>cliente</th>
            </tr>
            </thead>
            <tbody>";

            foreach($tabla as $registro)
            {
                echo "<tr>";
                echo "<td> $registro->NOMBRE</td>";
                echo "<td> $registro->ESTADO</td>";
                echo "<td> $registro->F_CREACION</td>";
                echo "<td> $registro->F_EVENTO</td>";
                echo "<td> $registro->CLIENTE</td>";
                echo "</tr>";
            }

            echo "</tbody>
            </table>";
            $conexion->desconectarBD();
        }
?>