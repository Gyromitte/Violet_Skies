<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];

    $consulta = "SELECT E.ID, C.NOMBRE, C.AP_PATERNO, C.AP_MATERNO, E.RFC, C.TELEFONO, C.CORREO, E.TIPO,E.COMPORTAMIENTO, E.CUENTA
    FROM EMPLEADOS E
    INNER JOIN CUENTAS C ON E.CUENTA = C.ID
    WHERE (C.CORREO LIKE '%$busqueda%'
    OR C.NOMBRE LIKE '%$busqueda%'
    OR C.AP_PATERNO LIKE '%$busqueda%'
    OR C.AP_MATERNO LIKE '%$busqueda%'
    or C.TELEFONO LIKE '%$busqueda%'
    OR E.TIPO LIKE '%$busqueda%'
    OR E.RFC LIKE '%$busqueda%'
    OR E.COMPORTAMIENTO LIKE '%$busqueda%')
    AND C.ESTADO = 'ACTIVO'";
    $tabla = $conexion->seleccionar($consulta);

    if (empty($tabla)) {
        echo "<p style= 'color: #343434;'>No se encontró ninguna coincidencia</p>";
    } else {
        echo '<div class="table-responsive">';
        echo '<table class="table table-hover mt-3">';
        echo '<thead class="thead-purple">';
        echo '<tr>';
        echo '<th>Nombre</th>';
        echo '<th>Ape. Paterno</th>';
        echo '<th>Ape. Materno</th>';
        echo '<th>RFC</th>';
        echo '<th>Teléfono</th>';
        echo '<th>Correo</th>';
        echo '<th>Comportamiento</th>';
        echo '<th>Tipo</th>';
        echo '<th style="text-align: center;"></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($tabla as $registro) {
            echo "<tr>";
            echo "<td> $registro->NOMBRE </td>";
            echo "<td> $registro->AP_PATERNO </td>";
            echo "<td> $registro->AP_MATERNO </td>";
            echo "<td> $registro->RFC </td>";
            echo "<td> $registro->TELEFONO </td>";
            echo "<td> $registro->CORREO </td>";
            echo "<td> $registro->COMPORTAMIENTO </td>";
            echo "<td> $registro->TIPO</td>";
            
            // Generar el botón de opciones con el menú desplegable
            echo "<td class='text-center'>";
            echo '<div class="dropdown">';
            echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
            echo '</button>';
            echo '<ul class="dropdown-menu custom-drop-menu">';
            echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@verHistorial" 
            data-id="' . $registro->CUENTA . '">
            <i class="fa-solid fa-clock-rotate-left me-2" style="color: #ffffff;"></i>Historial</a></li>';
            echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@editarEmpleado" 
            data-id="' . $registro->CUENTA . '">
            <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Editar</a></li>';
            echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@eliminarEmpleado" 
            data-id="' . $registro->CUENTA . '">
            <i class="fa-solid fa-user-slash me-2" style="color: #ffffff;"></i>Eliminar</a></li>';
            echo '</ul>';
            echo '</div>';
            echo "</td>";
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
} 

$conexion->desconectarBD();
?>

