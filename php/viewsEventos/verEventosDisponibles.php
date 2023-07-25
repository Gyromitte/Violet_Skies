<?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
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
            <th style='align-content': center;></th>
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
                echo "<td> $registro->INVITADOS</td>";
                echo "<td> $registro->SALON</td>";
                echo "<td> $registro->SALON</td>";
                echo "<td> $registro->SALON</td>";
                echo "<td class='text-center'>";
                echo '<div class="dropdown">';
                echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" 
                data-bs-toggle="dropdown" aria-expanded="false">';
                echo '</button>';
                echo '<ul class="dropdown-menu custom-drop-menu">';
                echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#empModal" 
                data-bs-whatever="@ponerte" 
                data-id="' . $registro->CUENTA . '">
                <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Entrar</a></li>';
                echo '</ul></div>';
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>
            </table>";
            $conexion->desconectarBD();
        }
        
?>