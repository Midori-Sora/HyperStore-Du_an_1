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
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);

        if (!$product_id || !$content || !$rating) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $data = [
            'product_id' => $product_id,
            'user_id' => $_SESSION['user_id'],
            'content' => $content,
            'rating' => $rating,
            'cmt_status' => 0 // Mặc định là chờ duyệt
        ];

        if (self::$commentModel->addComment($data)) {
            $_SESSION['success'] = 'Đã gửi đánh giá thành công, vui lòng chờ duyệt';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi gửi đánh giá';
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public static function getAverageRating($product_id) {
        self::init();
        return self::$commentModel->getRatingInfo($product_id);
    }

    public static function getUserPendingComments($user_id, $product_id) {
        self::init();
        return self::$commentModel->getUserPendingComments($user_id, $product_id);
    }
}
