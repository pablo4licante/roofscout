<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/fotoModel.php'); 
require_once('./src/models/tiposModel.php');
require_once('./src/models/paisModel.php');

class AnuncioController {
    public function inicio() {
        $anuncios = Anuncio::getUltimos();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
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
            $paises = Paises::getPaises();
            $tipos_vivienda = Tipos::getTipoVivienda();
            $tipos_anuncio = Tipos::getTipoAnuncio();
            $anuncios = Anuncio::getResultados($queryParams);
            include_once './src/views/busqueda.php';
        }
    }

    public function detalleAnuncio($id) {
        $anuncio = Anuncio::getAnuncio($id);
        $publicador = Usuario::getUsuario($anuncio['usuario']);
        $fotos = Foto::getFotosPorAnuncio($id);
        

        $ultimosVistos = isset($_COOKIE['ultimosVistos']) ? explode(',', $_COOKIE['ultimosVistos']) : [];

        if (($key = array_search($id, $ultimosVistos)) !== false) {
            unset($ultimosVistos[$key]);
        }

        array_unshift($ultimosVistos, $id);

        if (count($ultimosVistos) > 4) {
            array_pop($ultimosVistos);
        }

        setcookie('ultimosVistos', implode(',', $ultimosVistos), time() + (86400 * 7), "/");
        $tipos_mensaje = Tipos::getTipoMensaje();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/detalleAnuncio.php';
    }

    public function nuevoAnuncio() {
        $paises = Paises::getPaises();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/crearAnuncio.php';
    }

    public function mandarNuevoAnuncio() {
        $anuncioId = Anuncio::nuevoAnuncio($_POST);

        if ($anuncioId) {
            $_SESSION['flashdata'] = 'Anuncio creado con exito!';
            header("Location: /anuncio/$anuncioId");
            exit();
        } else {
            return false;
        }
    }

    public function agregarFoto($id) {
        $anuncio = Anuncio::getAnuncio($id);
        $paises = Paises::getPaises();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/agregarFotoAnuncio.php';
    }

    public function ultimosVistos() {
        $ids = isset($_COOKIE['ultimosVistos']) ? $_COOKIE['ultimosVistos'] : null;
        $anunciosVisitados = [];
        if ($ids) {
            $idsArray = explode(',', $ids);
            foreach ($idsArray as $id) {
                $anunciosVisitados[] = Anuncio::getAnuncio($id);
            }
        }
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        $paises = Paises::getPaises();
        include_once './src/views/templates/ultimoAnunciosVisitados.inc.php';
    }
}