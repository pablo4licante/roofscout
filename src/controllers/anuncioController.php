<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/fotoModel.php'); 

class AnuncioController {
    public function inicio() {
        $anuncios = Anuncio::getUltimos();
        include_once './src/views/inicio.php';
    }

    public function busqueda($queryParams) {

        if(isset($queryParams["precio_min"]) && $queryParams["precio_min"] != "" && !is_numeric($queryParams["precio_min"])) {
            echo "<div class='mensaje-error'>El precio mínimo debe ser un número entero.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        }

        elseif(isset($queryParams["precio_max"]) && $queryParams["precio_max"] != "" && !is_numeric($queryParams["precio_max"])) {
            echo "<div class='mensaje-error'>El precio máximo debe ser un número entero.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        }

        elseif(isset($queryParams["fecha_inicio"]) && $queryParams["fecha_inicio"] != "" && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $queryParams["fecha_inicio"])) {
            echo "<div class='mensaje-error'>La fecha de inicio debe tener el formato AAAA-MM-DD.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        }

        elseif(isset($queryParams["fecha_fin"]) && $queryParams["fecha_fin"] != "" && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $queryParams["fecha_fin"])) {
            echo "<div class='mensaje-error'>La fecha de fin debe tener el formato AAAA-MM-DD.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        }
        else {
            $anuncios = Anuncio::getResultados($queryParams);
            include_once './src/views/busqueda.php';
        }
    }

    public function detalleAnuncio($id) {
        $anuncio = Anuncio::getAnuncio($id);
        $publicador = Usuario::getUsuario($anuncio['usuario']);
        $fotos = Foto::getFotosPorAnuncio($id);
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