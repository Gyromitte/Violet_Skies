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
    $tipo="EMPLEADO";

    // Use a regular expression to check if the phone number contains any letter
    if (preg_match("/[a-zA-Z]/", $cel)) {
        // If the phone number contains a letter, it is invalid
        echo "<div class='alert alert-danger'>Error: No utilizar letras en tu numero de Celular</div>";
    }
    else if(strlen($cel) !== 10){
        echo "<div class='alert alert-danger'>Error: Numero de celular de 10</div>";
    }
    else if($nom=="" || $ap==""||$am==""||$usu==""||$pass==""||$confirm==""||$cell==""){
        echo "<div class='alert alert-danger'>Error: Registros vacios, favor de llenar</div>";
    }
    else{
        $db->Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo);
    }
    $db->desconectarBD();
?>