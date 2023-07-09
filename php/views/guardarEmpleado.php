<?php
    include "../dataBase.php";
    $db = new Database();
    $db->conectarBD();
    extract($_POST);
    $cadena = "INSERT INTO usuarios(rfc, correo, tipoUsuario)
    VALUES('$rfc', '$correo','$tipoUsuario')";
    $db->ejecutarSQL($cadena);
    echo "<div class='altert alert-success'>Empleado Registrado!</div>";            
?>