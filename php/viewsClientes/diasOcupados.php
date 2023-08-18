<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

/* Conseguir los días que ya están ocupados y marcarlos en el calendario */
$consulta = "SELECT DATE(F_EVENTO) AS FECHA, DETALLE_EVENTO.SALON, COUNT(*) AS CANTIDAD_EVENTOS 
             FROM EVENTO 
             INNER JOIN DETALLE_EVENTO ON EVENTO.ID = DETALLE_EVENTO.ID
             WHERE EVENTO.ESTADO = 'EN PROCESO' 
             GROUP BY DATE(F_EVENTO), DETALLE_EVENTO.SALON";
$resultado = $conexion->seleccionar($consulta);

// Crear un arreglo para almacenar los objetos de evento
$eventos = array();

foreach ($resultado as $fila) {
    $fechaEvento = $fila->FECHA; // Mantener el formato de fecha sin hora
    $color = $fila->CANTIDAD_EVENTOS > 1 ? '#ff0000' : '#0000ff'; // Rojo para más de 1 evento, azul para 1 o menos eventos
    $evento = array(
        'title' => 'Salón ' . $fila->SALON, // Agregar el número de salón al título del evento
        'start' => $fechaEvento,
        'backgroundColor' => $color,
    );
    $eventos[] = $evento;
}

$conexion->desconectarBD();

// Convertir el arreglo de eventos a formato JSON y enviarlo al cliente
echo json_encode($eventos);
?>
