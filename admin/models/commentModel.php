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

    public function addComment($user_id, $pro_id, $content) 
    {
        try {
            $sql = "INSERT INTO comments (user_id, pro_id, content) 
                    VALUES (:user_id, :pro_id, :content, NOW())";
            $stmt = $this->SUNNY->prepare($sql);
            
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':pro_id', $pro_id, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Add comment error: " . $e->getMessage());
            return false;
        }
    }

    public function getUsersList()
    {
        $sql = "SELECT user_id, user_name FROM users";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsList()
    {
        $sql = "SELECT pro_id, pro_name FROM products";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>