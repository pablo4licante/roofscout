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

        if (Usuario::checkCredentials($email, $password)) {
            
            //TODO
            //session_start();
            //$_SESSION['email'] = $email;

            header('Location: /?logged=true');
        } else {
            header('Location: /login');
            echo 'Error en las credenciales';
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
    
            header('Location: /login?registered=true');
        } else {
            echo 'Error en las credenciales';
            header('Location: /registro');
        }
    }
}