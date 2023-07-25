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
                $this->PDO_local->query($consulta);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        function seleccionarPreparado($consulta, $parametros)
        {
            try
            {
                $statement = $this->PDO_local->prepare($consulta);
                $statement->execute($parametros);
                $fila = $statement->fetchAll(PDO::FETCH_OBJ);
                return $fila;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        function ejecutarPreparado($consulta, $parametros)
        {
            try
            {
                $statement = $this->PDO_local->prepare($consulta);
                $statement->execute($parametros);
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
                    if(password_verify($pass,$renglon['CONTRASEÑA'])){
                        $ver = true;
                        $NOMBRE = $renglon['NOMBRE'];
                        $tipo = $renglon['TIPO_CUENTA'];
                        $id=$renglon['ID'];
                    }
                }
                if($ver){
                    session_start();
                    $_SESSION["name"] = $NOMBRE;
                    $_SESSION["logged_in"]=true;
                    if($tipo==='CLIENTE'){
                        $_SESSION["access"]=1;
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
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
                                $_SESSION["tipo"]="Mesero";
                                echo"<div class=' container'>";
                                echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                echo "</div>";
                                header("refresh:4;../viewsEmpleados/panelEmpleado.php");
                            }
                            else{
                                $_SESSION["tipo"]="Mesero";
                                echo"<div class=' container'>";
                                echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                echo "</div>";
                                header("refresh:4;../viewsEmpleados/panelEmpleado.php");
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
        function Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo){
            try{
                if($pass!==$confirm){
                    echo"<div class='alert alert-warning'>
                    <h3>Contrasenas no concuerdan</h3></div>";
                    header("refresh:2;../views/registrarse.php");
                }
                else{
                    $hash=password_hash($pass,PASSWORD_DEFAULT);
                    $cadena="INSERT INTO CUENTAS(NOMBRE, AP_PATERNO,AP_MATERNO, CORREO, CONTRASEÑA, 
                    TELEFONO,TIPO_CUENTA) VALUES('$nom','$ap','$am','$usu','$hash','$cel','$tipo')";
                    $this->PDO_local->query($cadena);
                    echo"<div class='alert alert-success'>Usuario Registrado</div>";
                    header("refresh:3;../views/login.php");
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>
