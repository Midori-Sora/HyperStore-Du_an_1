<?php
class CommentController {
    private static $commentModel;

    public static function init() {
        self::$commentModel = new CommentModel();
    }

    public static function getComments($product_id, $rating_filter = null) {
        self::init();
        return self::$commentModel->getCommentsByProduct($product_id, $rating_filter);
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
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);

        if (!$rating || $rating < 1 || $rating > 5) {
            $rating = 5;
        }

        if (!$product_id || !$content) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $data = [
            'product_id' => $product_id,
            'user_id' => $_SESSION['user_id'],
            'content' => $content,
            'rating' => $rating
        ];

        if (self::$commentModel->addComment($data)) {
            $_SESSION['success'] = 'Đã thêm bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thêm bình luận';
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public static function getAverageRating($product_id) {
        self::init();
        $ratingInfo = self::$commentModel->getAverageRating($product_id);
        $ratingCount = self::$commentModel->getRatingCount($product_id);
        
        // Làm tròn điểm trung bình đến 1 chữ số thập phân
        if ($ratingInfo['avg_rating'] !== null) {
            $ratingInfo['avg_rating'] = round($ratingInfo['avg_rating'], 1);
        }
        
        return [
            'avg_rating' => $ratingInfo['avg_rating'] ?? 0,
            'total_ratings' => $ratingCount,
            'rating_details' => [
                5 => [
                    'count' => $ratingInfo['five_star'] ?? 0,
                    'percent' => $ratingInfo['five_star_percent'] ?? 0
                ],
                4 => [
                    'count' => $ratingInfo['four_star'] ?? 0,
                    'percent' => $ratingInfo['four_star_percent'] ?? 0
                ],
                3 => [
                    'count' => $ratingInfo['three_star'] ?? 0,
                    'percent' => $ratingInfo['three_star_percent'] ?? 0
                ],
                2 => [
                    'count' => $ratingInfo['two_star'] ?? 0,
                    'percent' => $ratingInfo['two_star_percent'] ?? 0
                ],
                1 => [
                    'count' => $ratingInfo['one_star'] ?? 0,
                    'percent' => $ratingInfo['one_star_percent'] ?? 0
                ]
            ]
        ];
    }

    public static function filterComments() {
        if (!isset($_GET['product_id']) || !isset($_GET['rating'])) {
            return;
        }

        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        $rating = filter_input(INPUT_GET, 'rating', FILTER_SANITIZE_STRING);

        self::init();
        
        // Xử lý các trường hợp đặc biệt
        if ($rating === 'all') {
            $comments = self::$commentModel->getCommentsByProduct($product_id);
        } elseif ($rating === 'has-comment') {
            $comments = self::$commentModel->getCommentsWithContent($product_id);
        } elseif ($rating === 'has-media') {
            $comments = self::$commentModel->getCommentsWithMedia($product_id);
        } else {
            $comments = self::$commentModel->getCommentsByProduct($product_id, $rating);
        }

        // Include view file để render comments
        include 'client/views/product/comments-list.php';
        exit;
    }
}
