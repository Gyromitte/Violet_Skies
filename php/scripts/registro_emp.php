<?php
    include '../dataBase.php';
    require_once '/xampp/htdocs/vendor/autoload.php'; 
    use Aws\S3\S3Client;

    extract($_POST);
    $db = new Database();
    $db->conectarBD();
    $nom = $_POST['nom'];
    $ap = $_POST['ap'];
    $am = $_POST['am'];
    $usu = $_POST['usu'];
    $dire = $_POST['dire'];
    $pass = $_POST['pass'];
    $confirm = $_POST['ckpass'];
    $cel = $_POST['cel'];
    $ineFSubido = $_FILES['ine'];
    $backSubido = $_FILES['back'];
    $tipo = "EMPLEADO";
    
    // Configurar el cliente de Amazon S3
    $s3Client = new S3Client([
        'version' => 'latest',
        'region' => 'us-east-1', // Reemplaza con tu región
        'credentials' => [
            'key' => 'AKIASU4V6AHHNR5A3SHF',
            'secret' => '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',
        ],
    ]);
    
    $bucketName = 'violetskiesbucket'; // Reemplaza con el nombre de tu bucket
    
    try {
        // Subir imagen INE frente a Amazon S3
        $resultadoIneF = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => $ineFSubido['name'],
            'Body' => fopen($ineFSubido['tmp_name'], 'rb'),
            'ACL' => 'public-read',
        ]);
        
        // Subir imagen INE atrás a Amazon S3
        $resultadoBack = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => $backSubido['name'],
            'Body' => fopen($backSubido['tmp_name'], 'rb'),
            'ACL' => 'public-read',
        ]);
        
        // Obtener URLs públicas de las imágenes
        $urlIneF = $resultadoIneF['ObjectURL'];
        $urlBack = $resultadoBack['ObjectURL'];
        
        $pattern = '/[0-9\p{P}\p{S}&&[^ñ]]/u';
        
        // Use a regular expression to check if the phone number contains any letter
        if (preg_match("/[a-zA-Z]/", $cel)) {
            echo "<div class='alert alert-danger'>No utilizar letras en tu numero de Celular</div>";
        }
        else if (preg_match("$pattern", $nom) || preg_match("$pattern", $ap) || preg_match("$pattern", $am)) {
            echo"<div class='alert alert-danger'>No poner numeros o caracteres especiales en los nombres</div>";
        }
        else if(strlen($cel) < 10){
            echo "<div class='alert alert-danger'>Numero de celular demasiado corto</div>";
        }
        else if(strlen($cel) > 10){
            echo "<div class='alert alert-danger'>Numero de celular demasiado grande</div>";
        }
        else if(!ctype_digit($cel)){
            echo "<div class='alert alert-danger'>No utilizar caracteres especiales dentro del numero de celular</div>";
        }
        else if($nom=="" || $ap=="" || $am=="" || $usu=="" || $dire=="" || $pass=="" || $confirm=="" || $cel==""){
            echo "<div class='alert alert-danger'>Registros vacios, favor de llenar</div>";
        }
        else {
            $db->RegisterEmp($nom, $ap, $am, $usu, $dire, $pass, $confirm, $cel, $tipo, $ineFSubido, $backSubido, $s3Client, $bucketName);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    
    $db->desconectarBD();
?>