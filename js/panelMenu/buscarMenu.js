function searchMenu() {
    var searchInput = document.getElementById('busquedaMenu').value;
    var contTable = document.getElementById('cont-table-menus');
    var tableInfo = document.getElementById('table-info-menus');

        // Limpia la tabla y la información de búsqueda cuando la entrada está vacía
        if (searchInput === '') {
            contTable.innerHTML = "";
            tableInfo.innerHTML = 'Resultados de búsqueda: <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>';
            return; // Sale de la función para evitar realizar la petición AJAX vacía
        }
    if (searchInput.length >= 1) { // Realiza la búsqueda después de escribir al menos 3 caracteres
        $.ajax({
            type: "GET",
            url: "/php/viewsMenus/buscarMenu.php",
            data: { busqueda: searchInput },
            success: function(response) {
                tableInfo.innerHTML = 'Resultados de búsqueda: <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>';
                contTable.innerHTML = response;
            }
        });
    }
     else {
        contTable.innerHTML = "";
    }
}