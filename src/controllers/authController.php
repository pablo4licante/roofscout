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
        include_once './src/views/controlAcceso.php';
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
        include_once './src/views/controlRegistro.php';
    }
}