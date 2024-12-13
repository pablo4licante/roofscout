<?php

require_once('./src/models/anuncioModel.php');
require_once('./src/models/usuarioModel.php');
require_once('./src/models/fotoModel.php');
require_once('./src/models/tiposModel.php');
require_once('./src/models/paisModel.php');

class AnuncioController
{
    public function inicio()
    {
        $anuncios = Anuncio::getUltimos();
        
        $filename = "anuncios_favoritos.cdm";
        $favoritos = [];

        if (file_exists($filename)) {
            $file = fopen($filename, "r");
            if ($file) {
                while (($line = fgets($file)) !== false) {
                    $parts = explode(" #$ ", $line);
                    if (isset($parts[0])) {
                        $favoritos[] = $line;
                    }
                }
                fclose($file);
            }

        } else {
            echo "<div class='mensaje-error'>No se ha podido cargar la lista de favoritos.</div>";
        }
        $anuncios_favs = Anuncio::getFavoritos($favoritos);
        $anuncios_favoritos = [];
        foreach ($anuncios_favs as $anuncio_fav) {
            foreach ($favoritos as $line) {
                $parts = explode(" #$ ", $line);
                if (trim($parts[0]) == $anuncio_fav['id']) {
                    $anuncios_favoritos[] = [
                        'id' => $anuncio_fav['id'],
                        'url' => $anuncio_fav['url'],
                        'alt' => $anuncio_fav['alt'],
                        'titulo' => $anuncio_fav['titulo'],
                        'ciudad' => $anuncio_fav['ciudad'],
                        'pais' => $anuncio_fav['pais'],
                        'tipo_anuncio' => $anuncio_fav['tipo_anuncio'],
                        'precio' => $anuncio_fav['precio'],
                        'fecha_publi' => $anuncio_fav['fecha_publi'],
                        'nombre' => $parts[1],
                        'comentario' => $parts[2]
                    ];
                    break;
                }
            }
        }

        $consejos = json_decode(file_get_contents('./consejos.json'), true);
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/inicio.php';
    }

    public function busqueda($queryParams)
    {

        if (isset($queryParams["precio_min"]) && $queryParams["precio_min"] != "" && !is_numeric($queryParams["precio_min"])) {
            echo "<div class='mensaje-error'>El precio mínimo debe ser un número entero.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        } elseif (isset($queryParams["precio_max"]) && $queryParams["precio_max"] != "" && !is_numeric($queryParams["precio_max"])) {
            echo "<div class='mensaje-error'>El precio máximo debe ser un número entero.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        } elseif (isset($queryParams["fecha_inicio"]) && $queryParams["fecha_inicio"] != "" && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $queryParams["fecha_inicio"])) {
            echo "<div class='mensaje-error'>La fecha de inicio debe tener el formato AAAA-MM-DD.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        } elseif (isset($queryParams["fecha_fin"]) && $queryParams["fecha_fin"] != "" && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $queryParams["fecha_fin"])) {
            echo "<div class='mensaje-error'>La fecha de fin debe tener el formato AAAA-MM-DD.</div>";
            echo "<button onclick=\"window.location.href='/busqueda'\">Volver a la busqueda</button>";
        } else {
            $paises = Paises::getPaises();
            $tipos_vivienda = Tipos::getTipoVivienda();
            $tipos_anuncio = Tipos::getTipoAnuncio();
            $anuncios = Anuncio::getResultados($queryParams);
            include_once './src/views/busqueda.php';
        }
    }

    public function detalleAnuncio($id)
    {
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

    public function nuevoAnuncio()
    {
        $paises = Paises::getPaises();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/crearAnuncio.php';
    }

    public function mandarNuevoAnuncio()
    {
        $anuncioId = Anuncio::nuevoAnuncio($_POST);

        if ($anuncioId) {
            $_SESSION['flashdata'] = 'Anuncio creado con exito!';
            header("Location: /agregar-foto/$anuncioId");
            exit();
        } else {
            return false;
        }
    }

    public function agregarFoto($id)
    {
        $anuncio = Anuncio::getAnuncio($id);
        $paises = Paises::getPaises();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();

        $_SESSION['flashdata'] = 'Agrega una nueva foto para tu anuncio';

        include_once './src/views/agregarFotoAnuncio.php';
    }

    public function agregarFotoDB($id_anuncio, $titulo, $alt, $url)
    {
        $data = [
            'url' => $url,
            'anuncio' => $id_anuncio,
            'alt' => $alt
        ];
        Foto::nuevaFoto($data);
    }

    public function eliminarFoto($id)
    {
        $foto = Foto::getFoto($id);
        if (Foto::eliminarFoto($id)) {
            $_SESSION['flashdata'] = 'Foto eliminada con exito!';
            header("Location: /anuncio/" . $foto['anuncio']);
            exit();
        } else {
            $_SESSION['flashdata'] = 'No se ha podido eliminar la foto.';
            header("Location: /anuncio/" . $foto['anuncio']);
            exit();
        }
    }

    public function ultimosVistos()
    {
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

    public function eliminarAnuncio($id)
    {
        include_once('./src/views/eliminarAnuncio.php');
    }

    public function confirmarEliminarAnuncio($id, $password)
    {
        if (Usuario::checkCredentials($_SESSION['user'], $password)) {

            if (Anuncio::eliminarAnuncio($id)) {
                setcookie('ultimosVistos', '', time() - 3600, "/", "", false, true);
                $_SESSION['flashdata'] = 'Anuncio eliminado con exito!';
                header("Location: /perfil/{$_SESSION['user']}");
            } else {
                $_SESSION['flashdata'] = 'Anuncio no eliminado.';
                header("Location: /anuncio/{$id}");
            }
        } else {
            $_SESSION['flashdata'] = 'No se ha podido eliminar el anuncio. Comprueba que la contraseña es correcta.';
            header("Location: /anuncio/{$id}");
        }
    }

    public function modificarAnuncio($id)
    {
        $anuncio = Anuncio::getAnuncio($id);
        $paises = Paises::getPaises();
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        include_once './src/views/modificarAnuncio.php';
    }

    public function mandarModificarAnuncio($id)
    {
        if (Usuario::checkCredentials($_SESSION['user'], $_SESSION['password'])) {
            $anuncioId = Anuncio::modificarAnuncio($id, $_POST);

            if ($anuncioId) {
                $_SESSION['flashdata'] = 'Anuncio modificado con exito!';
                header("Location: /anuncio/$id");
                exit();
            } else {
                return false;
            }
        } else {
            $_SESSION['flashdata'] = 'No se ha podido modificar el anuncio. Comprueba que la contraseña es correcta.';
            header("Location: /modificar-anuncio/$id");
            exit();
        }
    }

    public function getAnuncio($id)
    {
        return Anuncio::getAnuncio($id);
    }

    public function generarRSS() {
        header("Content-Type: application/rss+xml; charset=UTF-8");
        header('Content-Disposition: attachment; filename="feed.rss.xml"');
    
    
        // Recuperar anuncios
        $anuncios = Anuncio::getUltimos(5);
    
        // Crear el documento XML
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
    
        // Nodo raíz <rss>
        $rss = $dom->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $dom->appendChild($rss);
    
        // Nodo <channel>
        $channel = $dom->createElement('channel');
        $rss->appendChild($channel);
    
        // Elementos generales del canal
        $title = $dom->createElement('title', 'Roofscout.one - Anuncios');
        $channel->appendChild($title);
    
        $link = $dom->createElement('link', 'http://roofscout.one/');
        $channel->appendChild($link);
    
        $description = $dom->createElement('description', 'Últimos anuncios publicados en Mi Sitio.');
        $channel->appendChild($description);
    
        $lastBuildDate = $dom->createElement('lastBuildDate', date(DATE_RSS));
        $channel->appendChild($lastBuildDate);
    
        $language = $dom->createElement('language', 'es-ES');
        $channel->appendChild($language);
    
        // Entradas de anuncios
        foreach ($anuncios as $anuncio) {
            $item = $dom->createElement('item');
    
            $itemTitle = $dom->createElement('title', htmlspecialchars($anuncio['titulo']));
            $item->appendChild($itemTitle);
    
            $itemLink = $dom->createElement('link', 'http://roofscout.one/anuncio/' . $anuncio['id']);
            $item->appendChild($itemLink);
    
            $itemDescription = $dom->createElement('description', htmlspecialchars($anuncio['descripcion']));
            $item->appendChild($itemDescription);
    
            $itemPubDate = $dom->createElement('pubDate', date(DATE_RSS, strtotime($anuncio['fecha'])));
            $item->appendChild($itemPubDate);
    
            $itemGuid = $dom->createElement('guid', 'http://roofscout.one/anuncio/' . $anuncio['id']);
            $item->appendChild($itemGuid);
    
            $channel->appendChild($item);
        }
    
        // Salida XML
        echo $dom->saveXML();
    }
    
    
    public function generarAtom() {
        header("Content-Type: application/atom+xml; charset=UTF-8");
        header('Content-Disposition: attachment; filename="feed.atom.xml"');
    
        // Recuperar anuncios
        $anuncios = Anuncio::getUltimos(5);
    
        // Crear el documento XML
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
    
        $feed = $dom->createElement('feed');
        $feed->setAttribute('xmlns', 'http://www.w3.org/2005/Atom');
        $dom->appendChild($feed);
    
        // Elementos generales
        $title = $dom->createElement('title', 'Roofscout.one - Anuncios');
        $feed->appendChild($title);
    
        $link = $dom->createElement('link');
        $link->setAttribute('href', 'http://roofscout.one/');
        $feed->appendChild($link);
    
        $updated = $dom->createElement('updated', date(DATE_ATOM));
        $feed->appendChild($updated);
    
        $author = $dom->createElement('author');
        $name = $dom->createElement('name', 'Mi Sitio');
        $author->appendChild($name);
        $feed->appendChild($author);
    
        $id = $dom->createElement('id', 'http://roofscout.one/');
        $feed->appendChild($id);
    
        // Entradas de anuncios
        foreach ($anuncios as $anuncio) {
            $entry = $dom->createElement('entry');
    
            $entryTitle = $dom->createElement('title', htmlspecialchars($anuncio['titulo']));
            $entry->appendChild($entryTitle);
    
            $entryLink = $dom->createElement('link');
            $entryLink->setAttribute('href', 'http://roofscout.one/anuncio/' . $anuncio['id']);
            $entry->appendChild($entryLink);
    
            $entryId = $dom->createElement('id', 'http://roofscout.one/anuncio/' . $anuncio['id']);
            $entry->appendChild($entryId);
    
            $entryUpdated = $dom->createElement('updated', date(DATE_ATOM, strtotime($anuncio['fecha'])));
            $entry->appendChild($entryUpdated);
    
            $entrySummary = $dom->createElement('summary', htmlspecialchars($anuncio['descripcion']));
            $entry->appendChild($entrySummary);
    
            $feed->appendChild($entry);
        }
    
        // Salida XML
        echo $dom->saveXML();
    }
    
    
}