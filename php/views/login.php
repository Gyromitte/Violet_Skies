<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violet skies - Ingresar</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/loginn.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!--Favi icon-->
    <link rel="icon" type="image/x-icon" href="/images/company_logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
        .register{
            color:darkblue;
        }
        .register:hover{
            color:purple;
        }
    </style>
</head>
<body>
    <?php
         session_start();
         if(isset($_SESSION["logged_in"])){
             header("../scripts/access.php");
         }
    ?>
<!-- Navbar -->
<nav class="navbar navbar-default row">
    <div class="companySection col-sm-auto">
        <!--Company Logo-->
        <div class="navbar-header">
            <!--Menu for mobiles-->
            <div class="btn-group dropdown drop-mobile" id="nav-button">
                <a href="#" class="btn btn-secondary dropdown-btn-custom" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bars fa-2x" style="color: #ffffff;"></i>
                </a>
            </div>
            <img id="company-logo" class="img-fluid" src="/images/company_logo.png" alt="companyLogo"
                onclick="this.classList.toggle('clicked')">
            <a class="no-underline" href="/index.html" id="company-name">Violet Skies</a>
        </div>
        <!--Tabs-->
        <ul class="nav list-inline">
            <li class="mr-3 tabs">
                <a class="no-underline" href="/html/about-us/about us.html">Nosotros</a>
            </li>
            <li class="mr-3 tabs">
                <a class="no-underline" href="/html/agendarEvento.html">Agendar Evento</a>
            </li>
            <li class="mr-3 tabs">
                <a class="no-underline" href="/html/trabajo.html">Trabajo</a>
            </li>
        </ul>
    </div>
    <!--Login-section-->
    <div class="login-section col-sm-auto">
        <a class="no-underline" href="/php/views/login.php">
            <button class="loginButton">
                <i class="fa-solid fa-door-open" style="color: #ffffff;"></i>
                Acceder
            </button>
        </a>
        <a class="no-underline" href="/php/views/registrarse.php">
            <button class="loginButton">
                <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                Registrarse
            </button>
        </a>
    </div>
</nav>

<!--DashBoard-->
<div id="dash-board" class="d-flex flex-column">
    <div id="dash-board-content">
        <ul>
            <li class="mr-3 tabs mb-4">
                <i class="fa-solid fa-users" style="color: #ffffff;"></i>
                <a class="no-underline" href="/html/about-us/about us.html">Nosotros</a>
            </li>
            <li class="mr-3 tabs mb-4">
                <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i>
                <a class="no-underline" href="/html/agendarEvento.html">Agendar Evento</a>
            </li>
            <li class="mr-3 tabs mb-4">
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
                <a class="no-underline" href="/html/trabajo.html">Trabajo</a>
            </li>
            <li class="mr-3 tabs mb-4">
                <a class="no-underline mb-4" href="/php/views/login.php">
                    <i class="fa-solid fa-door-open" style="color: #ffffff;"></i>
                    Acceder
                </a>
            </li>
            <li class="mr-3 tabs mb-4">
                <a class="no-underline mb-4" href="/php/views/registrarse.php">
                    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                    Registrarse
                </a>
            </li>
        </ul>
    </div>
</div>


<!-- Login -->
<div class="container-fluid full-page-container">
        <div class="row">
        <div class="col-md-4 left-one">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <h1>Iniciar sesión</h1>
                    <hr>
                    <form action="../scripts/verificarlogin.php" method="post">
                        <label class="form-label" name="usu">Correo:</label>
                        <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
                        <input class="form-control" type="email" name="usu" placeholder="Correo"><br>
                        <label class="form-label" name="pass">Contraseña:</label>
                        <i class="fa-solid fa-lock" style="color: #ffffff;"></i>
                        <input class="form-control" type="password" name="pass" placeholder="Contraseña"><br>
                        <button class="btn btn-primary btn-custom" type="submit">Ingresar</button>
                    </form>
                    <br>
                    <center><a href="../views/registrarse.php" class="no-underline">¿No tienes cuenta? ¡Regístrate!</a></center>
                </div>
            </div>
            <!-- Right section for the image (remaining 60% of the width) -->
            <div class="col-md-8 d-flex align-items-stretch img-container">
                <img src="/images/log-in.jpg" class="img-cover">
            </div>
        </div>
    </div>
    

    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <script src="/js/navbarMovil.js"></script>
</body>
</html>