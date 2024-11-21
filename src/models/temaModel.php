<?php

require_once("./src/models/dbModel.php");

class Temas
{
    public static function getTemas()
    {
        $sql = "SELECT * FROM temas";
        $db = DB::getConnection();
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        } 
    }
}