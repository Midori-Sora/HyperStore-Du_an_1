<?php
require_once './models/commentModel.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    public static function commentController() {
        try {
            $model = new CommentModel();
            $comments = $model->getCommentList();
            require_once './views/comment/comment.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function deleteCommentController() {
        try {
            if (!isset($_GET['id'])) {  
                throw new Exception("ID không hợp lệ");
            }

            $model = new CommentModel();
            if ($model->deleteComment($_GET['id'])) {
                $_SESSION['success'] = "Xóa bình luận thành công";
            } else {
                throw new Exception("Xóa bình luận thất bại");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: index.php?action=comment');
        exit();
    }

    public static function updateCommentStatusController() {
        header('Content-Type: application/json');
        try {
            if (!isset($_POST['id'], $_POST['status'])) {
                throw new Exception("Dữ liệu không hợp lệ");
            }

            $model = new CommentModel();
            $result = $model->updateCommentStatus($_POST['id'], $_POST['status']);
            
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit();
    }
}
