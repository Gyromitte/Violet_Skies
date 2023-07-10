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
    function Login($query){
        try{
            $res = $this->PDOLocal->query($query);
            $fila=$res->fetch(PDO::FETCH_ASSOC);
            return $fila;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}
?>