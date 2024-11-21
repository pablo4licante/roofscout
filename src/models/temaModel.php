<?php

require_once("./src/models/dbModel.php");

class Temas
{
    public static function getTema()
    {
        $email = isset($_COOKIE['user']) ? $_COOKIE['user'] : (isset($_SESSION['user']) ? $_SESSION['user'] : null);
        if ($email === null) {
            return false;
        }
        $sql = "SELECT t.* FROM usuarios u JOIN temas t WHERE email = :email AND t.id = u.tema";
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
        $sql = "UPDATE usuarios u SET u.tema = t.id WHERE email = :email AND t.id = :tema";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tema', $tema, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function getTemas() {
        $sql = "SELECT * FROM temas";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            return null;
        }
    }
}