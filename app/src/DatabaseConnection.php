<?php

namespace src;

use PDOException;

class DatabaseConnection
{
//   We use static keywords in this class to access properties and methods without needing to instantiate the class beforehand.
    private static DatabaseConnection|null $instance = null;
    private static \PDO $connection;

//    This method is used to check if instance of DatabaseConnection was already created, creates one if none.
    public static function getInstance(): ?DatabaseConnection
    {
        if (is_null(self::$instance)){
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

    public static function connect($host, $dbName, $user, $password): void
    {
        try {
            self::$connection = new \PDO("mysql:dbname=$dbName;host=$host", $user, $password);
        } catch(PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getConnection(): \PDO
    {
        return self::$connection;
    }

}