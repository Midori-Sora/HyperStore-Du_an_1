<?php
class CommentModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getCommentsByProduct($product_id) {
        $sql = "SELECT c.*, u.username, u.avatar 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.user_id 
                WHERE c.pro_id = ? 
                ORDER BY c.import_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        
        return $comments;
    }

    public function addComment($data) {
        $sql = "INSERT INTO comments (pro_id, user_id, content, import_date) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", 
            $data['product_id'],
            $data['user_id'],
            $data['content']
        );
        
        return $stmt->execute();
    }

    public function __destruct() {
        $this->conn->close();
    }
}
