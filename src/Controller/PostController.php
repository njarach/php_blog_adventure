<?php

namespace src\Controller;

use Exception;
use src\Service\Manager\PostManager;
use src\Service\Response;

class PostController extends AbstractController
{
    private PostManager $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $blogPosts = $this->postManager->findAll();
        return $this->render('blogpost/index.html.twig', [
            'posts' => $blogPosts
        ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId): Response
    {
        $blogPost = $this->postManager->findOneBy(['id' => $postId]);
        if ($blogPost) {
            return $this->render('blogpost/show.html.twig', [
                'post' => $blogPost,
            ]);
        } else {
            http_response_code(404);
            return $this->render('error/error.html.twig', [
                'errorCode' => 404,
                'errorMessage' => "Aucun article trouvé pour l'id $postId..."
            ]);
        }
    }
}