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
                    LEFT JOIN users u ON c.user_id = u.user_id 
                    WHERE c.pro_id = :product_id 
                    ORDER BY c.import_date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
