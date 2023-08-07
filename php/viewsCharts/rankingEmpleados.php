<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

header('Content-Type: application/json');

$consultaRanking = "SELECT EMPLEADO_ID, NOMBRE_EMPLEADO, CANTIDAD_EVENTOS_PARTICIPADOS
FROM (
    SELECT
        e.ID AS EMPLEADO_ID,
        c.NOMBRE AS NOMBRE_EMPLEADO,
        COUNT(EE.EMPLEADOS) AS CANTIDAD_EVENTOS_PARTICIPADOS,
        RANK() OVER (ORDER BY COUNT(EE.EMPLEADOS) DESC) AS RANK_EMPLEADO
    FROM
        EMPLEADOS e
    JOIN
        CUENTAS c ON e.CUENTA = c.ID
    JOIN
        EVENTO_EMPLEADOS EE ON e.ID = EE.EMPLEADOS
    WHERE
        c.ESTADO = 'ACTIVO'
    AND TRIM(c.NOMBRE) != ''
    GROUP BY
        e.ID, c.NOMBRE
) AS empleados_ranking
WHERE RANK_EMPLEADO <= 6";

$resultadoRanking = $conexion->seleccionar($consultaRanking);

$rankingEmpleados = array();

foreach ($resultadoRanking as $fila) {
    $empleado = array(
        "EMPLEADO_ID" => $fila->EMPLEADO_ID,
        "NOMBRE_EMPLEADO" => $fila->NOMBRE_EMPLEADO,
        "CANTIDAD_EVENTOS_PARTICIPADOS" => $fila->CANTIDAD_EVENTOS_PARTICIPADOS
    );
    $rankingEmpleados[] = $empleado;
}

echo json_encode($rankingEmpleados);

$conexion->desconectarBD();
?>