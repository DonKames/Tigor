<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cp = new CrudProveedor;
if (isset($_POST['btnForm'])) {
    require_once 'GUMPController.php';
    $proveedor = new Proveedor;
    $proveedor->setRut($_POST['rutProveedor']);
    $proveedor->setNombre($_POST['nombreProveedor']);
    $proveedor->setDireccion($_POST['direccionProveedor']);
    $proveedor->setComuna($_POST['comunaProveedor']);
    $proveedor->setEmail($_POST['emailProveedor']);
    $proveedor->setTelefono($_POST['telefonoProveedor']);
    switch ($_POST['btnForm']) {
        case "agregarProveedor":
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $cp->createProveedor($proveedor);
            }
            break;
        case "modificarProveedor":
            $cp->updateProveedor($proveedor);
            header('Location: ../WebPages/administrar.php');
            break;
    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case "leerProveedores":
            $cp->readProveedores();
            break;
        case "leerProveedor":
            $cp->readProveedor(htmlspecialchars($_GET['idProveedor']));
            break;
        case "eliminarProveedor":
            $cp->deleteProveedor(htmlspecialchars($_GET['idProveedor']));
            header('Location: ../../WebPages/administrar.php');
            break;
    }
}

class CrudProveedor
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createProveedor($proveedor)
    {
        try {
            $conexion = (new CrudProveedor)->conexion;
            $query = $conexion->prepare("INSERT INTO proveedores VALUES (:rut, :nombre, :direccion, :comuna, :email, :telefono);");
            $valores = ['rut' => $proveedor->getRut(), 'nombre' => $proveedor->getNombre(), 'direccion' => $proveedor->getDireccion(), 'comuna' => $proveedor->getComuna(), 'email' => $proveedor->getEmail(), 'telefono' => $proveedor->getTelefono()];
            $query->execute($valores);
        } catch (PDOException $ex) {
            switch ($ex->errorInfo[0]) {
                case 23000:
                    $resp = new ArrayObject();
                    $resp->append('El Proveedor ya existe');
                    echo json_encode($resp);
                    break;
            }
        }
    }


    function readProveedores()
    {
        try {
            $conexion = (new CrudProveedor)->conexion;
            $query = $conexion->prepare("SELECT * FROM proveedores ORDER BY rut ASC;");
            $query->execute();
            $listaProveedores = [];
            while ($resultado = $query->fetch()) {
                $proveedor = new Proveedor();
                $proveedor->setRut($resultado['rut']);
                $proveedor->setNombre($resultado['nombre']);
                $proveedor->setDireccion($resultado['direccion']);
                $proveedor->setComuna($resultado['comuna']);
                $proveedor->setEmail($resultado['email']);
                $proveedor->setTelefono($resultado['telefono']);
                $listaProveedores[] = $proveedor;
            }
            echo json_encode($listaProveedores);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function readProveedor($rutProveedor)
    {
        try {
            $conexion = (new CrudProveedor)->conexion;
            $query = $conexion->prepare("SELECT * FROM proveedores WHERE rut = :rutProveedor;");
            $valor = ['rutProveedor' => $rutProveedor];
            $query->execute($valor);
            if ($resultado = $query->fetch()) {
                $proveedor = new Proveedor();
                $proveedor->setRut($resultado['rut']);
                $proveedor->setNombre($resultado['nombre']);
                $proveedor->setDireccion($resultado['direccion']);
                $proveedor->setComuna($resultado['comuna']);
                $proveedor->setEmail($resultado['email']);
                $proveedor->setTelefono($resultado['telefono']);
                echo json_encode($proveedor);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function updateProveedor($proveedor)
    {
        try {
            $conexion = (new CrudProveedor)->conexion;
            $query = $conexion->prepare("UPDATE proveedores SET nombre = :nombreProveedor, direccion = :direccionProveedor, comuna = :comunaProveedor, email = :emailProveedor, telefono = :telefonoProveedor WHERE rut = :rutProveedor");
            $valores = ['nombreProveedor' => $proveedor->getNombre(), 'direccionProveedor' => $proveedor->getDireccion(), 'comunaProveedor' => $proveedor->getComuna(), 'emailProveedor' => $proveedor->getEmail(), 'telefonoProveedor' => $proveedor->getTelefono(), 'rutProveedor' => $proveedor->getRut()];
            $query->execute($valores);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function deleteProveedor($rutProveedor)
    {
        try {
            $conexion = (new CrudProveedor)->conexion;
            $query = $conexion->prepare("DELETE FROM proveedores WHERE rut = :rutProveedor;");
            $valor = ['rutProveedor' => $rutProveedor];
            $query->execute($valor);
            echo "Proveedor Eliminado";
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}