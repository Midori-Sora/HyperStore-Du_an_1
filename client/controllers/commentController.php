<?php
class CommentController {
    private static $commentModel;

    public static function init() {
        self::$commentModel = new CommentModel();
    }

    public static function getComments($product_id) {
        self::init();
        return self::$commentModel->getCommentsByProduct($product_id);
    }

    public static function addComment() {
        self::init();
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để bình luận';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

        if (!$product_id || !$content) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $data = [
            'product_id' => $product_id,
            'user_id' => $_SESSION['user_id'],
            'content' => $content
        ];

        if (self::$commentModel->addComment($data)) {
            $_SESSION['success'] = 'Đã thêm bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thêm bình luận';
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
