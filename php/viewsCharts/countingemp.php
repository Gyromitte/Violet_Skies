<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Consulta para contar cuentas de clientes */
$consultaClientes = "SELECT COUNT(*) AS count_clientes
            FROM EVENTO E JOIN CUENTAS CU ON E.CLIENTE=CU.ID JOIN DETALLE_EVENTO DE ON
            DE.ID=E.ID JOIN SALONES S ON S.ID=DE.SALON JOIN COMIDAS COM ON COM.ID=DE.COMIDA
            WHERE E.ESTADO='EN PROCESO' AND NOT EXISTS 
            (SELECT 1 FROM EVENTO_EMPLEADOS EE
            WHERE EE.EVENTO = E.ID AND EE.EMPLEADOS = emp)
            AND DE.ESTADO='FALTAN'";

$resultadoClientes = $conexion->seleccionar($consultaClientes);
$countDisp = $resultadoClientes[0]->count_disp;
header('Content-Type: application/json');
echo json_encode(array("count_disp" => $countDisp));
$conexion->desconectarBD();
?>