<?php

require_once('./src/models/anuncio.php'); 

class AnuncioController {
    public function inicio() {
        $anuncios = Anuncio::getUltimos();
        include_once './src/views/inicio.php';
    }
}