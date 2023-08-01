<?php
include_once '../dataBase.php';

// Verificar si se recibió el parámetro del ID del evento
if (isset($_GET['id'])) {
    $eventoId = $_GET['id'];
    
    // Crear una instancia de la clase Database
    $database = new Database();
    $database->conectarBD();
    
    // Consulta SQL para actualizar los detalles del evento
    $consulta = "UPDATE EVENTO E INNER JOIN DETALLE_EVENTO D ON E.ID=D.ID SET ";
    $parametros = array();

    // Verificar si se recibió el parámetro de la fecha del evento
    if (isset($_GET['F_EVENTO'])) {
        $fechaEvento = $_GET['F_EVENTO'];
        $consulta .= "E.F_EVENTO = :fechaEvento, ";
        $parametros[':fechaEvento'] = $fechaEvento;
    }

    // Verificar si se recibió el parámetro de invitados
    if (isset($_GET['INVITADOS'])) {
        $invitados = $_GET['INVITADOS'];
        $consulta .= "D.INVITADOS = :invitados, ";
        $parametros[':invitados'] = $invitados;
    }

    // Verificar si se recibió el parámetro de salón
    if (isset($_GET['SALON'])) {
        $salon = $_GET['SALON'];
        $consulta .= "D.SALON = :salon, ";
        $parametros[':salon'] = $salon;
    }

    // Verificar si se recibió el parámetro de comida
    if (isset($_GET['COMIDA'])) {
        $comida = $_GET['COMIDA'];
        $consulta .= "D.COMIDA = :comida, ";
        $parametros[':comida'] = $comida;
    }

    if (isset($_GET['MESEROS']) && $_GET['MESEROS'] !== "") {
        $meseros = $_GET['MESEROS'];
        $consulta .= "D.MESEROS = :meseros, ";
        $parametros[':meseros'] = $meseros;
    } else {
        // Si $_GET['MESEROS'] no está definido o es una cadena vacía, calcular el valor según la operación invitados/15
        // Asegurémonos de que invitados sea un número válido antes de hacer la operación
        if (isset($_GET['INVITADOS']) && is_numeric($_GET['INVITADOS'])) {
            $invitados = $_GET['INVITADOS'];
            $meseros = floor($invitados / 15);
        } else {
            // Si INVITADOS no está definido o no es un número válido, asignar un valor predeterminado (por ejemplo, 0)
            $meseros = 0;
        }
    
        $consulta .= "D.MESEROS = :meseros, ";
        $parametros[':meseros'] = $meseros;
    }

    if (isset($_GET['COCINEROS']) && $_GET['COCINEROS'] !== "") {
        $cocineros = $_GET['COCINEROS'];
        $consulta .= "D.COCINEROS = :cocineros, ";
        $parametros[':cocineros'] = $cocineros;
    } else {
        // Si $_GET['COCINEROS'] no está definido o es una cadena vacía, asignar el valor null a 'COCINEROS'
        $consulta .= "D.COCINEROS = :cocineros, ";
        $parametros[':cocineros'] = 0;
    }
    

    // Eliminar la coma final de la consulta
    $consulta = rtrim($consulta, ", ");

    // Agregar la condición para actualizar solo el evento específico
    $consulta .= " WHERE E.ID = :eventoId";
    $parametros[':eventoId'] = $eventoId;

    // Ejecutar la consulta si hay parámetros para actualizar
    if (!empty($parametros)) {
        $database->ejecutarPreparado($consulta, $parametros);
    }

    // Desconectar la base de datos
    $database->desconectarBD();

    // Preparar la respuesta JSON
    $response = array('success' => true, 'message' => 'Detalles del evento actualizados correctamente');
    // Establecer el encabezado Content-Type para indicar que la respuesta es de tipo JSON
    header('Content-Type: application/json');
    // Establecer el código de estado HTTP 200 (éxito)
    http_response_code(200);
    // Imprimir la respuesta JSON
    echo json_encode($response);
} else {
    // Enviar una respuesta JSON en caso de error
    $response = array('success' => false, 'message' => 'Error: Falta el parámetro del ID del evento');
    // Establecer el encabezado Content-Type para indicar que la respuesta es de tipo JSON
    header('Content-Type: application/json');
    // Establecer el código de estado HTTP 400 (solicitud incorrecta)
    http_response_code(400);
    // Imprimir la respuesta JSON
    echo json_encode($response);
}
?>
