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
    
}
?>