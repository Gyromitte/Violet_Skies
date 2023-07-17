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
    <style>
        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 0;
            overflow-x: hidden;
            padding-top: 20px;
        }
        .left {
            left: 0;
            background-image: url(/images/mesero.jpg);
        }
        .right {
            right: 0;
            background-image:url(/images/heroImage.jpg)
        }
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default row">
        <div class="companySection col-sm-auto">
            <!--Company Logo-->
            <div class="navbar-header">
                <img id="company-logo" class="img-fluid" src="/images/company_logo.png" alt="companyLogo">
                <a class="no-underline" href="/index.html" id="company-name">Violet Skies</a>   
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
    </nav>
    <div class="container">
        <div class="row">
            <div class="split left" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <div class="centered">
                    <h1>Registrate como Empleado!</h1>
                </div>
            </div>

            <div class="split right">
                <div class="centered">
                    <h1>Registrate como Cliente!</h1>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar como Empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../scripts/verificarlogin.php" method="post">
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
            <button class="loginButton" type="submit">Iniciar Sesion</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar como Empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../scripts/verificarlogin.php" method="post">
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
            <button class="loginButton" type="submit">Iniciar Sesion</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
</body>
</html>