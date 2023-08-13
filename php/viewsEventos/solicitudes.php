<?php
    if (isset($_GET['evento_id'])) {
        $evento_id = $_GET['evento_id'];

        // Obtener el nombre del evento si se ha pasado como parámetro GET
        $nombre_evento = isset($_GET['nombre_evento']) ? $_GET['nombre_evento'] : "Evento sin nombre";

        // Realiza la conexión a la base de datos y obtén las solicitudes para el evento específico
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        // Consulta para obtener las solicitudes de meseros
        $consulta_meseros = "SELECT E.ID, CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS EMPLEADO, E.TIPO, SE.ACEPTADO
                             FROM SOLICITUDES_EMPLEADO SE JOIN EMPLEADOS E ON SE.EMPLEADO=E.ID
                             JOIN CUENTAS C ON C.ID=E.CUENTA
                             WHERE EVENTO = '$evento_id' AND E.TIPO = 'MESERO'";

        // Consulta para obtener las solicitudes de cocineros
        $consulta_cocineros = "SELECT E.ID, CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS EMPLEADO, E.TIPO, SE.ACEPTADO
                               FROM SOLICITUDES_EMPLEADO SE JOIN EMPLEADOS E ON SE.EMPLEADO=E.ID
                               JOIN CUENTAS C ON C.ID=E.CUENTA
                               WHERE EVENTO = '$evento_id' AND E.TIPO = 'COCINA'";

        $parametros = array(":evento_id" => $evento_id);

        // Ejecutar las consultas y obtener los resultados
        $solicitudes_meseros = $conexion->seleccionar($consulta_meseros, $parametros);
        $solicitudes_cocineros = $conexion->seleccionar($consulta_cocineros, $parametros);

        // Desconectar de la base de datos
        $conexion->desconectarBD();

        // Mostrar el nombre del evento en el título
        echo "<h2>Empleados para $nombre_evento</h2>";

        echo '<div class="tabla-container">'; // Iniciar contenedor flex

        // Mostrar las solicitudes de meseros en una tabla si existen
        if (count($solicitudes_meseros) > 0) {
            echo "<br><div class='tabla'>";
            echo "<h3>Meseros:</h3>";
            echo "<form method='post' action='accion.php'>"; // Agregar un formulario para manejar la acción
            echo "<table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Empleado</th>
                    </tr>
                </thead>
                <tbody>";
            foreach ($solicitudes_meseros as $solicitud) {
                echo "<tr>
                      <td><input type='checkbox' name='meseros[]' value='$solicitud->ID'></td>
                      <td>$solicitud->EMPLEADO</td>
                      </tr>";
            }
            echo "</tbody></table>";
            echo "<button type='submit' class='btn btn-primary'>Aceptar seleccionados</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "<p>No hay solicitudes de meseros.</p>";
        }

        // Mostrar las solicitudes de cocineros en otra tabla si existen
        if (count($solicitudes_cocineros) > 0) {
            echo "<br><div class='tabla'>";
            echo "<h3>Cocineros:</h3>";
            echo "<form method='post' action='accion.php'>"; // Agregar un formulario para manejar la acción
            echo "<table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Empleado</th>
                    </tr>
                </thead>
                <tbody>";
            foreach ($solicitudes_cocineros as $solicitud) {
                echo "<tr>
                      <td><input type='checkbox' name='cocineros[]' value='$solicitud->ID'></td>
                      <td>$solicitud->EMPLEADO</td>
                      </tr>";
            }
            echo "</tbody></table>";
            echo "<button type='submit' class='btn btn-primary'>Aceptar seleccionados</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "<p>No hay solicitudes de cocineros.</p>";
        }
        

        echo '</div>'; // Cerrar contenedor flex
    } else {
        echo "Evento no especificado.";
    }
    ?>

