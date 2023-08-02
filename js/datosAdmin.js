  const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
  const btnGuardarCambios = document.getElementById('btnGuardarCambios');
  const btnCancelarCambios = document.getElementById('btnCancelarCambios');
  const successDiv = document.getElementById('alertMessage');
  // Función para enviar los datos del formulario a cambContraseña.php mediante AJAX
  function cambiarContraseña() {
    const formu = document.getElementById('formCambiarContrasena');
      const formCambiarPass = new FormData(formu);
    // Realizar la solicitud AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // La respuesta del servidor ha sido recibida correctamente
        const response = JSON.parse(this.responseText);
        const alertDiv = document.getElementById('alertMessage');
        if (response.success) {
          alertDiv.classList.add('alert-success')
          alertDiv.textContent = response.message;
          successDiv.classList.remove('d-none');
          successDiv.textContent = response.message;
          console.log(response.message);

          setTimeout(function() {
            location.reload();
          }, 3000); // 3000 milisegundos = 3 segundos

        } else {
          alertDiv.classList.add('alert-danger');
            alertDiv.textContent = response.message;
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
    xhttp.send(formCambiarPass);
  }

  // Agregar un evento al formulario para llamar a la función cambiarContraseña al enviarlo
  document.getElementById('formCambiarContrasena').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío normal del formulario
    cambiarContraseña();
  });

  function habilitarEdicion() {
    const inputs = document.querySelectorAll('.personal-info input[disabled]');
    inputs.forEach(input => input.removeAttribute('disabled'));
    
    const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnEditarDatosPersonales.classList.add('d-none');
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
          $("#mensajeModificar").text("Cambios guardados correctamente");
          $("#mensajeModificar").show();
          setTimeout(function () {
            $("#mensajeModificar").hide();
          }, 3000);
          console.log(response.message);
        } else {
          $("#mensajeModificar").text("Error al intentar hacer los cambios");
          $("#mensajeModificar").show();
          setTimeout(function () {
            $("#mensajeModificar").hide();
          }, 3000);
          console.log(response.message);
        }
        const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
        const btnGuardarCambios = document.getElementById('btnGuardarCambios');
        const btnCancelarCambios = document.getElementById('btnCancelarCambios');

        btnEditarDatosPersonales.classList.remove('d-none');
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

    const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnEditarDatosPersonales.classList.remove('d-none');
    btnGuardarCambios.classList.add('d-none');
    btnCancelarCambios.classList.add('d-none');
  }
  
  function nuevoAdmin() {
    const nombre = $('input[name="nombreNEW"]').val();
    const ap_paterno = $('input[name="ap_paternoNEW"]').val();
    const ap_materno = $('input[name="ap_maternoNEW"]').val();
    const telefono = $('input[name="telefonoNEW"]').val();
    const correo = $('input[name="correoNEW"]').val();
    const rfc = $('input[name="rfcNEW"]').val();
    if (!nombre || !ap_paterno || !ap_materno || !telefono || !correo || !rfc) {
      alert("Por favor, complete todos los campos requeridos");
      return; // Detener la ejecución de la función si hay campos vacíos
    }
    const mensajeConfirmacion = `¿Seguro que desea registrar un administrador con los siguientes datos?\n\nNombre: ${nombre}\nApellido Paterno: ${ap_paterno}\nApellido Materno: ${ap_materno}\nTeléfono: ${telefono}\nCorreo: ${correo}\nRFC: ${rfc}`;
    if (window.confirm(mensajeConfirmacion)) {
      // Si el usuario acepta, enviar los datos a registrarAdmin.php mediante una solicitud AJAX
      $.ajax({
        type: "POST", // O el método que utilices para enviar los datos
        url: "../viewsPerfil/registrarAdmin.php", // Archivo PHP que procesará los datos y los agregará a la base de datos
        data: {
          nombre,
          ap_paterno,
          ap_materno,
          telefono,
          correo,
          rfc
        },
        success: function () {
          $("#mensaje").text("Administrador registrado correctamente");
          $("#mensaje").show();
          console.log("Se registró exitosamente");
          setTimeout(function () {
            $('input[name="nombreNEW"]').val('');
            $('input[name="ap_paternoNEW"]').val('');
            $('input[name="ap_maternoNEW"]').val('');
            $('input[name="telefonoNEW"]').val('');
            $('input[name="correoNEW"]').val('');
            $('input[name="rfcNEW"]').val('');
            $("#mensaje").hide();
          }, 3000);
        },
        error: function (error) {
          $("#mensaje").text("Error al registrar nuevo usuario");
          $("#mensaje").show();
          setTimeout(function () {
            $("#mensaje").hide();
          }, 3000);
          console.error("Error al enviar los datos:", error);
        }
      });
    }
  }
  // Manejo del clic en el botón "Registrar administrador"
  $(document).ready(function () {
    $('#registrarAdmin').click(nuevoAdmin);
  });
