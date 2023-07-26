<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--StyleSheets-->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/panelAdmin.css">
    <!--Referencias a fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300&family=Patua+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>verPerfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
        @media (max-width: 767px) {
            .container {
                flex-direction: column;
            }

            .personal-info,
            .event-history {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
    
</head>
<body>
    <div class="container">
        <div class="personal-info">
            <hr>
            <h3 align="center">Datos personales</h3>
            <hr>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['name']; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['ap_paterno']; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Apellido materno:</label>
                <div class="col-sm-10">
                   <input class="form-control" type="text" value="<?php echo $_SESSION['AP_MATERNO']; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Teléfono:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['TELEFONO']; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Correo:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['CORREO']; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Contraseña:</label>
                <div class="col-sm-10">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena" onclic="cambContraseña.php">Cambiar contraseña</button>
                </div>
            </div>
        </div>

        <div class="event-history">
            <hr>
            <h3 align="center">Historial de eventos</h3>
            <hr>

        </div>
    </div>

    

    <?php include_once 'cambContraseña.php'; ?>

</body>
</html>
