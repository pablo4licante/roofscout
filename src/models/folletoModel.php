<?php

require_once "./src/models/dbModel.php";

class Folleto {
    public static function nuevaSolicitud($nombre, $email, $calle, $numero, $piso, $codigoPostal, $localidad, $provincia, $pais, $telefono, $colorPortada, $numCopias, $resolucion, $anuncio, $fechaRecepcion, $impresionColor, $impresionPrecio, $textoAdicional, $precio) {
        $sql = "INSERT INTO solicitudes (anuncio, texto, nombre, email, calle, numero, piso, codigo_postal, localidad, provincia, pais, telefono, color, copias, resolucion, fecha, icolor, iprecio, fregistro, coste) 
            VALUES (:anuncio, :texto, :nombre, :email, :calle, :numero, :piso, :codigo_postal, :localidad, :provincia, :pais, :telefono, :color, :copias, :resolucion, :fecha, :icolor, :iprecio, NOW(), :coste)";
        
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':anuncio', $anuncio, PDO::PARAM_STR);
        $stmt->bindValue(':texto', $textoAdicional, PDO::PARAM_STR);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':calle', $calle, PDO::PARAM_STR);
        $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindValue(':piso', $piso, PDO::PARAM_STR);
        $stmt->bindValue(':codigo_postal', $codigoPostal, PDO::PARAM_STR);
        $stmt->bindValue(':localidad', $localidad, PDO::PARAM_STR);
        $stmt->bindValue(':provincia', $provincia, PDO::PARAM_STR);
        $stmt->bindValue(':pais', $pais, PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindValue(':color', $colorPortada, PDO::PARAM_STR);
        $stmt->bindValue(':copias', $numCopias, PDO::PARAM_STR);
        $stmt->bindValue(':resolucion', $resolucion, PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $fechaRecepcion, PDO::PARAM_STR);
        $stmt->bindValue(':icolor', $impresionColor, PDO::PARAM_STR);
        $stmt->bindValue(':iprecio', $impresionPrecio, PDO::PARAM_STR);
        $stmt->bindValue(':coste', $precio, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }
}

