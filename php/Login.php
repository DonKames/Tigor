<?php
if (isset($_POST['btnForm'])) {
    require_once 'BaseDatos.php';
    require_once 'GUMPController.php';
    $user = $_POST['userLogin'];
    $pass = $_POST['passLogin'];
    $login = new Login;
    switch ($_POST['btnForm']) {
        case "leerUsuario":
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $login->readLogin($user, $pass);
            }
            break;
    }
}

class Login
{
    public $conexion;
    function __construct()
    {
        $this->conexion = (new BaseDatos)->conexion;
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function readLogin($user, $pass)
    {
        $conexion = (new Login)->conexion;
        $query = $conexion->prepare("SELECT id FROM admins WHERE usuario = :user AND password = :pass");
        $valores = [
            ':user' => $user,
            ':pass' => $pass
        ];
        $query->execute($valores);
        if ($resultado = $query->fetch()) {
            $response = new ArrayObject();
            session_start();
            $response->append("Validado");
            $response->append($_SESSION['id'] = $resultado['id']);
            $response->append($_SESSION['user'] = $user);
            echo json_encode($response);
            return true;
        } else {
            echo json_encode("Invalido");
            return false;
        }
    }
}
