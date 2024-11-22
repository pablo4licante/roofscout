<?php

require_once("./src/models/dbModel.php");

class Temas
{
    public static function getTema()
    {
        $sql = "SELECT * FROM temas t JOIN usuarios u on u.tema = t.id WHERE email = :email ";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $_SESSION['user'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return null;
        }
    }

    public static function setTema($tema)
    {
        $sql = "UPDATE usuarios u SET u.tema = :tema WHERE email = :email";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tema', $tema, PDO::PARAM_STR);
        $stmt->bindValue(':email', $_SESSION['user'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function getTemas() {
        $sql = "SELECT * FROM temas";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }
}