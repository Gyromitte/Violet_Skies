<?php
class BDHotel{
    private $PDOLocal;
    private $user="root";
    private $password="gay";
    private $server="mysql:host=localhost; dbname=proyecto";

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
    function Select($consulta){
        try{
            $res = $this->PDOLocal->query($consulta);
            $fila=$res->fetchAll(PDO::FETCH_OBJ);
            return $fila;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
?>