<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <title>Login</title>
    <style>
        .redirect div{
            background-color: rgb(27, 31, 59);
            background-blend-mode: overlay;
            z-index: 9999;
        }
        .redirect h1{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 70px;
            z-index: 9999;
        }
        .redirect h3{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 70px;
            z-index: 9999;
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
        .redirect div .container{
            background-color: rgb(27, 31, 59);
            height: 100%;
            width: 100%;
            padding-top: 300px;
            z-index: 9999;
        }
    </style>
</head>
<body class="redirect">
    <div>
        <?php
            echo"<div class=' container'>";
            echo"<h1 align='center'>No tienes acceso a esta pagina</h1><br>";
            echo"<h3 align='center'>Redirigiendo...</h3>";
            echo "</div>";
            header("refresh:4;/index.html");
        ?>
    </div>
</body>
</html>