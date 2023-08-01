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
    <link rel="stylesheet" href="/css/cards.css">
    <link rel="stylesheet" href="../viewsClientes/pruebasCEventos/pruebaEventos.css">   
     

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
    $datosUsuario = array(
        "id" => $_SESSION["id"],
        "nombre" => $_SESSION["name"],
        "ap_paterno" => $_SESSION["ap_paterno"],
        "ap_materno" => $_SESSION["ap_materno"],
        "telefono" => $_SESSION["telefono"],
        "correo" => $_SESSION["correo"]
    );

    // Convertir el array de datos del usuario en formato JSON para poder pasarlo a JavaScript
    $datosUsuarioJSON = json_encode($datosUsuario);
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
            <button data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Home</button>
            <button data-tab="eventos" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Mis eventos</button>
            <button data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <button data-tab="configuracion" class="dash-button"><i class="fa-solid fa-gear" style="color: #ffffff;"></i><br>Configuracion</button>
        </div>
    </div>



    <!--Main Content-->
    <div id="main">
        <!-- Página de Eventos del cliente -->
        <div id="home" class="tab-content active">
            <div class="panel-header">
                <h3 class="test">
                    Mis eventos
                    <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i>
                </h3>
            </div>
            <div class="container" id="cardContainer">
            <!-- Las cards se generan dinámicamente con JavaScript -->
            
            </div>
        </div>
        <!-- Agendar Eventos -->
        <div id="eventos" class="tab-content">
            <div class="container mt-5">
                <div style="display: flex; flex-direction: column;">
                <h1>Configuración de Eventos</h1>
                <form id="evento-form">
                    <div class="form-group">
                        <label for="nombre_evento">Nombre del evento:</label>
                        <input type="text" class="form-control" id="nombre_evento" required>
                    </div>
                        <div class="form-group">
                            <label for="salon">Salón:</label>
                            <select class="form-control" id="salon" required>
                                <option value="">Seleccione un salón</option>
                                <option value="Cuatrociénegas">Cuatrociénegas</option>
                                <option value="Torreón">Torreón</option>
                                <option value="Saltillo">Saltillo</option>
                                <option value="Coahuila">Coahuila</option>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="comida">Menú del evento:</label>
                        <select class="form-control" id="comida" required>
                            <option value=>Seleccione un menú</option>
                            <option value=1>Americano</option>
                            <option value=2>Continental</option>
                            <option value=3>Original</option>
                            <option value=4>Saludable</option>
                            <option value=5>El Santuario</option>
                            <option value=6>Mexicano</option>
                            <option value=7>Montaña</option>
                            <option value=8>Sabor de Valle</option>
                            <option value=9>Mediterráneo</option>
                            <option value=10>Sabor y Energía</option>
                            <option value=11>Mar y Tierra</option>
                            <option value=12>Celebración 1</option>
                            <option value=13>Celebración 2</option>
                            <option value=14>Celebración 3</option>
                            <option value=15>Celebración 4</option>
                            <option value=16>Celebración 5</option>
                            <option value=17>Esencial</option>
                            <option value=18>Dulce mañana</option>
                            <option value=19>Mexicano</option>
                            <option value=20>Natural</option>
                            <option value=21>Energético</option>
                            <option value=22>Barra</option>
                            <option value=23>Nacional</option>
                            <option value=24>Premium</option>
                            <option value=25>Celebración</option>
                            <option value=26>Hamburguesas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="invitados">Cantidad de invitados:</label>
                        <input type="number" class="form-control" id="invitados" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha y hora del evento:</label>
                        <input type="text" class="form-control" id="fechaEvento" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Evento</button>
                </form>
                <div id="eventos-list">
                    <!-- Aquí se mostrarán los eventos agregados -->
                </div>
                </div>
            </div>
        </div>
        <!-- Página de Perfil del cliente -->
        <div id="perfil" class="tab-content">
        <!-- Datos personales del usuario -->
            <div class="container mt-5">
                <div style="display: flex; flex-direction: column;">
                    <h1>Mis Datos Personales</h1>
                    <p><strong>Nombre:</strong> <span id="nombre"><?php echo $_SESSION["name"] ?></span></p>
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
    
    <script>
    // Definir una variable global en JavaScript para almacenar los datos del usuario
    var datosUsuario = <?php echo $datosUsuarioJSON; ?>;
    </script>
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
    <span id="datosUsuarioJSON" style="display: none;"><?php echo $datosUsuarioJSON; ?></span>
    <!-- Agrega las siguientes líneas para cargar jQuery, el complemento datetimepicker y tu propio script.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Agrega la siguiente línea para cargar el complemento datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="pruebaJSEventos.js"></script>
</body>
</html>