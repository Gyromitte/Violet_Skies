<?php
include_once '../dataBase.php';

// Verificar si se recibieron los datos del formulario por POST
if (isset($_POST['data'])) {
    // Obtener los datos enviados desde el formulario (los datos se envían en formato JSON)
    $data = json_decode($_POST['data'], true);

    // Verificar si se recibió el parámetro del ID del usuario
    $id = $data['id'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $database->conectarBD();

    // Consulta SQL para actualizar los datos personales del usuario
    $consulta = "UPDATE CUENTAS SET ";

    // Verificar si se recibió el parámetro del nombre
    if (isset($data['nombre'])) {
        $nombre = $data['nombre'];
        $consulta .= "NOMBRE = :nombre, ";
        $parametros[':nombre'] = $nombre;
    }

    // Verificar si se recibió el parámetro del apellido paterno
    if (isset($data['ap_paterno'])) {
        $ap_paterno = $data['ap_paterno'];
        $consulta .= "AP_PATERNO = :ap_paterno, ";
        $parametros[':ap_paterno'] = $ap_paterno;
    }

    // Verificar si se recibió el parámetro del apellido materno
    if (isset($data['ap_materno'])) {
        $ap_materno = $data['ap_materno'];
        $consulta .= "AP_MATERNO = :ap_materno, ";
        $parametros[':ap_materno'] = $ap_materno;
    }

    // Verificar si se recibió el parámetro del teléfono
    if (isset($data['telefono'])) {
        $telefono = $data['telefono'];
        $consulta .= "TELEFONO = :telefono, ";
        $parametros[':telefono'] = $telefono;
    }

    // Verificar si se recibió el parámetro del correo
    if (isset($data['correo'])) {
        $correo = $data['correo'];
        $consulta .= "CORREO = :correo, ";
        $parametros[':correo'] = $correo;
    }

    // Eliminar la coma final de la consulta
    $consulta = rtrim($consulta, ", ");

    // Agregar la condición para actualizar solo el usuario específico
    $consulta .= " WHERE ID = :id";
    $parametros[':id'] = $id;

    // Ejecutar la consulta si hay parámetros para actualizar
    if (!empty($parametros)) {
        $database->ejecutarPreparado($consulta, $parametros);
    }

    // Desconectar la base de datos
    $database->desconectarBD();

    // Preparar la respuesta JSON
    $response = array('success' => true, 'message' => 'Datos personales actualizados correctamente');
    // Establecer el encabezado Content-Type para indicar que la respuesta es de tipo JSON
    header('Content-Type: application/json');
    // Establecer el código de estado HTTP 200 (éxito)
    http_response_code(200);
    // Imprimir la respuesta JSON
    echo json_encode($response);
} else {
    // Si no se recibieron los datos del formulario, enviar una respuesta de error
    $response = array('success' => false, 'message' => 'No se recibieron los datos del formulario.');
    header('Content-Type: application/json');
    http_response_code(400); // Código de estado HTTP 400 (solicitud incorrecta)
    echo json_encode($response);
}
?>
