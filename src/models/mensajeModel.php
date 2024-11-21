<?php

require_once("./src/models/dbModel.php");

class Mensaje {
    public static function nuevoMensaje($emisor, $receptor, $mensaje, $anuncio, $tipo_mensaje) {
        $sql = "INSERT INTO mensajes (emisor, receptor, mensaje, anuncio, fecha_hora, tipo_mensaje) VALUES (:emisor, :receptor, :mensaje, :anuncio, NOW(), :tipo_mensaje)";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':emisor', $emisor, PDO::PARAM_STR);
        $stmt->bindValue(':receptor', $receptor, PDO::PARAM_STR);
        $stmt->bindValue(':mensaje', $mensaje, PDO::PARAM_STR);
        $stmt->bindValue(':anuncio', $anuncio, PDO::PARAM_INT);
        $stmt->bindValue(':tipo_mensaje', $tipo_mensaje, PDO::PARAM_STR);
        
        if($stmt->execute())
            return true;
        else
            return false; 
    }

    public static function getMensajesByAnuncio($anuncio) {
        $sql = "SELECT * FROM mensajes WHERE anuncio = :anuncio ORDER BY fecha_hora DESC";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':anuncio', $anuncio, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function getMensajesByReceptor($receptor) {
        $sql = "SELECT * FROM mensajes WHERE receptor = :receptor ORDER BY fecha_hora DESC";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':receptor', $receptor, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function getMensajesByEmisor($emisor) { 
        $sql = "SELECT * FROM mensajes WHERE emisor = :emisor ORDER BY fecha_hora DESC";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':emisor', $emisor, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

}