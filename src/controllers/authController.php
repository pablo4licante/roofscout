<?php
 
require_once('./src/models/usuarioModel.php');

class AuthController {

    public function login() {
        include_once './src/views/login.php';
    }

    public function register() {
        include_once './src/views/registro.php';
    }
 
    public function controlAcceso() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = $_POST['remember'];
        
        if (Usuario::checkCredentials($email, $password)) {
            
            $_SESSION['user'] = $email;

            if($remember == 'on') {
                setcookie('user', $email, time() + (86400 * 90), "/");
                setcookie('password', $password, time() + (86400 * 90), "/"); // TODO de verdad hay que guardarse la contrasenya??
            }

            $_SESSION["ultimaConexion"] = Usuario::getUltimaConexion();
            header('Location: /perfil?logged=true');
        } else {
            $_SESSION['flashdata'] =  'No se ha podido inciar sesion. Comprueba tus credenciales.';
            header('Location: /login');
        }
    }

    public function controlRegistro() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $sexo = $_POST['sexo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $foto_perfil = $_POST['foto_perfil'];

        if (Usuario::nuevoUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)) {
            $_SESSION['flashdata'] = $nombre . ', hemos creado tu cuenta con exito!';
            header('Location: /login');
        } else {
            $_SESSION['flashdata'] = 'Error de credenciales.';
            header('Location: /registro');
        }
    }

    public function cerrarSesion() {
        // Delete cookies
        setcookie('user', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        
        // Delete session
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
    }
}