<?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        extract($_POST);
        if($orden="porcreacion"){
            $consulta = "SELECT E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON WHERE E.ESTADO='EN PROCESO' ORDER BY E.F_CREACION";
        }
        else if($orden="lejanoevento"){
            $consulta = "SELECT E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON WHERE E.ESTADO='EN PROCESO' ORDER BY E.F_EVENTO desc";
        }
        
        $tabla = $conexion->seleccionar($consulta);

        foreach($tabla as $registro){
            echo "<div class='evento'>";
            echo "<b> $registro->NOMBRE</b>";
            echo "<p>Creada: $registro->F_CREACION</p>";
            echo "<p>Fecha de Evento: $registro->F_EVENTO</p>";
            echo "<p>Cliente: $registro->CLIENTE</p>";
            echo "<p>Cantidad de invitados: $registro->INVITADOS</p>";
            echo "<p>Salon: $registro->SALON</p>";
            echo "<p> $registro->MESEROS</p>";
            echo "<p> $registro->COCINEROS</p>";
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
         $conexion->desconectarBD();
        }
        
?>