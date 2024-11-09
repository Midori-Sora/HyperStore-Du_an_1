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

    public static function addCommentController()
    {
        try {
            $commentModel = new CommentModel();
            
            if(isset($_POST['them'])) {
                if(empty($_POST['user_id']) || empty($_POST['pro_id']) || empty($_POST['content'])) {
                    throw new Exception('Vui lòng điền đầy đủ thông tin');
                }
                
                $user_id = intval($_POST['user_id']);
                $pro_id = intval($_POST['pro_id']);
                $content = trim($_POST['content']);
                
                if($commentModel->addComment($user_id, $pro_id, $content)) {
                    $_SESSION['success'] = 'Thêm bình luận thành công';
                    header('location: index.php?action=comment');
                    exit();
                } else {
                    throw new Exception('Không thể thêm bình luận');
                }
            }
            
            $users = $commentModel->getUsersList();
            $products = $commentModel->getProductsList();
            
            require_once './views/add-comment.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=comment');
            exit();
        }
    }
}
?>