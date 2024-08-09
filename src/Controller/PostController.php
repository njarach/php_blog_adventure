<?php
namespace src\controller;

use Exception;
use src\Service\Manager\CommentManager;
use src\Service\Manager\PostManager;

class PostController extends AbstractController
{
    private PostManager $postManager;
    private CommentManager $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }

    /**
     * @throws Exception
     */
    public function index() {
        $blogPosts = $this->postManager->findAll();
       echo $this->render('blogpost/index.html.twig', [
           'posts'=>$blogPosts
       ]);
    }

    /**
     * @throws Exception
     */
    public function show(int $postId) {
        $blogPost = $this->postManager->findById($postId);
        if ($blogPost) {
            $authorName = $this->postManager->getAuthorName($blogPost->getAuthorId());
            $comments = $this->commentManager->getPostComments($postId);
            echo $this->render('blogpost/show.html.twig', [
                'post' => $blogPost,
                'authorName'=>$authorName,
                'comments'=>$comments
            ]);
        } else {
            http_response_code(404);
            echo $this->render('error/error.html.twig', [
                'errorCode'=>404,
                'errorMessage'=>"Aucun article trouvé pour l'id $postId..."
            ]);
        }
    }
}