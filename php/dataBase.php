
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
    
?>