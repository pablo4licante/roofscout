<?php

require_once("./src/models/usuarioModel.php");
require_once("./src/models/anuncioModel.php");

class UsuarioController {

    public function perfil() {
        $email = "pablo@example.com"; // TODO cambiar por el usuario logueado $_SESSION['usuario']
        $usuario = Usuario::getUsuario($email);
        $anuncios = Anuncio::getAnunciosPorUsuario($email);
        include_once("./src/views/perfil.php");
    }
}