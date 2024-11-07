<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');

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

    public function nuevoAnuncio() {
        include_once './src/views/crearAnuncio.php';
    }

    public function mandarNuevoAnuncio() {
        $anuncioId = Anuncio::nuevoAnuncio($_POST);

        if ($anuncioId) {
            header("Location: /anuncio/$anuncioId?created=true");
            exit();
        } else {
            // Handle the error appropriately
            echo "Error al crear el anuncio.";
        }
    }

    public function verAnuncio($id): void {
        $anuncio = Anuncio::getAnuncio($id);
        $publicador = Usuario::getUsuario($anuncio['usuario']);
        include_once './src/views/verAnuncio.php';
    }

    public function agregarFoto($id) {
        $anuncio = Anuncio::getAnuncio($id);
        include_once './src/views/agregarFotoAnuncio.php';
    }
}