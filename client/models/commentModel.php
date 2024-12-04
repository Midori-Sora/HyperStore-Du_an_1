<?php
class CommentModel {
    private $db;

    public function __construct() {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getCommentsByProduct($product_id) {
        try {
            $sql = "SELECT c.*, u.username, u.avatar
                    FROM comments c 
                    INNER JOIN users u ON c.user_id = u.user_id 
                    WHERE c.pro_id = :product_id
                    AND c.cmt_status = 1
                    ORDER BY c.import_date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Xử lý avatar mặc định
            foreach ($comments as &$comment) {
                if (empty($comment['avatar'])) {
                    $comment['avatar'] = 'assets/images/default-avatar.jpg';
                }
            }

            return $comments;
        } catch (PDOException $e) {
            error_log("Get comments error: " . $e->getMessage());
            return [];
        }
    }

    public function addComment($data) {
        try {
            $sql = "INSERT INTO comments (pro_id, user_id, content, rating, import_date) 
                    VALUES (:product_id, :user_id, :content, :rating, NOW())";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':product_id' => $data['product_id'],
                ':user_id' => $data['user_id'],
                ':content' => $data['content'],
                ':rating' => $data['rating']
            ]);
        } catch (PDOException $e) {
            error_log("Add comment error: " . $e->getMessage());
            return false;
        }
    }

    public function getAverageRating($product_id) {
        try {
            $sql = "SELECT 
                        COUNT(DISTINCT c.com_id) as total_ratings,
                        AVG(c.rating) as avg_rating,
                        SUM(CASE WHEN c.rating = 5 THEN 1 ELSE 0 END) as five_star,
                        SUM(CASE WHEN c.rating = 4 THEN 1 ELSE 0 END) as four_star,
                        SUM(CASE WHEN c.rating = 3 THEN 1 ELSE 0 END) as three_star,
                        SUM(CASE WHEN c.rating = 2 THEN 1 ELSE 0 END) as two_star,
                        SUM(CASE WHEN c.rating = 1 THEN 1 ELSE 0 END) as one_star
                    FROM comments c
                    WHERE c.pro_id = :product_id 
                    AND c.cmt_status = 1
                    AND c.rating > 0";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Tính phần trăm cho mỗi mức rating nếu có đánh giá
            if ($result['total_ratings'] > 0) {
                $result['five_star_percent'] = round(($result['five_star'] / $result['total_ratings']) * 100);
                $result['four_star_percent'] = round(($result['four_star'] / $result['total_ratings']) * 100);
                $result['three_star_percent'] = round(($result['three_star'] / $result['total_ratings']) * 100);
                $result['two_star_percent'] = round(($result['two_star'] / $result['total_ratings']) * 100);
                $result['one_star_percent'] = round(($result['one_star'] / $result['total_ratings']) * 100);
            } else {
                $result['five_star_percent'] = 0;
                $result['four_star_percent'] = 0;
                $result['three_star_percent'] = 0;
                $result['two_star_percent'] = 0;
                $result['one_star_percent'] = 0;
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Get average rating error: " . $e->getMessage());
            return [
                'total_ratings' => 0,
                'avg_rating' => 0,
                'five_star' => 0,
                'four_star' => 0,
                'three_star' => 0,
                'two_star' => 0,
                'one_star' => 0,
                'five_star_percent' => 0,
                'four_star_percent' => 0,
                'three_star_percent' => 0,
                'two_star_percent' => 0,
                'one_star_percent' => 0
            ];
        }
    }

    public function getTotalComments($product_id) {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM comments 
                    WHERE pro_id = :product_id 
                    AND cmt_status = 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total comments error: " . $e->getMessage());
            return 0;
        }
    }

    public function getCommentStats($product_id) {
        try {
            $sql = "SELECT 
                    COUNT(*) as total_comments,
                    COUNT(DISTINCT CASE WHEN rating > 0 THEN com_id END) as total_ratings
                    FROM comments 
                    WHERE pro_id = :product_id 
                    AND cmt_status = 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get comment stats error: " . $e->getMessage());
            return [
                'total_comments' => 0,
                'total_ratings' => 0
            ];
        }
    }

    public function getRatingCount($product_id) {
        try {
            $sql = "SELECT COUNT(*) as rating_count 
                    FROM comments 
                    WHERE pro_id = :product_id 
                    AND cmt_status = 1 
                    AND rating > 0";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['rating_count'];
        } catch (PDOException $e) {
            error_log("Get rating count error: " . $e->getMessage());
            return 0;
        }
    }

    public function getRatingInfo($product_id) {
        try {
            // Kiểm tra xem bảng comments có tồn tại không
            $checkTable = "SHOW TABLES LIKE 'comments'";
            $stmt = $this->db->prepare($checkTable);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return $this->getDefaultRatingInfo();
            }

            // Lấy thông tin đánh giá
            $sql = "SELECT 
                    COUNT(*) as total_ratings,
                    COALESCE(AVG(rating), 0) as average,
                    COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
                    COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
                    COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
                    COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
                    COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
                    FROM comments 
                    WHERE pro_id = :product_id 
                    AND cmt_status = 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $this->formatRatingInfo($result);
        } catch (PDOException $e) {
            error_log("Get rating info error: " . $e->getMessage());
            return $this->getDefaultRatingInfo();
        }
    }

    private function getDefaultRatingInfo() {
        return [
            'total_ratings' => 0,
            'average' => 0,
            'ratings' => [
                5 => ['count' => 0, 'percent' => 0],
                4 => ['count' => 0, 'percent' => 0],
                3 => ['count' => 0, 'percent' => 0],
                2 => ['count' => 0, 'percent' => 0],
                1 => ['count' => 0, 'percent' => 0]
            ]
        ];
    }

    private function formatRatingInfo($result) {
        $total = (int)$result['total_ratings'];
        return [
            'total_ratings' => $total,
            'average' => $total > 0 ? round($result['average'], 1) : 0,
            'ratings' => [
                5 => [
                    'count' => (int)$result['five_star'],
                    'percent' => $total > 0 ? round(($result['five_star'] / $total) * 100) : 0
                ],
                4 => [
                    'count' => (int)$result['four_star'],
                    'percent' => $total > 0 ? round(($result['four_star'] / $total) * 100) : 0
                ],
                3 => [
                    'count' => (int)$result['three_star'],
                    'percent' => $total > 0 ? round(($result['three_star'] / $total) * 100) : 0
                ],
                2 => [
                    'count' => (int)$result['two_star'],
                    'percent' => $total > 0 ? round(($result['two_star'] / $total) * 100) : 0
                ],
                1 => [
                    'count' => (int)$result['one_star'],
                    'percent' => $total > 0 ? round(($result['one_star'] / $total) * 100) : 0
                ]
            ]
        ];
    }

    public function getUserPendingComments($user_id, $product_id) {
        try {
            $sql = "SELECT c.*, u.username, u.avatar
                    FROM comments c 
                    INNER JOIN users u ON c.user_id = u.user_id 
                    WHERE c.pro_id = :product_id 
                    AND c.user_id = :user_id
                    AND c.cmt_status = 0
                    ORDER BY c.import_date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':product_id' => $product_id,
                ':user_id' => $user_id
            ]);
            
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Xử lý avatar mặc định
            foreach ($comments as &$comment) {
                if (empty($comment['avatar'])) {
                    $comment['avatar'] = 'assets/images/default-avatar.jpg';
                }
            }
            
            return $comments;
        } catch (PDOException $e) {
            error_log("Get user pending comments error: " . $e->getMessage());
            return [];
        }
    }

    public function hasUserPurchasedProduct($user_id, $product_id) {
        try {
            $sql = "SELECT COUNT(*) as purchased
                    FROM orders o
                    INNER JOIN order_details od ON o.order_id = od.order_id
                    WHERE o.user_id = :user_id 
                    AND od.product_id = :product_id
                    AND o.status = 'delivered'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':product_id' => $product_id
            ]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['purchased'] > 0;
        } catch (PDOException $e) {
            error_log("Check user purchase error: " . $e->getMessage());
            return false;
        }
    }
}
