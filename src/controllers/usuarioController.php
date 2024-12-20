<?php

require_once("./src/models/usuarioModel.php");
require_once("./src/models/anuncioModel.php");
require_once("./src/models/temaModel.php");

class UsuarioController {

    public function perfil($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            header('Location: /');
        }
        $usuario = Usuario::getUsuario($email);
        $anuncios = Anuncio::getAnunciosPorUsuario($email);
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        $paises = Paises::getPaises();
        include_once("./src/views/perfil.php");
    }

    public function paginaTemas() {
        $temas = Temas::getTemas();
        include_once("./src/views/seleccionTema.php");
    }
    
    public function seleccionarTema($numeroTema) {
        Temas::setTema($numeroTema);
        $_SESSION['tema'] = Temas::getTema()['fichero'];
        header('Location: /perfil/' . $_SESSION['user']);
    }

    public function paginaMisDatos() {
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        $paises = Paises::getPaises();
        $usuario = Usuario::getUsuario($_SESSION['user']);
        include_once("./src/views/modificarDatos.php");
    }
}