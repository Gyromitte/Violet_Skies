<?php
    class Database
    {
        private $PDO_local;
        private $user = "admin";
        private $password = "admin123";
        private $server = "mysql:host=database-1.cxbyakjiuopg.us-east-1.rds.amazonaws.com; dbname=VIOLET";

        function conectarBD()
        {
            try
            {
                $this->PDO_local = new PDO($this->server, $this->user, $this->password);
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
    }
?>