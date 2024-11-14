<?php

require_once("./src/models/usuarioModel.php");
require_once("./src/models/anuncioModel.php");

class UsuarioController {

    public function perfil() {
        $email = $_SESSION['user'];
        $usuario = Usuario::getUsuario($email);
        $anuncios = Anuncio::getAnunciosPorUsuario($email);
        include_once("./src/views/perfil.php");
    }

    public function paginaTemas() {
        include_once("./src/views/seleccionTema.php");
    }
    
    public function seleccionarTema($numeroTema) {
        Usuario::setTema($numeroTema);
        header('Location: /perfil');
    }
}