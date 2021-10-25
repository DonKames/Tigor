<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cc = new CrudCliente;
if (isset($_POST['btnForm'])) {
    require_once 'GUMPController.php';
    
    $cliente = new Cliente;
    $cliente->setRut($_POST['rutCliente']);
    $cliente->setNombre($_POST['nombreCliente']);
    $cliente->setDireccion($_POST['direccionCliente']);
    $cliente->setComuna($_POST['comunaCliente']);
    $cliente->setEmail($_POST['emailCliente']);
    $cliente->setTelefono($_POST['telefonoCliente']);
    switch ($_POST['btnForm']) {
        case "agregarCliente":
            echo "Entro Switch agregarCliente";
            $is_valid = GUMPController();
            echo ' resultado de is_valid '.json_encode($is_valid);
            if ($is_valid === false) {
                echo 'Failed';
            }else{
                $cc->createCliente($cliente);
                echo "Success";
                header('Location: ../WebPages/administrar.html');
            }
            break;
        case "modificarCliente":
            $cc->updateCliente($cliente);
            header('Location: ../WebPages/administrar.html');
            break;
    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case 'leerClientes':
            $cc->readClientes();
            break;
        case 'leerCliente':
            $cc->readCliente(htmlspecialchars($_GET['idCliente']));
            break;
        case 'eliminarCliente':
            $cc->deleteCliente(htmlspecialchars($_GET['idCliente']));
            header('Location: ../../WebPages/administrar.html');
            break;
    }
}


class CrudCliente
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createCliente($cliente)
    {
        try {
            $conexion = (new CrudCliente)->conexion;
            $query = $conexion->prepare("INSERT INTO clientes VALUES (:rut, :nombre, :direccion, :comuna, :email, :telefono);");
            $valores = ['rut' => $cliente->getRut(), 'nombre' => $cliente->getNombre(), 'direccion' => $cliente->getDireccion(), 'comuna' => $cliente->getComuna(), 'email' => $cliente->getEmail(), 'telefono' => $cliente->getTelefono()];
            $query->execute($valores);
            echo "Cliente Creado";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }

    function readCliente($rutCliente)
    {
        try {
            $conexion = (new CrudCliente)->conexion;
            $query = $conexion->prepare("SELECT * FROM clientes WHERE rut = :rutCliente;");
            $valor = ['rutCliente' => $rutCliente];
            $query->execute($valor);
            if ($resultado = $query->fetch()) {
                $cliente = new Cliente();
                $cliente->setRut($resultado['rut']);
                $cliente->setNombre($resultado['nombre']);
                $cliente->setDireccion($resultado['direccion']);
                $cliente->setComuna($resultado['comuna']);
                $cliente->setEmail($resultado['email']);
                $cliente->setTelefono($resultado['telefono']);
                echo json_encode($cliente);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function readClientes()
    {
        try {
            $conexion = (new CrudCliente)->conexion;
            $query = $conexion->prepare("SELECT * FROM clientes ORDER BY rut ASC;");
            $query->execute();
            $listaClientes = [];
            while ($resultado = $query->fetch()) {
                $cliente = new Cliente();
                $cliente->setRut($resultado['rut']);
                $cliente->setNombre($resultado['nombre']);
                $cliente->setDireccion($resultado['direccion']);
                $cliente->setComuna($resultado['comuna']);
                $cliente->setEmail($resultado['email']);
                $cliente->setTelefono($resultado['telefono']);
                $listaClientes[] = $cliente;
            }
            echo json_encode($listaClientes);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function deleteCliente($rutCliente)
    {
        try {
            echo $rutCliente;
            $conexion = (new CrudCliente)->conexion;
            $query = $conexion->prepare("DELETE FROM clientes WHERE rut = :rutCliente;");
            $valor = ['rutCliente' => $rutCliente];
            $query->execute($valor);
            echo "Cliente Eliminado";
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function updateCliente($cliente)
    {
        try {
            $conexion = (new CrudCliente)->conexion;
            $query = $conexion->prepare("UPDATE clientes SET nombre = :nombreCliente, direccion = :direccionCliente, comuna = :comunaCliente, email = :emailCliente, telefono = :telefonoCliente WHERE rut = :rutCliente");
            $valores = ['nombreCliente' => $cliente->getNombre(), 'direccionCliente' => $cliente->getDireccion(), 'comunaCliente' => $cliente->getComuna(), 'emailCliente' => $cliente->getEmail(), 'telefonoCliente' => $cliente->getTelefono(), 'rutCliente' => $cliente->getRut()];
            $query->execute($valores);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
