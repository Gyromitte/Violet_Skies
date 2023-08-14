var modal = document.getElementById("Main");
var modalForm = document.getElementById("modal-form");

modal.addEventListener("show.bs.modal", function (event) {
    // Botón que activó el modal
    var button = event.relatedTarget;
  
    // Obtener el tipo de formulario correspondiente al botón
    var formType = button.getAttribute("data-bs-whatever");
    // Actualizar el contenido del formulario
    updateModalContent(formType);
});

function updateModalContent(formType) {
    var formContent = "";
    var modalTitle = document.querySelector('#Main .modal-title');
    var form;
    //Conseguir el modal header para cambiarle el color
    var modalHeader = document.querySelector('.modal-header');
  
    switch (formType) {
        case "@emp":
            modalTitle.textContent = "Solicitar Contratacion";
            modalHeader.classList.remove('modal-header-warning');
            formContent = `
            <form id="EmpReg">
                <div class="mb-3">
                    <label class="control-label">Nombre(s): </label> 
                    <input class="form-control" type="text" name="nom" maxlength="30" placeholder="Nombre" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Apellido Paterno: </label> 
                    <input class="form-control" type="text" name="ap" maxlength="40" placeholder="Apellido Paterno" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Apellido Materno: </label> 
                    <input class="form-control" type="text" name="am" maxlength="40" placeholder="Apellido Materno" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Correo: </label> 
                    <input class="form-control" type="email" name="usu" placeholder="Correo" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Numero de Celular: </label> 
                    <input class="form-control" type="text" name="cel" placeholder="Telefono" maxlength="10" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Contraseña: </label>
                    <input class="form-control" type="password" name="pass" 
                    placeholder="Contraseña" required><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Comprobar Contraseña: </label>
                    <input class="form-control" type="password" name="ckpass"
                    placeholder="Comprobar Contraseña" required><br>
                </div>
                <div id="mensajeDiv" method="POST"></div>
                <div class="d-flex justify-content-center">
                    <button class="loginButton" type="submit">Registrarse</button>
                </div>
            </form>
            `;
            modalForm.innerHTML = formContent;

            //Obtener el formulario después de haberlo asignado al DOM
            form = document.querySelector('#EmpReg');
      
            //Agregar evento de envio al formulario
            form.addEventListener('submit', function (event) {
              event.preventDefault(); //Para que la pagina no de refresh al dar submit
      
              //Solicitud AJAX
              var xhr = new XMLHttpRequest();
              //Configurar la solicitud
              xhr.open("POST", "../scripts/registro_emp.php", true);
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              //Obtener los datos del formulario
              var nombre = form.elements['nom'].value;
              var ap = form.elements['ap'].value;
              var am = form.elements['am'].value;
              var usu = form.elements['usu'].value;
              var cel = form.elements['cel'].value;
              var pass = form.elements['pass'].value;
              var ckpass = form.elements['ckpass'].value;
              //Como se va enviar la solicitud: un string
              var formData = 'nom=' + encodeURIComponent(nombre) + '&ap=' + (ap) + 
              '&am=' + encodeURIComponent(am) + 
              '&usu=' + encodeURIComponent(usu) + 
              '&cel=' + encodeURIComponent(cel) + 
              '&pass=' + encodeURIComponent(pass) + 
              '&ckpass=' + encodeURIComponent(ckpass);
              xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                  //Manejo de la respuesta:
                  var respuesta = xhr.responseText;
                  document.getElementById('mensajeDiv').innerHTML = respuesta;
                  if(respuesta==="<div class='alert alert-success'>Te has registrado exitosamente!</div>"){
                    setTimeout(function () {
                        window.location.href = "../views/login.php";
                      }, 2000);
                }
                }
              };
              //Enviar el formulario
              xhr.send(formData);
              //Ver cual es la tabla activa para refrescar cualquier cambio
              console.log(currentTable);
              setTimeout(function() {
                checkCurrentTable(currentTable);
              }, 500); 
            });
            break;
        case "@cliente":
            modalTitle.textContent = "Registrar como Cliente";
            modalHeader.classList.remove('modal-header-warning');
            formContent = `
            <form id="CliReg">
                <div class="mb-3">
                    <label class="control-label">Nombre(s): </label> 
                    <input class="form-control" type="text" name="nom" maxlength="30" placeholder="Nombre" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Apellido Paterno: </label> 
                    <input class="form-control" type="text" name="ap" maxlength="40" placeholder="Apellido Paterno" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Apellido Materno: </label> 
                    <input class="form-control" type="text" name="am" maxlength="40" placeholder="Apellido Materno" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Correo: </label> 
                    <input class="form-control" type="email" name="usu" placeholder="Correo" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Numero de Celular: </label> 
                    <input class="form-control" type="text" name="cel" maxlength="15" placeholder="Telefono" requiered><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Contraseña: </label>
                    <input class="form-control" type="password" name="pass" 
                    placeholder="Contraseña" required><br>
                </div>
                <div class="mb-3">
                    <label class="control-label">Comprobar Contraseña: </label>
                    <input class="form-control" type="password" name="ckpass"
                    placeholder="Comprobar Contraseña" required><br>
                </div>
                <div id="mensajeDiv" method="POST"></div>
                <div class="d-flex justify-content-center">
                    <button class="loginButton" type="submit">Registrarse</button>
                </div>
            </form>
            
            `;
            modalForm.innerHTML = formContent;
    
            //Obtener el formulario después de haberlo asignado al DOM
            form = document.querySelector('#CliReg');
          
            //Agregar evento de envio al formulario
            form.addEventListener('submit', function (event) {
                event.preventDefault(); //Para que la pagina no de refresh al dar submit
          
                //Solicitud AJAX
                var xhr = new XMLHttpRequest();
                //Configurar la solicitud
                xhr.open("POST", "../scripts/registrocliente.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                //Obtener los datos del formulario
                var nombre = form.elements['nom'].value;
                var ap = form.elements['ap'].value;
                var am = form.elements['am'].value;
                var usu = form.elements['usu'].value;
                var cel = form.elements['cel'].value;
                var pass = form.elements['pass'].value;
                var ckpass = form.elements['ckpass'].value;
                //Como se va enviar la solicitud: un string
                var formData = 'nom=' + encodeURIComponent(nombre) + '&ap=' + (ap) + 
                '&am=' + encodeURIComponent(am) + 
                '&usu=' + encodeURIComponent(usu) + 
                '&cel=' + encodeURIComponent(cel) + 
                '&pass=' + encodeURIComponent(pass) + 
                '&ckpass=' + encodeURIComponent(ckpass);
                xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var respuesta = xhr.responseText;
                    document.getElementById('mensajeDiv').innerHTML = respuesta;
                    if(respuesta==="<div class='alert alert-success'>Te has registrado exitosamente!</div>"){
                        setTimeout(function () {
                            window.location.href = "../views/login.php";
                          }, 2000);
                    }
                }
            };
            
            xhr.send(formData);
           
            console.log(currentTable);
            setTimeout(function() {
                checkCurrentTable(currentTable);
            }, 500); 
        });
        break;
    }
}