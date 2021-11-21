<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cc = new CrudComunas;
$cc->readComunas();
if(isset($_GET[""])){

}else{

}


class CrudComunas{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function readComunas(){
        try{
            $query = "SELECT * FROM comunas";
            $resultado = $this->conexion->query($query);
            $resultado->execute();
            $comunas = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($comunas);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
}