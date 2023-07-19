<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <title>Login</title>
    <style>
        *{
            background-color: rgb(27, 31, 59);
        }
        h1{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 70px;
        }
        @keyframes anim-glow {
	        0% {
		        box-shadow: 0 0 rgba(188, 44, 201, 1);
	        }
	        100% {
		        box-shadow: 0 0 10px 8px transparent;
		        border-width: 2px;
	        }
        }
        div .container{
            height: 100%;
            width: 100%;
            padding-top: 300px;
        }
    </style>
</head>
<body>
    <div>
         <?php
            include'../dataBase.php';
            $db=new Database();
            $db->conectarBD();
            extract($_POST);
            if($pass==$ckpass){
                $hash=password_hash($pass,PASSWORD_DEFAULT);
                
                $cadena="INSERT INTO CUENTAS(NOMBRE, AP_PATERNO,AP_MATERNO, CORREO, 
                CONTRASEÑA, TELEFONO,TIPO_CUENTA) VALUES('$nom','$ap','$am','$usu','$hash','$cel','$tipo')";
    
                $db->ejecutarSQL($cadena);
                $db->desconectarBD();
                echo"<div class='container'>Usuario Registrado</div>";
                header("refresh:4; ../views/login.php");
            }
            else{
                echo"Contrasena no corresponde";
                header("refresh:4; ../views/registrarse.php");
            }
        ?>
    </div>
</body>
</html>