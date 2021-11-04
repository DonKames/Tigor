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
                }

                
                $prodCotizacion->idCotizacion = $id;
                
            }
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
}
