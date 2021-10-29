<?php
if (isset($_POST['btnForm'])){
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
    switch ($_POST['btnForm']) {
        case 'addCotizacion':
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $cc->createCotizacion($cotizacion);
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

    function createCotizacion($cotizacion){
        try{
            $conexion = (new CrudCotizacion)->conexion;
            $query = $conexion->prepare("INSERT INTO cotizaciones VALUES (null, :fecha, :rut, :nombre, :direccion, :comuna, :email, :telefono)");
            $valores = ["fecha"=>$cotizacion->fecha, "rut"=>$cotizacion->rut, "nombre"=>$cotizacion->nombre, "direccion"=>$cotizacion->direccion, "comuna"=>$cotizacion->comuna, "email"=>$cotizacion->email, "telefono"=>$cotizacion->telefono];
            $query->execute($valores);
        }catch(PDOException $ex){
            echo json_encode($ex->getMessage());
        }
    }
}
?>