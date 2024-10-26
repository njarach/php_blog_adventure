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

    /**
     * @throws Exception
     */
    public function createComment(string $content, int $userId, int $postId): Comment
    {
        $newComment = new Comment();
        try {
            if ($content && $postId) {
                $newComment->setContent($content);
                $newComment->setPostId($postId);
                $newComment->setUserId($userId);
                $newComment->setReviewed(false);
                $this->commentRepository->add($newComment);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $newComment;
    }

    /**
     * @throws Exception
     */
    public function edit(string $content, int $id): Comment
    {
        try {
            $existingComment = $this->commentRepository->findById($id);
            if ($existingComment) {
                $existingComment->setContent($content);

                $this->commentRepository->edit($existingComment);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $existingComment;
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
    public function reviewComment(int $id): Comment
    {
        try {
            $comment = $this->commentRepository->findOneBy(['id' => $id]);
            if ($comment) {
                $comment->setReviewed(true);


                $this->commentRepository->edit($comment);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $comment;
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
        $reviewedComments = $this->commentRepository->findBy(['reviewed' => true]);
        if (!empty($reviewedComments)) {
            return $reviewedComments;
        } else {
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