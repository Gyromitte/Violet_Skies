

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        try {
            include_once "../dataBase.php";
            $conexion = new Database();
            $conexion->conectarBD();

            $evento = $_GET['id'];
            $tipo = $_GET['tipo'];

            $consulta = "SELECT E.ID, E.TIPO, CONCAT(C.NOMBRE, ' ', C.AP_PATERNO, ' ', C.AP_MATERNO) AS NOMBRE, C.TELEFONO
                FROM CUENTAS C JOIN EMPLEADOS E ON C.ID = E.CUENTA JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EMPLEADOS
                WHERE EE.EVENTO = $evento AND E.TIPO = '$tipo'
                ORDER BY E.TIPO, NOMBRE ASC";

            $tabla = $conexion->seleccionar($consulta);

            if (count($tabla) > 0) {
                echo "<br><table class='table table-hover'>
                <thead class='thead-purple'>
                    <tr>
                    <th></th><th>NOMBRE</th><th>TELÉFONO</th>
                    </tr>
                </thead>
                <tbody>";

                foreach ($tabla as $registro) {
                    echo "<tr>";
                    echo "<td class='text-center'>";
                    echo "<button class='btn btn-danger' type='button' id='sacarEmpleado' data-empleado-id='$registro->ID' data-evento-id='$evento'>-</button>";

                    echo "</td>";
                    echo "<td> $registro->NOMBRE </td>";
                    echo "<td> $registro->TELEFONO </td>";
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
            } else {
                if($tipo === 'MESERO')
                {
                    echo "<br><p>No hay meseros por mostrar</p>";

                } else{
                    echo "<br><p>No hay cocineros por mostrar</p>";
                }
            }
            $conexion->desconectarBD();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("error" => "El parámetro 'id' no fue proporcionado."));
    }
}
?>


<script>
var sacarEmpleado = document.getElementById('sacarEmpleado');

sacarEmpleado.addEventListener('click', function() {
    // Retrieve the employee ID from the data-empleado-id attribute
    var idEmpleado = this.getAttribute('data-empleado-id');
        var idEvento = this.getAttribute('data-evento-id');
        var formContent = '';
    // Mostrar el modal de confirmación
    var confirmarCancelacion = window.confirm("¿Estás seguro que deseas sacar este empleado?");
    if (confirmarCancelacion) {
        var xhrsacarEmpleado = new XMLHttpRequest();
        xhrsacarEmpleado.onreadystatechange = function() {
            if (xhrsacarEmpleado.readyState === XMLHttpRequest.DONE) {
                if (xhrsacarEmpleado.status === 200) {
                    formContent += `<br><div class="alert alert-success" role="alert" align='center'>
                        Se ha aja</div>`;
                    setTimeout(() => {
                        updateModalContent(formType, idEmpleado, idEvento);
                    }, 500); // Actualizar el modal después de 2000 milisegundos (2 segundos)  
                    peticionesFuncion();
                    modalForm.innerHTML = formContent;
                } else {
                    console.error("Error AJAX para aja el empleado");
                }
            }
        };
        // Hacer la solicitud al script PHP y pasar el ID del evento para cancelar
        xhrsacarEmpleado.open("GET", "../viewsEventos/sacarEmpleado.php?id=" + idEmpleado + "&eventoId=" + idEvento, true);
        xhrsacarEmpleado.send();
    } else {
        // Si el usuario hace clic en "Cancelar", no se realiza ninguna acción
        console.log("Retiro del empleado cancelada por el usuario");
    }
});

</script>


