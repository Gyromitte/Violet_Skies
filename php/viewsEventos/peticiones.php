<!-- Tu código PHP -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once "../dataBase.php";
    $conexion = new Database();
    $conexion->conectarBD();

    $consulta = "SELECT VED.NOMBRE_EVENTO, VED.F_EVENTO, (DE.MESEROS-VED.NUMERO_MESEROS) AS FALTAN_MESEROS,
    (DE.COCINEROS-NUMERO_COCINEROS) AS FALTAN_COCINA, S.SOLICITUDES
    FROM Vista_Evento_Detalles VED JOIN DETALLE_EVENTO DE ON VED.EventoID=DE.ID JOIN 
    (
    SELECT E.ID, E.NOMBRE, COUNT(SE.ACEPTADO) AS SOLICITUDES
    FROM EVENTO E LEFT JOIN SOLICITUDES_EMPLEADO SE ON E.ID=SE.EVENTO
    WHERE E.ESTADO='EN PROCESO'
    GROUP BY E.ID, E.NOMBRE, E.F_EVENTO
    ) AS S ON VED.EventoID=S.ID
    WHERE (DE.MESEROS-VED.NUMERO_MESEROS) != 0 AND (DE.COCINEROS-NUMERO_COCINEROS) != 0";

    $tabla = $conexion->seleccionar($consulta);
    $conexion->desconectarBD();
    $tabla = json_decode(json_encode($tabla), true);
}
?>

<div class="card-grid">
    <?php foreach ($tabla as $fila) { ?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $fila['NOMBRE_EVENTO']; ?></h5>
                <p class="card-text"><?php echo $fila['F_EVENTO']; ?></p>
                <p class="card-text">Faltan meseros: <?php echo $fila['FALTAN_MESEROS']; ?></p>
                <p class="card-text">Faltan cocineros: <?php echo $fila['FALTAN_COCINA']; ?></p>
                <p class="card-text">Solicitudes: <?php echo $fila['SOLICITUDES']; ?></p>
                <a href="#" class="btn btn-primary">Ver solicitudes</a>
            </div>
        </div>
    <?php } ?>
</div>

<style>
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
        gap: 1rem;
    }
    .card {
        /* Cambia el color de fondo y el color del texto según tus preferencias */
        background-image: linear-gradient(135deg, white, #f58cd6);
        color: #333;
    }
</style>