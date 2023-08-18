<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$consulta = "SELECT DATE(F_EVENTO) AS FECHA, DETALLE_EVENTO.SALON
            FROM EVENTO 
            INNER JOIN DETALLE_EVENTO ON EVENTO.ID = DETALLE_EVENTO.ID
            WHERE EVENTO.ESTADO = 'EN PROCESO' 
            GROUP BY DATE(F_EVENTO), DETALLE_EVENTO.SALON";
$resultado = $conexion->seleccionar($consulta);

$eventos = array();

foreach ($resultado as $fila) {
    $fechaEvento = $fila->FECHA;
    $salon = $fila->SALON;
    $evento = array(
        'fecha' => $fechaEvento,
        'salon' => $salon,
    );
    $eventos[] = $evento;
}

$conexion->desconectarBD();

// Convertir el arreglo de eventos a formato JSON y enviarlo al cliente
header('Content-Type: application/json');
echo json_encode($eventos);
?>