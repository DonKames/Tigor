<?php
if (isset($_POST['btnForm'])) {
    require_once 'Modelos.php';
    require_once 'BaseDatos.php';
    require_once 'GUMPController.php';
    $cotizacion = new Cotizacion;
    $cc = new CrudCotizacion;
    $cotizacion->fecha = $_POST['fechaCotizacion'];
    $cotizacion->rut = $_POST['rutCotizacion'];
    $cotizacion->nombre = $_POST['nombreCotizacion'];
    $cotizacion->direccion = $_POST['direccionCotizacion'];
    $cotizacion->comuna = $_POST['comunaCotizacion'];
    $cotizacion->email = $_POST['emailCotizacion'];
    $cotizacion->telefono = $_POST['telefonoCotizacion'];
    $listaCodigos = explode(',', $_POST['listaCodigos']);
    $listaNombres = explode(',', $_POST['listaNombres']);
    $listaCantidades = explode(',', $_POST['listaCantidades']);
    $prodCotizacion = new ProdCotizacion();
    switch ($_POST['btnForm']) {
        case 'addCotizacion':
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $error = null;
                $cantProductosCotizacion = count($listaCodigos);
                for ($i = 0; $i < $cantProductosCotizacion; $i++) {
                    $prodCotizacion->codigoProd = $listaCodigos[$i];
                    $prodCotizacion->nombreProd = $listaNombres[$i];
                    $prodCotizacion->cantidadProd = $listaCantidades[$i];
                    $resProdCotiz = ProdController($prodCotizacion);
                    if ($resProdCotiz === false) {
                        $error = false;
                        //$message = 'Error al agregar productos a la cotizacion';
                        //echo json_encode($message);
                        break;
                    }
                }
                if ($error === false) {
                    break;
                } else {
                    $cc->createCotizacion($cotizacion);
                    $id = $cc->readIdCotizacion();
                    $prodCotizacion->idCotizacion = $id;
                    for ($i = 0; $i < $cantProductosCotizacion; $i++) {
                        $prodCotizacion->codigoProd = $listaCodigos[$i];
                        $prodCotizacion->nombreProd = $listaNombres[$i];
                        $prodCotizacion->cantidadProd = $listaCantidades[$i];
                        $cc->createProdCotizacion($prodCotizacion);
                    }
                    $response = new ArrayObject();
                    $response->append('success');
                    echo json_encode($response);
                }
                $prodCotizacion->idCotizacion = $id;
            }
            break;
    }
}

if (isset($_GET['btnForm'])) {
    require_once 'Modelos.php';
    require_once 'BaseDatos.php';
    require_once 'GUMPController.php';
    $cc = new CrudCotizacion;
    switch ($_GET['btnForm']) {
        case 'readCotizaciones':
            $cc->readCotizaciones();
            break;
        case 'readCotizacion':
            $cc->readCotizacion($_GET['idCotizacion']);
            break;
        case 'readProdsCotizacion':
            $cc->readProdsCotizacion($_GET['idCotizacion']);
            break;
    }
}

class CrudCotizacion
{
    public $conexion;
    public function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createCotizacion($cotizacion)
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("INSERT INTO cotizaciones VALUES (null, :fecha, :rut, :nombre, :direccion, :comuna, :email, :telefono)");
            $valores = ["fecha" => $cotizacion->fecha, "rut" => $cotizacion->rut, "nombre" => $cotizacion->nombre, "direccion" => $cotizacion->direccion, "comuna" => $cotizacion->comuna, "email" => $cotizacion->email, "telefono" => $cotizacion->telefono];
            $query->execute($valores);
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error createCotizacion");
        }
    }

    function readIdCotizacion()
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("SELECT id FROM cotizaciones ORDER BY id DESC LIMIT 1;");
            $query->execute();
            if ($resultado = $query->fetch()) {
                return $resultado['id'];
            }
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error readIdCotizacion");
        }
    }

    function readCotizacion()
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("SELECT * FROM cotizaciones WHERE id = :id;");
            $valores = ["id" => $_GET['idCotizacion']];
            $query->execute($valores);
            if ($resultado = $query->fetch()) {
                $cotizacion = new Cotizacion();
                $cotizacion->id = $resultado["id"];
                $cotizacion->fecha = $resultado["fecha"];
                $cotizacion->rut = $resultado["rut"];
                $cotizacion->nombre = $resultado["nombre"];
                $cotizacion->direccion = $resultado["direccion"];
                $cotizacion->comuna = $resultado["comuna"];
                $cotizacion->email = $resultado["email"];
                $cotizacion->telefono = $resultado["telefono"];
                echo json_encode($cotizacion);
            }
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error readIdCotizacion");
        }
    }

    function createProdCotizacion($prodCotizacion)
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("INSERT INTO prodCotizacion VALUES (null, :idCotizacion, :codigoProd, :nombreProd, :cantidadProd)");
            $valores = [
                "idCotizacion" => $prodCotizacion->idCotizacion,
                "codigoProd" => $prodCotizacion->codigoProd,
                "nombreProd" => $prodCotizacion->nombreProd,
                "cantidadProd" => $prodCotizacion->cantidadProd
            ];
            $query->execute($valores);
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error CreateProdCotizacion");
        }
    }

    function readCotizaciones()
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("SELECT * FROM cotizaciones");
            $query->execute();
            $cotizacionList = [];
            while ($resultado = $query->fetch()) {
                $cotizacion = new Cotizacion();
                $cotizacion->id = $resultado['id'];
                $cotizacion->fecha = $resultado['fecha'];
                $cotizacion->rut = $resultado['rut'];
                $cotizacion->nombre = $resultado['nombre'];
                $cotizacion->direccion = $resultado['direccion'];
                $cotizacion->comuna = $resultado['comuna'];
                $cotizacion->email = $resultado['email'];
                $cotizacion->telefono = $resultado['telefono'];
                $cotizacionList[] = $cotizacion;
            }
            echo json_encode($cotizacionList);
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error readCotizaciones");
        }
    }

    function readProdsCotizacion($idCotizacion)
    {
        try {
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("SELECT * FROM prodcotizacion WHERE idCotizacion = :id");
            $valores = ["id" => $idCotizacion];
            $query->execute($valores);
            $prodsCotizacionList = [];
            while ($resultado = $query->fetch()) {
                $cotizacion = new ProdCotizacion();
                $cotizacion->id = $resultado['id'];
                $cotizacion->idCotizacion = $resultado['idCotizacion'];
                $cotizacion->codigoProd = $resultado['codigoProd'];
                $cotizacion->nombreProd = $resultado['nombreProd'];
                $cotizacion->cantidadProd = $resultado['cantidadProd'];
                $prodsCotizacionList[] = $cotizacion;
            }
            echo json_encode($prodsCotizacionList);
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage() . " error readCotizaciones");
        }
    }
}
