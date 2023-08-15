<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'aceptar_seleccionados') {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        $empleadosSeleccionados = isset($_POST['empleados']) ? $_POST['empleados'] : array();
        $FALTAN_MESEROS = $_POST['faltan_meseros'];
        $EVENTO = $_POST['evento_id'];

        if (count($empleadosSeleccionados) > $FALTAN_MESEROS) {
            echo '<script>alert("Selecciona solo ' . $FALTAN_MESEROS . ' mesero(s).");</script>';
            echo '<script>window.history.back();</script>';
            exit();
        } else {
            if (is_array($empleadosSeleccionados) && count($empleadosSeleccionados) > 0) {
                foreach ($empleadosSeleccionados as $empleado_id) {
                    $update_query = "UPDATE SOLICITUDES_EMPLEADO SET ACEPTADO = 1 WHERE EMPLEADO = :empleado_id AND EVENTO = :EVENTO;
                    CALL ProcesoActualizarTablaEventoEmpleados()";
                    $parametros = array(":empleado_id" => $empleado_id, ":EVENTO" => $EVENTO);
                    $conexion->ejecutarPreparado($update_query, $parametros);
                }
                echo '<script>alert("Empleados aceptados exitosamente.");</script>';
                echo '<script>window.history.back();</script>';
            exit();
            } else {
                echo '<script>alert("No se han seleccionado empleados.");</script>';
                echo '<script>window.history.back();</script>';
            exit();
            }
        }

        $conexion->desconectarBD();
    }
}
?>
