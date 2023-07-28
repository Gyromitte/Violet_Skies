<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Consulta para contar cuentas de clientes */
$consultaClientes = "SELECT COUNT(*) AS count_clientes FROM CUENTAS C
WHERE TIPO_CUENTA = 'CLIENTE'";
$resultadoClientes = $conexion->seleccionar($consultaClientes);
$countClientes = $resultadoClientes[0]->count_clientes;

/* Consulta para contar a todos los empleados */
$consultaEmpleados = "SELECT COUNT(*) AS count_empleados FROM EMPLEADOS E";
$resultadoEmpleados = $conexion->seleccionar($consultaEmpleados);
$countEmpleados = $resultadoEmpleados[0]->count_empleados;

/* Consulta para contar eventos que haya sido FINALIZADOS */
$consultaEventos = "SELECT COUNT(*) AS count_eventos FROM EVENTO
WHERE ESTADO = 'FINALIZADO'";
$resultadoEventos = $conexion->seleccionar($consultaEventos);
$countEventos = $resultadoEventos[0]->count_eventos;

// Retornar los resultados como JSON
header('Content-Type: application/json');
echo json_encode(array("count_clientes" => $countClientes,
"count_empleados" => $countEmpleados, "count_eventos" => $countEventos));

$conexion->desconectarBD();
?>

