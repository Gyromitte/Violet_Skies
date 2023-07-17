<?php

include_once "../dataBase.php";
$conexion = new Database();
$conexion->conectarBD();

// Obtener la contraseña actual del formulario
$contrasenaActual = $_POST['contraseñaActual'];

// Consultar la contraseña actual almacenada en la base de datos
$consulta = "SELECT CONTRASEÑA FROM CUENTAS WHERE ID = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado && password_verify($contraseñaActual, $resultado['CONTRASEÑA'])) {
    // Obtener la nueva contraseña del formulario
    $nuevaContrasena = $_POST['newPassword'];
    
    // Generar el hash de la nueva contraseña
    $nuevoHashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña en la base de datos
    $actualizarConsulta = "UPDATE CUENTAS SET CONTRASEÑA = :nuevaContrasena WHERE ID = :id";
    $stmtActualizar = $pdo->prepare($actualizarConsulta);
    $stmtActualizar->bindValue(':nuevaContrasena', $nuevoHashContrasena);
    $stmtActualizar->bindValue(':id', $_SESSION['id']);
    $stmtActualizar->execute();
    
    // Mostrar un mensaje de éxito
    echo "¡La contraseña se ha cambiado correctamente!";
} 
else {
    // La contraseña actual no coincide, mostrar un mensaje de error
    echo "La contraseña actual ingresada es incorrecta.";
}
?>