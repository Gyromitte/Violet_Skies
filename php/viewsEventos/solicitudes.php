<?php
    if (isset($_GET['evento_id'])) {
        $evento_id = $_GET['evento_id'];
        $FALTAN_MESEROS = $_GET['FALTAN_MESEROS'];
        $FALTAN_COCINA = $_GET['FALTAN_COCINA'];

        $nombre_evento = isset($_GET['nombre_evento']) ? $_GET['nombre_evento'] : "Evento sin nombre";

        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        $consulta_meseros = "SELECT E.ID, CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS EMPLEADO, E.TIPO, SE.ACEPTADO
                             FROM SOLICITUDES_EMPLEADO SE JOIN EMPLEADOS E ON SE.EMPLEADO=E.ID
                             JOIN CUENTAS C ON C.ID=E.CUENTA
                             WHERE EVENTO = '$evento_id' AND E.TIPO = 'MESERO' AND SE.ACEPTADO=0 ORDER BY EMPLEADO ASC";

        $consulta_cocineros = "SELECT E.ID, CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS EMPLEADO, E.TIPO, SE.ACEPTADO
                               FROM SOLICITUDES_EMPLEADO SE JOIN EMPLEADOS E ON SE.EMPLEADO=E.ID
                               JOIN CUENTAS C ON C.ID=E.CUENTA
                               WHERE EVENTO = '$evento_id' AND E.TIPO = 'COCINA' AND SE.ACEPTADO=0 ORDER BY EMPLEADO ASC";

        $parametros = array(":evento_id" => $evento_id);

        $solicitudes_meseros = $conexion->seleccionar($consulta_meseros, $parametros);
        $solicitudes_cocineros = $conexion->seleccionar($consulta_cocineros, $parametros);

        $conexion->desconectarBD();
        
        echo "  <h2 class='text-center'>Empleados para $nombre_evento</h2>
        <ul class='nav nav-pills nav-fill' id='pills-tab' role='tablist'>
        <li class='nav-item' role='presentation'>
        <a class='nav-link' data-bs-toggle='pill' role='tab' aria-selected='true' onclick='mostrarSolicitudesEmpleados()'>Peticiones</a>
        </li>
        <li class='nav-item' role='presentation'>
        <a class='nav-link' data-bs-toggle='pill' role='tab' aria-selected='true' onclick='mostrarmeserosIngresados($evento_id)'>Meseros ingresados</a>
        </li>
        <li class='nav-item' role='presentation'>
        <a class='nav-link' data-bs-toggle='pill' role='tab' aria-selected='true' onclick='mostrarcocinaIngresados($evento_id)'>Cocina ingresados</a>
        </li>
        </ul>

        <div id='empleadosRegistrados'></div>

        <div class='tab-content' id='solicit'>
        <form method='post' action='/php/viewsEventos/ingresosEvento.php'>
        <h2>Meseros</h2>";
        if (count($solicitudes_meseros) > 0) {
            echo '<div class="tab-pane fade show active" role="tabpanel">';
            foreach ($solicitudes_meseros as $solicitud) {
                echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" name="meseros[]" value="' . $solicitud->ID . '">
                <label class="form-check-label">' . $solicitud->EMPLEADO . '</label>
                </div>';
            }
            echo '<input type="hidden" name="faltan_meseros" value="' . $FALTAN_MESEROS . '">';
        } else {echo "<h4>No hay solicitudes por mostrar</h4>";}
        echo "<br><h2>Cocina</h2>";
        if (count($solicitudes_cocineros) > 0) {    
            foreach ($solicitudes_cocineros as $solicitud) {
                echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" name="cocina[]" value="' . $solicitud->ID . '">
                <label class="form-check-label">' . $solicitud->EMPLEADO . '</label>
                </div>';
            }
            echo '<input type="hidden" name="faltan_cocina" value="' . $FALTAN_COCINA . '">';
        } else {echo "<h4>No hay solicitudes por mostrar</h4>";}
        echo '<input type="hidden" name="evento_id" value="' . $evento_id . '">
        <button type="submit" class="btn btn-primary" name="accion" value="aceptar_seleccionados">Aceptar empleados</button>
        </form>
        </div>
        </div>';
    } else {
    echo "<p class='text-center'>Evento no especificado.</p>";
}
?>