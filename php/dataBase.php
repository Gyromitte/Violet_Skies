<?php
    class Database
    {
        private $PDO_local;
        private $user = "doadmin";
        private $password = "AVNS_zPsBun59otEyJNJBtBv";
        private $server = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com";
        private $port=25060;
        private $database = "VIOLET";
        private $sslmode = "REQUIRED";

        function conectarBD()
        {
            try
            {
                $dsn = "mysql:host={$this->server};port={$this->port};dbname={$this->database};sslmode={$this->sslmode}";
                 $this->PDO_local = new PDO($dsn, $this->user, $this->password);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage(); 
            }
        }

        function desconectarBD()
        {
            try
            {
                $this->PDO_local = null;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage(); 
            }
        }

        function seleccionar($consulta)
        {
            try
            {
                $resultado = $this->PDO_local->query($consulta);
                $fila = $resultado->fetchAll(PDO:: FETCH_OBJ);
                return $fila;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        function ejecutarSQL($consulta)
        {
            try
            {
                return $this->PDO_local->query($consulta);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        
        function Login($usu,$pass){
            try{
                $ver = false;
                $query="SELECT * FROM CUENTAS WHERE CORREO='$usu'";
                $consulta = $this->PDO_local->query($query);

                while($renglon = $consulta->fetch(PDO::FETCH_ASSOC)){
                    if($pass=== $renglon['CONTRASEÑA']){
                        $ver = true;
                        $ID=$renglon['ID'];
                        $NOMBRE = $renglon['NOMBRE'];
                        $tipo = $renglon['TIPO_CUENTA'];
                        $ap_paterno=$renglon['AP_PATERNO'];
                        $ap_materno=$renglon['AP_MATERNO'];
                        $telefono=$renglon['TELEFONO'];
                        $correo=$renglon['CORREO'];
                    }
                }
                if($ver){
                    session_start();
                    $_SESSION["ID"] = $ID; 
                    $_SESSION["name"] = $NOMBRE;
                    $_SESSION["telefono"] = $telefono;
                    $_SESSION["ap_paterno"] = $ap_paterno;
                    $_SESSION["ap_materno"] = $ap_materno;
                    $_SESSION["correo"] = $correo;

                    if($tipo==='CLIENTE'){
                        $_SESSION["access"]=1;
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Bienvenido ".$_SESSION["cliente"]."</h1>";
                        echo "</div>";
                        header("refresh:4;/html/cliente/index.html");
                    }
                    else if($tipo==='ADMINISTRADOR'){
                        $_SESSION["access"]=3;
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                        echo "</div>";
                        header("refresh:4;../viewsEmpleados/panelAdmin.php");
                    }
                    else if ($tipo==='EMPLEADO'){
                        $query="SELECT * FROM EMPLEADOS JOIN CUENTAS ON CUENTAS.ID=EMPLEADOS.CUENTA
                        WHERE CUENTAS.ID='$id'";
                        $consulta=$this->PDO_local->query($query);
                        while($trabajo=$consulta->fetch(PDO::FETCH_ASSOC)){
                            $_SESSION["access"]=2;
                            if($trabajo['TIPO']=='MESERO'){
                                echo"<div class=' container'>";
                                echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                echo "</div>";
                                header("refresh:4;../viewsEmpleados/verMeseros.php");
                            }
                            else{
                                echo"<div class=' container'>";
                                echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                echo "</div>";
                                header("refresh:4;../viewsEmpleados/ver.php");
                            }
                        }
                    }
                }
                else{
                    echo"<div class='alert alert-warning'>";
                    echo"<h2 align='center'>Usuario o Password Incorrecto</h2>";
                    echo"</div>";
                    header("refresh:2;../views/Login.php");
                }
    
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        function cerrarSesion(){
            session_start();
            session_destroy();
            header("Location:/index.html");
        }
    }
?>