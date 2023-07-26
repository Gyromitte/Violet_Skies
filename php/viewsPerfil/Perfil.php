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
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
</head>
<body>
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
                    <input class="form-control" type="text" value="<?php echo $_SESSION['name']; ?>" name="nombre" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Apellido paterno:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['ap_paterno']; ?>" name="ap_paterno" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Apellido materno:</label>
                <div class="col-sm-10">
                   <input class="form-control" type="text" value="<?php echo $_SESSION['AP_MATERNO']; ?>" name="ap_materno" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Teléfono:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['TELEFONO']; ?>" name="telefono" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Correo:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['CORREO']; ?>" name="correo" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Contraseña:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="<?php echo $_SESSION['CORREO']; ?>"  name="contraseña"disabled>
                </div>
            </div>
            <div class="d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCambiarDatos" onclick="habilitarEdicion()" id="btnModificar">Modificar datos</button>
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
        Accordion Item #2
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>



<script>
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

    // Aquí envías newData al servidor para actualizar la base de datos usando AJAX o formularios, por ejemplo:
    // Puedes usar la clase Database para actualizar los datos:
    const database = new Database();
    database.conectarBD();
    database.ejecutarSQL(`UPDATE CUENTAS SET NOMBRE='${newData.nombre}', AP_PATERNO='${newData.ap_paterno}', AP_MATERNO='${newData.ap_materno}', TELEFONO='${newData.telefono}', CORREO='${newData.correo}' WHERE ID_TU_REGISTRO='${TU_ID}'`);
    database.desconectarBD();

    const btnModificar = document.getElementById('btnModificar');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnModificar.classList.remove('d-none');
    btnGuardarCambios.classList.add('d-none');
    btnCancelarCambios.classList.add('d-none');
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
    btnCancelarCambios.classList.add('d-none');
  }
</script>


</body>
</html>