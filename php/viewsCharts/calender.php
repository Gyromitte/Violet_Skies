<?php
// Conecta a tu base de datos (reemplaza los valores por los de tu configuración)
include '../dataBase.php';
$db = new Database;

// Consulta los eventos desde la base de datos (puedes ajustar esta consulta según tu esquema de datos)
$row = "CALL verSolicitudAsist(?)";

// Crea un array para almacenar los eventos
$eventos = array();
$parametros = array($emp);

$tabla = $conexion->seleccionarPreparado($consulta, $parametros);

// Itera sobre los resultados de la consulta y agrega los eventos al array
foreach ($tabla as $reg) {
    $evento = array(
        'start' => $reg->F_EVENTO
    );
    array_push($eventos, $evento);
}

// Cierra la conexión a la base de datos
$db->desconectarBD();

// Devuelve los eventos en formato JSON
header('Content-Type: application/json');
echo json_encode($eventos);

?>