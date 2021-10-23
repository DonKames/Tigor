<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cc = new CrudContact;
if (isset($_POST['btnForm'])) {
    $contact = new Contact();
    $contact->id = null;
    $contact->name = $_POST['nameContact'];
    $contact->email = $_POST['emailContact'];
    $contact->phone = $_POST['phoneContact'];
    $contact->message = $_POST['messageContact'];
    switch ($_POST['btnForm']) {
        case "addContact":
            $cc->createContact($contact);
            break;
    }
}

class CrudContact
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createContact($contact)
    {
        try {
            $conexion = (new CrudContact)->conexion;
            $query = $conexion->prepare("INSERT INTO contacts VALUES (null, :nombre, :email, :telefono, :mensaje);");
            $valores = ['nombre' => $contact->name, 'email' => $contact->email, 'telefono' => $contact->phone, 'mensaje' => $contact->message];
            $query->execute($valores);
            echo "contact Created";
            header('Location: ../WebPages/confirmacionContacto.html');
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }
}
?>