const btnEditarDatosPersonales = document.getElementById('btnEditarDatosPersonales');
const btnGuardarCambios = document.getElementById('btnGuardarCambios');
const btnCancelarCambios = document.getElementById('btnCancelarCambios');
const successDiv = document.getElementById('mensajeModificar');
  
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
    const telefonoError = document.getElementById('telefonoError'); 

    inputs.forEach(input => {
        if (input.name === 'telefono') { 
            input.removeAttribute('disabled');
            telefonoError.textContent = ''; // Clear the error message
        }
    });

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
      const telefonoError = document.getElementById('telefonoError');
      telefonoError.textContent = "Ingresa un número de teléfono válido (10 dígitos numéricos)";

      setTimeout(function () {
          telefonoError.textContent = '';
      }, 4000);

      return false;
  }

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
          const response = JSON.parse(this.responseText);
          if (response.success) {
              const telefonoSuccess = document.getElementById('telefonoSuccess');
              telefonoSuccess.style.display = "block";
              telefonoSuccess.innerHTML = "Teléfono guardado correctamente.";
              setTimeout(function() {
                  telefonoSuccess.style.display = "none";
              }, 2500);
              
              // Reload the page 
              setTimeout(function() {
                  location.reload();
              }, 2020); // Adjust the delay (in milliseconds)

              inputs.forEach(input => {
                  input.setAttribute('disabled', 'true');
              });
          } else {
                successDiv.textContent = "Error al intentar hacer los cambios";
                successDiv.classList.remove('d-none');
                setTimeout(function () {
                    successDiv.classList.add('d-none');
                }, 3000);
            }

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

    btnEditarDatosPersonales.classList.remove('d-none');
    btnGuardarCambios.classList.add('d-none');
    btnCancelarCambios.classList.add('d-none');
}
