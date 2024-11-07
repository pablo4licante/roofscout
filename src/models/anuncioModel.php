<?php

require_once("./src/models/dbModel.php");
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

    public static function getResultados($queryParams) {
        
        $sql = "SELECT * FROM anuncios ";
        
        $conditions = [];
        $params = [];

        $fields = [
            'query' => 'titulo LIKE :query', // Aqui query es el titulo
            'tipo_anuncio' => 'tipo_anuncio = :tipo_anuncio',
            'tipo_vivienda' => 'tipo_vivienda = :tipo_vivienda',
            'ciudad' => 'ciudad = :ciudad',
            'pais' => 'pais = :pais'
        ];

        foreach ($fields as $key => $condition) {
            if (!empty($queryParams[$key])) {
            if ($key == 'query') {
                $conditions[] = $condition;
                $params[":$key"] = '%' . $queryParams[$key] . '%';
            } else {
                $conditions[] = $condition;
                $params[":$key"] = $queryParams[$key];
            }
            }
        }

        // Casos especiales porque hay que usar un valor entre dos valores
        if (!empty($queryParams['precio_min'])) {
            $conditions[] = "precio >= :precio_min";
            $params[':precio_min'] = $queryParams['precio_min'];
        }

        if (!empty($queryParams['precio_max'])) {
            $conditions[] = "precio <= :precio_max";
            $params[':precio_max'] = $queryParams['precio_max'];
        }

        if (!empty($queryParams['fecha_inicio'])) {
            $conditions[] = "fecha_publi >= :fecha_inicio";
            $params[':fecha_inicio'] = $queryParams['fecha_inicio'];
        }

        if (!empty($queryParams['fecha_fin'])) {
            $conditions[] = "fecha_publi <= :fecha_fin";
            $params[':fecha_fin'] = $queryParams['fecha_fin'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $db = DB::getConnection();
        $stmt = $db->prepare($sql);

        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val);
        }
        $sql .= " ORDER BY fecha_publi DESC";

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

    public static function getAnuncio($id) {
        $sql = "SELECT * FROM anuncios WHERE id = :id";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return []; // Devuelve un array vacío en caso de error
        }
    }

    public static function nuevoAnuncio($data) {
        $sql = "INSERT INTO anuncios (titulo, descripcion, tipo_anuncio, tipo_vivienda, ciudad, pais, precio, fecha_publi, superficie, habitaciones, aseos, planta, anyo_construccion, usuario) 
            VALUES (:titulo, :descripcion, :tipo_anuncio, :tipo_vivienda, :ciudad, :pais, :precio, NOW(), :superficie, :habitaciones, :aseos, :planta, :anyo_construccion, :usuario)";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':titulo', $data['titulo'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':tipo_anuncio', $data['tipo_anuncio'], PDO::PARAM_STR);
        $stmt->bindValue(':tipo_vivienda', $data['tipo_vivienda'], PDO::PARAM_STR);
        $stmt->bindValue(':ciudad', $data['ciudad'], PDO::PARAM_STR);
        $stmt->bindValue(':pais', $data['pais'], PDO::PARAM_STR);
        $stmt->bindValue(':precio', $data['precio'], PDO::PARAM_INT);
        $stmt->bindValue(':superficie', $data['superficie'], PDO::PARAM_INT);
        $stmt->bindValue(':habitaciones', $data['habitaciones'], PDO::PARAM_INT);
        $stmt->bindValue(':aseos', $data['aseos'], PDO::PARAM_INT);
        $stmt->bindValue(':planta', $data['planta'], PDO::PARAM_INT);
        $stmt->bindValue(':anyo_construccion', $data['anyo_construccion'], PDO::PARAM_INT);
        $stmt->bindValue(':usuario', 'pablo@example.com', PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }
}