<?php
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();
        session_start();
        $emp=$_SESSION["trabajo"];
        extract($_POST);
       
            $consulta = "SELECT E.ID,E.NOMBRE, E.F_CREACION, E.F_EVENTO, CONCAT(CU.NOMBRE, ' ', CU.AP_PATERNO, ' ', CU.AP_MATERNO) AS CLIENTE,
            DE.INVITADOS, S.NOMBRE AS SALON,COM.NOMBRE AS COMIDA, DE.MESEROS, DE.COCINEROS
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON JOIN COMIDAS COM ON COM.ID=DE.COMIDA
             WHERE E.ESTADO='FINALIZADO'
             AND EXISTS (SELECT 1 FROM EVENTO_EMPLEADOS EE
            WHERE EE.EVENTO = E.ID AND EE.EMPLEADOS = '$emp') ORDER BY E.F_EVENTO ASC";
        
        $tabla = $conexion->seleccionar($consulta);
        $num=count($tabla);
        if($num==0){
            echo"<h1> No has estado escrito en ningun evento por el momento</h1>";
        }
        foreach($tabla as $registro){
            $evento=$registro->ID;

                $meseros="SELECT COUNT(EE.EMPLEADOS) FROM EVENTO_EMPLEADOS EE JOIN EVENTO E 
                ON E.ID=EE.EVENTO JOIN EMPLEADOS EMP ON EMP.ID=EE.EMPLEADOS WHERE
                E.ID='$evento' AND EMP.TIPO='MESERO'";
                $verm=$conexion->seleccionar($meseros);
                $cantm=count($verm);

                $cocineros="SELECT COUNT(EE.EMPLEADOS) FROM EVENTO_EMPLEADOS EE JOIN EVENTO E 
                ON E.ID=EE.EVENTO JOIN EMPLEADOS EMP ON EMP.ID=EE.EMPLEADOS WHERE
                E.ID='$evento' AND EMP.TIPO='COCINERO'";
                $verc=$conexion->seleccionar($cocineros);
                $cantc=count($verc);
            
            echo"<div class='container-fluid'";
            echo"<div class=' card-group col-lg-5 col-mb-5 col-sm-12  d-flex '>";
            echo "<div class='card' id='cuadroEvento'>";
            echo "<h4><b> $registro->NOMBRE</b></h4>";
            echo "<p><b>Creada: </b> $registro->F_CREACION</p>";
            echo "<p><b>Fecha de Evento: </b> $registro->F_EVENTO</p>";
            echo "<p><b>Cliente: </b> $registro->CLIENTE</p>";
            echo "<p><b>Cantidad de invitados: </b> $registro->INVITADOS</p>";
            echo "<p><b>Salon: </b> $registro->SALON</p>";
            echo "<p><b>Comida: </b> $registro->COMIDA</p>";
            echo "<p><b>Meseros Necesarios: </b>$cantm / $registro->MESEROS</p>";
            echo "<p><b>Cocineros Necesarios: </b>$cantc / $registro->COCINEROS</p>";
                echo"</div>";
            echo "</div>";
            echo"</div>";
            }
        
         $conexion->desconectarBD();
        
?>