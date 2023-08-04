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

// Retornar los resultados como JSON
header('Content-Type: application/json');
echo json_encode(array("count_clientes" => $countClientes,
"count_empleados" => $countEmpleados, "count_eventos" => $countEventos,
"count_solicitudes" => $countSolicitudes));

$conexion->desconectarBD();
?>


