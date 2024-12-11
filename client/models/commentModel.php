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
            $sql = "INSERT INTO comments (pro_id, user_id, content, import_date) 
                    VALUES (:product_id, :user_id, :content, NOW())";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':product_id' => $data['product_id'],
                ':user_id' => $data['user_id'],
                ':content' => $data['content']
            ]);
        } catch (PDOException $e) {
            error_log("Add comment error: " . $e->getMessage());
            return false;
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
