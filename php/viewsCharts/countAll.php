<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Consulta para contar cuentas de clientes */
$consultaClientes = "SELECT COUNT(*) AS count_clientes FROM CUENTAS C
WHERE TIPO_CUENTA = 'CLIENTE'
AND C.ESTADO = 'ACTIVO'";
$resultadoClientes = $conexion->seleccionar($consultaClientes);
$countClientes = $resultadoClientes[0]->count_clientes;

/* Consulta para contar a todos los empleados */
$consultaEmpleados = "SELECT COUNT(*) AS count_empleados FROM EMPLEADOS E
INNER JOIN CUENTAS C ON E.CUENTA = C.ID
WHERE C.ESTADO = 'ACTIVO'";
$resultadoEmpleados = $conexion->seleccionar($consultaEmpleados);
$countEmpleados = $resultadoEmpleados[0]->count_empleados;

/* Consulta para contar eventos que haya sido FINALIZADOS */
$consultaEventos = "SELECT COUNT(*) AS count_eventos FROM EVENTO
WHERE ESTADO = 'FINALIZADO'";
$resultadoEventos = $conexion->seleccionar($consultaEventos);
$countEventos = $resultadoEventos[0]->count_eventos;

/*Consulta para contar cuantas solicitudes hay actualmente*/
$consultaSolicitudes = "SELECT COUNT(*) AS count_solicitudes
FROM CUENTAS
WHERE CUENTAS.TIPO_CUENTA = 'EMPLEADO'
AND CUENTAS.ESTADO = 'ACTIVO'
AND NOT EXISTS (
    SELECT 1
    FROM EMPLEADOS
    WHERE EMPLEADOS.CUENTA = CUENTAS.ID
);";
$resultadoSolicitudes = $conexion->seleccionar($consultaSolicitudes);
$countSolicitudes = $resultadoSolicitudes[0]->count_solicitudes;

/* Consulta para contar eventos PENDIENTES */
$eventosPendientes = "SELECT COUNT(*) AS eventos_pendientes FROM EVENTO WHERE ESTADO = 'PENDIENTE'";
$resultadoPendientes = $conexion->seleccionar($eventosPendientes);
$countPendientes = $resultadoPendientes[0]->eventos_pendientes;

/* Consulta para contar eventos EN PROCESO */
$eventosProceso = "SELECT COUNT(*) AS eventos_proceso FROM EVENTO WHERE ESTADO = 'EN PROCESO'";
$resultadoProceso = $conexion->seleccionar($eventosProceso);
$countProceso = $resultadoProceso[0]->eventos_proceso;

/* Consulta para contar eventos CANCELADOS*/
$eventosCancelado = "SELECT COUNT(*) AS eventos_cancelados FROM EVENTO WHERE ESTADO = 'CANCELADO'";
$resultadoCancelado = $conexion->seleccionar($eventosCancelado);
$countCancelado = $resultadoCancelado[0]->eventos_cancelados;

/* Consulta para contar eventos FINALIZADOS*/
$eventosFin = "SELECT COUNT(*) AS eventos_cancelados FROM EVENTO WHERE ESTADO = 'FINALIZADO'";
$resultadoFin = $conexion->seleccionar($eventosFin);
$countFin = $resultadoFin[0]->eventos_cancelados;

// Retornar los resultados como JSON
header('Content-Type: application/json');
echo json_encode(array("count_clientes" => $countClientes,
"count_empleados" => $countEmpleados, 
"count_eventos" => $countEventos,
"count_solicitudes" => $countSolicitudes,
"countPendientes" => $countPendientes,
"countProceso" => $countProceso,
"countCancelado" => $countCancelado,
"countFin" => $countFin));

$conexion->desconectarBD();
?>


