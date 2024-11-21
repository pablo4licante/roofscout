<?php

require_once("./src/models/dbModel.php");

class Usuario
{
    public static function getUsuario($email)
    {
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

    public static function checkCredentials($email, $password)
    {
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

    public static function nuevoUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)
    {

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

    public static function modificarUsuario($email, $password, $nombre, $sexo, $fecha_nacimiento, $ciudad, $pais, $foto_perfil)
    {
        $sql_check = "SELECT COUNT(*) FROM usuarios WHERE email = :nuevo_email";
        $db = DB::getConnection();
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindValue(':nuevo_email', $email, PDO::PARAM_STR);
        $stmt_check->execute();
        
        if ($stmt_check->fetchColumn() > 0) {
            return false;
        }
        
        $sql = "UPDATE usuarios 
                SET email = :nuevo_email, 
                    password = :password, 
                    nombre = :nombre, 
                    sexo = :sexo, 
                    fecha_nacimiento = :fecha_nacimiento, 
                    ciudad = :ciudad, 
                    pais = :pais, 
                    foto_perfil = :foto_perfil 
                WHERE email = :email";
        
        $stmt = $db->prepare($sql);
    
        $stmt->bindValue(':email', $_SESSION['user'], PDO::PARAM_STR);
        $stmt->bindValue(':nuevo_email', $email, PDO::PARAM_STR);
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



    public static function updateUltimaConexion()
    {
        $email = isset($_COOKIE['user']) ? $_COOKIE['user'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);
        if ($email === null) {
            return false;
        }

        $sql = "UPDATE usuarios SET ultimaConexion = NOW() WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function getUltimaConexion()
    {

        $email = isset($_COOKIE['user']) ? $_COOKIE['user'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);
        if ($email === null) {
            return false;
        }
        $sql = "SELECT ultimaConexion FROM usuarios WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            return null;
        }
    }

    public static function getTema()
    {
        $email = isset($_COOKIE['user']) ? $_COOKIE['user'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);
        if ($email === null) {
            return false;
        }
        $sql = "SELECT tema FROM usuarios WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            return null;
        }
    }

    public static function setTema($tema)
    {
        $email = isset($_COOKIE['user']) ? $_COOKIE['user'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);
        if ($email === null) {
            return false;
        }
        $sql = "UPDATE usuarios SET tema = :tema WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tema', $tema, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }
}