<?php

require_once('./src/models/anuncio.php'); 

class AnuncioController {
    public function inicio() {
        $anuncios = Anuncio::getUltimos();
        include_once './src/views/inicio.php';
    }

    public function busqueda() {
        $anuncios = Anuncio::getResultados();
        include_once './src/views/busqueda.php';
    }
}