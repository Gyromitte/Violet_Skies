
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
    <!--Favi icon-->
    <link rel="icon" type="image/x-icon" href="/images/company_logo.png">
    <!--StyleSheets-->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/panelAdmin.css">
    <link rel="stylesheet" href="/css/cards.css">
    <link rel="stylesheet" href="/css/agendarEvento.css">

    <link rel="stylesheet" href="/php/viewsClientes/viewsClientes/css/style.css">

    <!-- Agrega la siguiente línea para cargar el CSS del complemento datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <!--Referencias a fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b60c246061.js" crossorigin="anonymous"></script>
    <script src="filterEvents.js" async defer></script>

    <!--Libreria full calendar-->
    <script src="/fullCalendar/fullcalendar.js"></script>

</head>
<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!--NavBar-->    
    <?php
        session_start();
        include_once 'menu.php';
        include_once 'salones.php';
        $access=1;
        if(isset($_SESSION["logged_in"])){
            if($_SESSION["access"]!==$access){
                header("Location:../scripts/access.php");
                
            }

        }
        else if(!isset($_SESSION["logged_in"])){
            header("Location:../views/login.php");
        }
        $datosUsuario = array(
            "id" => $_SESSION["ID"],
            "nombre" => $_SESSION["name"],
            "tipo" => $_SESSION["tipo"],
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
            <div style="margin-top: 20%;" > <?php echo $_SESSION["name"];?></div>
            <div><?php echo $_SESSION["tipo"];?><br><br></div>
            <button style="height: max-content;" data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Agendar evento</button>
            <button style="height: max-content;" data-tab="eventos" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Mis eventos</button>
            <button style="height: max-content;" data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <a style="text-decoration: none; height: max-content;" data-tab="logout" class="dash-button" href="../scripts/CerrarSesion.php">
            <i class="fa-solid fa-door-open" style="color: #ffffff; padding-top: 10px;"></i><br>Logout</a>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <!-- Página de Eventos del cliente -->
        <div id="home" class="tab-content active">
            <!--Div que contiene el calendario-->
            <div id="calendar" style="padding: 30px;"></div>
        </div>

        <!-- Agendar Eventos -->
        <div id="eventos" class="tab-content colspan">
            <div class="panel-header" style="display: flex; flex-direction: column; align-items: center;">
                    <h3 class="test" style="text-align: center; margin-top:2%">
                        Mis eventos
                        <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i>
                    </h3>
                    <div  style=" width:fit-content;"  class="custom-card rounded-5">
                        <h3 style=" padding-right:5%; padding-left:5%; text-align: center;">Aquí puedes ver tus eventos.</h3>
                            <p style=" padding-right:5%; padding-left:5%; text-align: center;"><b>Si deseas realizar cambios debes contactarte con nosotros para aclarar detalles.</b></p>
                    </div>
                </div>
                <div class="filter-buttons">
                    <button class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" onclick="filterEvents('PENDIENTE')">Pendiente</button>
                    <button class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" onclick="filterEvents('EN PROCESO')">En Proceso</button>
                    <button class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" onclick="filterEvents('FINALIZADO')">Finalizado</button>
                    <button class="btn-options ver-empleados btn btn-primary border-2 btn-outline-light rounded-5" onclick="filterEvents('CANCELADO')">Cancelado</button>
                    <a href="https://wa.me/528715659629?text=¡Hola! Quiero hablar con la persona a cargo" target="_blank" style="border:5px;  display: inline-block; background-color: green; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px;">
                            <i class="fa-brands fa-whatsapp me-1" style="color: #ffffff;"></i><b>WhatsApp</b>
                        </a>  
                </div>

                <div id="event-cards" class="card-container">
                <!-- Aquí se agregarán las tarjetas de eventos -->
                </div>
        </div>

        <!-- Página de Perfil del cliente -->
        <div id="perfil" class="tab-content">
        <!-- Datos personales del usuario -->
        <div class="container mt-5">
            <div style="display: flex; flex-direction: column;">
                <h3 style="text-align: center; margin-right: 5%" class="alert alert-primary">
                    Tendrás que volver a iniciar sesión después de editar tus datos
                </h3>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header custom-accordion-header">
                            <button class="accordion-button custom-accordion-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                            style="color: white;">
                            <i class="fa-solid fa-user me-2" style="color: #ffffff;"></i>
                            Datos personales
                            </button>
                        </h2>
                    <div style="padding-left: 10%; padding-right:10%" id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="personal-info">
                                <div class="mb-3 row">
                                    <p><strong>Nombre:</strong> <span id="nombre"><?php echo $_SESSION["name"]; ?></span></p>
                                    <p><strong>Apellido Paterno:</strong> <span id="ap_paterno"><?php echo $_SESSION["ap_paterno"]; ?></span></p>
                                    <p><strong>Apellido Materno:</strong> <span id="ap_materno"><?php echo $_SESSION["ap_materno"]; ?></span></p>
                                    <p><strong>Teléfono:</strong> <span id="telefono"><?php echo $_SESSION["telefono"]; ?></span></p>
                                    <p><strong>Correo:</strong> <span id="correo"><?php echo $_SESSION["correo"]; ?></span></p>
                                    <p><strong>Tipo de cuenta:</strong> <span id="tipo_cuenta"><?php echo $_SESSION["tipo"]; ?></span></p>
                                    <button type="button" class="btn btn-light" id="editarDatos" data-bs-toggle="modal" data-bs-target="#mainModal" data-bs-whatever="@editarPerfil">Editar Datos</button>
                                    <button class="btn btn-light" id="btnpassword" type="button" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">
                                    <i class="fa-solid fa-lock me-2" style="color: #ffffff;"></i>
                                    Cambiar contraseña</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
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
    <div id="cancelModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar evento</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cancelForm">
                    <p id="cancelMessage"></p>
                    <label>¿Estás seguro de que quieres cancelar el evento?</label>
                    <input type="hidden" id="eventIDInput" name="eventID">
                    <label class="form-label" for="password">Contraseña:</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                    <button type="submit">Cancelar evento</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="modalCambiarContrasena" tabindex="-1" aria-labelledby="modalCambiarContrasenaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="formCambiarContrasena" method="POST">
                      <div class="mb-3">
                        <label class="form-label">Contraseña actual:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Nueva contraseña:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                      </div>
                      <input type="hidden" name="cuenta" value="<?php echo $_SESSION["ID"]; ?>">
                      <button type="submit" class="btn btn-primary">Cambiar</button>
                      <div><br></div>
                      <div class="alert d-none" role="alert" align="center" id="alertMessage">
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>





    <!--Scripts que necesitan ejecutarse hasta el final-->
    <script>
    // Definir una variable global en JavaScript para almacenar los datos del usuario
    var datosUsuario = <?php echo $datosUsuarioJSON; ?>;
    document.addEventListener('DOMContentLoaded', function () {
        const comidaSelect = document.getElementById('comida');
        const descripcionComidaDiv = document.getElementById('descripcionComida');
        
        comidaSelect.addEventListener('change', function () {
            const selectedOption = comidaSelect.options[comidaSelect.selectedIndex];
            const descripcion = selectedOption.getAttribute('data-descripcion');
            
            descripcionComidaDiv.innerHTML = descripcion;
        });

    });
    

    </script>
    <script src="/js/dinamicTable.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <span id="datosUsuarioJSON" style="display: none;"><?php echo $datosUsuarioJSON; ?></span>
    <!-- Agrega las siguientes líneas para cargar jQuery, el complemento datetimepicker y tu propio script.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="/js/panelAdmin.js"></script>
    <script src="./pruebaJSEventos.js"></script>
    <script src="/js/datosAdmin.js"></script>
    <!-- Agrega la siguiente línea para cargar el complemento datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="/php/viewsClientes/viewsClientes/js/renderCalendar.js"></script>
</body>
</html>