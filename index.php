<?php

require_once 'vendor/autoload.php';

use src\controller\BlogPostController;
use src\controller\ErrorController;

// Start new session if no instance
session_start();

// Instantiate the Controllers
$blogPostController = new BlogPostController();
$errorController = new ErrorController();
$authenticationController = new \src\controller\AuthenticationController();

// Get the URL path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// This is the response code by default
$error_response_code = 200;

// Route the request based on the URL path
try {
    // Route the request based on the URL path
    switch ($path) {
        case '/php_blog_adventure/login':
            $authenticationController->login();
            break;
        case '/php_blog_adventure/logout':
            $authenticationController->logout();
            break;
        case '/php_blog_adventure/register':
            $authenticationController->register();
            break;
        case '/php_blog_adventure/blogposts':
            // Show all blog posts
            $blogPostController->index();
            break;
        case '/php_blog_adventure/blogpost':
            // Show a specific blog post
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $postId = $_GET['id'] ?? null;
                $blogPostController->show($postId);
            } else {
                // Invalid request method
                $error_response_code = http_response_code(405);
                throw new Exception("La méthode $_SERVER[REQUEST_METHOD] n'est pas autorisée.");
            }
            break;
        case '/php_blog_adventure/blogpost/edit':
            // Edit a specific blog post
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//                logic
            } else {
                // Invalid request method
                $error_response_code = http_response_code(405);
                throw new Exception("La méthode $_SERVER[REQUEST_METHOD] n'est pas autorisée.");
            }
            break;
        case '/php_blog_adventure/blogpost/add':
            // Add a new blog post
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//                logic
            } else {
                // Invalid request method
                $error_response_code = http_response_code(405);
                throw new Exception("La méthode $_SERVER[REQUEST_METHOD] n'est pas autorisée.");
            }
            break;
        case '/php_blog_adventure/blogpost/delete':
            // Delete a specific blog post
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
//                logic
            } else {
                // Invalid request method
                $error_response_code = http_response_code(405);
                throw new Exception("La méthode $_SERVER[REQUEST_METHOD] n'est pas autorisée.");
            }
            break;
        case '/php_blog_adventure/comment/add':
            if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//                logic
                } else {
                    // Invalid request method
                    $error_response_code = http_response_code(405);
                    throw new Exception("La méthode $_SERVER[REQUEST_METHOD] n'est pas autorisée.");
                }
            } else {
                throw new Exception('Vous devez être connecté pour ajouter un commentaire');
            }
            break;
        case '/php_blog_adventure/comment/review':
            // Review a comment (admin action)
            if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                // User is logged in as admin
            } else {
                throw new Exception("Vous devez être connecté en tant qu'administrateur pour effectuer cette action.");
            }
            break;
        default:
            // Handle 404 Not Found. We assign 404
            http_response_code(404);
            $error_response_code = 404;
            throw new Exception("La page que vous recherchez n'existe pas.");
    }
} catch (Exception $e) {
    $errorController->show($e, $error_response_code);
}