<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Configuración de Eventos</title>
    <!-- Agrega la siguiente línea para cargar el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agrega la siguiente línea para cargar el CSS del complemento datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="pruebaEventos.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Configuración de Eventos</h1>
        <form id="evento-form">
            <div class="form-group">
                <label for="nombre_evento">Nombre del evento:</label>
                <input type="text" class="form-control" id="nombre_evento" required>
            </div>
            <div class="form-group">
                <label for="salon">Salón:</label>
                <select class="form-control" id="salon" required>
                    <option value="">Seleccione un salón</option>
                    <option value="Cuatrociénegas">Cuatrociénegas</option>
                    <option value="Torreón">Torreón</option>
                    <option value="Saltillo">Saltillo</option>
                    <option value="Coahuila">Coahuila</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comida">Menú del evento</label>
                <select name="form-control" id="comida" required>
                    <option value=1>Americano</option>
                    <option value=2>Continental</option>
                    <option value=3>Original</option>
                    <option value=4>Saludable</option>
                    <option value=5>El Santuario</option>
                    <option value=6>Mexicano</option>
                    <option value=7>Montaña</option>
                    <option value=8>Sabor de Valle</option>
                    <option value=9>Mediterráneo</option>
                    <option value=10>Sabor y Energía</option>
                    <option value=11>Mar y Tierra</option>
                    <option value=12>Celebración 1</option>
                    <option value=13>Celebración 2</option>
                    <option value=14>Celebración 3</option>
                    <option value=15>Celebración 4</option>
                    <option value=16>Celebración 5</option>
                    <option value=17>Esencial</option>
                    <option value=18>Saludable</option>
                    <option value=19>Dulce mañana</option>
                    <option value=20>Mexicano</option>
                    <option value=21>Natural</option>
                    <option value=22>Energético</option>
                    <option value=23>Barra</option>
                    <option value=24>Nacional</option>
                    <option value=25>Premium</option>
                    <option value=26>Celebración</option>
                    <option value=27>Hamburguesas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="invitados">Cantidad de invitados:</label>
                <input type="number" class="form-control" id="invitados" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha y hora del evento:</label>
                <input type="text" class="form-control" id="fechaEvento" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Evento</button>
        </form>

        <div id="eventos-list">
            <!-- Aquí se mostrarán los eventos agregados -->
        </div>
    </div>

    <!-- Agrega las siguientes líneas para cargar jQuery, el complemento datetimepicker y tu propio script.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Agrega la siguiente línea para cargar el complemento datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="pruebaJSEventos.js"></script>
</body>
</html>
