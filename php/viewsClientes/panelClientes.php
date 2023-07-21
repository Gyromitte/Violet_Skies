
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
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
    <?php
        session_start();
        if (!isset($_SESSION["access"]) || $_SESSION["access"] !== 1) {
            echo"No tienes acceso a esta pagina";
            header("refresh:2;/index.html");
        }
        
    ?>
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
            <?php echo $_SESSION["name"];?>
        </div>
    </nav>
    <!--DashBoard-->
    <div id="dash-board">
        <div id="dash-board-content">
            <div id="dash-photo-user"></div>
            Username<br>
            Position<br><br>
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Mis eventos</button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <button data-tab="configuracion" class="dash-button"><i class="fa-solid fa-gear" style="color: #ffffff;"></i><br>Configuracion</button>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <!-- Página de Eventos del cliente -->
        <div id="home" class="tab-content active">
            <p class="test">Yo soy, home</p>
        </div>
        <!-- Página de Perfil del cliente -->
        <div id="perfil" class="tab-content">
        <!-- Datos personales del usuario -->
        <div class="container mt-5">
        <div style="display: flex; flex-direction: column;">
        <h1>Mis Datos Personales</h1>
            <p><strong>Nombre:</strong> <span id="nombre"><?php echo $_SESSION["name"]; ?></span></p>
            <p><strong>Apellido Paterno:</strong> <span id="ap_paterno"><?php echo $_SESSION["ap_paterno"]; ?></span></p>
            <p><strong>Apellido Materno:</strong> <span id="ap_materno"><?php echo $_SESSION["ap_materno"]; ?></span></p>
            <p><strong>Teléfono:</strong> <span id="telefono"><?php echo $_SESSION["telefono"]; ?></span></p>
            <p><strong>Correo:</strong> <span id="correo"><?php echo $_SESSION["correo"]; ?></span></p>
            <p><strong>Tipo de cuenta:</strong> <span id="tipo_cuenta">Cliente</span></p>
            <button class="btn btn-primary" id="editarDatos" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@editarPerfil">Editar Datos</button>

        </div>

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
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/filtroEventos.js"></script>
</body>
</html>