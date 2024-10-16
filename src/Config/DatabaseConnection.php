<?php

namespace src\Config;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $instance = null;
    public static function getInstance(): ?PDO
    {
        if (is_null(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=php_blog_adventure', 'root', '');
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}