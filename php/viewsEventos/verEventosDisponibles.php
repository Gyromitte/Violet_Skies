<?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();
        session_start();
        $emp=$_SESSION["trabajo"];
        extract($_POST);
        if($orden=="porcreacion"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, 
            CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON,COM.NOMBRE AS COMIDA,COM.DESCRIPCION, DE.MESEROS,
            DE.COCINEROS, DE.ESTADO AS CANT
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON JOIN COMIDAS COM ON COM.ID=DE.COMIDA
            WHERE E.ESTADO='EN PROCESO' AND NOT EXISTS 
            (SELECT 1 FROM EVENTO_EMPLEADOS EE
            WHERE EE.EVENTO = E.ID AND EE.EMPLEADOS = '$emp') ORDER BY E.F_CREACION";
        }
        else if($orden=="lejanoevento"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON,COM.NOMBRE AS COMIDA,COM.DESCRIPCION,
             DE.MESEROS, DE.COCINEROS, DE.ESTADO AS CANT
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON  JOIN COMIDAS COM ON COM.ID=DE.COMIDA
             WHERE E.ESTADO='EN PROCESO' AND NOT EXISTS
            (SELECT 1 FROM EVENTO_EMPLEADOS EE
            WHERE EE.EVENTO = E.ID AND EE.EMPLEADOS = '$emp') ORDER BY E.F_EVENTO DESC";
        }
        else if($orden=="cercasevento"){
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON,COM.NOMBRE AS COMIDA,COM.DESCRIPCION,
             DE.MESEROS, DE.COCINEROS, DE.ESTADO AS CANT
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON  JOIN COMIDAS COM ON COM.ID=DE.COMIDA
              WHERE E.ESTADO='EN PROCESO' AND NOT EXISTS
            (SELECT 1 FROM EVENTO_EMPLEADOS EE
            WHERE EE.EVENTO = E.ID AND EE.EMPLEADOS = '$emp') ORDER BY E.F_EVENTO ASC";
        }
        else{
            exit;
        }
        
        $tabla = $conexion->seleccionar($consulta);
        $num=count($tabla);
        if($num==0){
            echo"<h1> No hay eventos pendientes al momento</h1>";
        }
        foreach($tabla as $registro){
            $evento=$registro->ID;

            $count_query = "SELECT 
                        (SELECT COUNT(*) FROM EVENTO_EMPLEADOS 
                            WHERE EVENTO = '$evento' AND EMPLEADOS IN (SELECT ID FROM EMPLEADOS WHERE TIPO='MESERO')) AS cant_meseros,
                        (SELECT COUNT(*) FROM EVENTO_EMPLEADOS 
                            WHERE EVENTO = '$evento' AND EMPLEADOS IN (SELECT ID FROM EMPLEADOS WHERE TIPO='COCINA')) AS cant_cocineros
                    FROM DUAL";

                $result = $conexion->seleccionar($count_query);

                $cantm = $result[0]->cant_meseros;
                $cantc = $result[0]->cant_cocineros;


            if($registro->CANT==='LLENO'){
                continue;       
            }
            if($_SESSION["tipo"]=='MESERO'){
                if($cantm==$registro->MESEROS){
                    continue;
                }
            }
            if($_SESSION["tipo"]=='COCINERO'){
                if($cantc==$registro->COCINEROS){
                    continue;
                }
            }
                  
                
            echo"<div class='container-fluid'";
            echo"<div class=' card-group col-lg-5 col-mb-5 col-sm-12  d-flex '>";
            echo "<div class='card' id='cuadroEvento'>";
            echo "<h4><b> $registro->NOMBRE</b></h4>";
            echo "<p><b>Creada: </b> $registro->F_CREACION</p>";
            echo "<p><b>Fecha de Evento: </b> $registro->F_EVENTO</p>";
            echo "<p><b>Cliente: </b> $registro->CLIENTE</p>";
            echo "<p><b>Cantidad de invitados: </b> $registro->INVITADOS</p>";
            echo "<p><b>Salon: </b> $registro->SALON</p>";
            echo "<p data-bs-toggle='tooltip' data-bs-title='$registro->DESCRIPCION'>
            <b>Comida: </b> $registro->COMIDA</p>";
            echo "<p><b>Meseros Necesarios: </b>$cantm / $registro->MESEROS</p>";
            echo "<p><b>Cocineros Necesarios: </b>$cantc / $registro->COCINEROS</p>";
                echo "<div class='text-center'>";
                    echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">Asistir';
                        echo '</button>';
                        echo '<ul class="dropdown-menu custom-drop-menu">';
                            echo '<li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#empModal" 
                                data-bs-whatever="@asist" 
                                data-id="'.$registro->ID.'">
                                    <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Asistir
                                </a>
                                </li>';
                        echo '</ul>
                        </div>';
                echo "</div>";
                echo"</div>";
            echo "</div>";
            echo"</div>";
            }
            }
        
        
         $conexion->desconectarBD();
        
        
?>
