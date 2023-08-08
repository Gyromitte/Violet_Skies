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

    $pattern = '/[0-9\p{P}\p{S}&&[^ñ]]/u';

    if (preg_match("/[a-zA-Z]/", $cel)) {
        // If the phone number contains a letter, it is invalid
        echo "<div class='alert alert-danger'>No utilizar letras en tu numero de Celular</div>";
    }
    else if (preg_match("$pattern", $nom)) {
        // The input text contains numbers or special characters
        echo"<div class='alert alert-danger'>No poner numeros o caracteres especiales en 
        los nombres</div>";
    }
    else if (preg_match("$pattern", $ap)) {
        // The input text contains numbers or special characters
        echo"<div class='alert alert-danger'>No poner numeros o caracteres especiales en 
        los nombres</div>";
    }
    else if (preg_match("$pattern", $am)) {
        // The input text contains numbers or special characters
        echo"<div class='alert alert-danger'>No poner numeros o caracteres especiales en 
        los nombres</div>";
    }
    else if(strlen($cel) < 10){
        echo "<div class='alert alert-danger'>Numero de celular demasiado corto</div>";
    }
    else if(strlen($cel) > 15){
        echo "<div class='alert alert-danger'>Numero de celular demasiado grande</div>";
    }
    else if(!ctype_digit($cel)){
        echo "<div class='alert alert-danger'>No utilizar caracteres especiales dentro del numero
        de celular</div>";
    }
    else if($nom=="" || $ap==""||$am==""||$usu==""||$pass==""||$confirm==""||$cel==""){
        echo "<div class='alert alert-danger'>Registros vacios, favor de llenar</div>";
    }
    else{
        $db->Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo);
    }
    $db->desconectarBD();
?>