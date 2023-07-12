<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

          extract($_POST);


            if($depa === "todo") {$consulta = "SELECT * FROM evento";}
            else {$consulta = "SELECT * FROM evento WHERE estado='$depa'";}

          $tabla = $conexion->seleccionar($consulta);

            echo "<table class='table table-hover'>
            <thead class='thead-purple'>
            <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Administrativo</th>
            <th>chef</th>
            <th>mesero</th>
            <th>invitados</th>
            <th>estado</th>
            <th>creacion</th>
            <th>fecha</th>
            <th>comida</th>
            <th>salon</th>
            <th>cliente</th>
            </tr>
            </thead>
            <tbody>";

            foreach($tabla as $registro)
            {
                echo "<tr>";
                echo "<td> $registro->ID</td>";
                echo "<td> $registro->nombre</td>";
                echo "<td> $registro->usuarioAdmin</td>";
                echo "<td> $registro->usuarioChef</td>";
                echo "<td> $registro->usuarioMesero</td>";
                echo "<td> $registro->invitados</td>";
                echo "<td> $registro->estado</td>";
                echo "<td> $registro->fechaCreacion</td>";
                echo "<td> $registro->fechaFabulloso</td>";
                echo "<td> $registro->comidas_id</td>";
                echo "<td> $registro->salones_id</td>";
                echo "<td> $registro->clientes_id</td>";
                echo "</tr>";
            }

            echo "</tbody>
            </table>";
            $conexion->desconectarBD();
        }
?>