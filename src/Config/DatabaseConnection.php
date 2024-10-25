<?php

namespace src\Config;

use Exception;
use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $instance = null;

    /**
     * @throws Exception
     */
    public static function getInstance(): ?PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=php_blog_adventure', 'root', '');
            } catch (PDOException $e) {
                throw new Exception('Erreur de connexion à la base de données.');
            }
        }
        return self::$instance;
    }
}