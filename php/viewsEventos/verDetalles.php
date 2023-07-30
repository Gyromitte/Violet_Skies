<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$eventoId = $_GET['id']; 

$consultaEvento = "SELECT E.F_EVENTO, E.NOMBRE, CONCAT(CUENTAS.NOMBRE, ' ', CUENTAS.AP_PATERNO, ' ', CUENTAS.AP_MATERNO) AS CLIENTE, E.ESTADO
                    FROM EVENTO E INNER JOIN CUENTAS ON E.CLIENTE=CUENTAS.ID
                    WHERE E.ID=$eventoId";

$resultadoEvento = $conexion->seleccionar($consultaEvento);

// Verificar si se encontró un evento con el ID proporcionado
if (count($resultadoEvento) > 0) {
    $evento = (array) $resultadoEvento[0];
} else {
    // No se encontró un evento con el ID proporcionado
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Evento no encontrado'));
    $conexion->desconectarBD();
    exit;
}

$consultaDetalles = "SELECT D.INVITADOS, S.NOMBRE AS SALON, C.NOMBRE AS COMIDA, D.MESEROS, D.COCINEROS
                      FROM DETALLE_EVENTO D JOIN SALONES S ON S.ID=D.SALON JOIN COMIDAS C ON C.ID=D.COMIDA
                      WHERE D.ID=$eventoId";

$resultadoDetalles = $conexion->seleccionar($consultaDetalles);

if (count($resultadoDetalles) > 0) {
    $detalles = (array) $resultadoDetalles[0];
} else {
    // No se encontraron detalles para el evento con el ID proporcionado
    $detalles = array('INVITADOS' => '', 'SALON' => '', 'COMIDA' => '');
}

// Combinar los resultados de ambas consultas en un solo array
$evento = array_merge($evento, $detalles);

// Devolver los datos del evento en formato JSON
header('Content-Type: application/json');
echo json_encode($evento);

$conexion->desconectarBD();
?>
