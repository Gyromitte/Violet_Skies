<?php
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();
        session_start();
        $emp=$_SESSION["trabajo"];
        extract($_POST);
       
        $consulta = "CALL verEventosFinalizados(?)";
        $parametros = array($emp);

        $tabla = $conexion->seleccionarPreparado($consulta, $parametros);

        $num=count($tabla);
        if($num==0){
            echo"<h1> No has estado escrito en ningun evento por el momento</h1>";
        }
        foreach($tabla as $registro){
            $evento=$registro->ID;
            $eventoDate= new datetime($registro->F_CREACION);
            $fecha = $eventoDate->format('Y-m-d');

            
            echo"<div class='container-fluid'";
            echo"<div class=' card-group col-lg-5 col-mb-5 col-sm-12  d-flex '>";
            echo "<div class='card' id='cuadroEvento'>";
            echo "<h4><b> $registro->NOMBRE</b></h4>";
            echo "<p><b>Creada: </b> $fecha</p>";
            echo "<p><b>Fecha de Evento: </b> $registro->F_EVENTO</p>";
            echo "<p><b>Cliente: </b> $registro->CLIENTE</p>";
            echo "<p><b>Cantidad de invitados: </b> $registro->INVITADOS</p>";
            echo "<p><b>Salon: </b> $registro->SALON</p>";
            echo "<p><b>Comida: </b> $registro->COMIDA</p>";
            echo "<p><b>Meseros Necesarios: </b>$registro->MESEROS</p>";
            echo "<p><b>Cocineros Necesarios: </b>$registro->COCINEROS</p>";
                echo"</div>";
            echo "</div>";
            echo"</div>";
            }
        
         $conexion->desconectarBD();
        
?>