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
            $fila = $resultado->fetchAll(PDO::FETCH_OBJ);
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
                $result = $statement->execute($parametros);
                return $result; // Agregar esta línea para devolver el resultado de la ejecución
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function getPDO() {
            return $this->PDO_local;
        }
        
        function Login($usu,$pass){
            try{
                $ver = false;
                $query="SELECT * FROM CUENTAS WHERE CORREO='$usu'";
                $consulta = $this->PDO_local->query($query);

                while($renglon = $consulta->fetch(PDO::FETCH_ASSOC)){
                    if(password_verify($pass,$renglon['CONTRASEÑA'])){
                        $ver = true;
                        $ID=$renglon['ID'];
                        $NOMBRE = $renglon['NOMBRE'];
                        $tipo = $renglon['TIPO_CUENTA'];
                        $ap_paterno=$renglon['AP_PATERNO'];
                        $ap_materno=$renglon['AP_MATERNO'];
                        $telefono=$renglon['TELEFONO'];
                        $correo=$renglon['CORREO'];                       
                        $estado=$renglon['ESTADO'];
                    }
                }
                if($ver){
                    if($estado=="INACTIVO"){
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Parece que tu cuenta fue desactivada..</h1><br>";
                        echo"<h4 align='center'>Comunicase con un Administrador para volver 
                        a activarlo.</h4>";
                        echo "</div>";
                        header("refresh:8;/index.html");
                    }
                    else{
                        session_start();
                        $_SESSION["ID"] = $ID; 
                        $_SESSION["name"] = $NOMBRE;
                        $_SESSION["tipo"] = $tipo;
                        $_SESSION["telefono"] = $telefono;
                        $_SESSION["ap_paterno"] = $ap_paterno;
                        $_SESSION["ap_materno"] = $ap_materno;
                        $_SESSION["correo"] = $correo;
                        $_SESSION["logged_in"]=true;
                        if($tipo==='CLIENTE'){
                        $_SESSION["access"]=1;
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                        echo "</div>";
                        header("refresh:4;/php/viewsClientes/panelClientes.php");
                        }
                        else if($tipo==='ADMINISTRADOR'){
                        $_SESSION["access"]=3;
                        echo"<div class=' container'>";
                        echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                        echo "</div>";
                        header("refresh:4;../viewsEmpleados/panelAdmin.php");
                        }
                        else if ($tipo==='EMPLEADO'){
                        $query="SELECT EMP.ID, EMP.RFC,EMP.TIPO, EMP.CUENTA FROM EMPLEADOS EMP 
                        JOIN CUENTAS ON CUENTAS.ID=EMP.CUENTA WHERE CUENTAS.ID='$ID'";
                        $empleados=$this->PDO_local->query($query);
                        if($empleados->rowCount()===0){
                            $_SESSION["access"]=1.5;
                            echo"<div class=' container'>";
                            echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                            echo "</div>";
                            header("refresh:4;../viewsEmpleados/panelEmpleado.php");
                        }
                        else{
                            while($trabajo = $empleados->fetch(PDO::FETCH_ASSOC)){
                                $idemp=$trabajo['ID'];
                                $_SESSION["trabajo"]=$idemp;
                                $_SESSION["access"]=2;
                                if($trabajo['TIPO']=='MESERO'){
                                    $_SESSION["tipo"]="MESERO";
                                    echo"<div class=' container'>";
                                    echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                    echo "</div>";
                                    header("refresh:4;../viewsEmpleados/panelEmpleado.php");
                                }
                                else if($trabajo['TIPO']=='COCINA'){
                                    $_SESSION["tipo"]="COCINERO";
                                    echo"<div class=' container'>";
                                    echo"<h1 align='center'>Bienvenido ".$_SESSION["name"]."</h1>";
                                    echo "</div>";
                                    header("refresh:4;../viewsEmpleados/panelEmpleado.php");
                                }
                            }
                            }
                        }
                    }
                    }

                
                else{
                    echo"<div class='container'>";
                    echo"<h1 align='center'>Usuario o Contraseña Incorrecto</h1>";
                    echo"</div>";
                    header("refresh:2;../views/login.php");
                }
    
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        function cerrarSesion(){
            session_start();
            session_destroy();
            echo"<div class='container'>";
                    echo"<h1 align='center'>Cerrando Sesión</h1>";
                    echo"</div>";
            header("refresh:3;/index.html");
        }
        function Register($nom,$ap,$am,$usu,$pass,$confirm,$cel,$tipo){
            try{
                if($pass!==$confirm){
                    echo"<div class='alert alert-warning'>
                    Contrasenas no concuerdan</div>";
                }
                else{
                    try{
                    $hash=password_hash($pass,PASSWORD_DEFAULT);
                    $cadena="INSERT INTO CUENTAS(NOMBRE, AP_PATERNO,AP_MATERNO, CORREO, CONTRASEÑA, 
                    TELEFONO,TIPO_CUENTA) VALUES('$nom','$ap','$am','$usu','$hash','$cel','$tipo')";
                    $this->PDO_local->query($cadena);
                    echo"<div class='alert alert-success'>Te has registrado exitosamente!</div>";
                    }
                    catch(PDOException $e){
                        $errorMessage = $e->getMessage();

                        // Extract the relevant part of the error message
                        // Assuming the error message format is "SQLSTATE[45000]: <>: 1644 Your trigger message"
                        $startIndex = strpos($errorMessage, "1644") + 5;
                        $triggerMessage = substr($errorMessage, $startIndex);

                        // Display the trigger message without the unwanted part
                        echo "<div class='alert alert-danger'>" . $triggerMessage . "</div>";
                    }
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        function RegisterEmp($nom, $ap, $am, $usu, $dire, $pass, $confirm, $cel, $tipo, $ineSubido, $backSubido, $s3Client, $bucketName) {
            try {
                if ($pass !== $confirm) {
                    echo "<div class='alert alert-warning'>Contrasenas no concuerdan</div>";
                } else {
                    try {
                        $resultadoIne = $s3Client->putObject([
                            'Bucket' => $bucketName,
                            'Key' => $ineSubido['name'],
                            'Body' => fopen($ineSubido['tmp_name'], 'rb'),
                            'ACL' => 'public-read',
                        ]);
    
                        $resultadoBack = $s3Client->putObject([
                            'Bucket' => $bucketName,
                            'Key' => $backSubido['name'],
                            'Body' => fopen($backSubido['tmp_name'], 'rb'),
                            'ACL' => 'public-read',
                        ]);
    
                        // Obtener URLs públicas de las imágenes
                        $urlIne = $resultadoIne['ObjectURL'];
                        $urlBack = $resultadoBack['ObjectURL'];
    
                        $hash = password_hash($pass, PASSWORD_DEFAULT);
                        $cadena = "INSERT INTO CUENTAS(NOMBRE, AP_PATERNO, AP_MATERNO, CORREO, 
                        CONTRASEÑA, TELEFONO, TIPO_CUENTA, INE_F, INE_T, DIRECCION) VALUES ('$nom', '$ap', '$am', '$usu',
                        '$hash', '$cel', '$tipo', '$urlIne', '$urlBack','$dire')";
                        $this->PDO_local->query($cadena);
                        echo "<div class='alert alert-success'>Te has registrado exitosamente!</div>";
                    } catch (PDOException $e) {
                        $errorMessage = $e->getMessage();
    
                        // Extract the relevant part of the error message
                        // Assuming the error message format is "SQLSTATE[45000]: <>: 1644 Your trigger message"
                        $startIndex = strpos($errorMessage, "1644") + 5;
                        $triggerMessage = substr($errorMessage, $startIndex);
    
                        // Display the trigger message without the unwanted part
                        echo "<div class='alert alert-danger'>" . $triggerMessage . "</div>";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        function ejecutarInsert($consulta){
        try
        {
            $this->PDO_local->query($consulta);
            echo"<div class='alert alert-success'>Solicitud Enviada!</div>";
        }
        catch(PDOException $e)
        {
            $errorMessage = $e->getMessage();

            $startIndex = strpos($errorMessage, "1644") + 5;
            $triggerMessage = substr($errorMessage, $startIndex);

            echo "<div class='alert alert-danger'>" . $triggerMessage . "</div>";

        }
        }
    }
?>
