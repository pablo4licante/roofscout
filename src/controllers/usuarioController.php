<?php

require_once("./src/models/usuarioModel.php");
require_once("./src/models/anuncioModel.php");
require_once("./src/models/temaModel.php");

class UsuarioController {

    public function perfil($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            header('Location: /');
        }
        $usuario = Usuario::getUsuario($email);
        $anuncios = Anuncio::getAnunciosPorUsuario($email);
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        $paises = Paises::getPaises();
        include_once("./src/views/perfil.php");
    }

    public function paginaTemas() {
        $temas = Temas::getTemas();
        include_once("./src/views/seleccionTema.php");
    }
    
    public function seleccionarTema($numeroTema) {
        Temas::setTema($numeroTema);
        $_SESSION['tema'] = Temas::getTema()['fichero'];
        header('Location: /perfil/' . $_SESSION['user']);
    }

    public function paginaMisDatos() {
        $tipos_anuncio = Tipos::getTipoAnuncio();
        $tipos_vivienda = Tipos::getTipoVivienda();
        $paises = Paises::getPaises();
        $usuario = Usuario::getUsuario($_SESSION['user']);
        include_once("./src/views/modificarDatos.php");
    }

    public function eliminarFotoPerfil() {
        Usuario::eliminarFotoPerfil();
        $_SESSION['flashdata'] = "Foto de perfil eliminada correctamente.";
        header('Location: /perfil/' . $_SESSION['user']);
    }
    public function exportarUsuarioRSS() {
        header("Content-Type: application/rss+xml; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $_SESSION['user'] . '.rss.xml"');
    
        // Obtener información del usuario
        $usuario = Usuario::getUsuario($_SESSION['user']);
        if (!$usuario) {
            http_response_code(404);
            echo "Usuario no encontrado.";
            return;
        }
    
        // Obtener los anuncios del usuario
        $anuncios = Anuncio::getAnunciosPorUsuario($usuario['email']);
    
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
    
        // Información del canal
        $channel->appendChild($dom->createElement('title', "Anuncios de " . htmlspecialchars($usuario['nombre'])));
        $channel->appendChild($dom->createElement('link', "https://roofscout.one/perfil/" . $usuario['email']));
        $channel->appendChild($dom->createElement('description', "Información del usuario y sus anuncios"));
    
        // Información del usuario
        $userInfo = "Nombre: " . htmlspecialchars($usuario['nombre']) . "\n" .
                    "Email: " . htmlspecialchars($usuario['email']) . "\n" .
                    "Sexo: " . htmlspecialchars($usuario['sexo']) . "\n" .
                    "Fecha de nacimiento: " . htmlspecialchars($usuario['fecha_nacimiento']) . "\n" .
                    "Ciudad: " . htmlspecialchars($usuario['ciudad']) . "\n" .
                    "País: " . htmlspecialchars($usuario['pais']);
        $channel->appendChild($dom->createElement('description', htmlspecialchars($userInfo)));
    
        // Agregar cada anuncio como <item>
        foreach ($anuncios as $anuncio) {
            $item = $dom->createElement('item');
            $item->appendChild($dom->createElement('title', htmlspecialchars($anuncio['titulo'])));
            $item->appendChild($dom->createElement('link', "https://roofscout.one/anuncio/" . htmlspecialchars($anuncio['id'])));
            $item->appendChild($dom->createElement('guid', "https://roofscout.one/anuncio/" . htmlspecialchars($anuncio['id'])));
            $description = "";
            $fields = ['descripcion', 'tipo_anuncio', 'tipo_vivienda', 'ciudad', 'pais', 'precio', 'superficie', 'habitaciones', 'aseos', 'planta', 'anyo_construccion'];
            foreach ($fields as $field) {
                if (isset($anuncio[$field])) {
                    $description .= ucfirst(str_replace('_', ' ', $field)) . ": " . htmlspecialchars($anuncio[$field]) . "\n";
                }
            }
            $item->appendChild($dom->createElement('description', htmlspecialchars($description)));
            $channel->appendChild($item);
        }
    
        echo $dom->saveXML();
    }
    
    public function exportarUsuarioAtom() {
        header("Content-Type: application/atom+xml; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $_SESSION['user'] . '.atom.xml"');
    
        // Obtener información del usuario
        $usuario = Usuario::getUsuario($_SESSION['user']);
        if (!$usuario) {
            http_response_code(404);
            echo "Usuario no encontrado.";
            return;
        }
    
        // Obtener los anuncios del usuario
        $anuncios = Anuncio::getAnunciosPorUsuario($usuario['email']);
    
        // Crear el documento XML
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
    
        // Nodo raíz <feed>
        $feed = $dom->createElement('feed');
        $feed->setAttribute('xmlns', 'http://www.w3.org/2005/Atom');
        $dom->appendChild($feed);
    
        // Información básica del feed
        $feed->appendChild($dom->createElement('title', "Anuncios de " . htmlspecialchars($usuario['nombre'])));
        $feed->appendChild($dom->createElement('link', "https://roofscout.one/perfil/" . $usuario['email']));
        $feed->appendChild($dom->createElement('updated', date(DATE_ATOM)));
    
        // Información del usuario como autor
        $author = $dom->createElement('author');
        $author->appendChild($dom->createElement('name', htmlspecialchars($usuario['nombre'])));
        $author->appendChild($dom->createElement('email', htmlspecialchars($usuario['email'])));
        $feed->appendChild($author);
    
        // Agregar cada anuncio como <entry>
        foreach ($anuncios as $anuncio) {
            $entry = $dom->createElement('entry');
            $entry->appendChild($dom->createElement('title', htmlspecialchars($anuncio['titulo'])));
            $entry->appendChild($dom->createElement('link', "https://roofscout.one/anuncio/" . htmlspecialchars($anuncio['id'])));
            $entry->appendChild($dom->createElement('id', "https://roofscout.one/anuncio/" . htmlspecialchars($anuncio['id'])));
            $entry->appendChild($dom->createElement('updated', date(DATE_ATOM)));
    
            $summary = "";
            $fields = ['descripcion', 'tipo_anuncio', 'tipo_vivienda', 'ciudad', 'pais', 'precio', 'superficie', 'habitaciones', 'aseos', 'planta', 'anyo_construccion'];
            foreach ($fields as $field) {
                if (isset($anuncio[$field])) {
                    $summary .= ucfirst(str_replace('_', ' ', $field)) . ": " . htmlspecialchars($anuncio[$field]) . "\n";
                }
            }
            $entry->appendChild($dom->createElement('summary', htmlspecialchars($summary)));
            $feed->appendChild($entry);
        }
    
        echo $dom->saveXML();
    }    
        
}