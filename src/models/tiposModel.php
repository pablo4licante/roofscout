<?php

require_once("./src/models/dbModel.php");

class Tipos
{
    public static function getTipoVivienda()
    {
        $sql = "SELECT * FROM tipo_vivienda";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        } 
    }

    public static function getTipoAnuncio()
    {
        $sql = "SELECT * FROM tipo_anuncio";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        } 
    }

    // --------------------------------------------------------------

    public static function getTipoMensaje()
    {
        $sql = "SELECT * FROM tipo_mensaje";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        } 
    }
}