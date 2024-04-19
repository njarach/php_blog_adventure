<?php

require_once 'vendor/autoload.php';

use src\controller\BlogPostController;

// Instantiate the BlogPostController
$blogPostController = new BlogPostController();

// Get the URL path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request based on the URL path
switch ($path) {
    case '/php_blog_adventure/blogposts':
        // Call the index method of BlogPostController
        $blogPostController->index();
        break;
    case preg_match('/\/php_blog_adventure\/blogposts\/(\d+)/', $path, $matches) ? $matches[0] : false:
        // Extract postId from the URL and call the show method of BlogPostController
        $postId = $matches[1];
        $blogPostController->show($postId);
        break;
    default:
        // Handle 404 Not Found
        http_response_code(404);
        echo '404 Not Found';
}