<?php
include_once "../dataBase.php";
$db = new Database();
$db->conectarBD();

// Obtener el correo del formulario
$correo = $_POST['correo'];

// Verificar si la cuenta es de tipo empleado o cliente
$consultaTipoCuenta = "SELECT TIPO_CUENTA FROM CUENTAS WHERE CORREO = :correo";
$parametrosTipoCuenta = array(':correo' => $correo);
$resultadoTipoCuenta = $db->seleccionarPreparado($consultaTipoCuenta, $parametrosTipoCuenta);

if (!$resultadoTipoCuenta) {
    echo "<div class='alert alert-danger'>No se encontró ninguna cuenta asociada a ese correo</div>";
} else {
    $tipoCuenta = $resultadoTipoCuenta[0]->TIPO_CUENTA;

    if ($tipoCuenta == 'CLIENTE') {
        // Lógica para cuentas de tipo CLIENTE
        $consultaCliente = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'CLIENTE' AND CUENTAS.ESTADO = 'INACTIVO'";
        $parametrosCliente = array(':correo' => $correo);
        $resultadoCliente = $db->seleccionarPreparado($consultaCliente, $parametrosCliente);
        
                if (!$resultadoCliente) {
                    echo "<div class='alert alert-danger'>El cliente ya ha sido dado de alta <br>";
                    echo  "</div>";
                } else {
                    // Obtener el ID de la cuenta asociada al correo con estado INACTIVO
                    $consultaCuenta = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'CLIENTE' AND ESTADO = 'INACTIVO'";
                    $parametrosCuenta = array(':correo' => $correo);
                    $resultadoCuenta = $db->seleccionarPreparado($consultaCuenta, $parametrosCuenta);
        
                    if ($resultadoCuenta) {
                        $idCuenta = $resultadoCuenta[0]->ID;
        
                        // Cambiar el ESTADO a ACTIVO en la tabla CUENTAS
                        $cadena = "UPDATE CUENTAS SET ESTADO = 'ACTIVO' WHERE ID = :idCuenta";
                        $parametrosInsercion = array(':idCuenta' => $idCuenta);
                        $db->ejecutarPreparado($cadena, $parametrosInsercion);
        
                        echo "<div class='alert alert-success'>Cliente Re-incorporado al sistema</div>";
                    } else {
                        echo "<div class='alert alert-danger'>No se encontró una cuenta inactiva para dicho cliente</div>";
                    }
                }
        //echo "<div class='alert alert-info'>La cuenta es de tipo CLIENTE</div>";
    } else {
        // Lógica para cuentas de tipo EMPLEADO
        $consultaEmpleado = "SELECT * FROM EMPLEADOS WHERE CUENTA IN 
        (SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO' AND CUENTAS.ESTADO = 'INACTIVO')";
        $parametrosEmpleado = array(':correo' => $correo);
        $resultadoEmpleado = $db->seleccionarPreparado($consultaEmpleado, $parametrosEmpleado);

        if (!$resultadoEmpleado) {
            echo "<div class='alert alert-danger'>El empleado ya ha sido dado de alta <br>";
            echo "o dicho correo no perteneció a ningún empleado.";
            echo  "</div>";
        } else {
            // Obtener el ID de la cuenta asociada al correo con estado INACTIVO
            $consultaCuenta = "SELECT ID FROM CUENTAS WHERE CORREO = :correo AND TIPO_CUENTA = 'EMPLEADO' AND ESTADO = 'INACTIVO'";
            $parametrosCuenta = array(':correo' => $correo);
            $resultadoCuenta = $db->seleccionarPreparado($consultaCuenta, $parametrosCuenta);

            if ($resultadoCuenta) {
                $idCuenta = $resultadoCuenta[0]->ID;

                // Cambiar el ESTADO a ACTIVO en la tabla CUENTAS
                $cadena = "UPDATE CUENTAS SET ESTADO = 'ACTIVO' WHERE ID = :idCuenta";
                $parametrosInsercion = array(':idCuenta' => $idCuenta);
                $db->ejecutarPreparado($cadena, $parametrosInsercion);

                echo "<div class='alert alert-success'>Empleado Re-incorporado al sistema</div>";
            } else {
                echo "<div class='alert alert-danger'>No se encontró una cuenta inactiva para dicho empleado</div>";
            }
        }
    }
}

$db->desconectarBD();

?>

