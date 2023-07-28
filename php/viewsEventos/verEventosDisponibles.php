<?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        extract($_POST);
        if($orden=="porcreacion"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON WHERE E.ESTADO='EN PROCESO' ORDER BY E.F_CREACION";
        }
        else if($orden=="lejanoevento"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON WHERE E.ESTADO='EN PROCESO' ORDER BY E.F_EVENTO DESC";
        }
        else if($orden=="cercasevento"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON WHERE E.ESTADO='EN PROCESO' ORDER BY E.F_EVENTO ASC";
        }
        
        $tabla = $conexion->seleccionar($consulta);
        $num=count($tabla);
        if($num==0){
            echo"<h1> No hay eventos pendientes al momento</h1>";
        }

        foreach($tabla as $registro){
            echo"<div class='container-fluid'";
            echo"<div class=' card-group col-lg-5 col-mb-5 col-sm-12  d-flex '>";
            echo "<div class=' card' id='cuadroEvento'>";
            echo "<h4><b> $registro->NOMBRE</b></h4>";
            echo "<p><b>Creada:</b> $registro->F_CREACION</p>";
            echo "<p><b>Fecha de Evento:</b> $registro->F_EVENTO</p>";
            echo "<p><b>Cliente:</b> $registro->CLIENTE</p>";
            echo "<p><b>Cantidad de invitados:</b> $registro->INVITADOS</p>";
            echo "<p><b>Salon:</b> $registro->SALON</p>";
            echo "<p><b>Meseros Necesarios</b> $registro->MESEROS</p>";
            echo "<p><b>Cocineros Necesarios</b> $registro->COCINEROS</p>";
                echo "<div class='text-center'>";
                    echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">Entrar';
                        echo '</button>';
                        echo '<ul class="dropdown-menu custom-drop-menu">';
                            echo '<li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#empModal" 
                                data-bs-whatever="@ponerte" 
                                data-id="'.$registro->ID.'">
                                    <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Entrar
                                </a>
                                </li>';
                        echo '</ul>
                        </div>';
                echo "</div>";
                echo"</div>";
            echo "</div>";
            echo"</div>";
        }
         $conexion->desconectarBD();
        }
        
?>