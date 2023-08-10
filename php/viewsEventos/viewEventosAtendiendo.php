<?php
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();
        session_start();
        $emp=$_SESSION["trabajo"];
        extract($_POST);

        $consulta = "CALL verEmpAtendiendo(?)";
        $parametros = array($emp);

        $tabla = $conexion->seleccionarPreparado($consulta, $parametros);

        $num=count($tabla);
        if($num==0){
            echo"<h1> No estas escrito en ningun evento por el momento</h1>";
        }
        foreach($tabla as $registro){
            $evento=$registro->ID;
            
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
            echo "<p><b>Meseros Necesarios: </b>$registro->MESEROS</p>";
            echo "<p><b>Cocineros Necesarios: </b>$registro->COCINEROS</p>";
                echo "<div class='text-center'>";
                    echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">Cancelar';
                        echo '</button>';
                        echo '<ul class="dropdown-menu custom-drop-menu">';
                            echo '<li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#empModal" 
                                data-bs-whatever="@cancelar" 
                                data-id="'.$evento.'">
                                    <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Cancelar
                                </a>
                                </li>';
                        echo '</ul>';
                        echo '</div><br>';
                        echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" 
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
        
         $conexion->desconectarBD();
        
?>