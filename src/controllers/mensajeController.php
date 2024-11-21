<?php

require_once('./src/models/anuncioModel.php'); 
require_once('./src/models/usuarioModel.php');
require_once('./src/models/mensajeModel.php');

class MensajeController {
    public function escribirMensaje() {
        $mensaje = $_POST['mensaje'];
        $tipo_mensaje = $_POST['tipo_mensaje'];
        $anuncio_id = $_POST['anuncio_id'];
        $anuncio = Anuncio::getAnuncio($anuncio_id);
        $receptor = Usuario::getUsuario($anuncio['usuario']);
        $emisor = $_SESSION['user'];

        if(Mensaje::nuevoMensaje($emisor, $receptor['email'], $mensaje, $anuncio_id, $tipo_mensaje)) {
            $_SESSION['flashdata'] = 'Mensaje enviado con exito!';
            header('Location: /anuncio/' . $anuncio_id);
        }
        else {
            $_SESSION['flashdata'] = 'No se ha podido enviar el mensaje.';
            header('Location: /anuncio/' . $anuncio_id);
        }
    }

    public function misMensajes() {
        $tipos_mensaje = Tipos::getTipoMensaje();
        $email = $_SESSION['user']; 
        $mensajes_recibidos = Mensaje::getMensajesByReceptor($email);
        $mensajes_enviados = Mensaje::getMensajesByEmisor($email);
        include_once './src/views/mensajes.php';
    }

    public function mensajesPorAnuncio($idAnuncio) {
        
        $tipos_mensaje = Tipos::getTipoMensaje();
        $anuncio = Anuncio::getAnuncio($idAnuncio);
        if($_SESSION['user'] == $anuncio['usuario']) {
            $mensajes = Mensaje::getMensajesByAnuncio($idAnuncio);
            include_once './src/views/mensajes_anuncio.php';
        }
        else {
            header('Location: /anuncio/' . $idAnuncio);
        }
    }
}