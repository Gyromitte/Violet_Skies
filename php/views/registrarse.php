<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violet skies - Registrarse</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/loginn.css">
    <!--Favi icon-->
    <link rel="icon" type="image/x-icon" href="/images/company_logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
        .message-content {
            display: none;
        }
        #loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        .loading-spinner {
            display: block; /* Show the loading spinner */
        }

        .info {
            display: none; /* Hide the actual content */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 0;
            overflow-x: hidden;
            padding-top: 20px;
            font-size: 40px;
            font-weight: bold;
        }
        .left {
            left: 0;
            color: white;
            background-color: #d8d8d6;
        }
        .right {
            right: 0;
            color: white;
            background-color: #61697b;
        }
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .left:hover{
            cursor:pointer;
            color: white;
            text-shadow: 2px rgba(227, 122, 57,0.5);
            font-style: italic;
            background-blend-mode: overlay;
        }
        .right:hover{
            cursor:pointer;
            color: white;
            text-shadow: 2px rgba(210, 65, 250,0.5);
            font-style: italic;
            background-blend-mode: overlay;
        }
        .alert{
            text-align: center;
            z-index: 9999;
        }
        .modal{
            position: fixed;

        }
        .modal-body{
            height: 80vh;
            overflow-y: scroll;
        }

        .clientsImages{
            height: 300px;
        }
        @media screen and (max-width: 768px) {
        .clientsImages{
            height: 200px; /* Altura para pantallas con ancho máximo de 768px */
            width: 100%; /* Ancho ocupando todo el espacio disponible en la pantalla */
            max-width: 400px;
            
        }
    }
    </style>
    <script src="/js/registro.js" async defer></script>
</head>
<body>
<?php
         session_start();
         if(isset($_SESSION["logged_in"])){
             header("Location:../scripts/logintrue.php");
         }
    ?>
  
   <!-- Desktop Navbar -->
   <div class=" desktop-nav fixed-top">
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
   </div>
      
    <!-- Divided page -->
    <div class="container">
        <div class="row">
            <div class="split left" data-bs-toggle="modal" data-bs-target="#Main" data-bs-whatever=@emp>
                <div class="centered">
                    <br>
                    <h1>¡Regístrate como empleado!</h1>
                    <img class="clientsImages" src="/images/waiter.jpg">
                </div>
            </div>
        </div>

            <div class="split right" data-bs-toggle="modal" data-bs-target="#Main" data-bs-whatever=@cliente>
                <div class="centered">
                    <br>
                    <h1>¡Regístrate como cliente!</h1>
                    <img class="clientsImages" src="/images/customers.jpg">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="Main" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content custom-modal">
                    <div class="modal-header">
                            <!--Titulo que tendra el modal-->
                            <h1 class="modal-title fs-5" id="firstLabe"></h1>
                            <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-form">
                            <!--El contenido del modal cambia dependiendo del boton que lo activo-->
                    </div>
                </div>
            </div>
        </div>

    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/navbarMovil.js"></script>
</body>
</html>