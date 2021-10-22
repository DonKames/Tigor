<?php
    $cc = new CrudContact;

    if (isset($_POST['btnForm'])){
        switch ($_POST['btnForm']){}
    }


    class CrudContact{
        public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createContacto($contact)
    {
        try {
            $conexion = (new CrudContact)->conexion;
            $query = $conexion->prepare("INSERT INTO contacts VALUES (null, :nombre, :email, :telefono, :mensaje);");
            $valores = ['nombre' => $contact->nombre, 'email' => $contact->email, 'telefono' => $contact->telefono, 'mensaje' => $contact->mensaje];
            $query->execute($valores);
            echo "contact Created";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }
    }
?>