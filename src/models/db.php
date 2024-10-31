<?php

class DB {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = 'localhost';    
        $dbname = 'roofscout'; 
        $port = '6900'; 
        $username = 'root';             
        $password = '';

        try {
            $this->connection = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ha fallado la conexion con la base de datos: " . $e->getMessage();
        }
    }

    public static function getConnection() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance->connection;
    }
}
