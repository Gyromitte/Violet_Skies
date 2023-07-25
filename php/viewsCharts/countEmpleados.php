<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

header('Content-Type: application/json');

/* Contar empleados tipo Cocina */
$consultaCocina = "SELECT COUNT(*) AS count_cocina
FROM EMPLEADOS E
INNER JOIN CUENTAS C ON E.CUENTA = C.ID
WHERE E.TIPO = 'COCINA'
AND C.ESTADO = 'ACTIVO'";

$resultadoCocina = $conexion->seleccionar($consultaCocina);
$countCocina = $resultadoCocina[0]->count_cocina;

/* Contar empleados tipo Mesero */
$consultaMesero = "SELECT COUNT(*) AS count_mesero
FROM EMPLEADOS E
INNER JOIN CUENTAS C ON E.CUENTA = C.ID
WHERE E.TIPO = 'MESERO'
AND C.ESTADO = 'ACTIVO'";

$resultadoMesero = $conexion->seleccionar($consultaMesero);
$countMesero = $resultadoMesero[0]->count_mesero;

echo json_encode(array("count_cocina" => $countCocina, "count_mesero" => $countMesero));

$conexion->desconectarBD();
?>