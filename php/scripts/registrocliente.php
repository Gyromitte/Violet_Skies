<?php
    include '../dataBase.php';
    extract($_POST);
    $db=new Database();
    $db->conectarBD();
    $nom = $_POST['nom'];
    $ap = $_POST['ap'];
    $am = $_POST['am'];
    $usu = $_POST['usu'];
    $pass = $_POST['pass'];
    $confirm = $_POST['ckpass'];
    $cel = $_POST['cel'];
    $tipo="CLIENTE";

    if($pass!==$confirm){
        echo"<div class='alert alert-warning'>
        <h3>Contrasenas no concuerdan</h3></div>";
    }
    else{
        try{
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $cadena="INSERT INTO CUENTAS(NOMBRE, AP_PATERNO,AP_MATERNO, CORREO, CONTRASEÑA, 
        TELEFONO,TIPO_CUENTA) VALUES('$nom','$ap','$am','$usu','$hash','$cel','$tipo')";
        $db->ejecutarSQL($cadena);
        echo"<div class='alert alert-success'>Usuario Registrado</div>";
        header("refresh:3;/php/views/login.php");
        }
        catch(PDOException $e){
            echo"<div class='alert alert-danger'>".$e->getMessage()."</div>";
        }
    }
    $db->desconectarBD();
?>