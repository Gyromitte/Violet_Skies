<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <title>Login</title>
    <style>
        div{
            background-color: rgb(27, 31, 59);
            height: 100%;
            width: 100%;
        }
        h1{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 70px;
        }
        h3{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 40px;
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
            padding-bottom: 300px;
        }
    </style>
</head>
<body>
    <div>
        <?php
            echo"<div class='container'>";
            echo"<h1 align='center'>No tienes acceso a esta pagina</h1><br>";
            echo"<h3 align='center'>Redirigiendo...</h3>";
            echo "</div>";
        ?>
        <?php
            header("refresh:4;/index.html");
        ?>
    </div>
</body>
</html>