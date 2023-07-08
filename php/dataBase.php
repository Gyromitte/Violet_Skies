<?php
    class Database
    {
        private $PDO_local;
        private $user = "root";
        private $password = "";
        private $server = "mysql:host=localhost; dbname=proyecto";

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