<?php

namespace src\Service\Manager;

use Exception;
use src\model\Comment;
use src\Repository\CommentRepository;

class CommentManager
{
    private CommentRepository $commentRepository;
    private array $commentErrors = [];

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    // To show a list of comments, maybe useful ?
    /**
     * @throws Exception
     */
    public function getAllComments(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function getPostComments(int $postId): array
    {
        $comments = $this->commentRepository->findBy(['post_id' => $postId]);
        return $comments ?: [];
    }

    public function createComment(string $content, int $userId, int $postId): ?Comment
    {
        if ($content && $postId){
            $newComment = new Comment();
            $newComment->setContent($content);
            $newComment->setPostId($postId);
            // for now user id is 1 , will be added dynamically later when authentication is added
            $newComment->setUserId($userId);
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
        $comment = $this->commentRepository->findOneBy(['id'=>$id]);
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

    public function validateCommentData(array $data): array
    {
        $commentErrors = $this->commentErrors;
        if (!$this->checkComment($data['content'])) {
            $commentErrors['content'] = 'Vous devez renseigner un contenu valide.';
        }

        return $commentErrors;
    }

    private function checkComment($data): bool
    {
        return isset($data) && !empty(trim($data));
    }

    /**
     * @throws Exception
     */
    public function getReviewedComments(): ?array
    {
        $reviewedComments = $this->commentRepository->findBy(['reviewed'=>true]);
        if (!empty($reviewedComments)){
            return $reviewedComments;
        }else{
            return null;
        }
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function getReviewSortedComments(): array
    {
        $comments = $this->getAllComments();
        $reviewedComments = [];
        $unreviewedComments = [];
        foreach ($comments as $comment) {
            if ($comment->isReviewed()) {
                $reviewedComments[] = $comment;
            } else {
                $unreviewedComments[] = $comment;
            }
        }
        return array($reviewedComments, $unreviewedComments);
    }
}