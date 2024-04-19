<?php

namespace src\config;

use PDO;
use PDOException;

class DatabaseConnection
{
//   We use static keywords in this class to access properties and methods without needing to instantiate the class beforehand.
    private static ?PDO $instance = null;
    public static function getInstance(): ?PDO
    {
        if (is_null(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=php_blog_adventure', 'root', '');
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}