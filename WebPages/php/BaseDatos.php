<?php
class BaseDatos
{
    public $conexion;
    function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=Tigor", "root", "");
    }
}
?>