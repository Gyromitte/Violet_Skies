<?php
include "../dataBase.php";

    $emp = $_SESSION["ID"];
    $trab=$_SESSION["trabajo"];
    $db = new DataBase();

    $db->conectarBD();
      
    $query = "SELECT * FROM CUENTAS WHERE ID = '$emp'";
    $cuenta=$db->seleccionar($query);
    if ($cuenta) {
?>
   <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Datos personales
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="personal-info">
                  <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" value="<?php echo $cuenta[0]->NOMBRE; ?>" name="nombre" disabled>
                    </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $cuenta[0]->AP_PATERNO; ?>" name="ap_paterno" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido materno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $cuenta[0]->AP_MATERNO; ?>" name="ap_materno" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Teléfono:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $cuenta[0]->TELEFONO; ?>" name="telefono" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Correo:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $cuenta[0]->CORREO; ?>" name="correo" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Contraseña:</label>
                      <div class="col-sm-10">
                        <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">Cambiar contraseña</button>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_SESSION["ID"]; ?>">
                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" onclick="habilitarEdicion()" id="btnEditarDatosPersonales">Modificar datos</button>
                      <div class="d-flex justify-content-end">
                        <button class="btn btn-success d-none" id="btnGuardarCambios" onclick="guardarCambios()">Guardar cambios</button>
                        <button class="btn btn-danger d-none" id="btnCancelarCambios" onclick="cancelarCambios()">Cancelar</button>
                      </div>
                    </div>
                    <div id="mensajeModificar"></div>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        </div>      <?php
    }
    // Cerrar la conexión
    $db->desconectarBD();
?>

