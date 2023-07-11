<?php
    include_once "../dataBase.php";
            $conection = new Database();
            $conection->conectarBD();
            /*Mostrar solo a los empleados que tengan un tipo asignado*/
            $consulta = "SELECT estado, nombre, fechaCreacion, fechaFabulloso from evento;";

            $tabla = $conection->seleccionar($consulta);

            echo "<table class='table table-hover mt-3'>
            <thead class='thead-purple'>
            <tr>
            <th>estado</th>
            <th>nombre</th>
            <th>fechaCreacion</th>
            <th>fechaFabulloso</th>
            </tr>
            </thead>
            <tbody>";
            foreach($tabla as $reg)
            {
                echo "<tr>";
                echo "<td> $reg->estado</td>";
                echo "<td> $reg->nombre</td>";
                echo "<td> $reg->fechaCreacion</td>";
                echo "<td> $reg->fechaFabulloso</td>";
                echo "</tr>";
            }
            echo "</tbody>
            </table>";
            $conection->desconectarBD();

?>