<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <?php
            include '../dataBase.php';
            $db=new Database();
            $db->conectarBD();
            extract($_POST);

            $db->Login("$usu","$pass");
            $db->desconectarBD();
        ?>
    </div>
</body>
</html>