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
                        <input class="form-control" type="text" value="<?php echo $result[0]->TELEFONO; ?>" name="telefono" disabled>
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
                        <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">Cambiar contraseña</button>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_SESSION["ID"]; ?>">
                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" onclick="habilitarEdicion()" id="btnModificar">Modificar datos</button>
                      <div class="d-flex justify-content-end">
                        <button class="btn btn-success d-none" id="btnGuardarCambios" onclick="guardarCambios()">Guardar cambios</button>
                        <button class="btn btn-danger d-none" id="btnCancelarCambios" onclick="cancelarCambios()">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Registrar nuevo administrador
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <strong>Recuerda que las personas que des de alta tendrán privilegios sobre los trabajadores y eventos registrados en esta página</strong>
                  <div class="personal-info">
                    <br>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Nombre:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="nombre">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="ap_paterno">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Apellido materno:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="ap_materno">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Teléfono:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="telefono">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">Correo:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="correo">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-2 col-form-label">RFC:</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="RFC">
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" onclick="registrarAdmin()" id="nuevoAdmin">Agregar nuevo administrador</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

            <div class="modal fade" id="modalCambiarContrasena" tabindex="-1" aria-labelledby="modalCambiarContrasenaLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCambiarContrasenaLabel">Cambiar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="formCambiarContrasena" method="POST">
                      <div class="mb-3">
                        <label for="currentPassword" class="form-label">Contraseña actual:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                      </div>
                      <div class="mb-3">
                        <label for="newPassword" class="form-label">Nueva contraseña:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                      </div>
                      <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                      </div>
                      <input type="hidden" name="cuenta" value="<?php echo $_SESSION["ID"]; ?>">
                      <button type="submit" class="btn btn-primary" id="btnCambiarContrasena">Cambiar</button>
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

<script>
  const btnModificar = document.getElementById('btnModificar');
  const btnGuardarCambios = document.getElementById('btnGuardarCambios');
  const btnCancelarCambios = document.getElementById('btnCancelarCambios');
  const formu = document.getElementById('formCambiarContrasena');
    const formData = new FormData(formu);
    const successDiv = document.getElementById('alertMessage');
  // Función para enviar los datos del formulario a cambContraseña.php mediante AJAX
  function cambiarContraseña() {

    // Realizar la solicitud AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // La respuesta del servidor ha sido recibida correctamente
        const response = JSON.parse(this.responseText);
        const alertDiv = document.getElementById('alertMessage');

        if (response.success) {
          alertDiv.classList.add('alert-success')
          // Los datos se actualizaron correctamente en la base de datos
          alertDiv.textContent = response.message;
          // Aplicar la clase CSS para alerta de éxito
          successDiv.textContent = response.message;
          successDiv.classList.remove('d-none');
          console.log(response.message);

          setTimeout(function() {
            location.reload();
          }, 3000); // 3000 milisegundos = 3 segundos

        } else {
          alertDiv.classList.add('alert-danger');
            alertDiv.textContent = response.message;
            // Aplicar la clase CSS para alerta de error
            successDiv.classList.remove('d-none');
            successDiv.textContent = response.message;
            console.log(response.message);

            setTimeout(function() {
              alertDiv.classList.add('d-none'); // Agrega la clase para ocultar el div
            }, 3000); 
        }
      }
    };
    xhttp.open("POST", "../viewsPerfil/cambContraseña.php", true);
    xhttp.send(formData);
  }

  // Agregar un evento al formulario para llamar a la función cambiarContraseña al enviarlo
  document.getElementById('formCambiarContrasena').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío normal del formulario
    cambiarContraseña();
  });

  function habilitarEdicion() {
    const inputs = document.querySelectorAll('.personal-info input[disabled]');
    inputs.forEach(input => input.removeAttribute('disabled'));
    
    const btnModificar = document.getElementById('btnModificar');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnModificar.classList.add('d-none');
    btnGuardarCambios.classList.remove('d-none');
    btnCancelarCambios.classList.remove('d-none');
  }

  function guardarCambios() {
    const inputs = document.querySelectorAll('.personal-info input:not([disabled])');
    const newData = {}; // Objeto para almacenar los nuevos datos editados.

    inputs.forEach(input => {
      newData[input.name] = input.value; // Almacena el nuevo valor en el objeto newData con el nombre del campo como clave.
      input.setAttribute('disabled', 'true'); // Deshabilitar los inputs nuevamente después de guardar los cambios.
    });
    // Aquí usaremos AJAX para enviar newData al archivo guardarCambios.php
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // La respuesta del servidor ha sido recibida correctamente
        const response = JSON.parse(this.responseText);
        if (response.success) {
          // Los datos se actualizaron correctamente en la base de datos
          // Puedes mostrar un mensaje de éxito o realizar alguna acción adicional
          console.log(response.message);
        } else {
          // Hubo un error al actualizar los datos en la base de datos
          // Puedes mostrar un mensaje de error o realizar alguna acción de manejo de errores
          console.log(response.message);
        }
        const btnModificar = document.getElementById('btnModificar');
        const btnGuardarCambios = document.getElementById('btnGuardarCambios');
        const btnCancelarCambios = document.getElementById('btnCancelarCambios');

        btnModificar.classList.remove('d-none');
        btnGuardarCambios.classList.add('d-none');
        btnCancelarCambios.classList.add('d-none');
      }
    };
    xhttp.open("POST", "../viewsPerfil/guardarDatos.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(newData));
  }

  function cancelarCambios() {
    const inputs = document.querySelectorAll('.personal-info input:not([disabled])');
    inputs.forEach(input => {
      input.setAttribute('disabled', 'true');
      input.value = input.defaultValue;
    });

    const btnModificar = document.getElementById('btnModificar');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnModificar.classList.remove('d-none');
    btnGuardarCambios.classList.add('d-none');
    btnCancelarCambios.classList.ad  
  }
</script>