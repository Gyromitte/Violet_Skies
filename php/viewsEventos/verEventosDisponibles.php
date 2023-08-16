<?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();
        session_start();
        $emp=$_SESSION["trabajo"];
        $modo=$_SESSION["tipo"];
        extract($_POST);
        if($modo=='COCINERO'){
            $modo='COCINA';
        }
  
        $consulta = "CALL verEventosDisponibles(?,?)";
        $parametros = array($emp,$orden);

        $tabla = $conexion->seleccionarPreparado($consulta, $parametros);

        $num=count($tabla);
        if($num==0){
            echo"<h1 style='color: #343434;
            '> No hay eventos pendientes al momento</h1>";
        }
        foreach($tabla as $registro){
            $evento=$registro->ID;
            $eventoDate= new datetime($registro->F_CREACION);
            $fecha = $eventoDate->format('Y-m-d');
            $consulta="SELECT COUNT(*) as cant FROM EVENTO_EMPLEADOS WHERE EVENTO = '$evento' AND EMPLEADOS 
            IN (SELECT ID FROM EMPLEADOS WHERE TIPO='$modo')";
            $cant=$conexion->seleccionar($consulta);
            foreach($cant as $many){
                $people=$many->cant;
                $cantm="SELECT MESEROS,COCINEROS FROM DETALLE_EVENTO WHERE ID='$evento'";
                $cantm=$conexion->seleccionar($cantm);
                foreach($cantm as $numdetails){
                    if($modo == 'MESERO' && $people == $numdetails->MESEROS){
                        continue 3; // Skip this event if MESEROS are already fulfilled
                    }
                    else if($modo == 'COCINA' && $people == $numdetails->COCINEROS){
                        continue;
                    }        
                }
            }
            if($registro->MESEROS=='' && $registro->COCINEROS==''){
                continue;
            }
            else if($modo == 'MESERO' && $registro->MESEROS === "0/0"){
                continue; // Skip this event if MESEROS are already fulfilled
            }
            else if($modo == 'COCINA' && $registro->COCINEROS === "0/0"){
                continue; // Skip this event if COCINEROS are already fulfilled
            }

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
                echo "<div class='text-center'>";
                echo"<div>";
                        echo '<button class="col-12 btn btn-options btn-primary border-2 btn-outline-light rounded-5" type="button" 
                        href="#" data-bs-toggle="modal" data-bs-target="#empModal" 
                        data-bs-whatever="@asist" 
                        data-id="'.$registro->ID.'">Asistir';
                    echo"</div>";
                        echo '</button><br>';
                        echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown btn-outline-light rounded-5" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">Descripcion de Comida';
                        echo '</button>';
                        echo '<ul class="dropdown-menu custom-drop-menu">';
                        if($registro->COMIDA=='No aplica'){
                            echo '<li>
                                    <p>No hay comida en este evento.</p>
                                </li>';
                        }
                        else{
                            echo '<li>
                                    '.$registro->DESCRIPCION.'
                                </li>';
                        }
                        echo '</ul>';
                    echo '</div>';
                echo "</div>";
                echo"</div>";
            echo "</div>";
            echo"</div>";
            }
            }
        
        
         $conexion->desconectarBD();
        
        
?>
