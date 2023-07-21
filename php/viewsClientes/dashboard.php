

<!-- Mostrar los datos del usuario logueado en el HTML -->
<div class="container mt-5">
    <h1>Mis Datos Personales</h1>
    <p><strong>Nombre:</strong> <span id="nombre"><?php echo $nombre; ?></span></p>
    <p><strong>Apellido Paterno:</strong> <span id="ap_paterno"><?php echo $apPaterno; ?></span></p>
    <p><strong>Apellido Materno:</strong> <span id="ap_materno"><?php echo $apMaterno; ?></span></p>
    <p><strong>Correo:</strong> <span id="correo"><?php echo $correo; ?></span></p>
    <p><strong>Tipo de cuenta:</strong> <span id="tipo_cuenta"><?php echo $tipoCuenta; ?></span></p>
    <button class="btn btn-primary" id="editarDatos">Editar Datos</button>
</div>
