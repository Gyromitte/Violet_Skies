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
                echo "<br><table class='table table-hover table-sm' id='t'>
                <thead class='thead-purple'>
                    <tr>
                    <th></th><th>NOMBRE</th><th>TELÉFONO</th>
                    </tr>
                </thead>
                <tbody>";

                foreach ($tabla as $registro) {
                    echo "<tr>";
                    echo "<td class='text-center'>";
                    echo "<button class='btn btn-danger sacarEmpleado' type='button' data-empleado-id='$registro->ID' data-evento-id='$evento'>-</button>";
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

                } else if ($tipo === 'COCINA'){
                    echo "<br><p>No hay cocineros por mostrar</p>";
                } else {
                    echo "<br><p>No hay empleados por mostrar</p>";
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
var sacarEmpleado = document.querySelectorAll('.sacarEmpleado');

sacarEmpleado.forEach(function(button) {
    button.addEventListener('click', function() {
        var idEmpleado = this.getAttribute('data-empleado-id');
        var idEvento = this.getAttribute('data-evento-id');
    // Mostrar el modal de confirmación
    var confirmarCancelacion = window.confirm("¿Estás seguro que deseas sacar este empleado?");
    
    if (confirmarCancelacion) {
        var xhrsacarEmpleado = new XMLHttpRequest();
        xhrsacarEmpleado.onreadystatechange = function() {
            if (xhrsacarEmpleado.readyState === XMLHttpRequest.DONE) {
                if (xhrsacarEmpleado.status === 200) {
                    formContent += `<br><div id="successMessage" class="alert alert-success" role="alert" align='center'>
                    Se ha eliminado con éxito</div>`;
                    setTimeout(() => {
                        updateModalContent(idEmpleado, idEvento);
                    }, 2000);
                    peticionesFuncion();
                    
                } else {
                    console.error("Error AJAX para aja el empleado");
                }
            }
        };
        xhrsacarEmpleado.open("GET", "../viewsEventos/sacarEmpleado.php?id=" + idEmpleado + "&eventoId=" + idEvento, true);
        xhrsacarEmpleado.send();
    } else {
        console.log("Retiro del empleado cancelada por el usuario");
    }
});
});

</script>