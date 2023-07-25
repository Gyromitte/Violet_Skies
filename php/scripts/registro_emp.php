<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    include '../dataBase.php';
    extract($_POST);
    $db=new Database();
    $db->conectarBD();
    $tipo="EMPLEADO";  
    $db->Register($nom,$ap,$am,$usu,$pass,$ckpass,$cel,$tipo);
    $db->desconectarBD();
    }
?>