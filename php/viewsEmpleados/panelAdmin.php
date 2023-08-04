<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!-<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Violet skies - Panel Admininistrador</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--StyleSheets-->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/panelAdmin.css">
    <!--Favi icon-->
    <link rel="icon" type="image/x-icon" href="/images/company_logo.png">
    <!--Referencias a fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <!--Chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--Scripts que necesitan ejecutarse primero-->
    <script src="/js/panelAdmin.js" async defer></script>
    <!--<style>
        .redirect div{
            background-color: rgb(27, 31, 59);
            background-blend-mode: overlay;
        }
        .redirect h1{
            text-align: center;
            color:rgb(131, 103, 199);
            animation: anim-glow 2s ease infinite;
            font-size: 70px;
        }
        .redirect h3{
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
        .redirect div .container{
            background-color: rgb(27, 31, 59);
            height: 100%;
            width: 100%;
            padding-top: 300px;
        }
    </style>
    -->
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!--NavBar-->
    <?php
        session_start();
        $access=3;
        if(isset($_SESSION["logged_in"])){
            if($_SESSION["access"]!==$access){
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
        <h2><span id="fecha"></span></h2>
        <div class="nav-user">
            <?php
            if (isset($_SESSION["logged_in"])) {
                if (isset($_SESSION["access"]) == 3) {
                    echo $_SESSION["name"];
                }
            } else {
                echo "Username";
            }
            ?>
        </div>
    </nav>
    <!--DashBoard-->
    <div id="dash-board">
        <div id="dash-board-content">
            <?php
            if (isset($_SESSION["logged_in"])) {
                if (isset($_SESSION["access"]) == 3) {
                    echo $_SESSION["name"];
                }
            } else {
                echo "Username";
            }
            ?>
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Home</button>
            <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i><br>Eventos</button>
            <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>Empleados</button>
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
            <!--Info Cards-->
            <div class="container-fluid mt-4">
                <div class="row">
                    <!--Clientes-->
                    <div class="col-md-4 mb-4">
                        <div class="info-card d-flex align-items-center justify-content-between">
                            <div class="info d-flex flex-column align-items-center mb-2">
                                <h3 id="clientesCard"></h3>
                                <h5>Clientes registrados</h5>
                            </div>
                            <i class="fa-solid fa-user fa-5x" style="color: #ffffff;"></i>
                        </div>
                    </div>
                    <!--Empleados-->
                    <div class="col-md-4">
                        <div class="info-card d-flex align-items-center justify-content-between">
                            <div class="info d-flex flex-column align-items-center mb-2">
                                <h3 id="empleadosCard"></h3>
                                <h5>Empleados activos</h5>
                            </div>
                            <i class="fa-solid fa-briefcase fa-5x" style="color: #ffffff;"></i>
                        </div>
                    </div>
                    <!--Eventos-->
                    <div class="col-md-4">
                        <div class="info-card d-flex align-items-center justify-content-between">
                            <div class="info d-flex flex-column align-items-center mb-2">
                                <h3 id="eventosCard"></h3>
                                <h5>Eventos realizados</h5>
                            </div>
                            <i class="fa-solid fa-calendar-days fa-5x" style="color: #ffffff;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!--Charts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <canvas id="eventosAño"></canvas>
                    </div>
                    <div class="col-md-5">
                        <canvas id="proporcionEmpleados"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div id="eventos" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Panel de Eventos
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
        </div><br>
            <form id="filtroForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="search-container">
                    <!-- Filtro de estado - A la izquierda -->
                    <div class="filter">
                        <div class="btn-group">
                            <label class="control-label">Estado:</label>
                            <select id="estadoSelect" name="estado" class="form-select form-select-custom">
                                <option value="todo" selected>Todos</option>
                                <option value="PENDIENTE">
                                <i class="fa-solid fa-list-check" style="color: #ffffff;"></i>
                                    Pendiente</option>
                                <option value="EN PROCESO">
                                    En proceso
                                    <i class="fa-solid fa-bars-progress" style="color: #ffffff;"></i>
                                </option>
                                <option value="FINALIZADO">Finalizado</option>
                                <option value="CANCELADO">Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <!-- Buscador - A la derecha -->
                    <div class="search">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar evento por nombre o cliente">
                            
                            <button id="searchButton" type ="button" class="ver-empleados btn btn-outline-primary">
                            <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div id="tablaResultados"></div>
        </div>
        <div id="empleados" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Panel de Empleados
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <br>
            <div class="search-container">
                <div class="filter">
                    <button type="button" class="btn btn-success border-2 btn-outline-light rounded-5 btn-options" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@registrarEmpleado">
                        <i class="fa-solid fa-address-card" style="color: #ffffff;"></i>
                        Registrar
                    </button>
                </div>
                <!--Barra de Busqueda-->
                <div class="input-group mb-3 search-bar" id="search">
                    <input type="text" id="busqueda" class="form-control" placeholder="Buscar a un empleado" aria-label="" aria-describedby="button-addon2">
                    <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                </div>
            </div>
            <br>
            <!--Opciones de Vistas-->
            <div class="view-options mb-2">
                <div>
                    <button id="verCocineros" data-url="verCocineros.php" type="button" class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                        <i class="fa-solid fa-utensils" style="color: #ffffff;"></i>
                        Ver Cocineros
                    </button>
                    <button id="verMeseros" data-url="verMeseros.php" type="button" class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                        <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>
                        Ver Meseros
                    </button>
                </div>
                <!--Barra de Busqueda-->
                <div class="input-group mb-3 search-bar">
                    <input type="text" id="busqueda" class="form-control" placeholder="Buscar a un empleado" aria-label="" aria-describedby="button-addon2">
                    <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
                        <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                </div>
            </div>
            <!--Informacion de la tabla-->
            <h3 id="table-info"></h3>
            <!--Container para tablas-->
            <div class="cont-table">
                <!--Contenido Default-->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Contenido de la izquierda -->
                        <div class="col-md-5">
                        <div class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                            <h3 class="me-2">
                            <i class="fa-solid fa-business-time" style="color: #ffffff;"></i>
                                Solicitudes Pendientes: 
                            </h3>
                            <h2 id="solicitudesCard"></h2>
                        </div>
                            <div class="col-md-12">
                                <canvas id="proporcionEmpleados2" style="height: 40px"></canvas>
                            </div>
                        </div>
                        <!-- Canvas a la derecha -->
                        <div class="info-card col-md-7">
                            <canvas id="participacionEmpleados"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="perfil" class="tab-content">
            <h3 class="test" style="text-align:center";>
                PERFIL
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <?php include "../viewsPerfil/verPerfil.php"?>
        </div>
        <div id="configuracion" class="tab-content">
            <p class="test">Yo soy, configuracion.</p>
        </div>
        <!--Modal-->
        <div class="modal fade" id="mainModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <script src="/js/charts.js"></script>
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/filtroEventos.js"></script>
</body>

</html>