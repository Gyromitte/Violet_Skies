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
