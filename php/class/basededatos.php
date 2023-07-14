<?php
class BDHotel{
    private $PDOLocal;
    private $user="admin";
    private $password="admin123";
    private $server="mysql:host=database-1.cxbyakjiuopg.us-east-1.rds.amazonaws.com; dbname=VIOLET";

    function conexionHotel(){
        try{
            $this->PDOLocal=new PDO($this->server,$this->user,$this->password);
        }
        catch(PDOException $E){
            echo $E->getMessage();
        }
    }
    function desconectarHotel(){
        try{
            $this->PDOLocal=null;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function Select($query){
        try{
            $res = $this->PDOLocal->query($query);
            $fila=$res->fetchAll(PDO::FETCH_OBJ);
            return $fila;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function Login($usu,$pass){
        try{
            $ver=false;
            $query="SELECT * FROM CUENTAS WHERE CORREO='$usu'";
            $consulta=$this->PDOLocal->query($query);

            while($renglon=$consulta->fetch(PDO::FETCH_ASSOC)){
                if(password_verify($pass,$renglon['contraseña'])){
                    $ver=true;
                }
            }
            if($ver){
                session_start();
                if($renglon['TIPO_CUENTA']=='CLIENTE'){
                    $_SESSION["cliente"]=$usu;
                    echo"<div class='alert alert-success'>";
                    echo"<h2 align='center'>Bienvenido ".$_SESSION["cliente"]."</h2>";
                    echo "</div>";
                    header("refresh:2;/html/cliente/index.html");
                }
                else if($renglon['TIPO_CUENTA']=='ADMINISTRADOR'){
                    $_SESSION["admin"]=$usu;
                    echo"<div class='alert alert-success'>";
                    echo"<h2 align='center'>Bienvenido ".$_SESSION["admin"]."</h2>";
                    echo "</div>";
                    header("refresh:2;/html/panelAdmin.html");
                }
                else if ($renglon['TIPO_CUENTA']=='EMPLEADO'){
                    $usu=$renglon['id'];
                    $query="SELECT * FROM EMPLEADOS JOIN CUENTAS ON CUENTAS.ID=EMPLEADOS.CUENTA
                    WHERE CUENTAS.ID='$usu'";
                    $consulta=$this->PDOLocal->query($query);
                    while($trabajo=$consulta->fetch(PDO::FETCH_ASSOC)){
                        if($trabajo['TIPO']=='MESERO'){
                            $_SESSION["mesero"]=$usu;
                            echo"<div class='alert alert-success'>";
                            echo"<h2 align='center'>Bienvenido ".$_SESSION["mesero"]."</h2>";
                            echo "</div>";
                            header("refresh:2;/html/trabajo.html");
                        }
                        else{
                            $_SESSION["chef"]=$usu;
                            echo"<div class='alert alert-success'>";
                            echo"<h2 align='center'>Bienvenido ".$_SESSION["chef"]."</h2>";
                            echo "</div>";
                            header("refresh:2;/html/cotisazion.html");
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
}
?>