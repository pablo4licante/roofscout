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
        $emisor = "pablo@example.com"; // TODO cambiar por el usuario logueado $_SESSION['usuario']

        if(Mensaje::nuevoMensaje($emisor, $receptor['email'], $mensaje, $anuncio_id, $tipo_mensaje))
            header('Location: /anuncio/' . $anuncio_id .'?mensaje=ok');
        else
            header('Location: /anuncio/' . $anuncio_id .'?mensaje=error');
    }

    public function misMensajes() {
        $email = 'pablo@example.com'; // TODO cambiar por el usuario logueado $_SESSION['usuario']
        $mensajes_recibidos = Mensaje::getMensajesByReceptor($email);
        $mensajes_enviados = Mensaje::getMensajesByEmisor($email);
        include_once './src/views/mensajes.php';
    }
}