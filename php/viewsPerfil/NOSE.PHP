<?PHP
include_once "../dataBase.php";
try {

            $database = new Database();
            $database->conectarBD();


            $newPassword="localhost123";

                    // Actualizar la contraseña en la base de datos
                    $hashNuevaContraseña = password_hash($newPassword, PASSWORD_DEFAULT); // Hashear la nueva contraseña
                    $consulta = "UPDATE CUENTAS SET CONTRASEÑA = :newPassword WHERE ID = 5";
                    $actualizar = $database->getPDO()->prepare($consulta);
                    $actualizar->bindParam(':newPassword', $hashNuevaContraseña);
                    $actualizar->execute();
                    echo "Contraseña actualizada con éxito.";
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



                    $database->desconectarBD();

        ?>