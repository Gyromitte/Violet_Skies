<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'aceptar_seleccionados') {
        include_once "../dataBase.php";
        $conexion = new Database();
        $conexion->conectarBD();

        $empleadosSeleccionados = isset($_POST['empleados']) ? $_POST['empleados'] : array();
        $FALTAN_COCINA = $_POST['faltan_cocina'];
        $EVENTO = $_POST['evento_id'];

        if (count($empleadosSeleccionados) > $FALTAN_MESEROS) {
            echo '<script>alert("No puedes agregar mas cocineros");</script>';
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
                echo 'ok';
                echo '<script>
                setTimeout(function() {
                    window.location.reload();
                }, 3000); // 3000 milisegundos = 3 segundos
                </script>';
            } else {
                echo '<script>window.history.back();</script>';
                exit();
            }
        }

        $conexion->desconectarBD();
    }
}
?>