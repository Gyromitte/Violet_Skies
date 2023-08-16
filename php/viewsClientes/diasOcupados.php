<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Conseguir los días que ya están ocupados y marcarlos en el calendario */
$consulta = "SELECT DATE(F_EVENTO) AS FECHA, COUNT(*) AS CANTIDAD_EVENTOS FROM EVENTO 
WHERE ESTADO = 'EN PROCESO' GROUP BY DATE(F_EVENTO)";
$resultado = $conexion->seleccionar($consulta);

// Crear un arreglo para almacenar los objetos de evento
$eventos = array();

foreach ($resultado as $fila) {
    $fechaEvento = $fila->FECHA; // Mantener el formato de fecha sin hora
    $color = $fila->CANTIDAD_EVENTOS > 1 ? '#ff0000' : ''; // Color rojo si hay múltiples eventos, de lo contrario vacío
    $evento = array(
        'title' => 'Evento(s)',
        'start' => $fechaEvento,
        'backgroundColor' => $color,
    );
    $eventos[] = $evento;
}

$conexion->desconectarBD();

// Convertir el arreglo de eventos a formato JSON y enviarlo al cliente
echo json_encode($eventos);

?>
