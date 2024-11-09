<?php
class CommentModel extends MainModel {
    public function __construct()
    {
        try {
            parent::__construct();
            error_log("Database connection established");
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw $e;
        }
    }
    public function getCommentList() {
        $sql = "SELECT comments.*, products.pro_name, users.user_name
                FROM comments
                INNER JOIN products ON comments.pro_id = products.pro_id
                INNER JOIN users ON comments.user_id = users.user_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteComment($id) 
    {
        try {
            $sql = "DELETE FROM comments WHERE com_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete comment error: " . $e->getMessage());
            return false;
        }
    }

    public function getUsersList()
    {
        try {
            $sql = "SELECT user_id, user_name FROM users";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting users list: " . $e->getMessage());
            return [];
        }
    }

    public function getProductsList()
    {
        try {
            $sql = "SELECT pro_id, pro_name FROM products";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting products list: " . $e->getMessage());
            return [];
        }
    }
}
?>