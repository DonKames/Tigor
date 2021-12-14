<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
require_once 'GUMPController.php';
$cc = new CrudContact;
if (isset($_POST['btnForm'])) {
    require_once 'PhpMailer.php';

    $contact = new Contact();
    $contact->name = $_POST['contactName'];
    $contact->email = $_POST['contactEmail'];
    $contact->phone = $_POST['contactPhone'];
    $contact->message = $_POST['contactMessage'];

    switch ($_POST['btnForm']) {
        case "addContact":
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $cc->createContact($contact);
                $cc->sendEmail($contact);
            }
            break;

        case "readContact":

            break;
    }
}

if(isset($_GET['btnForm'])){
    switch ($_GET['btnForm']) {
        case "readContacts":
            $cc->readContacts();
            break;
        case "readContact":
            $cc->readContact($_GET['id']);
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

            //header('Location: ../WebPages/confirmacionContacto.html');
            //echo json_encode($result);
        } catch (PDOException $ex) {
            echo json_encode($ex);
        }
    }

    function readContacts(){
        try{
            $conexion = (new CrudContact)->conexion;
            $query = $conexion->prepare("SELECT * FROM contacts");
            $query->execute();
            $contactList = [];
            while($result = $query->fetch()){
                $contact = new Contact();
                $contact->id = $result['id'];
                $contact->name = $result['name'];
                $contact->email = $result['email'];
                $contact->phone = $result['phone'];
                $contactList[] = $contact;
            }
            echo json_encode($contactList);
        }catch(PDOException $ex){
            echo json_encode($ex->getMessage() . " error readContact.");
        }
    }

    function readContact($idContact)
    {
        try {
            $conexion = (new CrudContact)->conexion;
            $query = $conexion->prepare("SELECT * FROM contacts WHERE id = :idContact;");
            $valor = ['idContact' => $idContact];
            $query->execute($valor);
            if ($resultado = $query->fetch()) {
                $contact = new Contact();
                $contact->id = ($resultado['id']);
                $contact->name = ($resultado['name']);
                $contact->email = ($resultado['email']);
                $contact->phone = ($resultado['phone']);
                $contact->message = ($resultado['message']);
                echo json_encode($contact);
            }else{
                $notFound = false;
                echo json_encode($notFound);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function sendEmail($contact)
    {
        $mailer = new Mailer();
        $mailer->sendMail($contact);
    }
}
