<!DOCTYPE html>
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
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <!--Chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        form img{
            max-width: 100%; /* Make the image scale to the container's width */
    height: auto; /* Maintain the image's aspect ratio */
    display: block; /* Remove any extra spacing around the image */

    /* Add some margin to separate the images */
    margin: 10px auto;
}

/* Apply specific styles for screens with a maximum width of 768px (typical mobile devices) */
@media (max-width: 768px) {
    form img {
        /* Adjust the maximum width to fit smaller screens */
        max-width: 90%;
    }
}
        #loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
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
        </style>
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
     <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
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
            Admin<br>
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>
            Home
            </button>
            <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i><br>
            Eventos
            </button>
            <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>
            Empleados
            </button>
            <button data-tab="comidas" class="dash-button"><i class="fa-solid fa-burger" style="color: #ffffff;"></i><br>
            Menús
            </button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>
            Perfil
            </button>
            <a style="text-decoration: none;" data-tab="logout" class="dash-button" href="../scripts/CerrarSesion.php">
            <i class="fa-solid fa-door-open" style="color: #ffffff; padding-top: 10px;"></i><br>Logout</a>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <div id="home" class="tab-content active">
            <h3 style="text-align:center;    padding: 10px;
    width: 50%; color: #343434;">
                Home
                <i class="fa-solid fa-house" style="color: #343434;"></i>
            </h3>
            <!--Info Cards-->
            <div class="container-fluid mt-4">
                <div class="row">
                    <!--Clientes-->
                    <div class="col-md-4 mb-4">
                        <div class="info-card d-flex align-items-center justify-content-between">
                            <div class="info d-flex flex-column align-items-center mb-2">
                            <div class='loading-spinner'>
                                <div class='spinner-border text-light' role='status'>
                                    <span class='visually-hidden'>Loading...</span>
                                </div>
                            </div>
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
                            <div class='loading-spinner'>
                                <div class='spinner-border text-light' role='status'>
                                    <span class='visually-hidden'>Loading...</span>
                                </div>
                            </div>
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
                            <div class='loading-spinner'>
                                <div class='spinner-border text-light' role='status'>
                                    <span class='visually-hidden'>Loading...</span>
                                </div>
                            </div>
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
        <div class="panel-header">  
            <h3 class="test">
                Panel de Eventos
                <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i>
            </h3>
        </div><br>
            <form id="filtroForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="search-container">
                    <!-- Filtro de estado - A la izquierda -->
                    <div class="filter">
                        <div class="btn-group">
                            <label class="control-label" style="color :#343434;" >Mostrar:</label>
                            <select id="estadoSelect" name="estado" class="form-select form-select-custom">
                                <option value="GRAFICOS" selected>Resumen</option>
                                <option value="todo">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="EN PROCESO">En proceso</option>
                                <option value="FINALIZADO">Finalizado</option>
                                <option value="CANCELADO">Cancelado</option>
                                <option value="PETICIONES">Peticiones</option>
                            </select>
                        </div>
                    </div>
                    <!-- Buscador - A la derecha -->
                    <div class="search">
                        <div class="searchFechas">
                            <div class="input-group search-row">
                                <input type="text" class="form-control" id="searchInput" placeholder="Buscar evento por nombre o cliente">
                                <button id="searchButton" type="button" class="ver-empleados btn btn-outline-primary">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i>
                                </button>
                            </div>
                            <div class="input-group search-row">
                                <input type="date" class="form-control" id="fechaInicioInput" name="fecha_inicio">
                                <input type="date" class="form-control" id="fechaFinInput" name="fecha_fin">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="container-fluid">
            <div id="contentRow" class="row">
                <!-- Canvas a la izquierda -->
	            <div class="graficaEventos col-md-7" >
                    <canvas id="menuChart"></canvas>
	            </div>
	            <!-- Contenido de la derecha -->
	            <div class="col-md-5">
		            <div id="eventosPendientes" class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                		    <i class="fa-solid fa-business-time" style="color: #ffffff;"></i>
                            Eventos pendientes: 
			            </h3>
                        <h2 id="pendientesCard"></h2>
		            </div>
		            <div id="eventosEnProceso" class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                            <i class="fa-regular fa-calendar-days"></i>
                            Eventos en proceso: 
			            </h3>
                        <h2 id="procesoCard"></h2>       
		            </div>
                    <div id="eventosFin" class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                            <i class="fa-regular fa-calendar-check"></i>
                             Eventos finalizados: 
			            </h3>
                        <h2 id="finCard"></h2>       
		            </div>
                    <div id="eventosCancelados" class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                            <i class="fa-regular fa-calendar-xmark"></i>
                            Eventos cancelados: 
			            </h3>
                        <h2 id="canceladoCard"></h2>       
		            </div>
                    <div id="peticiones" class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                        <h3 class="me-2">
                            <i class="fa-regular fa-calendar-xmark"></i>
                             Peticiones:
			            </h3>
                        <h2 id="peticionesCard"></h2>       
		            </div>
	            </div>
            </div>
            
            <div class="table-responsive">
                <div id="tablaResultados"></div>
                <div id="peticionesResult"></div>
            </div>
        </div>

            <!-- Modal de Confirmación -->
            <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar acción</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas cancelar este evento?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelModal">No</button>
                            <button type="button" class="btn btn-danger" id="btnAceptarCancelar" data-dismiss="modal" tabindex="-1";>Sí</button>
                        </div>
                    </div>
                </div>
            </div>
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
                    <button type="button" class="btn btn-success border-2 btn-outline-light rounded-5 btn-options" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@re-incorporarEmpleado">
                        <i class="fa-solid fa-person-walking-arrow-loop-left" style="color: #ffffff;"></i>
                        Re-incorporar
                    </button>
                </div>
                <!--Barra de Busqueda-->
                <div class="input-group mb-3 search-bar" id="search">
                    <input type="text" id="busqueda" class="form-control" placeholder="Buscar a un empleado"
                        onkeyup="searchEmployee()"
                     aria-label="" aria-describedby="button-addon2">
                    <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                </div>
            </div>
            <br>
            <!--Opciones de Vistas-->
        <div class="view-options mb-2">
            <div>
                <div class="dropdown form-select-custom">
                    <button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vistas:
                    </button>
                    <ul class="dropdown-menu custom-drop-menu">
                        <li>
                            <button id="verGraficos" data-url="" type="button" class="btn-view-custom btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-chart-pie" style="color: #ffffff;"></i>
                                Ver Gráficos
                            </button>
                        </li>
                        <li>
                            <button id="verCocineros" data-url="verCocineros.php" type="button" class="btn-view-custom btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-utensils" style="color: #ffffff;"></i>
                                Ver Cocineros
                            </button>
                        </li>
                        <li>
                            <button id="verMeseros" data-url="verMeseros.php" type="button" class="btn-view-custom btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>
                                Ver Meseros
                            </button>
                        </li>
                        <li>
                            <button id="verSolicitudes" data-url="verSolicitudes.php" type="button" class="btn-view-custom btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-business-time" style="color: #ffffff;"></i>
                                Ver Solicitudes
                            </button>
                        </li>
                    </ul>
                </div>
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
                        <div class="col-md-5" style="padding-left: 0px !important;">
                        <div class="info-card mb-2" style="height: 25px; display: flex; align-items: center;">
                            <h3 class="me-2">
                            <i class="fa-solid fa-business-time" style="color: #ffffff;"></i>
                                Solicitudes Pendientes: 
                            </h3>
                            <h2 id="solicitudesCard"></h2>
                        </div>
                            <div class="col-md-12 donut-container">
                                <canvas id="proporcionEmpleados2" style="height: 40px"></canvas>
                            </div>
                        </div>
                        <!-- Canvas a la derecha -->
                        <div class="info-card col-md-7">
                            <canvas id="participacionEmpleados" style="height: 70%; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="comidas" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Panel de Menús
                <i class="fa-solid fa-burger" style="color: #ffffff;"></i>
            </h3>
            <br>
            <div class="search-container">
            <div class="filter">
                    <button type="button" class="btn btn-success border-2 btn-outline-light rounded-5 btn-options" data-bs-toggle="modal" data-bs-target="#modalComida" data-bs-whatever="">
                        <i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i>
                        Agregar Menú
                    </button>
                </div>
                <!--Barra de Busqueda-->
                <div class="input-group mb-3 search-bar" id="search">
                    <input type="text" id="busquedaMenu" class="form-control" placeholder="Buscar un menú"
                        onkeyup="searchMenu()"
                     aria-label="" aria-describedby="button-addon2">
                    <button id="buscarEmpleado" data-url="buscarEmpleado.php" class="ver-empleados btn btn-outline-primary" type="button" id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                </div>

            </div>
            <br>
            <!--Opciones de Vistas-->
        <div class="view-options mb-2">
            <div>
                <div class="dropdown form-select-custom">
                    <button class="btn btn-secondary dropdown-toggle custom-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vistas:
                    </button>
                    <ul class="dropdown-menu custom-drop-menu">
                        <li>
                            <button id="verBebidas" data-vista="1" data-url="verCocineros.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-wine-glass" style="color: #ffffff;"></i>
                                Bebidas
                            </button>
                        </li>
                        <li>
                            <button id="verDesayuno" data-vista="2" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-egg" style="color: #ffffff;"></i>
                                Desayuno
                            </button>
                        </li>
                        <li>
                            <button id="verDesBuffet" data-vista="3" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-bacon" style="color: #ffffff;"></i>
                                Des. Buffet
                            </button>
                        </li>
                        <li>
                            <button id="verComida" data-vista="4" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-burger" style="color: #ffffff;"></i>
                                Comida
                            </button>
                        </li>
                        <li>
                            <button id="verComidaBuffet" data-vista="5" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-drumstick-bite" style="color: #ffffff;"></i>
                                Comida Buffet
                            </button>
                        </li>
                        <li>
                            <button id="verCoffee" data-vista="6" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-mug-saucer" style="color: #ffffff;"></i>
                                Coffee break
                            </button>
                        </li>
                        <li>
                            <button id="verDescontinuado" data-vista="8" data-url="/php/viewsMenus/verMenus.php" type="button" class="btn-view-custom btn-options ver-menus btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal">
                                <i class="fa-solid fa-circle-minus" style="color: #ffffff;"></i>
                                Descontinuado
                            </button>
                        </li>
                    </ul>
                </div>
            </div> 
        </div>
            <!--Informacion de la tabla-->
            <h3 id="table-info-menus"></h3>
            <!--Container para tablas-->
            <div id="cont-table-menus">
                <!--Contenido Default-->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Contenido de la izquierda -->
                        <div class="col-md-5 pieMenus">
                            <canvas id="pieTipoMenus" style="height: 60%; width: 100%; margin-right: 0px !important;"></canvas>
                        </div>
                        <!-- Canvas a la derecha -->
                        <div class="info-card col-md-7" style="margin-right: 0px !important;">
                            <canvas id="menuChart2" style="height: 70%; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="perfil" class="tab-content">
                <h3 class="test" style="text-align:center";>
                    Perfil
                    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                </h3>
                <br>
                <?php include "../viewsPerfil/datosAdmin.php"?>
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

        <!--Modal de comidas-->
        <div class="modal fade" id="modalComida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content custom-modal">
                    <div class="modal-header">
                        <!--Titulo que tendra el modal-->
                        <h1 class="modal-title fs-5" id="firstLabe">Agregar un menu </h1>
                        <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-form">
                        <p>Aqui puedes agregar un nuevo menu al sistema</p>
                        <form id="formularioMenu">
                            <div class="mb-3">
                                <label class="control-label">Nombre del nuevo menu:</label>
                                <input type="text" name="nombre" placeholder="Nombre del menu" class="form-control" maxlength="45" required>
                            </div>
                            <div class="mb-3">
                            <label class="control-label">Descripcion:</label>
                            <textarea name="descripcion" placeholder="En que consiste el menu" class="form-control descripcion-input" rows="4" maxlength="200" required></textarea>
                            </div>
                            <div class="mb-3">
                            <div class="form-group mb-3">
                                <label for="tipoMenu">Tipo de Menu:</label>
                                <select name="tipoMenu" class="form-control form-select">
                                    <option value="1">Bebidas</option>
                                    <option value="2">Desayuno</option>
                                    <option value="3">Desayuno Buffet</option>
                                    <option value="4">Comida</option>
                                    <option value="5">Comida Buffet</option>
                                    <option value="6">Coffee Break</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button id="aceptarMenu" type="submit" class="btn btn-primary btn-modal me-2"><i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i>Agregar</button>
                                <button id="cerrarAltaMenu" type="button" class="btn btn-primary btn-modal" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                        <div id="mensajeDiv" class="mt-10" method="POST"></div>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var formulario = document.getElementById("formularioMenu");
        var mensajeDiv = document.getElementById("mensajeDiv");
        var modalMenu = document.getElementById("modalComida");
        var cerrarModal = document.getElementById("cerrarAltaMenu");
        var aceptarMenu = document.getElementById("aceptarMenu");

        formulario.addEventListener("submit", function(e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        var formData = new FormData(formulario);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/php/viewsMenus/altaMenu.php", true);

        xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                mensajeDiv.innerHTML = xhr.responseText;
                if(xhr.responseText == "<div class='alert alert-success mt-4'>Menu agregado exitosamente</div>")
                {   
                    //Cerrar modal simulando un click
                    setTimeout(function() {
                        cerrarModal.click();
                    }, 1500);
                    //Limpiar el formulario
                    formulario.reset();
                }
                } else {
                    mensajeDiv.innerHTML = "Hubo un error en la solicitud.";
                }
            }
        };
        xhr.send(formData);
        });
    });
</script>

        
    </div>
    <!--Scripts que necesitan ejecutarse hasta el final-->
    <script src="/js/panelAdmin.js" async defer></script>
    <script src="/js/charts.js"></script>
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/filtroEventos.js"></script>
    <script src="/js/datosAdmin.js"></script>
    <script src="/js/buscarEmpleado.js"></script>
    <script src="/js/panelMenu/buscarMenu.js"></script>
</body>

</html>