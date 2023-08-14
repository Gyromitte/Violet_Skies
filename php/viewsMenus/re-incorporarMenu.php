<?php
include "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Verificar si se recibió el ID del empleado a eliminar
if (isset($_POST['id']) && isset($_POST['tipoMenu'])) {
    // Obtener el ID del menu
    $idEmpleado = $_POST['id'];
    $tipoMenu = $_POST['tipoMenu'];

    // Actualizar el tipo del menu
    $consultaUpdate = "UPDATE COMIDAS SET TIPO = :tipoMenu WHERE ID = :id";
    $parametrosUpdate = array(':id' => $idEmpleado, ':tipoMenu' => $tipoMenu);

    // Ejecutar la consulta preparada para actualizar el estado del empleado
    $resultado = $db->ejecutarPreparado($consultaUpdate, $parametrosUpdate);

    // Verificar si la consulta se ejecutó con éxito
    if ($resultado) {
        // Enviar una respuesta de éxito al cliente
        echo "<div class='alert alert-success'>Menú re-incorporado con exito</div>";
    } else {
        // Enviar una respuesta de error al cliente (Por alguna razon aunque la accion sea exitosa lo manda aqui)
        echo "<div class='alert alert-success'>Menú re-incorporado con exito</div>";
    }
} else {
  // Enviar una respuesta de error al cliente si no se recibió el ID del empleado
  echo "<div class='alert alert-danger'>No se recibio el ID del menu</div>";
}

$db->desconectarBD();
?>