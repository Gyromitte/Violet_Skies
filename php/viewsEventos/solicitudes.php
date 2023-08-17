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

        
        echo "<h2 class='text-center'>Empleados para $nombre_evento</h2>";
echo '<ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">';

    echo '<li class="nav-item" role="presentation">';
    echo '<a class="nav-link" id="pills-meseros-tab" data-bs-toggle="pill" href="#pills-meseros" role="tab" aria-controls="pills-meseros" aria-selected="true" id="meserosSoli" onclick="mostrarSolicitudesEmpleados()">Peticiones</a>
    ';
    echo '</li>';


    echo '<li class="nav-item" role="presentation">';
    echo '<a class="nav-link" id="pills-cocineros-tab" data-bs-toggle="pill" href="#pills-cocineros" role="tab" aria-controls="pills-cocineros" aria-selected="false" id="cocinaSoli">Cocineros</a>';
    echo '</li>';

echo '</ul>';

echo '<div class="tab-content" id="solicit">';
echo "<h2>Meseros</h2>";
if (count($solicitudes_meseros) > 0) {
    echo '<div class="tab-pane fade show active" id="pills-meseros" role="tabpanel" aria-labelledby="pills-meseros-tab">';
    echo '<form method="post" action="/php/viewsEventos/aceptarMeseros.php">';
    foreach ($solicitudes_meseros as $solicitud) {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="empleados[]" value="' . $solicitud->ID . '">';
        echo '<label class="form-check-label">' . $solicitud->EMPLEADO . '</label>';
        echo '</div>';
    }
    echo '<input type="hidden" name="faltan_meseros" value="' . $FALTAN_MESEROS . '">';
    echo '<input type="hidden" name="evento_id" value="' . $evento_id . '">';
    echo '<button type="submit" class="btn btn-primary" name="accion" value="aceptar_seleccionados">Aceptar seleccionados</button>';
    echo '</form>';
    echo '</div>';
} else {echo "<h4>No hay solicitudes por mostrar</h4>";}
if (count($solicitudes_cocineros) > 0) {
    echo '<div class="tab-pane fade show active" id="pills-meseros" role="tabpanel" aria-labelledby="pills-meseros-tab">';
    echo '<form method="post" action="/php/viewsEventos/aceptarCocina.php">';
    echo "<h2>Cocina</h2>";
    foreach ($solicitudes_cocineros as $solicitud) {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="empleados[]" value="' . $solicitud->ID . '">';
        echo '<label class="form-check-label">' . $solicitud->EMPLEADO . '</label>';
        echo '</div>';
    }
    echo '<input type="hidden" name="faltan_coina" value="' . $FALTAN_COCINA . '">';
    echo '<input type="hidden" name="evento_id" value="' . $evento_id . '">';

    echo '<button type="submit" class="btn btn-primary" name="accion" value="aceptar_seleccionados">Aceptar seleccionados</button>';
    echo '</form>';
    echo '</div>';
} else {echo "<h4>No hay solicitudes por mostrar</h4>";}

echo '</div>';

} else {
    echo "<p class='text-center'>Evento no especificado.</p>";
}
?>