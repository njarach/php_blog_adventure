<?php

namespace src\controller\AdminController;

use Exception;
use src\model\Post;
use src\Repository\PostRepository;

class PostController extends CrudController
{
    // check role and authorization in service ?
    public function index()
    {
//        here add logic so an admin can view all the blogposts for easier management
    }

    /**
     * @throws Exception
     */
    public function new()
    {
        $newPost = new Post();
//        $newPost->setId(9);
        $newPost->setContent('Nouveau post!');
        $newPost->setAuthorId(1);
//        $newPost->setId(8);
        $newPost->setCategoryId(1);
        $newPost->setTitle('Nouveau titre !');
//        $newPost->setContent('Nouveau post!');
        $postRepository = new PostRepository();
        $postRepository->add($newPost);
        echo 'nouvel article créé !';
    }

    /**
     * @throws Exception
     */
    public function edit(int $postId)
    {
        $postRepostiory = new PostRepository();
        $post = $postRepostiory->findById($postId);
        $post->setContent('Contenu modifié encore !');
        $post->setTitle('Titre modifié à nouveau !');
        $postRepostiory->edit($post);
        echo 'Post édite';
    }

    /**
     * @throws Exception
     */
    public function delete(int $postId)
    {
        $postRepostiory = new PostRepository();
        $post = $postRepostiory->findById($postId);
        $postRepostiory->delete($post);
        echo 'Post supprimé';
    }

    public function show(int $postId)
    {
        // TODO: Implement show() method.
    }
}