<?php
class CommentController {
    private static $commentModel;

    public static function init() {
        if (!self::$commentModel) {
            self::$commentModel = new CommentModel();
        }
    }

    public static function commentController() {
        self::init();
        try {
            $comments = self::$commentModel->getCommentList();
            require_once './views/comment/comment.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function deleteCommentController() 
    {
        self::init();
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }
            
            $id = $_GET['id'];

            if (self::$commentModel->deleteComment($id)) {
                $_SESSION['success'] = 'Xóa bình luận thành công';
            } else {
                throw new Exception('Không thể xóa bình luận');
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?action=comment');
        exit();
    }

    public static function updateStatusController() {
        self::init();
        try {
            if (!isset($_GET['id']) || !isset($_GET['status'])) {
                throw new Exception('Thiếu thông tin cần thiết');
            }
            
            $id = (int)$_GET['id'];
            $status = (int)$_GET['status'];
            
            if (!in_array($status, [0, 1])) {
                throw new Exception('Trạng thái không hợp lệ');
            }
            
            if (self::$commentModel->updateCommentStatus($id, $status)) {
                $_SESSION['success'] = $status == 1 ? 
                    'Duyệt bình luận thành công' : 
                    'Hủy duyệt bình luận thành công';
            } else {
                throw new Exception('Cập nhật trạng thái thất bại');
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?action=comment');
        exit();
    }
}
?>