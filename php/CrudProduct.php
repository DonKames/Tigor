<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cp = new CrudProduct;
if (isset($_POST['btnForm'])) {
    $producto = new Producto;
    $producto->codigo = $_POST["codigoProduct"];
    $producto->nombre = $_POST["nombreProduct"];
    $producto->categoria = $_POST["categoriaProduct"];
    $producto->descripcion = $_POST["descripcionProduct"];
    $producto->imagen = $_FILES["imgProduct"];
    switch ($_POST["btnForm"]) {
        case "agregarProduct":
            $cp->createProduct($producto);
            header('Location: ../WebPages/administrar.html');
            break;
        case "modificarProduct":
            //$cp->updateProduct();
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
            //$cp->deleteCategoria(htmlspecialchars($_GET['idCategoria']));
            header('Location: ../../WebPages/administrar.html');
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
            move_uploaded_file($_FILES["imgProducto"]["tmp_name"], "../imgs/products/" . $producto->codigo);
            //move_uploaded_file($_FILES["imgProducto"]["tmp_name"],"E:/OneDrive - INACAP/xampp2/htdocs/Tigor/imgs/products/".$producto->codigo);            
            $query->execute($valores);
            echo $_FILES["imgProduct"]["tmp_name"];
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

    function readProducts($filtro)
    {
        if($filtro !== "null") {
            try {
                
                $conexion = (new CrudProduct)->conexion;
                $query = $conexion->prepare("SELECT * FROM productos WHERE categoria = '".$filtro."';");
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
        }else{
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
            $query = $conexion->prepare("UPDATE productos SET nombre = :nombre, categoria = :categoria, descripcion = :descripcion WHERE id = :id;");
            $valores = ['nombre' => $product->nombre, 'id' => $product->id];
            $query->execute($valores);
            echo $product->id;
            echo "Product Modificado";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }

    function deleteCategoria($idCategoria)
    {
        try {
            echo $idCategoria;
            $conexion = (new CrudCategoria)->conexion;
            $query = $conexion->prepare("DELETE FROM categorias WHERE id = :idCategoria;");
            $valor = ['idCategoria' => $idCategoria];
            $query->execute($valor);
            echo "Categoria Eliminado";
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
