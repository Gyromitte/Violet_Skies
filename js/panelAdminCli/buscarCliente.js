function searchCliente() {
    var searchInput = document.getElementById('busquedaCliente').value;
    var contTable = document.querySelector('.cont-table');
    var tableInfo = document.getElementById('table-info');

        // Limpia la tabla y la información de búsqueda cuando la entrada está vacía
        if (searchInput === '') {
            contTable.innerHTML = "";
            tableInfo.innerHTML = 'Resultados de búsqueda: <i class="fa-solid fa-magnifying-glass" style="color: #343434;"></i>';
            return; // Sale de la función para evitar realizar la petición AJAX vacía
        }
    if (searchInput.length >= 1) { // Realiza la búsqueda después de escribir al menos 3 caracteres
        $.ajax({
            type: "GET",
            url: "/php/viewsAdminCli/buscarCliente.php",
            data: { busqueda: searchInput },
            success: function(response) {
                tableInfo.innerHTML = 'Resultados de búsqueda: <i class="fa-solid fa-magnifying-glass" style="color: #343434;"></i>';
                contTable.innerHTML = response;
            }
        });
    }
     else {
        contTable.innerHTML = "";
    }
}