<?php
 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/paisesModel.php');

class AuthController {

    public function login() {
        include_once './src/views/login.php';
    }

    public function register() {
        $paises = Paises::getPaises();
        include_once './src/views/registro.php';
    }

    public function modificar() {
        include_once './src/views/modificarDatos.php';
    }
 
    public function controlAcceso() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = $_POST['remember'];
        
        if (Usuario::checkCredentials($email, $password)) {
            
            $_SESSION['user'] = $email;

            if($remember == 'on') {
                setcookie('user', $email, time() + (86400 * 90), "/");
                setcookie('password', $password, time() + (86400 * 90), "/");
            }

            $_SESSION["ultimaConexion"] = Usuario::getUltimaConexion();
            header('Location: /perfil?logged=true');
        } else {
            $_SESSION['flashdata'] =  'No se ha podido inciar sesion. Comprueba tus credenciales.';
            header('Location: /login');
        }
    }

    public function controlDeCookies() {
        if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
            if (!Usuario::checkCredentials($_SESSION['user'], $_SESSION['password'])) {
                session_destroy();
                $_SESSION['flashdata'] = 'Sesión expirada. Por favor, inicie sesión nuevamente.';
                header('Location: /login');
                exit();
            }
            return true;
        }
    
        if (isset($_COOKIE['user']) && isset($_COOKIE['password'])) {
            if (!Usuario::checkCredentials($_COOKIE['user'], $_COOKIE['password'])) {
                setcookie('user', '', time() - 3600, '/');
                setcookie('password', '', time() - 3600, '/');
                $_SESSION['flashdata'] = 'Error al recuperar los datos de identificación. Inicie sesión para continuar.';
                header('Location: /login');
                exit();
            }
    
            $_SESSION['user'] = $_COOKIE['user'];
            $_SESSION['password'] = $_COOKIE['password'];
            return true;
        }
        $_SESSION['flashdata'] = 'Por favor, inicie sesión para continuar.';
        header('Location: /login');
        exit();
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

    public function controlModificar() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $sexo = $_POST['sexo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $foto_perfil = $_POST['foto_perfil'];

        if (Usuario::modificarUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)) {
            $_SESSION['flashdata'] = $nombre . ', ¡hemos realizado los cambios con éxito!';
            
            if (isset($_COOKIE['user'])) {
                setcookie('user', '', time() - 3600, '/');
            }
            if (isset($_COOKIE['password'])) {
                setcookie('password', '', time() - 3600, '/');
            }
        
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
            }
            session_destroy();
        
            setcookie('user', $email, time() + (86400 * 90), "/");
            setcookie('password', $password, time() + (86400 * 90), "/");
        
            session_start();
            $_SESSION['user'] = $email;
            $_SESSION['password'] = $password;
        
            header('Location: /perfil/' . $email);
            exit;
        } else {
            $_SESSION['flashdata'] = 'Error en los datos introducidos. Puede que el email ya esté en uso.';
            header('Location: /perfil/' . $_SESSION['user']);
            exit;
        }
        
    }

    public function cerrarSesion() {
        setcookie('user', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
    }
}