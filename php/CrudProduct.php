<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cp = new CrudProduct;
if(isset($_POST['btnForm'])){
    $producto = new Producto;
    switch($_POST["btnForm"]){
        case "agregarProducto":
            $producto->codigo = $_POST["codigoProducto"];
            $producto->nombre = $_POST["nombreProducto"];
            $producto->categoria = $_POST["categoriaProducto"];
            $producto->descripcion = $_POST["descripcionProducto"];
            $producto->imagen = $_FILES["imgProducto"];
            $cp->createProduct($producto);
            header('Location: ../WebPages/administrar.html');
            break;

    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case "leerProducts":
            $cp->readProducts();
            break;
        case "leerProduct":
            $cp->readProduct(htmlspecialchars($_GET['idProduct']));
            break;
        case "eliminarCategoria":
            //$cp->deleteCategoria(htmlspecialchars($_GET['idCategoria']));
            header('Location: ../../WebPages/administrar.html');
            break;
    }
}

class CrudProduct{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createProduct($producto){
        try {
            $conexion = (new CrudProduct)->conexion;
            $query = $conexion->prepare("INSERT INTO productos VALUES (:codigo, :nombre, :categoria, :descripcion, null);");
            $valores = ['codigo' => $producto->codigo, 'nombre' => $producto->nombre, 'categoria' => $producto->categoria, 'descripcion' => $producto->descripcion];
            move_uploaded_file($_FILES["imgProducto"]["tmp_name"],"../imgs/products/".$producto->codigo);
            //move_uploaded_file($_FILES["imgProducto"]["tmp_name"],"E:/OneDrive - INACAP/xampp2/htdocs/Tigor/imgs/products/".$producto->codigo);            
            $query->execute($valores);
            echo $_FILES["imgProducto"]["tmp_name"];
            echo "Producto Creado";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
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

    function readProducts()
    {
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

    function updateCategoria($categoria)
    {
        try {
            $conexion = (new CrudCategoria)->conexion;
            $query = $conexion->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id;");
            $valores = ['nombre' => $categoria->nombre, 'id' => $categoria->id];
            $query->execute($valores);
            echo $categoria->id;
            echo "Categoria Modificada";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }
}
?>