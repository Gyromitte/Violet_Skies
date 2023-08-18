var cantidadInvitadosInput = document.querySelector("#invitados");
var salonSelect = document.querySelector("#salon");

//Variable para saber que fecha escogio el usuario
var fecha = document.querySelector("#selected-date");

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

    mostrarSalonesSegunCantidadInvitados(cantidadInvitados);
});
    function mostrarSalonesSegunCantidadInvitados(cantidad) {
        var fechaSeleccionada = new Date(fecha.value); // Obtener la fecha seleccionada por el usuario
    
            // Iterar a través de las fechas ocupadas pasadas desde PHP
        for (var i = 0; i < eventos.length; i++) {
        var fechaOcupada = new Date(eventos[i].start);
            var fechaOcupada = new Date(fechasOcupadas[i].start);
    
            // Comparar las fechas y deshabilitar opciones si coinciden
            if (fechaSeleccionada.getTime() === fechaOcupada.getTime()) {
                var salonOptions = salonSelect.options;
                for (var j = 0; j < salonOptions.length; j++) {
                    salonOptions[j].disabled = true; // Deshabilitar todas las opciones
    
                    // Habilitar opciones según la cantidad de invitados
                    if (cantidad >= 10 && cantidad <= 20 && (salonOptions[j].value >= 6 && salonOptions[j].value <= 9)) {
                        salonOptions[j].disabled = false;
                    }
                    if (cantidad > 20 && cantidad <= 50 && (salonOptions[j].value == 1 || salonOptions[j].value == 2)) {
                        salonOptions[j].disabled = false;
                    }
                    if (cantidad > 50 && cantidad <= 80 && (salonOptions[j].value == 10 || salonOptions[j].value == 11)) {
                        salonOptions[j].disabled = false;
                    }
                    if (cantidad > 80 && cantidad <= 120 && (salonOptions[j].value >= 3 && salonOptions[j].value <= 5)) {
                        salonOptions[j].disabled = false;
                    }
                }
                break; // Salir del bucle una vez que se encuentra una fecha coincidente
            }
        }
}