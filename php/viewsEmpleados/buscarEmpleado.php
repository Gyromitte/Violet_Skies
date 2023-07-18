<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Verificar si se ha pasado el parámetro "busqueda" en la solicitud GET
if (isset($_GET['busqueda'])) {
  $busqueda = $_GET['busqueda'];

  $consulta = "SELECT E.ID, C.NOMBRE, C.AP_PATERNO, C.AP_MATERNO, E.RFC, C.TELEFONO, C.CORREO, E.TIPO, E.CUENTA
    FROM EMPLEADOS E
    INNER JOIN CUENTAS C ON E.CUENTA = C.ID
    WHERE C.CORREO = '$busqueda'
    OR C.NOMBRE = '$busqueda'
    OR C.AP_PATERNO = '$busqueda'
    OR C.AP_MATERNO = '$busqueda'";
  $tabla = $conexion->seleccionar($consulta);

  if (empty($tabla)) {
    echo "No se encontró ninguna coincidencia";
  } else {
    echo "<table class='table table-hover mt-3'>
            <thead class='thead-purple'>
                <tr>
                    <th>Nombre</th>
                    <th>Ape. Paterno</th>
                    <th>Ape. Materno</th>
                    <th>RFC</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th style='align-content': center;><th>
                </tr>
            </thead>
            <tbody>";

    foreach ($tabla as $registro) {
        echo "<tr>";
        echo "<td> $registro->NOMBRE </td>";
        echo "<td> $registro->AP_PATERNO </td>";
        echo "<td> $registro->AP_MATERNO </td>";
        echo "<td> $registro->RFC </td>";
        echo "<td> $registro->TELEFONO </td>";
        echo "<td> $registro->CORREO </td>";
        echo "<td> $registro->TIPO</td>";
        // Generar el botón de opciones con el menú desplegable
        echo "<td class='text-center'>";
        echo '<div class="dropdown">';
        echo '<button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
        echo '</button>';
        echo '<ul class="dropdown-menu custom-drop-menu">';
        echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@editarEmpleado" 
        data-id="' . $registro->CUENTA . '">Editar</a></li>';
        echo '<li><a class="dropdown-item" href="#">Eliminar</a></li>';
        echo '</ul>';
        echo '</div>';
        echo "</td>";
        echo '</tr>'; 
    }

    echo "</tbody>
          </table>";
  }
} 

$conexion->desconectarBD();
?>

