<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

          extract($_POST);


            if($estado === "todo") {$consulta = "SELECT E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID";}
            else {$consulta = "SELECT E.NOMBRE, E.ESTADO, E.F_CREACION, F_EVENTO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS CLIENTE
              FROM EVENTO E INNER JOIN CUENTAS C ON E.CLIENTE=C.ID WHERE E.ESTADO='$estado'";}

          $tabla = $conexion->seleccionar($consulta);

    if (count($tabla) > 0) {
        echo '<div class="table-responsive">';
        echo "<table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Creación</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($tabla as $registro) {
            echo "<tr>";
            echo "<td> $registro->NOMBRE</td>";
            echo "<td> $registro->ESTADO</td>";
            echo "<td> $registro->F_CREACION</td>";
            echo "<td> $registro->F_EVENTO</td>";
            echo "<td> $registro->CLIENTE</td>";

            // Generar el botón de opciones con el menú desplegable
            echo "<td class='text-center'>";
            echo '<div class="dropdown">';
            echo "<button class='btn btn-secondary dropdown-toggle custom-dropdown' type='button' data-bs-toggle='modal' data-bs-target='#mainModal'
            data-bs-whatever='@verDetallesEvento' data-event-id='$registro->ID' >";
            echo '</button>';
            echo '</div>';
            echo "</td>";
            echo "</tr>";
        }
    }
}
?>