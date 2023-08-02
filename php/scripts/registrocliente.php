<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    if (preg_match("/[a-zA-Z]/", $cel)) {
        // If the phone number contains a letter, it is invalid
        echo "<div class='alert alert-danger'>Error: No utilizar letras en tu numero de Celular</div>";
    }
    else if(!(strlen($cel) >= 10 && strlen($cel)<=15)){
        echo "<div class='alert alert-danger'>Error: Numero de celular de de 10 a 15</div>";
    }
    else if($nom=="" || $ap==""||$am==""||$usu==""||$pass==""||$confirm==""||$cel==""){
        echo "<div class='alert alert-danger'>Error: Registros vacios, favor de llenar</div>";
    }
    else{
    $db->Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo);
    }
    $db->desconectarBD();
?>