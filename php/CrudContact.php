<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cc = new CrudContact;
if (isset($_POST['btnForm'])) {
    require_once 'GUMPController.php';
    $contact = new Contact();
    $contact->name = $_POST['contactName'];
    $contact->email = $_POST['contactEmail'];
    $contact->phone = $_POST['contactPhone'];
    $contact->message = $_POST['contactMessage'];

    switch ($_POST['btnForm']) {
        case "addContact":
            $is_valid = GUMPController();
            
            if($is_valid === true) {
                $cc->createContact($contact);
            }
            break;

        case "readContact":

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
            $result = $query->execute($valores);
            
            //header('Location: ../WebPages/confirmacionContacto.html');
            //echo json_encode($result);
        } catch (PDOException $ex) {
            echo json_encode($ex);
        }
    }
}
