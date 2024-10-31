<?php

require_once("./src/models/db.php");
class Anuncio {
    public static function getUltimos($limit = 5) {

        $sql = "SELECT * FROM anuncios ORDER BY fecha_publi DESC LIMIT :limit";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }
}