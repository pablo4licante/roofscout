<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/fotoModel.php');

class FotoController {

    public function detalleFoto($id): void {
        $foto = Foto::getFoto($id);
        include_once './src/views/detalleFoto.php';
    }

}