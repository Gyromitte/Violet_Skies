var cantidadInvitadosInput = document.querySelector("#invitados");
var salonSelect = document.querySelector("#salon");

//Array global que tiene los eventos: eventosObtenidos
//Variable global para saber que fecha escogio el usuario: fechaSeleccionadaObj

cantidadInvitadosInput.addEventListener("blur", function () {
    var cantidadInvitados = parseInt(cantidadInvitadosInput.value);
    console.log(cantidadInvitados);

    if (isNaN(cantidadInvitados)) {
        cantidadInvitados = 10; // Establecer 10 como valor predeterminado
    } else {
        cantidadInvitados = Math.min(Math.max(cantidadInvitados, 10), 120);
    }
    cantidadInvitadosInput.value = cantidadInvitados;
    var torreon = `
                                            <option value ='1'> Torreón 1 Cupo: 50 </option>
                                            <option value ='2'> Torreón 2 Cupo: 50 </option>`;
    var coahuila = `
                                            <option value ='3'> Coahuila 1 Cupo: 120 </option>
                                            <option value ='4'> Coahuila 2 Cupo: 120 </option>
                                            <option value ='5'> Coahuila 3 Cupo: 120 </option>`;
    var cuatrocienegeas = `
                                            <option value ='6'> Cuatrociénegas 1 Cupo: 20 </option>
                                            <option value ='7'> Cuatrociénegas 2 Cupo: 20 </option>
                                            <option value ='8'> Cuatrociénegas 3 Cupo: 20 </option>
                                            <option value ='9'> Cuatrociénegas 4 Cupo: 20 </option>`;
    var saltillo = `
                                            <option value ='10'> Saltillo 1 Cupo: 80 </option>
                                            <option value ='11'> Saltillo 2 Cupo: 80 </option>`;

    if (cantidadInvitados >= 10 && cantidadInvitados <= 20) {
        salonSelect.innerHTML = `
                                            <option value="">Seleccione un salón</option>
                                            ` + cuatrocienegeas;
    }
    if (cantidadInvitados > 20 && cantidadInvitados <= 50) {
        salonSelect.innerHTML = `
                                            <option value="">Seleccione un salón</option>
                                            `+ torreon;
    }
    if (cantidadInvitados > 50 && cantidadInvitados <= 80) {
        salonSelect.innerHTML = `
                                            <option value="">Seleccione un salón</option>
                                            `+ saltillo;
    }
    if (cantidadInvitados > 80 && cantidadInvitados <= 120) {
        salonSelect.innerHTML = `
                                            <option value="">Seleccione un salón</option>
                                            `+ coahuila;
    }



    desactivateSalones();

});

    //Desactivar opciones del salon
    function desactivateSalones(){
        var fechaSeleccionada = fechaSeleccionadaObj.toISOString().split('T')[0]; // Obtener la fecha en formato 'YYYY-MM-DD'
    
        console.log(fechaSeleccionada);
        eventosObtenidos.forEach(function (evento) {
         var eventoFecha = new Date(evento.fecha);
         var eventoFormatted = eventoFecha.toISOString().split('T')[0];
    
         if (eventoFormatted === fechaSeleccionada) {
             var salonOption = document.querySelector(`[value='${evento.salon}']`);
             if (salonOption) {
                 salonOption.disabled = true;
             }
         }
        });
        }