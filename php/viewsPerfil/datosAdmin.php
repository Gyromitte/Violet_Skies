<?php
include_once "../dataBase.php";

// Obtener el identificador único del usuario para buscar sus datos
if (isset($_SESSION["ID"])) {
  $user_id = $_SESSION["ID"];
    try {
      // Crear una instancia de la clase DataBase para usar los identificadores de la clase
      $db = new DataBase();
      // Llamar al método conectar() para establecer la conexión a la base de datos
      $conexion = $db->conectarBD();
      // Consulta preparada para buscar los datos del usuario por su ID
      $query = "SELECT * FROM CUENTAS WHERE ID = :user_id";
      $parametros = array(':user_id' => $user_id);
      $result = $db->seleccionarPreparado($query, $parametros);
      if ($result) {
      ?>
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header custom-accordion-header">
            <button class="accordion-button custom-accordion-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
            style="color: white;">
            <i class="fa-solid fa-user me-2" style="color: #ffffff;"></i>
            Datos personales
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="personal-info">
                  <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" value="<?php echo $result[0]->NOMBRE; ?>" name="nombre" disabled>
                    </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $result[0]->AP_PATERNO; ?>" name="ap_paterno" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido materno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $result[0]->AP_MATERNO; ?>" name="ap_materno" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Teléfono:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="tel" pattern="^[0-9]{10}$" value="<?php echo $result[0]->TELEFONO; ?>" name="telefono" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Correo:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php echo $result[0]->CORREO; ?>" name="correo" disabled>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Contraseña:</label>
                      <div class="col-sm-10">
                        <button class="btn btn-light" id="btnpassword" type="button" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">
                          <i class="fa-solid fa-lock me-2" style="color: #ffffff;"></i>
                          Cambiar contraseña</button>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_SESSION["ID"]; ?>">
                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" onclick="habilitarEdicion()" id="btnEditarDatosPersonales">
                        <i class="fa-solid fa-pencil me-2" style="color: #ffffff;"></i>Modificar datos</button>
                        <div class="d-flex justify-content-end">
                          <button class="btn btn-success d-none" id="btnGuardarCambios" onclick="guardarCambios()">
                            <i class="fa-solid fa-floppy-disk me-2" style="color: #ffffff;"></i>Guardar cambios</button>
                            <button class="btn btn-danger d-none" id="btnCancelarCambios" onclick="cancelarCambios()">
                              <i class="fa-solid fa-ban me-2" style="color: #ffffff;"></i>Cancelar</button>
                            </div>
                          </div>
                          <div id="mensajeModificar" class="alert alert-success" role="alert"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
              <button class="accordion-button collapsed custom-accordion-header" style="color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <i class="fa-solid fa-address-card me-2" style="color: #ffffff;"></i>Registrar nuevo administrador
              </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <strong>Considera que el registrar un nuevo administrador estás otorgando permisos para manejar información sensible</strong>
                <div><br></div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Nombre:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="text" name="nombreNEW" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="text" name="ap_paternoNEW">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Apellido materno:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="text" name="ap_maternoNEW">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Teléfono:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="tel" pattern="^[0-9]{10}$" name="telefonoNEW">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Correo:</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="email" name="correoNEW">
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button class="btn btn-primary" onclick="nuevoAdmin()" id="nuevoAdmin">
                  <i class="fa-solid fa-address-card me-2" style="color: #ffffff;"></i>Registrar administrador</button>
                </div>
                <div id="mensaje"></div>
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
          
      <?php
      } else {
        echo "Usuario no encontrado.";
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    // Cerrar la conexión
    $db->desconectarBD();
  } else {
    echo "No se ha proporcionado un identificador de usuario.";
  }
?>

