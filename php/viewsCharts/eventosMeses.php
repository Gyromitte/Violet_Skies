<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Consulta para contar eventos que hayan sido FINALIZADOS agrupados por mes */
$consultaEventos = "SELECT MONTH(F_EVENTO) as mes, COUNT(*) AS cantidad FROM EVENTO
WHERE ESTADO = 'FINALIZADO'
GROUP BY mes
ORDER BY mes ASC";

$resultadoEventos = $conexion->seleccionar($consultaEventos);

// Creamos un array con la cantidad de eventos por mes
$eventosPorMes = array_fill(0, 12, 0); // Inicializamos el array con ceros para cada mes
foreach ($resultadoEventos as $evento) {
    $mes = intval($evento->mes);
    $eventosPorMes[$mes - 1] = intval($evento->cantidad);
}

// Retornar los resultados como JSON
header('Content-Type: application/json');
echo json_encode($eventosPorMes);

$conexion->desconectarBD();
?>
