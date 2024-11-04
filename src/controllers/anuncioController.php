<?php

require_once('./src/models/anuncio.php'); 
require_once('./src/models/usuario.php');

class AnuncioController {
    public function inicio() {
        $anuncios = Anuncio::getUltimos();
        include_once './src/views/inicio.php';
    }

    public function busqueda($queryParams) {
        $anuncios = Anuncio::getResultados($queryParams);
        include_once './src/views/busqueda.php';
    }

    public function detalleAnuncio($id) {
        $anuncio = Anuncio::getAnuncio($id);
        $publicador = Usuario::getUsuario($anuncio['usuario']);
        include_once './src/views/detalleAnuncio.php';
    }
}