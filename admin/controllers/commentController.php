<?php
require_once './models/commentModel.php';

class CommentController {
    public static function commentController() {
        $commentModel = new CommentModel();
        $comments = $commentModel->getCommentList();
        require_once './views/comment.php';
    }

    public static function deleteCommentController() 
    {
        try {
            $commentModel = new CommentModel();
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }
            
            $id = $_GET['id'];

            if ($commentModel->deleteComment($id)) {
                $_SESSION['success'] = 'Xóa bình luận thành công';
            } else {
                throw new Exception('Không thể xóa bình luận');
            }
            
            header('Location: index.php?action=comment');
            exit();
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            header('Location: index.php?action=comment');
            exit();
        }
    }
}
?>