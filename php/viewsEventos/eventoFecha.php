<?php
include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

$consulta = "SELECT DATE(F_EVENTO) AS Fecha
FROM EVENTO 
WHERE ESTADO = 'EN PROCESO'
GROUP BY DATE(F_EVENTO)
HAVING COUNT(F_EVENTO) = 3;";
$resultado = $conexion->seleccionar($consulta);

$fechasFormateadas = array();
foreach ($resultado as $row) {
    $fecha = $row->Fecha; // Accessing the property "Fecha" from the stdClass object
    $fechaFormateada = date("Y-m-d 00:00", strtotime($fecha));
    $fechasFormateadas[] = $fechaFormateada;
}

// Devolver las fechas formateadas en formato JSON
header('Content-Type: application/json');
echo json_encode($fechasFormateadas);

$conexion->desconectarBD();
?>
