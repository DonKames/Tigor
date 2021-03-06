<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cp = new CrudProduct;
if (isset($_POST['btnForm'])) {
    require_once 'GUMPController.php';
    $producto = new Producto;
    $producto->codigo = $_POST["codigoProduct"];
    $producto->nombre = $_POST["nombreProduct"];
    $producto->categoria = $_POST["categoriaProduct"];
    $producto->descripcion = $_POST["descripcionProduct"];
    if(isset($_FILES['imagenProduct'])){
        $producto->imagen = $_FILES['imagenProduct'];
    }
    switch ($_POST["btnForm"]) {
        case "agregarProduct":
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $cp->createProduct($producto);
            }
            break;
        case "modificarProduct":
            $cp->updateProduct($producto);
            header('Location: ../administrar.php');
    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case "leerProducts":
            $cp->readProducts($_GET["filtro"]);
            break;
        case "leerProduct":
            $cp->readProduct(htmlspecialchars($_GET['idProduct']));
            break;
        case "eliminarCategoria":
            $cp->deleteProducto(htmlspecialchars($_GET['idProduct']));
            header('Location: ../../administrar.php');
            break;
    }
}

class CrudProduct
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createProduct($producto)
    {
        try {
            $conexion = (new CrudProduct)->conexion;
            $query = $conexion->prepare("INSERT INTO productos VALUES (:codigo, :nombre, :categoria, :descripcion);");
            $valores = ['codigo' => $producto->codigo, 'nombre' => $producto->nombre, 'categoria' => $producto->categoria, 'descripcion' => $producto->descripcion];
            if(isset($_FILES['imgProduct'])){
                echo "entre if archivo";
                $respImg = move_uploaded_file($_FILES["imgProduct"]["tmp_name"], "E:/OneDrive - INACAP/xampp2/htdocs/TigorRespaldo/WebPages/imgs/products/" . $producto->codigo);
                echo $respImg;
                echo $_FILES["imgProduct"]["tmp_name"];
            }
            //move_uploaded_file($_FILES["imgProducto"]["tmp_name"],"E:/OneDrive - INACAP/xampp2/htdocs/Tigor/imgs/products/".$producto->codigo);            
            $query->execute($valores);
        } catch (PDOException $ex) {
            switch ($ex->errorInfo[0]) {
                case 23000:
                    $resp = new ArrayObject();
                    $resp->append('El Producto ya existe');
                    $resp->append($ex);
                    echo json_encode($resp);
                    break;
            }
        }
    }

    function readProduct($codigoProduct)
    {
        try {
            $conexion = (new CrudProduct)->conexion;
            $query = $conexion->prepare("SELECT * FROM productos WHERE codigo = :codigoProduct;");
            $valor = ['codigoProduct' => $codigoProduct];
            $query->execute($valor);
            if ($resultado = $query->fetch()) {
                $producto = new Producto();
                $producto->codigo = $resultado['codigo'];
                $producto->nombre = $resultado['nombre'];
                $producto->categoria = $resultado['categoria'];
                $producto->descripcion = $resultado['descripcion'];
                echo json_encode($producto);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function readProducts($filtro)
    {
        if ($filtro !== "null") {
            try {

                $conexion = (new CrudProduct)->conexion;
                $query = $conexion->prepare("SELECT * FROM productos WHERE categoria = '" . $filtro . "';");
                $query->execute();
                $productList = [];
                while ($resultado = $query->fetch()) {
                    $product = new Producto();
                    $product->codigo = $resultado['codigo'];
                    $product->nombre = $resultado['nombre'];
                    $product->categoria = $resultado['categoria'];
                    $product->descripcion = $resultado['descripcion'];
                    $productList[] = $product;
                }
                echo json_encode($productList);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        } else {
            try {
                $conexion = (new CrudProduct)->conexion;
                $query = $conexion->prepare("SELECT * FROM productos;");
                $query->execute();
                $productList = [];
                while ($resultado = $query->fetch()) {
                    $product = new Producto();
                    $product->codigo = $resultado['codigo'];
                    $product->nombre = $resultado['nombre'];
                    $product->categoria = $resultado['categoria'];
                    $product->descripcion = $resultado['descripcion'];
                    $productList[] = $product;
                }
                echo json_encode($productList);
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }

    function updateProduct($product)
    {
        try {
            $conexion = (new CrudProduct)->conexion;
            $query = $conexion->prepare("UPDATE productos SET nombre = :nombre, categoria = :categoria, descripcion = :descripcion WHERE codigo = :codigo;");
            $valores = ['nombre' => $product->nombre, 'categoria' => $product->categoria, 'descripcion' => $product->descripcion, 'codigo' => $product->codigo];
            $query->execute($valores);
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }

    function deleteProducto($codigo)
    {
        try {
            $conexion = (new CrudProduct)->conexion;
            $query = $conexion->prepare("DELETE FROM productos WHERE codigo = :codigo;");
            $valor = ['codigo' => $codigo];
            $query->execute($valor);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
