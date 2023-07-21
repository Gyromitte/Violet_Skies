<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder</title>
    <link rel="stylesheet" href="/css/loginn.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
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
            color:sienna;
            background-image: url(/images/mesero.jpg);
        }
        .right {
            right: 0;
            color:blueviolet;
            background-image:url(/images/heroImage.jpg);
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
            background-color: rgba(252, 58, 192, 0.8);
            background-blend-mode: overlay;
        }
        .right:hover{
            cursor:pointer;
            color: white;
            text-shadow: 2px rgba(210, 65, 250,0.5);
            background-color: rgba(147, 6, 186, 0.8);
            background-blend-mode: overlay;
        }
        .alert{
            text-align: center;
            z-index: 99;
        }
        .modal{
            position: fixed;

        }
        .modal-body{
            height: 80vh;
            overflow-y: scroll;
        }
    </style>
    <script src="/js/panelAdmin.js" async defer></script>
</head>
<body>
  
   <!-- Desktop Navbar -->
  
   <div class=" desktop-nav fixed-top">
<div class="tab-content">
  <nav class="navbar navbar-default row">
    <div class="companySection col-sm-auto">
      <!-- Company Logo -->
      <div class="navbar-header">
        <img id="company-logo" class="img-fluid" src="/images/company_logo.png" alt="companyLogo">
        <a class="no-underline" href="/index.html" id="company-name">Violet Skies</a>
      </div>
      <!-- Tabs -->
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
    <!-- Login Section -->
    <div class="login-section col-sm-auto">
      <button class="loginButton">
        <i class="fa-solid fa-door-open" style="color: #ffffff;"></i>
        <a class="no-underline" href="/php/views/login.php">Acceder</a>
      </button>
    </div>
  </nav>
</div>
   </div>
      
   <!-- Mobile Side Menu -->
   <!--
<div class=" mobile-nav">
<div id="dash-board" class="d-block overflow-hidden">
  <div class="d-block" style="overflow: hidden;">
    <div id="dash-board-content">
      <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Home</button>
      <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i><br>Eventos</button>
      <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>Empleados</button>
      <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
      <a href="../scripts/CerrarSesion.php"><button data-tab="logout" class="dash-button"><i class="fa-solid fa-gear" style="color: #ffffff;"></i><br>Logout</button></a>
    </div>
  </div>
</div>
</div>
      -->
    <!--Divided page-->
    <div class="container">
        <div class="row">
            <div class="split left" data-bs-toggle="modal" data-bs-target="#Empleado">
                <div class="centered">
                    <h1>Registrate como Empleado!</h1>
                </div>
            </div>

            <div class="split right" data-bs-toggle="modal" data-bs-target="#Cliente">
                <div class="centered">
                    <h1>Registrate como Cliente!</h1>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Empleado -->
<div class="modal fade" id="Empleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog fixed-top">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar como Empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <label class="form-label" name="nom">Nombre(s): </label> 
            <input class="form-control" type="text" name="nom" placeholder="Nombre"><br><br>
            <label class="form-label" name="ap">Apellido Paterno: </label> 
            <input class="form-control" type="text" name="ap" placeholder="Apellido Paterno"><br><br>
            <label class="form-label" name="am">Apellido Materno: </label> 
            <input class="form-control" type="text" name="am" placeholder="Apellido Materno"><br><br>
            <label class="form-label" name="usu">Correo: </label> 
            <input class="form-control" type="email" name="usu" placeholder="Correo"><br><br>
            <label class="form-label" name="cel">Numero de Celular: </label> 
            <input class="form-control" type="text" name="cel" placeholder="Telefono"><br><br>
            <label class="form-label" name="pass">Contraseña: </label>
            <input class="form-control" type="password" name="pass" 
            placeholder="Contraseña" required><br><br>
            <label class="form-label" name="ckpass">Comprobar Contraseña: </label>
            <input class="form-control" type="password" name="ckpass"
             placeholder="Comprobar Contraseña" required`><br><br>
            <button class="loginButton" type="submit" name="reg">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Modal de Cliente-->
<div class="modal fade" id="Cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar como Cliente</h1>
        <button type="button" class="btn-close" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <label class="form-label" name="nom">Nombre(s): </label> 
            <input class="form-control" type="text" name="nom" placeholder="Nombre"><br><br>
            <label class="form-label" name="ap">Apellido Paterno: </label> 
            <input class="form-control" type="text" name="ap" placeholder="Apellido Paterno"><br><br>
            <label class="form-label" name="am">Apellido Materno: </label> 
            <input class="form-control" type="text" name="am" placeholder="Apellido Materno"><br><br>
            <label class="form-label" name="usu">Correo: </label> 
            <input class="form-control" type="email" name="usu" placeholder="Correo"><br><br>
            <label class="form-label" name="cel">Numero de Celular: </label> 
            <input class="form-control" type="text" name="cel" placeholder="Telefono"><br><br>
            <label class="form-label" name="pass">Contraseña: </label>
            <input class="form-control" type="password" name="pass" placeholder="Contraseña"><br><br>
            <label class="form-label" name="ckpass">Comprobar Contraseña: </label>
            <input class="form-control" type="password" name="ckpass" placeholder="Comprobar Contraseña"><br><br>
            <button class="loginButton" type="submit" name="regc">Iniciar Sesion</button>   
        </form>
      </div>
    </div>
  </div>
</div>
   <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      include '../dataBase.php';
      extract($_POST);
      $db=new Database();
      $db->conectarBD();
      if(isset($_POST['reg'])){
        $tipo="EMPLEADO";  
        $db->Register($nom,$ap,$am,$usu,$pass,$ckpass,$cel,$tipo);
      }
       else if(isset($_POST['regc'])){
          $tipo="CLIENTE";  
          $db->Register($nom,$ap,$am,$usu,$pass,$ckpass,$cel,$tipo);
          exit;
        }
      $db->desconectarBD();
      }
   ?>
    
    <script src="/js/filtroEventos.js"></script>
    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>