<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--StyleSheets-->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/panelAdmin.css">
    <link rel="icon" type="image/x-icon" href="./images/company_logo.png">
    <!--Referencias a fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <style>
			#cuadroEvento{
				border: 3px solid darkblue;
				background-color: violet;
				color: white;
				padding: 5px; 
				margin: 5px;
				float: left;
			}
		</style>
    <!--Scripts que necesitan ejecutarse primero-->
    <script src="/js/panelEmpleado.js" async defer></script>
</head>
<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!--NavBar-->    
    <?php
         session_start();
         if(isset($_SESSION["logged_in"])){
             if($_SESSION["access"]===3){
                 header("Location:../scripts/access.php");
             }
             else if($_SESSION["access"]===1){
                 header("Location:../scripts/access.php");
             }
         }
         else if(!isset($_SESSION["logged_in"])){
             header("Location:../views/login.php");
         }
    ?>
    <nav>
        <div class="nav-menu">
            <button id="nav-button">
                <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
            </button>
            <img id="company-logo" class="img-fluid" src="/images/company_logo.png" alt="companyLogo" style="height:1.5em; margin-right: 10px;">
            Violet Skies
        </div>
        <div class="nav-user">
            <?php
                echo $_SESSION["name"];
            ?>
        </div>
    </nav>
    <!--DashBoard-->
    <div id="dash-board">
        <div id="dash-board-content">
            <?php
                echo $_SESSION["name"];
            ?>
            <br>
            <?php 
                if($_SESSION["access"]==1.5){
                    echo"Ninguno";
                }
                else{
                echo $_SESSION["tipo"]; 
                }
            ?><br><br>
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Home</button>
            <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i><br>Eventos Disponibles</button>
            <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>Eventos Asistiendo</button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <a style="text-decoration: none;" data-tab="logout" class="dash-button" href="../scripts/CerrarSesion.php">
                <i class="fa-solid fa-door-open" style="color: #ffffff; padding-top: 10px;"></i><br>Logout</a>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <div id="home" class="tab-content active">
            <p class="test">Yo soy, home</p>
        </div>
        <div id="eventos" class="tab-content">
        <h3 class="test" style="text-align:center; ">
                Eventos Disponibles
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <?php
            if($_SESSION["access"]==1.5){
                echo"<h1>El Administrador aun no confirma tu cuenta</h1>";
            }
            else{
            echo"<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#empModal' data-bs-whatever='@fat' >Open modal for @fat</button>
            <div class='container'>
            <form id='EmpDisp' action=".$_SERVER['PHP_SELF']." method='POST'>
                <br>
                <div class='btn-group'>
                    <label class='control-label'>Orden: </label>
                    <select id='tipoorden' name='orden' class='form-select'>;
                        <option value='porcreacion' selected>Recientemente Creadas</option>;
                        <option value='lejanoevento'>Eventos Lejanos</option>;
                        <option value='cercasevento'>Eventos Cercanos</option>;
                    </select>
                </div>
            </form>
            </div>
            <br>
            <div id='tablaResultados'></div>
        </div>";
        }
        ?>
        <div id="empleados" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Eventos Asistiendo
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <?php
            if($_SESSION["access"]==1.5){
                echo"<h1>El Administrador aun no confirma tu cuenta</h1>";
            }
            else{
            echo"<br>
            <h3 id='table-info'></h3>
            
            <div class='cont-table'>
            </div>
        </div>";
            }
        ?>
        <div id="perfil" class="tab-content">
            <p class="test">Yo soy, perfiles.</p>
        </div>

        <!--Modal-->
        <div class="modal fade" id="empModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div>
    <!--Scripts que necesitan ejecutarse hasta el final-->
    <script src="/js/EventosDisp.js"></script>
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>