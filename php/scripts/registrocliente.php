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

    $db->Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo);
    $db->desconectarBD();
?>