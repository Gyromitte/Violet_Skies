<?php
class Database
{
    private $PDO_local;
    private $user = "doadmin";
    private $password = "AVNS_zPsBun59otEyJNJBtBv";
    private $server = "db-mysql-nyc1-69612-do-user-14325582-0.b.db.ondigitalocean.com";
    private $port = 25060;
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
            $statement->execute($parametros);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
?>
