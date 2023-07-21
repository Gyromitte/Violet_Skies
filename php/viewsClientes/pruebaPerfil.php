<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Datos Personales</title>
    <!-- Enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php
        session_start();
        if (!isset($_SESSION["access"]) || $_SESSION["access"] !== 1) {
            echo"No tienes acceso a esta pagina";
            header("refresh:2;/index.html");
        }
        
    ?>
</head>

<body>
    <!-- Datos personales del usuario -->
    <div class="container mt-5">
                <h1>Mis Datos Personales</h1>
                <p><strong>Nombre:</strong> <span id="nombre"><?php echo $_SESSION["name"]; ?></span></p>
                <p><strong>Apellido Parerno:</strong> <span id="ap_paterno"><?php echo $_SESSION["ap_paterno"]; ?></span></p>
                <p><strong>Apellido Materno:</strong> <span id="ap_materno"><?php echo $_SESSION["ap_materno"]; ?></span></p>
                <p><strong>Teléfono:</strong> <span id="Teléfono"><?php echo $_SESSION["telefono"]; ?></span></p>
                <p><strong>correo:</strong> <span id="correo"><?php echo $_SESSION["correo"]; ?></span></p>
                <p><strong>Tipo de cuenta:</strong> <span id="tipo_cuenta">Cliente</span></p>
                <button class="btn btn-primary" id="editarDatos" data-toggle="modal" data-target="#modalEditarDatos">Editar Datos</button>
            </div>

    <div class="modal fade" id="modalEditarDatos" tabindex="-1" role="dialog" aria-labelledby="modalEditarDatosLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarDatosLabel">Editar Datos Personales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditarDatos" method="post" action="pruebaComprobación.php">
                        <div class="form-group">
                            <label for="nombreInput">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombreInput" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_paternoInput">Apellido Paterno:</label>
                            <input type="text" class="form-control" name="ap_paterno" id="ap_paternoInput" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_maternoInput">Apellido Materno:</label>
                            <input type="text" class="form-control" name="ap_materno" id="ap_maternoInput" required>
                        </div>
                        <div class="form-group">
                            <label for="telefonoInput">Teléfono:</label>
                            <input type="tel" class="form-control" name="telefono" id="telefonoInput" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasenaInput">Contraseña:</label>
                            <input type="password" class="form-control" name="contrasena" id="contrasenaInput" required>
                        </div>
                        <input type="hidden" name="correo" id="correoInput">
                        <input type="hidden" name="tipo_cuenta" id="tipo_cuentaInput">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Obtener los datos actuales del usuario
        const nombre = document.getElementById('nombre').textContent;
        const apPaterno = document.getElementById('ap_paterno').textContent;
        const apMaterno = document.getElementById('ap_materno').textContent;
        const correo = document.getElementById('correo').textContent;
        const tipoCuenta = document.getElementById('tipo_cuenta').textContent;
        

        // Rellenar los campos del formulario del modal con los datos actuales
        document.getElementById('nombreInput').value = nombre;
        document.getElementById('ap_paternoInput').value = apPaterno;
        document.getElementById('ap_maternoInput').value = apMaterno;
        document.getElementById('correoInput').value = correo;
        document.getElementById('tipo_cuentaInput').value = tipoCuenta;
        

        // Abrir el modal cuando se haga clic en el botón de editar datos
        document.getElementById('editarDatos').addEventListener('click', function () {
        console.log('Botón "Editar Datos" clickeado.');
        $('#modalEditarDatos').modal('show');
        });

    </script>

    <!-- Enlace al archivo JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
