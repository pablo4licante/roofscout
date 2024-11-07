<?php

require_once("./src/models/dbModel.php");

class Usuario {
    public static function getUsuario($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function checkCredentials($email, $password) {
        $sql = 'SELECT * FROM usuarios WHERE email = :email AND password = :password';
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function nuevoUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil) {
    
    $sql = "INSERT INTO usuarios (email, password, nombre, sexo, fecha_nacimiento, ciudad, pais, foto_perfil) 
        VALUES (:email, :password, :nombre, :sexo, :fecha_nacimiento, :ciudad, :pais, :foto_perfil)";
    $db = DB::getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindValue(':sexo', $sexo, PDO::PARAM_STR);
    $stmt->bindValue(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
    $stmt->bindValue(':ciudad', $ciudad, PDO::PARAM_STR);
    $stmt->bindValue(':pais', $pais, PDO::PARAM_STR);
    $stmt->bindValue(':foto_perfil', $foto_perfil, PDO::PARAM_STR);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    }
}