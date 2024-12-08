<?php

require_once("./src/models/dbModel.php");
class Foto {
    public static function getUltimos($limit = 5) {

        $sql = "SELECT * FROM fotos ORDER BY id DESC LIMIT :limit";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function getResultados($queryParams) {
        
        $sql = "SELECT * FROM fotos ";
        
        $conditions = [];
        $params = [];

        $fields = [
            'url' => 'url LIKE :url',
            'anuncio' => 'anuncio = :anuncio',
            'alt' => 'alt LIKE :alt'
        ];

        foreach ($fields as $key => $condition) {
            if (!empty($queryParams[$key])) {
                $conditions[] = $condition;
                $params[":$key"] = '%' . $queryParams[$key] . '%';
            }
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $db = DB::getConnection();
        $stmt = $db->prepare($sql);

        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }
        $sql .= " ORDER BY id DESC";

        if ($stmt->execute()) {

            if(count($conditions) > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return []; // Si no se ha especificado ningun filtro == no se ha buscado nada
            }
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function getFoto($id) {
        $sql = "SELECT * FROM fotos WHERE id = :id";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function nuevaFoto($data) {
        $sql = "INSERT INTO fotos (url, anuncio, alt, principal) 
            VALUES (:url, :anuncio, :alt, 0)";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':url', $data['url'], PDO::PARAM_STR);
        $stmt->bindValue(':anuncio', $data['anuncio'], PDO::PARAM_INT);
        $stmt->bindValue(':alt', $data['alt'], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }

    public static function getFotosPorAnuncio($anuncio) {
        $sql = "SELECT * FROM fotos WHERE anuncio = :anuncio ORDER BY id DESC";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':anuncio', $anuncio, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function eliminarFoto($id) {
        $sql = "DELETE FROM fotos WHERE id = :id";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function hacerPrincipal($id) {
        $sql = "UPDATE fotos SET principal = 0 WHERE anuncio = (SELECT anuncio FROM fotos WHERE id = :id);
                UPDATE fotos SET principal = 1 WHERE id = :id";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
