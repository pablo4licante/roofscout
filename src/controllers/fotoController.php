<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/fotoModel.php');

class FotoController {

    public function detalleFoto($id): void {
        $foto = Foto::getFoto($id);
        $anuncio = Anuncio::getAnuncio($foto['anuncio']);
        include_once './src/views/detalleFoto.php';
    }

    public function hacerPrincipal($id) {
        $foto = Foto::getFoto($id);
        if(Foto::hacerPrincipal( $id)) {
            $_SESSION['flashdata'] = 'Foto principal cambiada con exito!';
            header("Location: /anuncio/".$foto['anuncio']);
            exit();
        } else {
            $_SESSION['flashdata'] = 'No se ha podido cambiar la foto principal.';
            header("Location: /anuncio/".$foto['anuncio']);
            exit();
        }
    }

}