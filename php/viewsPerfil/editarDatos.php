<?php
include_once '../dataBase.php';

// Función para actualizar los datos en la base de datos
function actualizarDatos($datos) {
    $database = new Database();
    $database->conectarBD();

    // Supongamos que los datos enviados desde el cliente son un arreglo asociativo con los nombres de los campos como claves
    $id = $datos['id'];
    $nombre = $datos['nombre'];
    $ap_paterno = $datos['ap_paterno'];
    $ap_materno = $datos['ap_materno'];
    $telefono = $datos['telefono'];
    $correo = $datos['correo'];

    // Luego, puedes usar la clase Database para actualizar los datos
    $query = "UPDATE TU_TABLA SET NOMBRE='$nombre', AP_PATERNO='$ap_paterno', AP_MATERNO='$ap_materno', TELEFONO='$telefono', CORREO='$correo' WHERE ID_TU_REGISTRO='$id'";
    $database->ejecutarSQL($query);

    $database->desconectarBD();

    // Puedes enviar una respuesta al cliente para indicar que la actualización se realizó correctamente
    $respuesta = array('status' => 'success', 'message' => 'Datos actualizados correctamente');
    echo json_encode($respuesta);
}

// Manejar la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de hacer las validaciones necesarias antes de usar la función
    // Aquí, suponemos que el cliente envía los datos como JSON
    $datos = json_decode(file_get_contents('php://input'), true);

    if (!empty($datos)) {
        actualizarDatos($datos);
    } else {
        $respuesta = array('status' => 'error', 'message' => 'Datos no válidos');
        echo json_encode($respuesta);
    }
}
?>
