<?php
include_once '../dataBase.php';

if (isset($_GET['id'])) {
    $eventoId = $_GET['id'];
    
    $database = new Database();
    $database->conectarBD();
    $dispMeseros = 0;
    $dispCocina=0;
    $meserosNecesarios = $_GET['meserosNecesarios'];
    $cocinaNecesarios = $_GET['cocinaNecesarios'];
    $consulta = "UPDATE EVENTO E INNER JOIN DETALLE_EVENTO D ON E.ID=D.ID SET ";
    $parametros = array();

    if (isset($_GET['F_EVENTO'])) {
        $fechaEvento = $_GET['F_EVENTO'];
        $consulta .= "E.F_EVENTO = :fechaEvento, ";
        $parametros[':fechaEvento'] = $fechaEvento;
    }

    if (isset($_GET['INVITADOS'])) {
        $invitados = $_GET['INVITADOS'];
        $consulta .= "D.INVITADOS = :invitados, ";
        $parametros[':invitados'] = $invitados;
        if($invitados < 15){
            $meserosNecesarios=2;
            $cocinaNecesarios=5;
        } else {
            $meserosNecesarios = ceil($invitados / 15);
            $cocinaNecesarios = ceil((($invitados - 10) / 15) + 5);
        }
    }    

    $consultaEmpleados = "SELECT E.TIPO, COUNT(E.TIPO) AS CANT FROM EMPLEADOS E JOIN CUENTAS C ON E.CUENTA = C.ID WHERE C.ESTADO = 'ACTIVO'
        AND E.ID NOT IN 
        (
            SELECT E.ID FROM EMPLEADOS E JOIN EVENTO_EMPLEADOS EE ON E.ID = EE.EMPLEADOS JOIN EVENTO EV ON EV.ID = EE.EVENTO
            JOIN CUENTAS C ON C.ID = E.CUENTA 
            WHERE EV.F_EVENTO = :fechaEvento
        ) GROUP BY E.TIPO";
    $dispEmpleados = $database->seleccionarPreparado($consultaEmpleados, array(':fechaEvento' => $fechaEvento));

    foreach ($dispEmpleados as $fila) {
        $tipo = $fila->TIPO;
        $cantidad = $fila->CANT;
    
        if ($tipo === 'MESERO') {
            $dispMeseros = $cantidad;
        } elseif ($tipo === 'COCINA') {
            $dispCocina = $cantidad;
        }
    }

    if (isset($_GET['MESEROS']) && $_GET['MESEROS'] !== "") {
        if (intval($_GET['MESEROS']) > $meserosNecesarios)
        {
            $response = array('success' => false, 'message' => 'El número máximo de meseros para ' . $invitados . ' invitados son ' . $meserosNecesarios);
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
            exit;
        } else {
            if (isset($_GET['MESEROS']) && intval($_GET['MESEROS']) > $dispMeseros)
            {
                $response = array('success' => false, 'message' => 'No hay suficientes meseros disponibles');
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode($response);
                exit;
            } else {
                $meseros = $_GET['MESEROS'];
                $consulta .= "D.MESEROS = :meseros, ";
                $parametros[':meseros'] = $meseros;
            }
        }
    }
    else {
        $meseros = 0;
        $consulta .= "D.MESEROS = :meseros, ";
        $parametros[':meseros'] = $meseros;
    }

    if (isset($_GET['COCINEROS']) && $_GET['COCINEROS'] !== "" && $_GET['COCINEROS'] !== "0") {
        if (intval($_GET['COCINEROS']) > $cocinaNecesarios || intval($_GET['COCINEROS']) < $cocinaNecesarios) {
            $response = array('success' => false, 'message' => 'El número necesarios de cocineros para ' . $invitados . ' invitados son ' . $cocinaNecesarios);
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
            exit;
        } else {
            if (isset($_GET['COCINEROS']) && intval($_GET['COCINEROS']) > $dispCocina)
            {
                $response = array('success' => false, 'message' => 'No hay suficientes cocineros disponibles');
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode($response);
                exit;
            } else {
                $cocineros = $_GET['COCINEROS'];
                $consulta .= "D.COCINEROS = :cocineros, ";
                $parametros[':cocineros'] = $cocineros;
            }
        }
        
    }
    else {
        $cocineros = 0;
        $consulta .= "D.COCINEROS = :cocineros, ";
        $parametros[':cocineros'] = $cocineros;
    }

    if (isset($_GET['SALON'])) {
        $salon = $_GET['SALON'];
        $consulta .= "D.SALON = :salon, ";
        $parametros[':salon'] = $salon;
    }

    if (isset($_GET['COMIDA'])) {
        $comida = $_GET['COMIDA'];
        $consulta .= "D.COMIDA = :comida, ";
        $parametros[':comida'] = $comida;
    }

    $consulta = rtrim($consulta, ", ");

    $consulta .= " WHERE E.ID = :eventoId";
    $parametros[':eventoId'] = $eventoId;

    if (!empty($parametros)) {
        $database->ejecutarPreparado($consulta, $parametros);
    }

    $database->desconectarBD();

    $response = array('success' => true, 'message' => 'Detalles del evento actualizados correctamente');
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Error: Falta el parámetro del ID del evento');
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode($response);
}
?>


