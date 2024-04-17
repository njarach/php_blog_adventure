<?php

use src\DatabaseConnection;

require_once 'src/DatabaseConnection.php';

$host = 'localhost';
$dbname = 'php_blog_adventure';
$username = 'root';
$password = '';

// Connect to the database
DatabaseConnection::connect($host,$dbname,$username,$password);

// Routing to the stuff the user wants to do
