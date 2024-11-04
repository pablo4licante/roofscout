<?php

require_once("./src/models/db.php");

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
}