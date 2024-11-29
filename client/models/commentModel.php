<?php
class CommentModel {
    private $db;

    public function __construct() {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getCommentsByProduct($product_id, $rating_filter = null) {
        try {
            $sql = "SELECT c.*, u.username, u.avatar,
                    GROUP_CONCAT(ci.image_url) as images
                    FROM comments c 
                    LEFT JOIN users u ON c.user_id = u.user_id 
                    LEFT JOIN comment_images ci ON c.com_id = ci.comment_id
                    WHERE c.pro_id = :product_id";
            
            if ($rating_filter !== null && $rating_filter !== 'all') {
                $sql .= " AND c.rating = :rating";
            }
            
            $sql .= " GROUP BY c.com_id ORDER BY c.import_date DESC";
            
            $stmt = $this->db->prepare($sql);
            $params = [':product_id' => $product_id];
            
            if ($rating_filter !== null && $rating_filter !== 'all') {
                $params[':rating'] = $rating_filter;
            }
            
            $stmt->execute($params);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Process images
            foreach ($comments as &$comment) {
                $comment['images'] = $comment['images'] ? explode(',', $comment['images']) : [];
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
}
