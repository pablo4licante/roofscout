<?php

require_once("./src/models/dbModel.php");

class Paises
{
    public static function getPaises()
    {
        $sql = "SELECT * FROM paises";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        } 
    }
}