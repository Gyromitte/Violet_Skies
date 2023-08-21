<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'aceptar_seleccionados') {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        $meserosSeleccionados = isset($_POST['meseros']) ? $_POST['meseros'] : array();
        $cocinaSeleccionados = isset($_POST['cocina']) ? $_POST['cocina'] : array();
        $FALTAN_MESEROS = isset($_POST['faltan_meseros']) ? $_POST['faltan_meseros'] : 0;
        $FALTAN_COCINA = isset($_POST['faltan_cocina']) ? $_POST['faltan_cocina'] : 0;
        $EVENTO = $_POST['evento_id'];
        
        $update_query = "UPDATE SOLICITUDES_EMPLEADO SET ACEPTADO = 1 WHERE ";

        if (count($cocinaSeleccionados) > $FALTAN_COCINA || count($meserosSeleccionados) > $FALTAN_MESEROS) {
            echo '<script>alert("Solo hay cupo para ' . $FALTAN_COCINA . ' en cocina y/o ' . $FALTAN_MESEROS . ' mesero(s)");</script>';
            exit();
        } else {
            $conditions = array();
            if (count($meserosSeleccionados) > 0) {
                $meserosString = implode(', ', $meserosSeleccionados);
                $conditions[] = "EMPLEADO IN ($meserosString)";
            }
            if (count($cocinaSeleccionados) > 0) {
                $cocinaString = implode(', ', $cocinaSeleccionados);
                $conditions[] = "EMPLEADO IN ($cocinaString)";
            }
            if (count($conditions) > 0) {
                $update_query .= implode(' OR ', $conditions);
                $update_query .= " AND EVENTO = :EVENTO";
                $parametros = array(":EVENTO" => $EVENTO);
                $conexion->ejecutarPreparado($update_query, $parametros);
                $conexion->ejecutarSQL("CALL actualizar_estado_detalle_evento()");
                $conexion->ejecutarSQL("CALL ProcesoActualizarTablaEventoEmpleados();");
                
                echo '<script>alert("Empleados aceptados exitosamente.");</script>';
                echo '<script>window.history.back();</script>';
            } else {
                echo '<script>alert("No se han seleccionado empleados.");</script>';
                echo '<script>window.history.back();</script>';
            }
            exit();
        }
        $conexion->desconectarBD();
    }
}
?>
