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
        echo '<div class="d-flex justify-content-center">';
    echo '<div class="accordion" id="accordionMeserosCocineros">'; // Iniciar el contenedor de acordeones

if (count($solicitudes_meseros) > 0) {
    echo '<div class="accordion-item">';
    echo '<h2 class="accordion-header" id="headingMeseros">';
    echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeseros" aria-expanded="true" aria-controls="collapseMeseros">Meseros</button>';
    echo '</h2>';
    echo '<div id="collapseMeseros" class="accordion-collapse collapse show" aria-labelledby="headingMeseros" data-bs-parent="#accordionMeserosCocineros">';
    echo '<div class="accordion-body">';
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
    echo '</div>';
    echo '</div>';
}

    if (count($solicitudes_cocineros) > 0) {
        echo '<div class="accordion-item">';
        echo '<h2 class="accordion-header" id="headingCocineros">';
        echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCocineros" aria-expanded="false" aria-controls="collapseCocineros">Cocineros</button>';
        echo '</h2>';
        echo '<div id="collapseCocineros" class="accordion-collapse collapse" aria-labelledby="headingCocineros" data-bs-parent="#accordionMeserosCocineros">';
        echo '<div class="accordion-body">';
        echo '<form method="post" action="/php/viewsEventos/aceptarCocina.php">';
        foreach ($solicitudes_cocineros as $solicitud) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="empleados[]" value="' . $solicitud->ID . '">';
            echo '<label class="form-check-label">' . $solicitud->EMPLEADO . '</label>';
            echo '</div>';
        }
        echo '<input type="hidden" name="faltan_cocina" value="' . $FALTAN_COCINA . '">';
        echo '<input type="hidden" name="evento_id" value="' . $evento_id . '">';
    echo '<button type="submit" class="btn btn-primary" name="accion" value="aceptar_seleccionados">Aceptar seleccionados</button>';
    echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    else
    {
        echo 'Aún no hay solicitudes para este evento';
    }

    echo '</div>';
    echo '</div>';
} else {
    echo "<p class='text-center'>Evento no especificado.</p>";
}
?>

