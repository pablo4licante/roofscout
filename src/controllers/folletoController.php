<?php
require_once('./src/models/folletoModel.php');

class FolletoController {
    public function solicitarFolleto() {
        include_once('./src/views/solicitarFolleto.php');
    }

    public function mandarSolicitudFolleto() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $calle = $_POST['calle'];
        $numero = $_POST['numero'];
        $piso = $_POST['piso'];
        $codigoPostal = $_POST['codigo-postal'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];
        $telefono = $_POST['telefono'];
        $colorPortada = $_POST['color-portada'];
        $numCopias = $_POST['num-copias'];
        $resolucion = $_POST['resolucion'];
        $anuncio = $_POST['anuncio'];
        $fechaRecepcion = $_POST['fecha-recepcion'];
        $impresionColor = $_POST['impresion-color'];
        $impresionPrecio = $_POST['impresion-precio'];
        $textoAdicional = $_POST['texto-adicional'];
        $precio = $_POST['precio'];

        // Redirect to the response page
        header('Location: /respuesta-solicitar-folleto?' .
        'nombre=' . urlencode($nombre) . 
        '&email=' . urlencode($email) . 
        '&calle=' . urlencode($calle) . 
        '&numero=' . urlencode($numero) . 
        '&piso=' . urlencode($piso) . 
        '&codigo-postal=' . urlencode($codigoPostal) . 
        '&localidad=' . urlencode($localidad) . 
        '&provincia=' . urlencode($provincia) . 
        '&pais=' . urlencode($pais) . 
        '&telefono=' . urlencode($telefono) . 
        '&color-portada=' . urlencode($colorPortada) . 
        '&num-copias=' . urlencode($numCopias) . 
        '&resolucion=' . urlencode($resolucion) . 
        '&anuncio=' . urlencode($anuncio) . 
        '&fecha-recepcion=' . urlencode($fechaRecepcion) . 
        '&impresion-color=' . urlencode($impresionColor) . 
        '&impresion-precio=' . urlencode($impresionPrecio) . 
        '&texto-adicional=' . urlencode($textoAdicional) .
        '&precio=' . urlencode($precio));
    }

    public function respuestaSolicitarFolleto() {
        include_once('./src/views/respuestaSolicitudFolleto.php');
    }
}