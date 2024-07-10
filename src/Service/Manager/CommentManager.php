<?php

namespace src\Service\Manager;

use Exception;
use src\model\Comment;
use src\Repository\CommentRepository;

class CommentManager
{
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    // To show a list of comments, maybe useful ?
    /**
     * @throws Exception
     */
    public function getLatestComments(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function getPostComments(int $postId): ?array
    {
        $comments = $this->commentRepository->findBy(['id_post'=>$postId]);
        if (!empty($comments)){
            return $comments;
        } else {
            return null;
        }
    }

    public function createNewComment(string $content, int $userId, int $postId): ?Comment
    {
        if ($content && $postId){
            $newComment = new Comment();
            $newComment->setContent($content);
            $newComment->setPostId($postId);
            // for now user id is 1 , will be added dynamically later when authentication is added
            $newComment->setUserId(1);
            // will add a condition if user is admin, it sets the reviewed to true automatically
            $newComment->setReviewed(false);
            try {
                $this->commentRepository->add($newComment);
            } catch (Exception $e) {
                echo 'Erreur: ' . $e->getMessage();
            }
            return $newComment;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function edit(string $content, int $id): ?Comment
    {
        $existingComment = $this->commentRepository->findById($id);

        if ($existingComment){
            $existingComment->setContent($content);

            try {
                $this->commentRepository->edit($existingComment);
            } catch (Exception $e) {
                echo 'Erreur: ' . $e->getMessage();
            }
            return $existingComment;
        } else {
            echo "Erreur: Il semblerait que le commentaire n'existe plus.";
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $comment = $this->commentRepository->findById($id);
        $this->commentRepository->delete($comment);
    }

    /**
     * @throws Exception
     */
    public function reviewComment(int $id): ?Comment
    {
        $comment = $this->commentRepository->findById($id);
        if ($comment){
            $comment->setReviewed(true);

            try {
                $this->commentRepository->edit($comment);
            } catch (Exception $e) {
                echo 'Erreur: ' . $e->getMessage();
            }
            return $comment;
        } else {
            echo "Erreur: Il semblerait que le commentaire n'existe plus.";
        }
        return null;
    }

}