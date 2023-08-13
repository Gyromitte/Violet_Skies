<?php
include "../dataBase.php";

$emp = $_SESSION["ID"];
$db = new DataBase();
$db->conectarBD();

$query = "SELECT * FROM CUENTAS WHERE ID = '$emp'";
$cuenta = $db->seleccionar($query);
if ($cuenta) {
?>
   <div class="container-fluid text-center" style="margin-top: 100px;">
        <div class="accordion-item mx-auto rounded">
        <h2 class="accordion-header custom-accordion-header text-start">
            <i class="fa-solid fa-user me-2" style="color: #ffffff;"></i>
            Datos personales
        </h2>
        <div>
        <div class="personal-info accordion" id="accordionExample" style="color: black;">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Nombre:</label>
                <div class="col-sm-9 accordion-header  text-center">
                    <input class="form-control" type="text" value="<?php echo $cuenta[0]->NOMBRE; ?>" name="nombre" disabled>
                </div>
            </div>
            <div class="mb-3 row ">
                <label class="col-sm-3 col-form-label">Apellido paterno:</label>
                <div class="col-sm-9 accordion-header">
                    <input class="form-control" type="text" value="<?php echo $cuenta[0]->AP_PATERNO; ?>" name="ap_paterno" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Apellido materno:</label>
                <div class="col-sm-9 accordion-header">
                    <input class="form-control" type="text" value="<?php echo $cuenta[0]->AP_MATERNO; ?>" name="ap_materno" disabled>
                </div>
            </div>
            <div class="mb-3 row ">
                <label class="col-sm-3 col-form-label">Teléfono:</label>
                <div class="col-sm-9 accordion-header">
                    <input class="form-control" type="text" value="<?php echo $cuenta[0]->TELEFONO; ?>" name="telefono" disabled>
                </div>
            </div>
            <div class="mb-3 row ">
                <label class="col-sm-3 col-form-label">Correo:</label>
                <div class="col-sm-9 accordion-header">
                    <input class="form-control" type="text" value="<?php echo $cuenta[0]->CORREO; ?>" name="correo" disabled>
                </div>
            </div>
            <div class="mb-3 row ">
                <label class="col-sm-3 col-form-label">Contraseña:</label>
                <div class="col-sm-4 accordion-header">
                <button class="btn btn-light" id="btnpassword" type="button"  data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">
                          <i class="fa-solid fa-lock me-2" style="color: #ffffff;"></i>
                          Cambiar contraseña</button>                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-primary" id="btnEditarDatosPersonales" onclick="habilitarEdicion()">
                        <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Editar Datos</button>
                    <button class="btn btn-success d-none" id="btnGuardarCambios" onclick="guardarCambios()">
                        <i class="fa-solid fa-floppy-disk me-2" style="color: #ffffff;"></i>Guardar Cambios</button>
                    <button class="btn btn-danger d-none" id="btnCancelarCambios" onclick="cancelarCambios()">
                        <i class="fa-solid fa-ban me-2" style="color: #ffffff;"></i>Cancelar Cambios</button>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $_SESSION["ID"]; ?>">
        </div>
    </div>
</div>
</div>
<div id="mensajeModificar"></div>

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

<?php
}
$db->desconectarBD();
?>
