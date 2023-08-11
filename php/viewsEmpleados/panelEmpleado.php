<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!-<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Violet skies - Panel de Empleado</title>
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
				background-image: linear-gradient(145deg, #5603ad, #f58cd6);
				color: white;
				padding: 5px; 
				margin: 5px;
				float: left;
            }
            .cutebox{
                background-color: #5603ad;
                border-radius: 5em;
                padding: 10px;
                width: 100%;
                height: 100%;
                align-items: center;
                justify-content: center;
            }

		</style>
    <!--Scripts que necesitan ejecutarse primero-->
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
            <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>Eventos En Curso</button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <a style="text-decoration: none;" data-tab="logout" class="dash-button" href="../scripts/CerrarSesion.php">
                <i class="fa-solid fa-door-open" style="color: #ffffff; padding-top: 10px;"></i><br>Logout</a>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <div id="home" class="tab-content active">
        <h3 class="test" style="text-align:center; ">
                Home
                <i class="fa-solid fa-house" style="color: #ffffff;"></i>
            </h3>
            <?php
            if($_SESSION["access"]==1.5){
                echo"<div class='container'>";
                echo"<div class='cutebox'>";
                echo"<h1>Gracias por buscar trabajo con nosotros!</h1>";
                echo"</div>";
                echo"</div>";
                echo"<br>";
                echo"<div class='container'>";
                echo"<div class='test'>";
                echo"<h4>Su solicitud ha sido enviada.</h4>";
                echo"</div>";
                echo"</div>";
                echo"<br>";
                echo"<div class='container'>";
                echo"<div class='test'>";
                echo"<div>Un administrador se pondra en contacto con usted proximamente.</div>";
                echo"</div>";
                echo"</div>";
            }
            else{
                echo"<div class='container-fluid mt-4'>
                <div class='row'>
                    <div class='col-md-4 mb-4'>
                        <div class='info-card d-flex align-items-center justify-content-between'>
                            <div class='info d-flex flex-column align-items-center mb-2'>
                                <h3 id='DispCard'></h3>
                                <h5>Eventos Disponibles</h5>
                            </div>
                            <i class='fa-solid fa-briefcase fa-5x' style='color: #ffffff;'></i>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='info-card d-flex align-items-center justify-content-between'>
                            <div class='info d-flex flex-column align-items-center mb-2'>
                                <h3 id='AsistCard'></h3>
                                <h5>Eventos Atendiendo</h5>
                            </div>
                            <i class='fa-solid fa-briefcase fa-5x' style='color: #ffffff;'></i>
                        </div>
                    </div>
                    <div class='col-md-4 mb-4'>
                        <div class='info-card d-flex align-items-center justify-content-between'>
                            <div class='info d-flex flex-column align-items-center mb-2'>
                                <h3 id='SolicCard'></h3>
                                <h5>Solicitudes Enviadas</h5>
                            </div>
                            <i class='fa-solid fa-briefcase fa-5x' style='color: #ffffff;'></i>
                        </div>
                    </div>
                    </div>
                    </div>";
            }
            ?>
        </div>
        <div id="eventos" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Eventos Disponibles
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <?php
            if($_SESSION["access"]==1.5){
                echo"<h1>El Administrador aun no confirma tu cuenta</h1></div>";
            }
            else{
            echo"
            <form id='EmpDisp' action=".$_SERVER['PHP_SELF']." method='POST'>
                <br>
                <div class='search-container'>
                <div class='filter'>
                <div class='btn-group'>
                    <label class='control-label'style='margin-right: 8px;'>Orden:</label>
                    <select id='tipoorden' name='orden' class='form-select form-select-custom'>;
                        <option value='porcreacion'>Recientemente Creadas</option>;
                        <option value='lejanoevento'>Eventos Lejanos</option>;
                        <option value='cercasevento'>Eventos Cercanos</option>;
                    </select>
                </div>
                </div>
                </div>
            </form>
            <br>
            <div id='tablaResultados'></div>
        </div>";
        }
        ?>
        <div id="empleados" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Eventos En Curso
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <?php
                if($_SESSION["access"]==1.5){
                    echo"<h1>El Administrador aun no confirma tu cuenta</h1>";
                }
                else{
                    echo"
                    <br>
                    <div class='view-options'>
                        <div>
                        <button id='verPend' data-url='../viewsEventos/viewEventosAtendiendo.php' type='button'
                        class='btn-options ver-eventos btn btn-primary border-2 btn-outline-light rounded-5'
                        data-bs-target='#Main'>
                            <i class='fa-solid fa-calendar-days' style='color: #ffffff;'></i>
                            Eventos Pendientes
                        </button>
                        <button id='verFin' data-url='../viewsEventos/verFinalizados.php' type='button' 
                        class='btn-options ver-eventos btn btn-primary border-2 btn-outline-light rounded-5'
                        data-bs-target='#Main'>
                            <i class='fa-solid fa-bell-concierge' style='color: #ffffff;'></i>
                            Historial
                        </button>
                        <button id='verSolic' data-url='../viewsEventos/verSolicAsist.php' type='button' 
                        class='btn-options ver-eventos btn btn-primary border-2 btn-outline-light rounded-5'
                        data-bs-target='#Main'>
                            <i class='fa-solid fa-bell-concierge' style='color: #ffffff;'></i>
                            Solicitudes de Asistencia
                        </button>
                        </div>
                    </div>
                    <br>
                    
                    <h3 id='table-info'></h3>

                    <div class='cont-table'></div>";
                }
            ?>
        </div>
        <div id="perfil" class="tab-content">
            <div class="container">
                <?php echo" <div class='container'>";
                include "../viewsPerfil/datosEmp.php";
                echo" </div>"; ?>
            </div>
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
    <script src="/js/panelEmpleado.js" async defer></script>
    <script src="/js/EventoAsist.js"></script>
    <script src="/js/chartsemp.js"></script>
    <script src="/js/EventosDisp.js"></script>
    <script src="/js/datosempleado.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>