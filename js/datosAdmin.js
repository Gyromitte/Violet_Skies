  const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
  const btnGuardarCambios = document.getElementById('btnGuardarCambios');
  const btnCancelarCambios = document.getElementById('btnCancelarCambios');
  const successDiv = document.getElementById('alertMessage');

  function cambiarContraseña() {
    const formu = document.getElementById('formCambiarContrasena');
      const formCambiarPass = new FormData(formu);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
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
          }, 3000);

        } else {
          alertDiv.classList.add('alert-danger');
            alertDiv.textContent = response.message;
            successDiv.classList.remove('d-none');
            successDiv.textContent = response.message;
            console.log(response.message);

            setTimeout(function() {
              alertDiv.classList.add('d-none');
            }, 3000); 
        }
      }
    };
    xhttp.open("POST", "../viewsPerfil/cambContraseña.php", true);
    xhttp.send(formCambiarPass);
  }

  document.getElementById('formCambiarContrasena').addEventListener('submit', function(event) {
    event.preventDefault();
    cambiarContraseña();
  });

  function habilitarEdicion() {
    const inputs = document.querySelectorAll('.personal-info input[disabled]');
    inputs.forEach(input => {
        if (input.name !== 'correo') {
            input.removeAttribute('disabled');
        }
    });
    
    const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
    const btnGuardarCambios = document.getElementById('btnGuardarCambios');
    const btnCancelarCambios = document.getElementById('btnCancelarCambios');

    btnEditarDatosPersonales.classList.add('d-none');
    btnGuardarCambios.classList.remove('d-none');
    btnCancelarCambios.classList.remove('d-none');
  }

  function guardarCambios() {
    const inputs = document.querySelectorAll('.personal-info input:not([disabled])');
    const newData = {};

    inputs.forEach(input => {
      newData[input.name] = input.value;
    });
    const telefonoValue = newData['telefono'];
    const telefonoPattern = /^[0-9]{10}$/;
    if (!telefonoPattern.test(telefonoValue)) {
      alert("Ingresa un número de teléfono válido");
      return false;
    }
    
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {

        const response = JSON.parse(this.responseText);
        if (response.success) {
          $("#mensajeModificar").text("Cambios guardados correctamente");
          $("#mensajeModificar").show();
          setTimeout(function () {
            $("#mensajeModificar").hide();
          }, 3000);
          console.log(response.message);
          inputs.forEach(input => {
            input.setAttribute('disabled', 'true');
          });
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
    if (!nombre || !ap_paterno || !ap_materno || !telefono || !correo) {
      alert("Por favor, complete todos los campos requeridos");
      return;
    }
    if (!/^[0-9]{10}$/.test(telefono)) {
      alert("Ingresa un número de teléfono válido");
      return false;
    }
    if (!/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/.test(correo)) {
      alert("Ingresa una dirección de correo electrónico válida");
      return;
    }
    const mensajeConfirmacion = `¿Seguro que desea registrar un administrador con los siguientes datos?\n\nNombre: ${nombre}\nApellido Paterno: ${ap_paterno}\nApellido Materno: ${ap_materno}\nTeléfono: ${telefono}\nCorreo: ${correo}`;
    if (window.confirm(mensajeConfirmacion)) {
      $.ajax({
        type: "POST",
        url: "../viewsPerfil/registrarAdmin.php",
        data: {
          nombre,
          ap_paterno,
          ap_materno,
          telefono,
          correo,
        },
        success: function (response) {
          const data = JSON.parse(response);
          if (data.mensaje) {
            const mensajeExito = `${data.mensaje}. Asegúrate de darle sus credenciales para ingresar a su cuenta<p>Correo: ${data.correo}<\p><strong>Contraseña: ${data.contraseña}<\stron>`;
          
            // Actualiza el contenido del modalAdminRegistrado
            $("#modalAdminRegistrado .modal-body").html(`<p>${mensajeExito}</p>`);
            
            // Muestra el modalAdminRegistrado
            $("#modalAdminRegistrado").modal("show");
  
            console.log("Se registró exitosamente");
            setTimeout(function () {
              $('input[name="nombreNEW"]').val("");
              $('input[name="ap_paternoNEW"]').val("");
              $('input[name="ap_maternoNEW"]').val("");
              $('input[name="telefonoNEW"]').val("");
              $('input[name="correoNEW"]').val("");
            }, 3000);
          } else {
            alert(data);
            console.error("Error al registrar nuevo administrador:", data);
          }
        },
        error: function (error) {
          $("#mensaje").text("Error al registrar nuevo usuario");
          $("#mensaje").show();
          setTimeout(function () {
            $("#mensaje").hide();
          }, 3000);
          console.error("Error al enviar los datos:", error);
        },
      });
    }
  }
  
  $(document).ready(function () {
    $("#registrarAdmin").click(nuevoAdmin);
  });