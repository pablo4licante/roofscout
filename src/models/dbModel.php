<?php

class DB {
    private static $instance = null;
    private $connection;

    private function __construct() {
        
        $host = 'sql101.infinityfree.com';    
        $dbname = 'if0_37316886_roofscoutDB'; 
        $port = '3306'; 
        $username = 'if0_37316886';     // TODO: Crear usuario con password        
        $password = 'jQFsQZWSRwmZgfj';
        
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


    public static function closeConnection() {
        if (self::$instance !== null) {
            self::$instance->connection = null;  
            self::$instance = null;
        }
    }

}
