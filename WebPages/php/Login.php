<?php
require_once '../vendor/autoload.php';
require_once 'BaseDatos.php';
require_once 'GUMPController.php';

use Firebase\JWT\JWT;

if (isset($_POST['btnForm'])) {

    $login = new Login;
    switch ($_POST['btnForm']) {
        case "leerUsuario":
            $user = $_POST['userLogin'];
            $pass = $_POST['passLogin'];
            $is_valid = GUMPController();
            if ($is_valid === true) {
                $login->readLogin($user, $pass);
            }
            break;
    }
}

if (isset($_GET['btnForm'])) {
    switch ($_GET['btnForm']) {
        case "verificarUser":
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                $login = new Login;
                $tokenObj = explode(' ', $headers['Authorization']);
                $token = $tokenObj[1];
                $login->verificarUser($token);
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
            $time = time();
            $key = 'R1O2G3I4T5';
            $response = new stdClass();
            $token = array(
                'iat' => $time,
                'exp' => $time + (60 * 5),
                'data' => [
                    'id' => $resultado['id'],
                    'name' => $user
                ]
            );
            $jwt = JWT::encode($token, $key);
            setcookie('token', $jwt, time() + (60 * 5), "/");
            $response->status = 'Validado';
            $response->token = $jwt;
            echo json_encode($response);
            /*Anterior
            $response = new ArrayObject();
            session_start();
            $response->append("Validado");
            $response->append($_SESSION['id'] = $resultado['id']);
            $response->append($_SESSION['user'] = $user);
            echo json_encode($response);
            return true;*/
        } else {
            echo json_encode("Invalido");
            return false;
        }
    }

    public function verificarUser($token)
    {
        try {
            $data = JWT::decode($token, 'R1O2G3I4T', array('HS256'));
            echo json_encode("Verificado");
        } catch (Exception $e) {
            //header('Location: ../WebPages/Login.html');
            //$login = new Login;
            echo json_encode($e->getMessage());
            //header('Location')$login->cambiarPagina();
        };
    }
    public function cambiarPagina()
    {
        header('Location: ../WebPages/Login.html');
    }
}
