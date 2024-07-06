<?php

namespace src\controller\AdminController;

use Exception;
use src\Service\Manager\PostManager;

class PostController extends CrudController
{
    private PostManager $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    // check role and authorization in service ?
    public function index()
    {
//        here add logic so an admin can view all the blogposts for easier management
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        // TODO : déplacer checkpost vers le manager
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TODO : erreur = array, pour cibler quel input n'est pas valide. Rassembler les check dans une fonction, compter les erreurs, if count error > 1, ...

            $title = $this->checkPost($_POST['title']) ? $_POST['title'] : null;
            $content = $this->checkPost($_POST['content']) ? $_POST['content'] : null;
            $categoryId = $this->checkPost($_POST['category_id']) ? $_POST['category_id'] : null;
            $intro = $this->checkPost($_POST['intro']) ? $_POST['intro'] : null;

            if ($title && $content && $categoryId && $intro) {
                $this->postManager->createPost($title, $content, $categoryId, $intro);
                echo $this->render('blogpost/index.html.twig', [
                    'posts' => $this->postManager->findAll()
                ]);
            } else {
                // TODO : renvoyer les éléments déjà remplis par l'user, soit un tableau (voir le tableau d'erreur, faire un tableau de valeur dans la foulée)
                $categories = $this->postManager->getAllCategories();
                echo $this->render('blogpost/new.html.twig', [
                    'categories' => $categories,
                    'error' => 'All fields are required and cannot be empty or spaces.'
                ]);
            }
        } else {
            // Fetch all categories to display them in the form
            $categories = $this->postManager->getAllCategories();
            echo $this->render('blogpost/new.html.twig', [
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function edit(int $postId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $this->checkPost($_POST['title']) ? $_POST['title'] : null;
            $content = $this->checkPost($_POST['content']) ? $_POST['content'] : null;
            $categoryId = $this->checkPost($_POST['category_id']) ? $_POST['category_id'] : null;
            $intro = $this->checkPost($_POST['intro']) ? $_POST['intro'] : null;

            if ($title && $content && $categoryId && $intro) {
                $this->postManager->edit($postId, $title, $content, $categoryId, $intro);
                echo $this->render('blogpost/index.html.twig', [
                    'posts' => $this->postManager->findAll()
                ]);
            } else {
                $categories = $this->postManager->getAllCategories();
                $post = $this->postManager->findById($postId);
                echo $this->render('blogpost/edit.html.twig', [
                    'post' => $post,
                    'categories' => $categories,
                    'error' => 'All fields are required and cannot be empty or spaces.'
                ]);
            }
        } else {
            // Fetch the post and categories to display them in the form
            $categories = $this->postManager->getAllCategories();
            $post = $this->postManager->findById($postId);
            echo $this->render('blogpost/edit.html.twig', [
                'post' => $post,
                'categories' => $categories
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $postId)
    {
        $post = $this->postManager->findById($postId);
        $this->postManager->delete($post);
        echo "Post $postId supprimé";
        echo $this->render('blogpost/index.html.twig',[
            'posts'=>$this->postManager->findAll()
        ]);
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
    }
    private function checkPost($data): bool
    {
        return isset($data) && !empty(trim($data));
    }
}