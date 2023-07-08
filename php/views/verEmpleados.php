<?php
    include "/xampp/htdocs/php/scripts/dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

            $consulta = "SELECT * FROM usuarios";

            $tabla = $conexion->seleccionar($consulta);

            echo "<table class='table table-hover'>
            <thead class='table-dark'>
            <tr>
            <th>ID</th>
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
                echo "<td> $registro->id </td>";
                echo "<td> $registro->nombre </td>";
                echo "<td> $registro->apellidoPaterno </td>";
                echo "<td> $registro->apellidoMaterno </td>";
                echo "<td> $registro->rfc </td>";
                echo "<td> $registro->telefono </td>";
                echo "<td> $registro->correo </td>";
                echo "<td> $registro->tipoUsuario</td>";
                echo "</tr>";
            }
            echo "</tbody>
            </table>";
            $conexion->desconectarBD();
?>