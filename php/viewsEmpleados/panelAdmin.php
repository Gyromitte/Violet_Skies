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
    <!--Referencias a fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <script src="/js/panelAdmin.js" async defer></script>

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!--NavBar-->    
    <nav>
        <div class="nav-menu">
            <button id="nav-button">
                <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
            </button>
            Hoteleria
        </div>
        <h2><span id="fecha"></span></h2>
        <div class="nav-user">
            <i class="fa-solid fa-bell" style="color: #ffffff;"></i>
            <div id="nav-photo-user"></div>
            Username
        </div>
    </nav>
    <!--DashBoard-->
    <div id="dash-board">
        <div id="dash-board-content">
            <div id="dash-photo-user"></div>
            Username<br>
            Position<br><br>
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Home</button>
            <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i><br>Eventos</button>
            <button data-tab="empleados" class="dash-button"><i class="fa-solid fa-briefcase" style="color: #ffffff;"></i><br>Empleados</button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <button data-tab="configuracion" class="dash-button"><i class="fa-solid fa-gear" style="color: #ffffff;"></i><br>Configuracion</button>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <div id="home" class="tab-content active">
            <p class="test">Yo soy, home</p>
        </div>
        <div id="eventos" class="tab-content">
        <h3 class="test" style="text-align:center; ">
                Panel de Eventos
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@fat">Open modal for @fat</button>
            
            <div class="container">
            <form id="filtroForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <br>
                <div class="btn-group">
                    <label class="control-label">Estado:</label>
                    <select id="estadoSelect" name="depa" class="form-select">;
                        <option value="todo" selected>Todos</option>;
                        <option value="Pendiente">Pendiente</option>;
                        <option value="Finalizado">Finalizado</option>;
                        <option value="En progreso">En progreso</option>;
                        <option value="Cancelado">Cancelado</option>;
                    </select>
                </div>
        
            </form>
            </div>
            <br>
            <div id="tablaResultados"></div>

            








        </div>
        <div id="empleados" class="tab-content">
            <h3 class="test" style="text-align:center; ">
                Panel de Empleados
                <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
            </h3>
            <br>
            <button type="button" class="btn btn-success border-2 btn-outline-light rounded-5 btn-options" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@registrarEmpleado">
                <i class="fa-solid fa-address-card" style="color: #ffffff;"></i>
                Registrar
            </button>
            <button type="button" class="btn btn-danger border-2 btn-outline-light rounded-5 btn-options" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@eliminarEmpleado">
                <i class="fa-solid fa-user-slash" style="color: #ffffff;"></i>
                Eliminar
            </button>
            <br>
            <br>
            <!--Opciones de Vistas-->
            <div class="view-options">
                <div>
                    <button id="verCocineros" data-url="verCocineros.php"  type="button" class="ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal" data-bs-whatever="">
                        <i class="fa-solid fa-utensils" style="color: #ffffff;"></i>
                        Ver Cocineros
                    </button>
                    <button id="verMeseros" data-url="verMeseros.php" type="button" class="ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" data-bs-target="#mainModal" data-bs-whatever="">
                        <i class="fa-solid fa-bell-concierge" style="color: #ffffff;"></i>
                        Ver Meseros
                    </button>
                </div>
                <!--Barra de Busqueda-->
                <div class="input-group mb-3 search-bar">
                    <input type="text" class="form-control" placeholder="Buscar a un empleado" aria-label="" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #1f71ff;"></i></button>
                </div>
            </div>
            <!--Informacion de la tabla-->
            <h3 id="table-info"></h3>
            <!--Container para tablas-->
            <div class="cont-table">
            </div>
        </div>
        <div id="perfil" class="tab-content">
            <p class="test">Yo soy, perfiles.</p>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-form">
                            <!--El contenido del modal cambia dependiendo del boton que lo activo-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Scripts que necesitan ejecutarse hasta el final-->
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/filtroEventos.js"></script>
</body>
</html>