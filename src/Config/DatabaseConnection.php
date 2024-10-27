<?php

namespace src\Config;

use Exception;
use PDO;
use PDOException;

define('DB_HOST', 'localhost');
define('DB_NAME', 'php_blog_adventure');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

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
                self::$instance = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASSWORD
                );
            } catch (PDOException $e) {
                throw new Exception('Erreur de connexion à la base de données.');
            }
        }
        return self::$instance;
    }
}
