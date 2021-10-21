<?php
require_once 'Modelos.php';
require_once 'BaseDatos.php';
$cc = new CrudCategoria;

if (isset($_POST['btnForm'])) {
    $categoria = new Categoria;
    $categoria->id = $_POST['idCategoria'];
    $categoria->nombre = $_POST['nombreCategoria'];

    switch ($_POST['btnForm']) {
        case "agregarCategoria":
            echo "Entro Switch agregarCategoria";
            $cc->createCategoria($categoria);
            echo "CHAO";
            header('Location: ../WebPages/administrar.html');
            break;
        case "modificarCategoria":
            $cc->updateCategoria($categoria);
            header('Location: ../WebPages/administrar.html');
            break;
    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case "leerCategorias":
            $cc->readCategorias();
            break;
        case "leerCategoria":
            $cc->readCategoria(htmlspecialchars($_GET['idCategoria']));
            break;
        case "eliminarCategoria":
            $cc->deleteCategoria(htmlspecialchars($_GET['idCategoria']));
            header('Location: ../../WebPages/administrar.html');
            break;
        case "leerCategoriasFiltro":
            header('Location: ../../WebPages/productos.html');
            $cc->readCategorias($_GET["filtro"]);
            break;
    }
}

class CrudCategoria
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function createCategoria($categoria)
    {
        try {
            $conexion = (new CrudCategoria)->conexion;
            $query = $conexion->prepare("INSERT INTO categorias VALUES (null, :nombre);");
            $valores = ['nombre' => $categoria->nombre];
            $query->execute($valores);
            echo "Categoria Creada";
        } catch (PDOException $ex) {
            echo "Hubo un Error <br>";
            echo $ex;
        }
    }

    function readCategoria($idCategoria)
    {
        try {
            $conexion = (new CrudCategoria)->conexion;
            $query = $conexion->prepare("SELECT * FROM categorias WHERE id = :idCategoria;");
            $valor = ['idCategoria' => $idCategoria];
            $query->execute($valor);
            if ($resultado = $query->fetch()) {
                $categoria = new Categoria();
                $categoria->id = $resultado['id'];
                $categoria->nombre = $resultado['nombre'];
                echo json_encode($categoria);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function readCategorias()
    {
        try {
            $conexion = (new CrudCategoria)->conexion;
            $query = $conexion->prepare("SELECT * FROM categorias;");
            $query->execute();
            $listaCategorias = [];
            while ($resultado = $query->fetch()) {
                $categoria = new Categoria();
                $categoria->id = $resultado['id'];
                $categoria->nombre = $resultado['nombre'];
                $listaCategorias[] = $categoria;
            }
            echo json_encode($listaCategorias);
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
