<?php
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    extract($_POST);
    $consulta = "SELECT E.NOMBRE, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
    DE.INVITADOS, DE.SALON
    FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID INNER JOIN DETALLE_EVENTO DE ON
    DE.ID=E.ID ORDER BY E.F_CREACION";
        

          $tabla = $conexion->seleccionar($consulta);

            echo "<table class='table table-hover'>
            <thead class='thead-purple'>
            <tr>
            <th>Nombre</th>
            <th>creacion</th>
            <th>fecha</th>
            <th>cliente</th>
            <th>Invitados</th>
            <th>Salon</th>
            <th>Meseros Necesarios</th>
            <th>Cocineros Necesarios</th>
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
        
?>