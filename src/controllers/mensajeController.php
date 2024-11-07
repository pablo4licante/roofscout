<?php

require_once('./src/models/anuncio.php'); 
require_once('./src/models/usuario.php');

class MensajeController {
    public function escribirMensaje($id) {
        $anuncio = Anuncio::getAnuncio($id);
        $publicador = Usuario::getUsuario($anuncio['usuario']);
        include_once './src/views/detalleAnuncio.php';
    }
}