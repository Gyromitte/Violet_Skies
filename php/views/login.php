<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder</title>
    <link rel="stylesheet" href="/css/loginn.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-default row">
        <div class="companySection col-sm-auto">
            <!--Company Logo-->
            <div class="navbar-header">
                <img id="company-logo" class="img-fluid" src="/images/company_logo.jpg" alt="companyLogo">
                    <a class="no-underline" href="/index.html" id="company-name">Hoteleria</a>
            </div>      
            <!--Tabs-->
            <ul class="nav list-inline">
                <li class="mr-3 tabs">
                    <a class="no-underline" href="/html/about-us/about us.html">Nosotros</a>
                </li>
                <li class="mr-3 tabs">
                    <a class="no-underline" href="#">Agendar Evento</a>
                </li>
                <li class="mr-3 tabs">
                    <a class="no-underline" href="/html/trabajo.html">Trabajo</a>
                </li>
            </ul>
        </div>         
        <!--Login-section-->
        <div class="login-section col-sm-auto" >
            <button class="loginButton">
                <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                <a class="no-underline" href="#">Registrarse</a>
            </button>
        </div>
    </nav>
    <div class="background-cover">
        <br>
        <div class="container">
            <div class="row">
                <div class="col-6 d-none d-sm-block center" id="heroImage">
                    <img id="" class="img-fluid" src="images/company_logo.jpg" alt="companylogo">
                </div>
                <div class="heroContainer col-6 ">
                    <div class="leftHeroSection">
                    <!--Oh mira aqui esta un form para el login-->
                    <h1>Acceder a tu Cuenta</h1><hr><br>
                    <form action="#" method="post">
                        <label class="form-label" name="usu">Usuario: </label> 
                        <input class="form-control" type="text" name="usu" placeholder="Usuario"><br><br>
                        <label class="form-label" name="pass">Contraseña: </label>
                        <input class="form-control" type="password" name="pass" placeholder="Contraseña"><br><br>
                        <button class="loginButton" type="submit">Iniciar Sesion</button>
                    </form>
                    <?php
                         include '../class/basededatos.php';
                         $conexion=new BDHotel();
                         $conexion->conexionHotel();

                         $Query="SELECT * FROM CUENTAS WHERE " 
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
</body>
</html>