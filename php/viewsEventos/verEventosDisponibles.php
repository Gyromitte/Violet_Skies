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
    DE.ID=E.ID WHERE E.ESTADO='PENDIENTE' ORDER BY E.F_CREACION";
        

          $tabla = $conexion->seleccionar($consulta);

            foreach($tabla as $registro)
            {
                echo "<div class='evento'>";
                echo "<b> $registro->NOMBRE</b>";
                echo "<p>Creada: $registro->F_CREACION</p>";
                echo "<p>Fecha de Evento: $registro->F_EVENTO</p>";
                echo "<p> $registro->CLIENTE</p>";
                echo "<p> $registro->INVITADOS</p>";
                echo "<p> $registro->SALON</p>";
                echo "<p> 5</p>";
                echo "<p> 7</p>";
                echo "<div class='text-center'>";
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
                echo "</div>";
                echo "</div>";
            }

            echo "</tbody>
            </table>";
            $conexion->desconectarBD();
        }
        
?>