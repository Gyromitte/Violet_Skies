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

    <!--Nuevo styleShett-->
    <link rel="stylesheet" href="/php/viewsClientes/calendario/css/style.css">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <!--Libreria flatpickr-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/flatpickr.min.js"></script>

    <style>
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
    <script src="/php/viewsClientes/calendario/js/renderCalendar.js"></script>

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
    $access = 1;
    if (isset($_SESSION["logged_in"])) {
        if ($_SESSION["access"] !== $access) {
            header("Location:../scripts/access.php");
        }
    } else if (!isset($_SESSION["logged_in"])) {
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
            <div style="margin-top: 20%;"> <?php echo $_SESSION["name"]; ?></div>
            <div><?php echo $_SESSION["tipo"]; ?><br><br></div>
            <button style="height: max-content;" data-tab="home" class="dash-button"><i class="fa-solid fa-house" style="color: #ffffff;"></i><br>Agendar evento</button>
            <button style="height: max-content;" data-tab="eventos" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Mis eventos</button>
            <button style="height: max-content;" data-tab="perfil" class="dash-button"><i class="fa-solid fa-user" style="color: #ffffff;"></i><br>Perfil</button>
            <a style="text-decoration: none; height: max-content;" data-tab="logout" class="dash-button" href="../scripts/CerrarSesion.php">
                <i class="fa-solid fa-door-open" style="color: #ffffff; padding-top: 10px;"></i><br>Logout</a>
        </div>
    </div>
    <!--Main Content-->
    <div id="main">
        <!-- Agendar Evento -->
        <div id="home" class="tab-content active" style="padding: 50px;">
            <div class="row">
                <!-- Div que contiene el calendario -->
                <div class="col-md-5">
                    <div id="calendar"></div>
                </div>
                <!-- Div del wizard -->
                <div class="col-md-7 d-flex flex-column align-items-center justify wizard" style="padding-left: 50px;">
                    <!-- Div de información pasos -->
                    <div style="width: fit-content;" class="rounded-2 mb-2" id="infoAgendar"></div>
                    <!-- Div de advertencia -->
                    <div class="alert alert-danger" id="infoAdvertencia" style="display: none;"></div>
                    <!-- Div de explicación -->
                    <div style="width: fit-content;" class="rounded-2 mb-4" id="infoExpli"></div>
                    <!--Div de las comidas-->
                    <div style=" align-content:center; justify-content: center;  display: none;" class="container custom-item rounded-2 mb-2" id="descripcionComida">
                        <!-- Aquí van las comidas -->
                        Escoge un menú para ver su descripción
                    </div>
                    <div class="container d-flex flex-column align-items-center">
                        <!-- Formulario de pasos o pestañas -->
                        <div class="step-form">
                            <form id="evento-form" method="post">
                                <!-- Contenido del primer paso (Fecha del evento e invitados) -->
                                <div class="step step-1">
                                    <!-- Campos del primer paso -->
                                    <div class="form-group mb-4">
                                        <label for="fecha_evento">Fecha del evento:</label>
                                        <input autocomplete="off" type="date" class="form-control abbb" name="fecha" id="selected-date" readonly="" required="">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="hora_evento">Hora del evento: </label>
                                        <input type="time" id="hora_evento" class="form-control" name="hora_evento" placeholder="HH:MM AM/PM">
                                    </div>
                                    <!--Cantidad de invitados-->
                                    <div class="form-group mb-4">
                                        <label for="cantidad_invitados">Cantidad de invitados: </label>
                                        <input type="text" class="form-control" id="invitados" name="invitados" oninput="limitarANumeros(this); mostrarSalones();" maxlength="3">
                                    </div>
                                </div>
                                <script>
                                    
                                </script>
                                <!-- Contenido del segundo paso (Nombre del evento) -->
                                <div class="step step-2">
                                    <div class="form-group mb-4">
                                        <label for="nombre_evento">Nombre del evento: </label>
                                        <input type="text" class="form-control" id="nombre_evento" name="nombre_evento" required maxlength="50" oninput="limitarALetras(this)">
                                    </div>
                                </div>
                                <!-- Contenido del tercer paso (Salon) -->
                                <div class="step step-3">
                                    <!-- Campos del segundo paso -->
                                    <div class="form-group mb-4">
                                        <label for="salon">Salón:</label>
                                        <select class="form-control" id="salon" name="salon" required>
                                            <!-- Opciones del select -->
                                            <option value="">Seleccione un salón</option>
                                        </select>
                                    </div>
                                </div>
                                <!--Este es un coco de TF2, si lo quitas los salones no se mostraran, no se por que-->
                                <script>
                                    var cantidadInvitadosInput = document.querySelector("#invitados");
                                    var cantidadInvitados = parseInt(cantidadInvitadosInput.value);
                                    var salonSelect = document.querySelector("#salon");

                                    function mostrarSalones(){
                                        console.log(cantidadInvitados);
                                        if(cantidadInvitados >= 10 && cantidadInvitados < 20 )
                                        {
                                            salonSelect.innerHTML = `<option value ='1'> Cuatrociénegas 1 Cupo: 20 </option>`;
                                            console.log("wow");
                                        }
                                        console.log(salonSelect);
                                    }
                                </script>
                                <!--Obtener eventos y mandarlo a paramEven.js-->
                                <script>
                                    let eventosObtenidos = [];
                                    $.ajax({
                                        url: '/php/viewsClientes/checkSalones.php',
                                        method: 'GET',
                                        success: function (data) {
                                            eventosObtenidos = data; // No necesitas JSON.parse aquí
                                            console.log("Eventos obtenidos:", eventosObtenidos);
                                        },
                                        error: function (error) {
                                            console.error("Error al obtener eventos:", error);
                                        }
                                    });
                                </script>
                                <!--Contenido del cuarto paso (Menu)-->
                                <div class="step step-4">
                                <label for="comida">Menú del evento:</label>
                                    <select class="form-control mb-4" id="comida" name="comida" required>
                                        <option value="">Seleccione una comida del menú</option>
                                        <?php
                                        foreach ($menuItems as $menuItem) {
                                            echo '<option value="' . $menuItem['ID'] . '" data-descripcion="' . $menuItem['DESCRIPCION'] . '">' . $menuItem['NOMBRE'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!--Paso final (Confirmacion)-->
                                <div class="step step-5 align-text-center mb-3">
                                    <p>Fecha del evento: <span id="confirm-fecha"></span></p>
                                    <p>Hora del evento: <span id="confirm-hora"></span></p>
                                    <p>Cantidad de invitados: <span id="confirm-invitados"></span></p>
                                    <p>Nombre del evento: <span id="confirm-nombre"></span></p>
                                    <p>Salón seleccionado: <span id="confirm-salon"></span></p>
                                    <p>Menú seleccionado: <span id="confirm-menu"></span></p>
                                    <div class="alert alert-info">Recuerda que puedes regresar a cualquier paso <br> anterior para corregir lo que desees</div>
                                    <div class="center-button">
                                        <button class="btn btn-primary confirm-button" id="accept-button">
                                            Enviar solicitud de evento<br>
                                            <i class="fa-solid fa-paper-plane" style="color: #ffffff;"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Botones de navegación entre pasos -->
                                <div class="step-navigation step-navigation-container">
                                    <button class="btn btn-primary prev-step btn-wizard"><i class="fa-solid fa-backward me-2" style="color: #ffffff;"></i>Anterior</button>
                                    <button class="btn btn-primary next-step btn-wizard">Siguiente <i class="fa-solid fa-forward me-2" style="color: #ffffff;"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
</div>
        <!-- Agendar Eventos -->
        <div id="eventos" class="tab-content colspan">
            <div class="panel-header" style="display: flex; flex-direction: column; align-items: center;">
                <h3 class="test" style="text-align: center; margin-top:2%">
                    Mis eventos
                    <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i>
                </h3>
                <div style=" width:fit-content;" class="custom-card rounded-5">
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
                    <div class='d-flex justify-content-center'>
                        <div class='loading-spinner' id='loadingSpinner'>
                            <div class='spinner-border text-primary' role='status'>
                                <span class='visually-hidden'>Loading...</span>
                            </div>
                        </div>
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
                                <button class="accordion-button custom-accordion-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: white;">
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
        document.addEventListener('DOMContentLoaded', function() {
            const comidaSelect = document.getElementById('comida');
            const descripcionComidaDiv = document.getElementById('descripcionComida');

            comidaSelect.addEventListener('change', function() {
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


    <script src="/php/viewsClientes/calendario/js/wizard.js"></script>

    <script src="/php/viewsClientes/calendario/js/paramEven.js"></script>
    <script>
        flatpickr("#hora_evento", {
        enableTime: true,          // Habilitar la selección de tiempo
        noCalendar: true,          // No mostrar el calendario
        dateFormat: "H:i",         // Cambiar el formato de hora a 24 horas
        time_24hr: true,           // Usar formato de 24 horas
        minuteIncrement: 60,       // Incremento de minutos a 60 (solo horas)
        minTime: "06:00",          // Hora mínima permitida (6:00 AM)
        maxTime: "22:00",          // Hora máxima permitida (10:00 PM)
        
        });
    </script>
</body>

</html>