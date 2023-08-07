<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

header('Content-Type: application/json');

$consultaRanking = "SELECT COMIDAS.NOMBRE AS Menu, COUNT(*) AS Pedidos
FROM DETALLE_EVENTO
INNER JOIN COMIDAS ON DETALLE_EVENTO.COMIDA = COMIDAS.ID
INNER JOIN EVENTO ON DETALLE_EVENTO.ID = EVENTO.ID
WHERE EVENTO.F_EVENTO >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
GROUP BY COMIDAS.NOMBRE
ORDER BY Pedidos DESC
LIMIT 5;   ";

$resultadoRanking = $conexion->seleccionar($consultaRanking);

$rankingMenu = array();

foreach ($resultadoRanking as $fila) {
    $empleado = array(
        "Menu" => $fila->Menu,
        "Pedidos" => $fila->Pedidos
    );
    $rankingMenu[] = $empleado;
}

echo json_encode($rankingMenu);

$conexion->desconectarBD();
?>