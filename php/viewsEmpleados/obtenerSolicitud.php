<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Verificar si se recibió el ID de la solicitud a obtener
if (isset($_GET['id'])) {
  // Obtener el ID de la solicitud a obtener
  $idSolicitud = $_GET['id'];

  // Consulta para obtener los datos de la solicitud con el ID específico
  $consulta = "SELECT NOMBRE, AP_PATERNO, AP_MATERNO, TELEFONO, CORREO FROM CUENTAS WHERE CUENTAS.ID = :id";
  $parametros = array(':id' => $idSolicitud);

  // Ejecutar la consulta preparada para obtener los datos de la solicitud
  $resultado = $db->seleccionarPreparado($consulta, $parametros);

  // Verificar si se encontraron resultados
  if ($resultado && count($resultado) > 0) {
    // Obtener los datos de la solicitud como un arreglo asociativo
    $solicitud = $resultado[0]; // Se asume que solo se espera un resultado

    // Devolver los datos de la solicitud como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($solicitud);
  } else {
    // Si no se encontraron resultados, devolver una respuesta de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(array('error' => "No se encontró la solicitud con el ID proporcionado."));
  }
} else {
  // Enviar una respuesta de error en formato JSON al cliente si no se recibió el ID de la solicitud
  header('Content-Type: application/json');
  echo json_encode(array('error' => "No se proporcionó el ID de la solicitud."));
}

$db->desconectarBD();

?>