<?php
require_once './models/commentModel.php';

class CommentController {
    public static function commentController() {
        $commentModel = new CommentModel();
        $comments = $commentModel->getCommentList();
        require_once './views/comment/comment.php';
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

    public static function updateStatusController() {
        try {
            if (!isset($_GET['id']) || !isset($_GET['status'])) {
                throw new Exception('Thiếu thông tin cần thiết');
            }
            
            $id = (int)$_GET['id'];
            $status = (int)$_GET['status'];
            
            if (!in_array($status, [0, 1])) {
                throw new Exception('Trạng thái không hợp lệ');
            }
            
            $commentModel = new CommentModel();
            
            if ($commentModel->updateCommentStatus($id, $status)) {
                $_SESSION['success'] = $status == 1 ? 
                    'Duyệt bình luận thành công' : 
                    'Hủy duyệt bình luận thành công';
            } else {
                throw new Exception('Cập nhật trạng thái thất bại');
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        
        header('Location: index.php?action=comment');
        exit();
    }
}
?>