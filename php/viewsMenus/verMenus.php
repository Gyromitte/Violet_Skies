<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

isset($_GET['vista']);
    $vista = $_GET['vista'];


    
    $consulta = "SELECT c.ID, c.NOMBRE, c.DESCRIPCION, tc.TIPO
                 FROM COMIDAS c
                 JOIN TIPO_COMIDAS tc ON c.TIPO = tc.ID
                 WHERE c.TIPO = $vista";
    
    $tabla = $conexion->seleccionar($consulta);

echo '<div class="table-responsive">';
echo '<table class="table table-hover mt-3">';
echo '<thead class="thead-purple">';
echo '<tr>';
echo '<th>Menú</th>';
echo '<th>Descripcion</th>';;
echo '<th>Tipo</th>';
echo '<th style="text-align: center;"></th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
    
foreach ($tabla as $registro) {
    echo "<tr>";
    echo "<td> $registro->NOMBRE </td>";
    echo "<td> $registro->DESCRIPCION </td>";
    echo "<td> $registro->TIPO </td>";

    //8 es DESCONTINUADO
    if($vista == '8'){
        echo "<td class='text-center'>";
        echo '<div class="dropdown">';
        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
        echo '</button>';
        echo '<ul class="dropdown-menu custom-drop-menu">';
        echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@reincorporarMenu" 
        data-id="' . $registro->ID . '">
        <i class="fa-solid fa-rotate-left me-2" style="color: #ffffff;"></i>Re-Incorporar</a></li>';
        echo '</ul>';
        echo '</div>';
        echo "</td>";
        echo '</tr>';
    }else{
        // Generar el botón de opciones con el menú desplegable
        echo "<td class='text-center'>";
        echo '<div class="dropdown">';
        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
        echo '</button>';
        echo '<ul class="dropdown-menu custom-drop-menu">';
        echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@editarMenu" 
        data-id="' . $registro->ID . '">
        <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Editar</a></li>';
        echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@descontinuarMenu" 
        data-id="' . $registro->ID . '">
        <i class="fa-solid fa-circle-minus me-2" style="color: #ffffff;"></i>Descontinuar</a></li>';
        echo '</ul>';
        echo '</div>';
        echo "</td>";
        echo '</tr>';
    }

    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';


$conexion->desconectarBD();
?>